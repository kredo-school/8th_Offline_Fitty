<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DailyLogSeeder extends Seeder
{
    public function run()
    {
        // Meal types
        $mealTypes = ['Breakfast', 'Lunch', 'Dinner'];

        // 栄養素データ（USDA FoodData Centralに準拠）
        $subcategories = [
            "Simple Sugars" => "30g",
            "Complex Carbohydrates" => "40g",
            "Fiber" => "15g",
            "Starches" => "20g",
            "Polysaccharides" => "4g",
            "Lysine" => "2.1g",
            "Leucine" => "2.0g",
            "Isoleucine" => "2.7g",
            "Valine" => "2.6g",
            "Threonine" => "1.8g",
            "Methionine" => "1.2g",
            "Phenylalanine" => "1.4g",
            "Histidine" => "1.1g",
            "Arginine" => "1.3g",
            "Saturated Fats" => "7g",
            "Unsaturated Fats" => "10g",
            "Omega-3 Fatty Acids" => "1.5g",
            "Omega-6 Fatty Acids" => "1.2g",
            "Trans Fats" => "0.3g",
            "Vitamin A" => "700µg",
            "Vitamin B1 (Thiamine)" => "1.2mg",
            "Vitamin B2 (Riboflavin)" => "1.3mg",
            "Vitamin B6 (Pyridoxine)" => "1.7mg",
            "Vitamin B12 (Cobalamin)" => "2.4µg",
            "Vitamin C" => "90mg",
            "Vitamin D" => "15µg",
            "Vitamin E" => "10mg",
            "Vitamin K" => "120µg",
            "Calcium" => "1000mg",
            "Iron" => "18mg",
            "Magnesium" => "400mg",
            "Potassium" => "3500mg",
            "Sodium" => "2300mg",
            "Zinc" => "11mg",
            "Phosphorus" => "700mg",
            "Copper" => "0.9mg",
            "Manganese" => "2.3mg",
            "Fluoride" => "4mg",
        ];

        // 今日の日付
        $today = Carbon::now();

        // サンプルデータの生成
        $data = [];
        for ($i = 1; $i <= 50; $i++) {
            $currentDate = $today->copy()->subDays($i); // 昨日から50日前までの日付を計算

            for ($userId = 2; $userId <= 3; $userId++) {
                foreach ($mealTypes as $mealType) {
                    $data[] = [
                        'weight' => rand(50, 100), // 体重
                        'meal_type' => $mealType, // ランダムなmeal_type
                        'meal_content' => "Sample content for {$mealType}",
                        'comment' => 'happy meal',
                        'image' => null, // 画像は今回はnull
                        'nutritions' => json_encode([
                            "Proteins" => rand(20, 60) . "g",
                            "Fats" => rand(10, 30) . "g",
                            "Carbohydrates" => rand(80, 120) . "g",
                            "Vitamins" => rand(10, 20) . "mg",
                            "Minerals" => rand(100, 300) . "mg",
                            "Subcategories" => $subcategories,
                        ]),
                        'meal_calorie' => rand(200, 700), // カロリー
                        'user_id' => $userId, // ユーザーID
                        'input_date' => $currentDate->toDateString(),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }
        }

        // データを挿入
        DB::table('daily_logs')->insert($data);

        $this->command->info('Daily log data with input_date and 50 days range has been seeded successfully.');
    }
}
