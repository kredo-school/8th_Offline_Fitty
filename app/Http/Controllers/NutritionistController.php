<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserProfile;
use App\Models\DailyLog;
use Carbon\Carbon;

use Illuminate\Support\Facades\Auth;



class NutritionistController extends Controller
{
    private $user;
    private $user_profile;
    private $dailylog;

    public function __construct(User $user, UserProfile $user_profile, DailyLog $dailylog)
    {
        $this->user = $user;
        $this->user_profile = $user_profile;
        $this->dailylog = $dailylog;

    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // 現在の日時から一週間前の日付を計算
        $one_week_ago = now()->subWeek();

        // 栄養士に関連するユーザー情報を取得（advice_sent_dateが一週間前よりも前のデータを取得）
        $user_profiles = $this->user_profile
            ->where('nutritionist_id', Auth::user()->id)
            ->where(function ($query) use ($one_week_ago) {
                $query->where('advice_sent_date', '<', $one_week_ago)
                      ->orWhereNull('advice_sent_date'); // advice_sent_dateがnullの場合も含める
            })
            ->get();

        // 栄養士とその関連ユーザー情報をビューに渡す
        return view('nutritionists.index', compact('user_profiles'));
    }



    function sendAdvice($id)
    {

        $user_profile = $this->user_profile->where('user_id', $id)->first();
        $dailylog = $this->dailylog->where('user_id', $id)->first();

        $radarChartData = $this->showpfcvm($id);

        // 必要に応じて radarChartData のデータを加工
        $satisfactionRates = $radarChartData['satisfactionRates'] ?? [];
        $message = $radarChartData['message'] ?? null;
        $categories = ['Carbohydrates', 'Proteins', 'Fats','Vitamins','Minerals'];
        $categoryData = [];

        foreach ($categories as $category) {
            $categoryData[$category] = $this->showCategory($id, $category);
        }

        return view('nutritionists.sendAdvice', compact('user_profile', 'satisfactionRates', 'categoryData', 'message','category'));
    }

    public function showpfcvm($id)
    {
        $user_prolile = User::find($id);

        if (!$user_prolile) {
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
            'user_profile' => $user_prolile
        ];
    }

    public function showCategory($id, $category)
    {
        $user_profile = User::find($id);

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


    function profile()
    {
        return view('nutritionists.profile');
    }
    function editprofile()
    {
        return view('nutritionists.editprofile');
    }

    /**
     * Show the form for creating a new resource.
     */

}
