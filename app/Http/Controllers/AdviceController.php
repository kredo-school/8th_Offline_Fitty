<?php

namespace App\Http\Controllers;

use App\Models\Advice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserProfile;
use App\Models\DailyLog;
use Carbon\Carbon;




class AdviceController extends Controller
{
    private $advice;
    private $user_profile;
    private $dailylog;


    public function __construct(Advice $advice, UserProfile $user_profile, DailyLog $dailylog)
    {
        $this->advice = $advice;
        $this->user_profile = $user_profile;
        $this->dailylog = $dailylog;

    }



    /**
     * Store a newly created resource in storage.
     */

public function store(Request $request)
{
    $request->validate([
        'overall'   => 'required',
        'message'   => 'required',
        'user_id'   => 'required|exists:users,id'
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

    $radarChartData = $this->showpfcvm($id);

    // 必要に応じて radarChartData のデータを加工
    $satisfactionRates = $radarChartData['satisfactionRates'] ?? [];
    $message = $radarChartData['message'] ?? null;
    $categories = ['Carbohydrates', 'Proteins', 'Fats', 'Vitamins', 'Minerals'];
    $categoryData = [];

    foreach ($categories as $category) {
        $categoryData[$category] = $this->showCategory($id, $category);
    }

    // リクエストの日付でアドバイスを取得
    $adviceDate = $request->input('date');
    $advice = $this->advice->where('user_id', $id)
                           ->whereDate('created_at', $adviceDate)
                           ->first();

    return view('nutritionists.showHistory', compact(
        'user_profile',
        'satisfactionRates',
        'categoryData',
        'message',
        'dailylog',
        'advice'
    ));
}



public function showpfcvm($id)
    {
    $user_profile = $this->user_profile->findOrFail($id);

        if (!$user_profile) {
            return [
                'satisfactionRates' => [],
                'message' => 'User not found.',
            ];
        }

        $endDate = Carbon::yesterday();
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

        // キー名を統一する処理を追加
        $actualValues = [
            "Proteins" => $actualValues["Protein"] ?? 0,
            "Fats" => $actualValues["Fat"] ?? 0,
            "Carbohydrates" => $actualValues["Carbohydrates"] ?? 0,
            "Vitamins" => $actualValues["Vitamins"] ?? 0,
            "Minerals" => $actualValues["Minerals"] ?? 0,
        ];
        // dd($actualValues);

        $satisfactionRates = [];
        foreach ($recommendedValues as $key => $recommended) {
            $actual = $actualValues[$key] ?? 0;
            $satisfactionRates[$key] = round(($actual / $recommended) * 100, 1);
        }

        return [
            'satisfactionRates' => $satisfactionRates,
            'message' => null,
            'user_profile' => $user_profile
        ];
    }


    public function showCategory($id, $category)
    {
        $user_profile = $this->user_profile->findOrFail($id);

        if (!$user_profile) {
            return [
                'subCategoryRates' => [],
                'message' => 'User not found.',
            ];
        }

        $endDate = Carbon::yesterday();
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

        // ユーザーの体重を取得（デフォルト: 70kg）
        $weight = $dailyLogs->first()->weight ?? 70;

        $subCategoryTotals = [];
        $subCategoryRecommended = [];

        foreach ($dailyLogs as $log) {
            $nutritions = json_decode($log->nutritions, true);

            // サブカテゴリーが存在しない場合をスキップ
            if (!isset($nutritions['Subcategories'])) {
                continue;
            }

            // `$category` に基づいて該当サブカテゴリーを選別
            $subcategories = $nutritions['Subcategories'];
            $filteredSubcategories = [];
            foreach ($subcategories as $subCategory => $value) {
                if ($this->isCategoryMatch($subCategory, $category)) {
                    $filteredSubcategories[$subCategory] = $value;
                }
            }

            // フィルタリングされたサブカテゴリーで計算
            foreach ($filteredSubcategories as $subCategory => $value) {
                $numericValue = (float) filter_var($value, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

                // 合計値を計算
                $subCategoryTotals[$subCategory] = ($subCategoryTotals[$subCategory] ?? 0) + $numericValue;

                // 推奨値を計算
                $subCategoryRecommended[$subCategory] = ($subCategoryRecommended[$subCategory] ?? 0) + $this->getSubcategoryRequirement($subCategory, $weight);
            }
        }

        // サブカテゴリー充足率を計算
        $subCategoryRates = [];
        foreach ($subCategoryRecommended as $subCategory => $recommended) {
            $actual = $subCategoryTotals[$subCategory] ?? 0;
            $subCategoryRates[$subCategory] = round(($actual / $recommended) * 100, 1);
        }

        return [
            'subCategoryRates' => $subCategoryRates,
            'message' => empty($subCategoryRates) ? 'No subcategories found for this category.' : null,
        ];
    }




    private function getSubcategoryRequirement($subCategory, $weight)
    {
        $requirements = [
            // Carbohydrates サブカテゴリー
            "Simple Sugars" => 5, // 1kgあたり5g
            "Complex Carbohydrates" => 10,
            "Fiber" => 1,
            "Starches" => 3,
            "Polysaccharides" => 0.5,

            // Proteins サブカテゴリー
            "Lysine" => 0.03,
            "Leucine" => 0.04,
            "Isoleucine" => 0.03,
            "Valine" => 0.03,
            "Threonine" => 0.02,
            "Methionine" => 0.01,
            "Phenylalanine" => 0.015,
            "Histidine" => 0.01,
            "Arginine" => 0.015,

            // Fats サブカテゴリー
            "Saturated Fats" => 0.8,
            "Unsaturated Fats" => 1.2,
            "Omega-3 Fatty Acids" => 0.1,
            "Omega-6 Fatty Acids" => 0.2,
            "Trans Fats" => 0.05,

            // Vitamins サブカテゴリー
            "Vitamin A" => 10, // 1kgあたり10µg
            "Vitamin B1 (Thiamine)" => 0.02,
            "Vitamin B2 (Riboflavin)" => 0.02,
            "Vitamin B6 (Pyridoxine)" => 0.03,
            "Vitamin B12 (Cobalamin)" => 0.002,
            "Vitamin C" => 1.5,
            "Vitamin D" => 0.01,
            "Vitamin E" => 0.2,
            "Vitamin K" => 2,

            // Minerals サブカテゴリー
            "Calcium" => 15, // 1kgあたり15mg
            "Iron" => 0.3,
            "Magnesium" => 5,
            "Potassium" => 50,
            "Sodium" => 30,
            "Zinc" => 0.2,
            "Phosphorus" => 10,
            "Copper" => 0.02,
            "Manganese" => 0.04,
            "Fluoride" => 0.1,
        ];

        $requirementPerKg = $requirements[$subCategory] ?? 1; // デフォルト値: 1単位/1kg
        return $requirementPerKg * $weight;
    }

    /**
     * サブカテゴリーが指定されたカテゴリーに属しているか確認
     */
    private function isCategoryMatch($subCategory, $category)
    {
        $categoryMapping = [
            'Carbohydrates' => ['Simple Sugars', 'Complex Carbohydrates', 'Fiber', 'Starches', 'Polysaccharides'],
            'Proteins' => ['Lysine', 'Leucine', 'Isoleucine', 'Valine', 'Threonine', 'Methionine', 'Phenylalanine', 'Histidine', 'Arginine'],
            'Fats' => ['Saturated Fats', 'Unsaturated Fats', 'Omega-3 Fatty Acids', 'Omega-6 Fatty Acids', 'Trans Fats'],
            'Vitamins' => ['Vitamin A', 'Vitamin B1 (Thiamine)', 'Vitamin B2 (Riboflavin)', 'Vitamin B6 (Pyridoxine)', 'Vitamin B12 (Cobalamin)', 'Vitamin C', 'Vitamin D', 'Vitamin E', 'Vitamin K'],
            'Minerals' => ['Calcium', 'Iron', 'Magnesium', 'Potassium', 'Sodium', 'Zinc', 'Phosphorus', 'Copper', 'Manganese', 'Fluoride']
        ];

        return in_array($subCategory, $categoryMapping[$category] ?? []);
    }
    /**
     * Display the specified resource.
     */
    public function show(Advice $advice)
    {
        //
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
}


