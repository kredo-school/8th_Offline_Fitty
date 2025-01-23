<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $subCategories = [
            // Carbohydrates (category_id = 1)
            ['name' => 'Simple Sugars', 'category_id' => 1, 'requirement' => 300000],
            ['name' => 'Complex Carbohydrates', 'category_id' => 1, 'requirement' => 400000],
            ['name' => 'Fiber', 'category_id' => 1, 'requirement' => 25000],
            ['name' => 'Starches', 'category_id' => 1, 'requirement' => 300000],
            ['name' => 'Polysaccharides', 'category_id' => 1, 'requirement' => 20000],

            // Proteins (category_id = 2) - Amino acids
            ['name' => 'Lysine', 'category_id' => 2, 'requirement' => 2400],
            ['name' => 'Leucine', 'category_id' => 2, 'requirement' => 4200],
            ['name' => 'Isoleucine', 'category_id' => 2, 'requirement' => 2000],
            ['name' => 'Valine', 'category_id' => 2, 'requirement' => 2000],
            ['name' => 'Threonine', 'category_id' => 2, 'requirement' => 1500],
            ['name' => 'Tryptophan', 'category_id' => 2, 'requirement' => 250],
            ['name' => 'Methionine', 'category_id' => 2, 'requirement' => 1200],
            ['name' => 'Phenylalanine', 'category_id' => 2, 'requirement' => 1500],
            ['name' => 'Histidine', 'category_id' => 2, 'requirement' => 1000],
            ['name' => 'Arginine', 'category_id' => 2, 'requirement' => 3100],

            // Fats (category_id = 3)
            ['name' => 'Saturated Fats', 'category_id' => 3, 'requirement' => 20000],
            ['name' => 'Unsaturated Fats', 'category_id' => 3, 'requirement' => 40000],
            ['name' => 'Omega-3 Fatty Acids', 'category_id' => 3, 'requirement' => 1600],
            ['name' => 'Omega-6 Fatty Acids', 'category_id' => 3, 'requirement' => 17000],
            ['name' => 'Trans Fats', 'category_id' => 3, 'requirement' => 0],

            // Vitamins (category_id = 4)
            ['name' => 'Vitamin A', 'category_id' => 4, 'requirement' => 900],
            ['name' => 'Vitamin B1 (Thiamine)', 'category_id' => 4, 'requirement' => 1200],
            ['name' => 'Vitamin B2 (Riboflavin)', 'category_id' => 4, 'requirement' => 1300],
            ['name' => 'Vitamin B6 (Pyridoxine)', 'category_id' => 4, 'requirement' => 1600],
            ['name' => 'Vitamin B12 (Cobalamin)', 'category_id' => 4, 'requirement' => 2.4],
            ['name' => 'Vitamin C', 'category_id' => 4, 'requirement' => 90000],
            ['name' => 'Vitamin D', 'category_id' => 4, 'requirement' => 15],
            ['name' => 'Vitamin E', 'category_id' => 4, 'requirement' => 15],
            ['name' => 'Vitamin K', 'category_id' => 4, 'requirement' => 120],

            // Minerals (category_id = 5)
            ['name' => 'Calcium', 'category_id' => 5, 'requirement' => 1000000],
            ['name' => 'Iron', 'category_id' => 5, 'requirement' => 18000],
            ['name' => 'Magnesium', 'category_id' => 5, 'requirement' => 400000],
            ['name' => 'Potassium', 'category_id' => 5, 'requirement' => 3500000],
            ['name' => 'Sodium', 'category_id' => 5, 'requirement' => 2300000],
            ['name' => 'Zinc', 'category_id' => 5, 'requirement' => 11000],
            ['name' => 'Phosphorus', 'category_id' => 5, 'requirement' => 700000],
            ['name' => 'Copper', 'category_id' => 5, 'requirement' => 900],
            ['name' => 'Manganese', 'category_id' => 5, 'requirement' => 2300],
            ['name' => 'Fluoride', 'category_id' => 5, 'requirement' => 4000],
        ];

        // 各データにタイムスタンプを追加
        foreach ($subCategories as &$subCategory) {
            $subCategory['created_at'] = now();
            $subCategory['updated_at'] = now();
        }

        // データを挿入
        DB::table('sub_categories')->insert($subCategories);

        $this->command->info('Sub-categories with detailed data have been seeded successfully.');
    }
}
