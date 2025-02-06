<?php

namespace App\Http\Controllers;

use App\Models\Advice;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserProfile;
use App\Models\DailyLog;
use App\Models\Category;
use App\Models\SubCategory;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;





class AdviceController extends Controller
{
    private $advice;
    private $user_profile;
    private $dailylog;
    private $user;



    public function __construct(Advice $advice, UserProfile $user_profile, DailyLog $dailylog, User $user)
    {
        $this->advice = $advice;
        $this->user_profile = $user_profile;
        $this->dailylog = $dailylog;
        $this->user = $user; // $userを初期化
    }



    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        $request->validate([
            'overall' => 'required',
            'message' => 'required',
            'user_id' => 'required|exists:users,id'
        ]);

        // 保存するアドバイスのデータを設定
        $this->advice->nutritionist_id = Auth::user()->id;
        $this->advice->user_id = $request->user_id;
        $this->advice->overall = $request->overall;
        $this->advice->message = $request->message;

        // アドバイスを保存
        $this->advice->save();

        // user_profiles テーブルから該当するレコードを取得
        $userProfile = $this->user_profile->where('user_id', $request->user_id)->first();


        // 現在の日付をadvice_dateに保存
        $currentDate = Carbon::now()->toDateString(); // 'Y-m-d'形式で取得

        $userProfile->advice_sent_date = $currentDate;

        $userProfile->save();




