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




    public function history($id)
    {
        $user_profile = $this->user_profile->findOrFail($id);
        $adviceList = $this->advice->where('user_id', $id)->orderBy('created_at', 'desc')->get();

        return view('nutritionists.history')
            ->with('user_profile', $user_profile)
            ->with('adviceList', $adviceList);
    }

    public function showHistory($id, Request $request)
    {
        $user_profile = $this->user_profile->findOrFail($id);

        $dailylog = $this->dailylog->where('user_id', $id)->first();



        // 必要に応じて radarChartData のデータを加工
        $satisfactionRates = $radarChartData['satisfactionRates'] ?? [];
        $message = $radarChartData['message'] ?? null;
        $categories = ['Carbohydrates', 'Proteins', 'Fats', 'Vitamins', 'Minerals'];
        $categoryData = [];



        // リクエストの日付でアドバイスを取得
        $adviceDate = $request->input('date');
        $advice = $this->advice->where('user_id', $id)
            ->whereDate('created_at', $adviceDate)
            ->first();

        $radarChartData = $this->showpfcvm($id, $adviceDate);

        foreach ($categories as $category) {
            $categoryData[$category] = $this->showCategory($id, $category, $adviceDate);
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



    public function showpfcvm($id, $adviceDate)
    {
        $user_profile = User::find($id);

        if (!$user_profile) {
            return [
                'satisfactionRates' => [],
                'message' => 'User not found.',
            ];
        }

        $endDate = Carbon::parse($adviceDate)->subDay();
        $startDate = $endDate->copy()->subDays(6);
        $dailyLogs = DailyLog::where('user_id', $id)
            ->whereBetween('input_date', [$startDate, $endDate])
            ->get();

        if ($dailyLogs->isEmpty()) {
            return [
                'satisfactionRates' => [],
                'message' => 'No data available for the last 7 days for this user.',
            ];
        }

        $weight = $dailyLogs->first()->weight;
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

        return [
            'satisfactionRates' => $satisfactionRates,
            'message' => null,
            'user_profile' => $user_profile,
        ];
    }

    public function showCategory($id, $category, $adviceDate)
    {
        // ユーザー情報を取得
        $user_profile = $this->user_profile->findOrFail($id);

        if (!$user_profile) {
            return [
                'subCategoryRates' => [],
                'message' => 'User not found.',
            ];
        }

        // 1週間分のデータを取得
        $endDate = Carbon::parse($adviceDate)->subDay();
        $startDate = $endDate->copy()->subDays(6);

        $dailyLogs = DailyLog::where('user_id', $id)
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

    public function index($id)
    {
        // 指定されたユーザーIDに関連するアドバイスを取得
        $user = $this->user->findOrFail($id);
        $adviceList = $this->advice->where('user_id', $id)
        ->orderBy('created_at', 'desc')
        ->paginate(10); 

        return view('users.advice_index', compact('user', 'adviceList'));
    }


    public function showAdvice($id)
    {
        $advice = $this->advice
            ->where('id', $id)
            ->firstOrFail();

        $user_profile = $this->user_profile->findOrFail($id);

        $dailylog = $this->dailylog->where('user_id', $id)->first();



        // 必要に応じて radarChartData のデータを加工
        $satisfactionRates = $radarChartData['satisfactionRates'] ?? [];
        $message = $radarChartData['message'] ?? null;
        $categories = ['Carbohydrates', 'Proteins', 'Fats', 'Vitamins', 'Minerals'];
        $categoryData = [];



        // リクエストの日付でアドバイスを取得
        $adviceDate = $advice->created_at->format('Y-m-d');

        // showWeightメソッドを呼び出してグラフ用データを取得
        $weightData = $this->showWeight($id, $adviceDate);

        $radarChartData = $this->showpfcvm($id, $adviceDate);


        return view('users.advice_show', compact(
            'advice',
            'satisfactionRates',
            'categoryData',
            'message',
            'dailylog',
            'weightData',
            'user_profile'
        ));
    }

    public function showWeight($id, $adviceDate)
    {

        $endDate = Carbon::parse($adviceDate)->subDay();
        $startDate = $endDate->copy()->subDays(6);

        // データを取得
        $dailyLogs = DailyLog::where('user_id', $id)
            ->whereBetween('input_date', [$startDate, $endDate])
            ->orderBy('input_date', 'asc')
            ->get();

        // グラフ用のデータを整形
        $dates = [];
        $weights = [];

        foreach ($dailyLogs as $log) {
            $dates[] = $log->input_date->format('Y-m-d');
            $weights[] = $log->weight;
        }

        // ビューにデータを渡す
        return [
            'dates' => $dates,
            'weights' => $weights,
            'message' => $dailyLogs->isEmpty() ? 'No data available.' : null
        ];
    }



}


