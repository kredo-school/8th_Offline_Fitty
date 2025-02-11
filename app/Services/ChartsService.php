<?php
namespace App\Services;

use App\Models\DailyLog;
use App\Models\UserProfile;
use App\Models\SubCategory;
use App\Models\Category;
use Carbon\Carbon;

class ChartsService
{
    protected $user_profile;
    protected $dailyLog;

    public function __construct(UserProfile $user_profile, DailyLog $dailyLog)
    {
        $this->user_profile = $user_profile;
        $this->dailyLog = $dailyLog;
    }

    public function showpfcvm($user_id, $startDate = null, $endDate = null)
    {

        $user_profile = $this->user_profile->where('user_id', $user_id)->first();
        // パラメータが渡されなかった場合はデフォルトの日付を設定
        if (!$endDate) {
            $endDate = Carbon::yesterday(); // デフォルト：昨日
        } else {
            $endDate = Carbon::parse($endDate); // 渡された場合は Carbon インスタンス化
        }
    
        if (!$startDate) {
            $startDate = $endDate->copy()->subDays(6); // デフォルト：過去7日間
        } else {
            $startDate = Carbon::parse($startDate); // 渡された場合は Carbon インスタンス化
        }
    
        // 何日分のデータかを計算
        $dateRangeDays = $startDate->diffInDays($endDate) + 1; // 端の日も含める

        // 指定した期間のデータを取得
        $dailyLogs = $this->dailyLog->where('user_id', $user_id)
            ->whereBetween('input_date', [$startDate, $endDate])
            ->get();
    
        if ($dailyLogs->isEmpty()) {
            return [
                'satisfactionRates' => [],
                'message' => 'No data available for the selected period.',
            ];
        }
    
        // 以降の処理（栄養素計算など）は変更なし
        $weight = $dailyLogs->first()->weight;
        $recommendedValues = [
            "Carbohydrates" => $weight * 5 * $dateRangeDays,
            "Fats" => $weight * 1.0 * $dateRangeDays,
            "Proteins" => $weight * 1.2 * $dateRangeDays,
            "Vitamins" => $weight * 2 * $dateRangeDays,
            "Minerals" => $weight * 10 * $dateRangeDays,
        ];
    
        $actualValues = [];
        
        foreach ($dailyLogs as $log) {
            $nutritions = json_decode($log->nutritions, true);
            foreach ($nutritions as $key => $value) {
                //$numericValue = (int) filter_var($value, FILTER_SANITIZE_NUMBER_INT);

                //54.3gが543gに変換されるバグを修正 omori
                $numericValue = (float) filter_var($value, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                $actualValues[$key] = ($actualValues[$key] ?? 0) + $numericValue;
            }
        }
        
       
        $actualValues = [
            "Proteins" => $actualValues["Proteins"] ?? 0,
            "Fats" => $actualValues["Fats"] ?? 0,
            "Carbohydrates" => $actualValues["Carbohydrates"] ?? 0,
            "Vitamins" => $actualValues["Vitamins"] ?? 0,
            "Minerals" => $actualValues["Minerals"] ?? 0,
        ];
    

        $satisfactionRates = [];
        foreach ($recommendedValues as $key => $recommended) {
            $actual = $actualValues[$key] ?? 0;
            $satisfactionRates[$key] = $recommended > 0 ? round(($actual / $recommended) * 100, 1) : 0;
        }
    
        //dd($satisfactionRates);
        return [
            'satisfactionRates' => $satisfactionRates,
            'message' => null,
            'user_profile' => $user_profile,
        ];
    }


    public function showCategory($user_id, $category)
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
        $endDate = Carbon::yesterday();
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


    
}
