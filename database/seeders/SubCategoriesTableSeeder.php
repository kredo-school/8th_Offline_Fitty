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
            ['name' => 'Simple Sugars', 'category_id' => 1],
            ['name' => 'Complex Carbohydrates', 'category_id' => 1],
            ['name' => 'Fiber', 'category_id' => 1],
            ['name' => 'Starches', 'category_id' => 1],
            ['name' => 'Polysaccharides', 'category_id' => 1],

            // Proteins (category_id = 2) - Amino acids
            ['name' => 'Lysine', 'category_id' => 2],
            ['name' => 'Leucine', 'category_id' => 2],
            ['name' => 'Isoleucine', 'category_id' => 2],
            ['name' => 'Valine', 'category_id' => 2],
            ['name' => 'Threonine', 'category_id' => 2],
            ['name' => 'Tryptophan', 'category_id' => 2],
            ['name' => 'Methionine', 'category_id' => 2],
            ['name' => 'Phenylalanine', 'category_id' => 2],
            ['name' => 'Histidine', 'category_id' => 2],
            ['name' => 'Arginine', 'category_id' => 2],

            // Fats (category_id = 3)
            ['name' => 'Saturated Fats', 'category_id' => 3],
            ['name' => 'Unsaturated Fats', 'category_id' => 3],
            ['name' => 'Omega-3 Fatty Acids', 'category_id' => 3],
            ['name' => 'Omega-6 Fatty Acids', 'category_id' => 3],
            ['name' => 'Trans Fats', 'category_id' => 3],

            // Vitamins (category_id = 4)
            ['name' => 'Vitamin A', 'category_id' => 4],
            ['name' => 'Vitamin B1 (Thiamine)', 'category_id' => 4],
            ['name' => 'Vitamin B2 (Riboflavin)', 'category_id' => 4],
            ['name' => 'Vitamin B6 (Pyridoxine)', 'category_id' => 4],
            ['name' => 'Vitamin B12 (Cobalamin)', 'category_id' => 4],
            ['name' => 'Vitamin C', 'category_id' => 4],
            ['name' => 'Vitamin D', 'category_id' => 4],
            ['name' => 'Vitamin E', 'category_id' => 4],
            ['name' => 'Vitamin K', 'category_id' => 4],

            // Minerals (category_id = 5)
            ['name' => 'Calcium', 'category_id' => 5],
            ['name' => 'Iron', 'category_id' => 5],
            ['name' => 'Magnesium', 'category_id' => 5],
            ['name' => 'Potassium', 'category_id' => 5],
            ['name' => 'Sodium', 'category_id' => 5],
            ['name' => 'Zinc', 'category_id' => 5],
            ['name' => 'Phosphorus', 'category_id' => 5],
            ['name' => 'Copper', 'category_id' => 5],
            ['name' => 'Manganese', 'category_id' => 5],
            ['name' => 'Fluoride', 'category_id' => 5],
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