        return redirect()->route('nutri.index')->with('success', 'Advice sent successfully!');
    }




    public function updateMemo(Request $request, $id)
    {
        // バリデーション：メモが1000文字以内であることを検証
        $request->validate([
            'memo' => 'nullable|string|max:1000',
        ]);

        try {
            // ユーザーのメモを更新
            $user_profile = $this->user_profile->findOrFail($id);
            $user_profile->nutritionist_memo = $request->memo;
            $user_profile->save();

            // JSON形式のレスポンスを返す
            return response()->json([
                'success' => true,
                'message' => 'Memo updated successfully!',
                'memo' => $user_profile->nutritionist_memo,
            ]);
        } catch (\Exception $e) {


            // エラーレスポンスを返す
            return response()->json([
                'success' => false,
                'message' => 'Failed to update memo. Please try again.',
            ], 500);
        }
    }




    public function history($user_id)
    {
        $user_profile = $this->user_profile->where('user_id', $user_id)->first();
        $adviceList = $this->advice->where('user_id', $user_id)->orderBy('created_at', 'desc')->get();

        return view('nutritionists.history')
            ->with('user_profile', $user_profile)
            ->with('adviceList', $adviceList);
    }

    public function showHistory($user_id, Request $request)
    {
        $user_profile = $this->user_profile->where('user_id', $user_id)->first();

        $dailylog = $this->dailylog->where('user_id', $user_id)->first();


        // リクエストの日付でアドバイスを取得
        $adviceDate = $request->input('date');
        $advice = $this->advice->where('user_id', operator: $user_id)
            ->whereDate('created_at', $adviceDate)
            ->first();

        $radarChartData = $this->showpfcvm($user_id, $adviceDate);

        // 必要に応じて radarChartData のデータを加工
        $satisfactionRates = $radarChartData['satisfactionRates'] ?? [];
        $message = $radarChartData['message'] ?? null;
        $categories = ['Carbohydrates', 'Proteins', 'Fats', 'Vitamins', 'Minerals'];
        $categoryData = [];

        foreach ($categories as $category) {
            $categoryData[$category] = $this->showCategory($user_id, $category, $adviceDate);
        }

        return view('nutritionists.showHistory', compact(
            'user_profile',
            'satisfactionRates',
            'categoryData',
            'message',
            'dailylog',
            'advice'
        ));
    }



    public function showpfcvm($user_id, $adviceDate)
    {
        $user_profile = $this->user_profile->where('user_id', $user_id)->first();

        if (!$user_profile) {
            return [
                'satisfactionRates' => [],
                'message' => 'User not found.',
            ];
        }

        $endDate = Carbon::parse($adviceDate)->subDay();
        // dd($endDate);
        $startDate = $endDate->copy()->subDays(6);
        $dailyLogs = DailyLog::where('user_id', $user_id)
            ->whereBetween('input_date', [$startDate, $endDate])
            ->get();

        if ($dailyLogs->isEmpty()) {
            return [
                'satisfactionRates' => [],
                'message' => 'No data available for the last 7 days for this user.',
            ];
        }

        $weight = $dailyLogs->first()->weight;
        // dd($weight);
        $recommendedValues = [
            "Carbohydrates" => $weight * 5 * 7,
            "Fats" => $weight * 1.0 * 7,
            "Proteins" => $weight * 1.2 * 7,
            "Vitamins" => $weight * 2 * 7,
            "Minerals" => $weight * 10 * 7,
        ];

        $actualValues = [];
        foreach ($dailyLogs as $log) {
            $nutritions = json_decode($log->nutritions, true);
            foreach ($nutritions as $key => $value) {
                $numericValue = (int) filter_var($value, FILTER_SANITIZE_NUMBER_INT);
                $actualValues[$key] = ($actualValues[$key] ?? 0) + $numericValue;
            }
        }

        $actualValues = [
            "Proteins" => $actualValues["Protein"] ?? 0,
            "Fats" => $actualValues["Fat"] ?? 0,
            "Carbohydrates" => $actualValues["Carbohydrates"] ?? 0,
            "Vitamins" => $actualValues["Vitamins"] ?? 0,
            "Minerals" => $actualValues["Minerals"] ?? 0,
        ];

        $satisfactionRates = [];
        foreach ($recommendedValues as $key => $recommended) {
            $actual = $actualValues[$key] ?? 0;
            $satisfactionRates[$key] = $recommended > 0 ? round(($actual / $recommended) * 100, 1) : 0;
        }
        // dd($user_profile);

        return [
            'satisfactionRates' => $satisfactionRates,
            'message' => null,
            'user_profile' => $user_profile,
        ];
    }

    public function showCategory($user_id, $category, $adviceDate)
    {
        // ユーザー情報を取得
        $user_profile = $this->user_profile->where('user_id', $user_id)->first();


        if (!$user_profile) {
            return [
                'subCategoryRates' => [],
                'message' => 'User not found.',
            ];
        }

        // 1週間分のデータを取得
        $endDate = Carbon::parse($adviceDate)->subDay();
        $startDate = $endDate->copy()->subDays(6);

        $dailyLogs = DailyLog::where('user_id', $user_id)
            ->whereBetween('input_date', [$startDate, $endDate])
            ->get();

        if ($dailyLogs->isEmpty()) {
            return [
                'subCategoryRates' => [],
                'message' => 'No data available for the last 7 days for this user.',
            ];
        }

        $weight = (float) $dailyLogs->first()->weight ?? 70; // デフォルト体重もfloatに


        // 指定されたカテゴリーのサブカテゴリを取得
        $categoryModel = Category::with('subcategory')->where('name', $category)->first();

        if (!$categoryModel) {
            return [
                'subCategoryRates' => [],
                'message' => 'Category not found.',
            ];
        }

        $subcategories = $categoryModel->subcategory;

        $subCategoryTotals = [];
        $subCategoryRecommended = [];

        foreach ($dailyLogs as $log) {
            // JSONデータを正規化
            $nutritions = json_decode($log->nutritions, true);
            // dd($nutritions);
            $normalizedNutritions = $this->normalizeToMg($nutritions);
            // dd($normalizedNutritions);

            if (!isset($normalizedNutritions['Subcategories'])) {
                continue;
            }

            $subCategoryRecommended = []; // 初期化


            // JSON内のSubcategoriesキーに基づいてデータを処理
            foreach ($subcategories as $subcategory) {
                $subCategoryName = $subcategory->name;

                // 実際の値がJSONに存在するか確認
                if (!isset($normalizedNutritions['Subcategories'][$subCategoryName])) {
                    continue;
                }

                $numericValue = $normalizedNutritions['Subcategories'][$subCategoryName];

                // 実績値を加算
                $subCategoryTotals[$subCategoryName] = ($subCategoryTotals[$subCategoryName] ?? 0) + $numericValue;

                // 推奨値を取得
                $requirement = (float) $this->getSubcategoryRequirementFromDB($subCategoryName);

                // 推奨値を単純に設定 (繰り返し加算しない)
                $subCategoryRecommended[$subCategoryName] = $requirement * $weight * 7;
            }

        }

        // サブカテゴリーごとの充足率を計算
        $subCategoryRates = [];
        foreach ($subCategoryRecommended as $subCategoryName => $recommended) {
            $actual = $subCategoryTotals[$subCategoryName] ?? 0;
            $subCategoryRates[$subCategoryName] = $recommended > 0 ? round(($actual / $recommended) * 100, 1) : 0;
        }
        // dd([
        //     'Subcategory' => $subCategoryName,
        //     'Requirement per Day (mg/kg)' => $requirement,
        //     'Weight (kg)' => $weight,
        //     'Weekly Requirement (mg)' => $requirement * $weight * 7,
        //     'subCategoryRecommended' => $subCategoryRecommended, // 現在の全体状況
        // ]);

        // dd([
        //     'Subcategory' => $subCategoryName,
        //     'Actual Value (mg)' => $actual, // 実績値
        //     'Recommended Value (mg)' => $recommended, // 推奨値
        //     'Satisfaction Rate (%)' => $subCategoryRates[$subCategoryName] // 充足率
        // ]);

        return [
            'subCategoryRates' => $subCategoryRates,
            'message' => empty($subCategoryRates) ? 'No subcategories found for this category.' : null,
        ];
    }



    private function getSubcategoryRequirementFromDB($subCategoryName)
    {
        // サブカテゴリーの`requirement`を取得し、float型に変換
        $requirement = (float) SubCategory::where('name', $subCategoryName)->value('requirement');

        return $requirement;
    }


    private function normalizeToMg($nutritions)
    {
        $normalized = [];

        foreach ($nutritions as $key => $value) {
            // Subcategoriesの処理を分ける
            if ($key === 'Subcategories' && is_array($value)) {
                $normalized['Subcategories'] = $this->normalizeToMg($value);
                continue;
            }

            // 数値部分を取得
            $numericValue = (float) filter_var($value, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

            // 単位を取得（g, µg, mg）
            $unit = strtolower(preg_replace('/[0-9\.\s]+/', '', $value)); // 数値部分を取り除く

            // 単位に応じた変換
            switch ($unit) {
                case 'g': // グラムをmgに変換
                    $normalized[$key] = $numericValue * 1000;
                    break;
                case 'µg': // マイクログラムをmgに変換
                    $normalized[$key] = $numericValue / 1000;
                    break;
                case 'mg': // mgはそのまま
                default:
                    $normalized[$key] = $numericValue;
                    break;
            }



        }

        return $normalized;
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Advice $advice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Advice $advice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Advice $advice)
    {
        //
    }

    public function index($user_id)
    {
        // 指定されたユーザーIDに関連するアドバイスを取得
        $user = $this->user_profile->where('user_id', $user_id)->first();
        $adviceList = $this->advice->where('user_id', $user_id)->get();

        return view('users.advice_index', compact('user', 'adviceList'));
    }


    public function showAdvice($id, $date)
    {
        $advice = $this->advice
            ->where('id', $id)
            ->firstOrFail();

        $user_profile = $advice->user->where('id', $advice->user_id)->first();
        // dd($user_profile);

        $dailylog = $this->dailylog->where('user_id', $advice->user_id)->first();
        // dd($dailylog);

        // showWeightメソッドを呼び出してグラフ用データを取得
        $weightData = $this->showWeight($advice->user_id, $date);

        $radarChartData = $this->showpfcvm($advice->user_id, $date);

        // 必要に応じて radarChartData のデータを加工
        $satisfactionRates = $radarChartData['satisfactionRates'] ?? [];
        $message = $radarChartData['message'] ?? null;
        $categories = ['Carbohydrates', 'Proteins', 'Fats', 'Vitamins', 'Minerals'];
        $categoryData = [];


        return view('users.advice_show', compact(
            'advice',
            'satisfactionRates',
            'categoryData',
            'message',
            'dailylog',
            'weightData',
            'user_profile',

        ));
    }
    public function showWeight($id, $date)
    {
        $endDate = Carbon::parse($date)->subDay();
        $startDate = $endDate->copy()->subDays(6);

        // データを取得
        $dailyLogs = DailyLog::where('user_id', $id)
            ->whereBetween('input_date', [$startDate, $endDate])
            ->orderBy('input_date', 'asc')
            ->get();

        // グループ化して日ごとの平均を計算
        $groupedData = $dailyLogs->groupBy(function ($log) {
            return Carbon::parse($log->input_date)->format('Y-m-d'); // 日付だけ取得
        })->map(function ($logs) {
            return $logs->avg('weight'); // 体重の平均を計算
        });

        // グラフ用のデータに変換
        $averageDates = $groupedData->keys()->toArray();  // 日付ラベル
        $averageWeights = $groupedData->values()->toArray(); // 平均体重データ

        return [
            'dates' => $averageDates, // 修正: 日ごとのラベル
            'weights' => $averageWeights, // 修正: 平均体重
            'message' => $dailyLogs->isEmpty() ? 'No data available.' : null
        ];
    }


    public function readToggle($id, $adviceId)
    {
        \Log::info("readToggle method called with id: {$id}, adviceId: {$adviceId}");

        $advice = Advice::findOrFail($adviceId);

        $advice->is_read = 1;
        $advice->save();

        \Log::info("Advice read status changed", ['advice_id' => $adviceId, 'new_status' => $advice->is_read]);

        return redirect()->back()->with('success', 'Read status updated');
    }

    public function unread($id, $adviceId)
    {
        \Log::info("unread method called with id: {$id}, adviceId: {$adviceId}");

        $advice = Advice::findOrFail($adviceId);

        $advice->is_read = 0;
        $advice->save();

        \Log::info("Advice read status removed", ['advice_id' => $adviceId]);

        return redirect()->back()->with('success', 'Read status removed');
    }

    public function likeToggle($id, $adviceId)
    {
        \Log::info("likeToggle method called with id: {$id}, adviceId: {$adviceId}");

        $advice = Advice::findOrFail($adviceId);

        $advice->is_liked = 1;
        $advice->save();

        \Log::info("Advice like status changed", ['advice_id' => $adviceId, 'new_status' => $advice->is_liked]);

        return redirect()->back()->with('success', 'Like status updated');
    }

    public function unlike($id, $adviceId)
    {
        \Log::info("unlike method called with id: {$id}, adviceId: {$adviceId}");

        $advice = Advice::findOrFail($adviceId);

        $advice->is_liked = 0;
        $advice->save();

        \Log::info("Advice like status removed", ['advice_id' => $adviceId]);

        return redirect()->back()->with('success', 'Like status removed');
    }

}
