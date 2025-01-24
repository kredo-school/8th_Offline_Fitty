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
            ['name' => 'Simple Sugars', 'category_id' => 1, 'requirement' => 500],
            ['name' => 'Complex Carbohydrates', 'category_id' => 1, 'requirement' => 500],
            ['name' => 'Fiber', 'category_id' => 1, 'requirement' => 300],
            ['name' => 'Starches', 'category_id' => 1, 'requirement' => 2000],
            ['name' => 'Polysaccharides', 'category_id' => 1, 'requirement' => 2000],

            // Proteins (category_id = 2) - Amino acids
            ['name' => 'Lysine', 'category_id' => 2, 'requirement' => 30],
            ['name' => 'Leucine', 'category_id' => 2, 'requirement' => 39],
            ['name' => 'Isoleucine', 'category_id' => 2, 'requirement' => 20],
            ['name' => 'Valine', 'category_id' => 2, 'requirement' => 26],
            ['name' => 'Threonine', 'category_id' => 2, 'requirement' => 15],
            ['name' => 'Tryptophan', 'category_id' => 2, 'requirement' => 4],
            ['name' => 'Methionine', 'category_id' => 2, 'requirement' => 11],
            ['name' => 'Phenylalanine', 'category_id' => 2, 'requirement' => 25],
            ['name' => 'Histidine', 'category_id' => 2, 'requirement' => 10],
            ['name' => 'Arginine', 'category_id' => 2, 'requirement' => 31],

            // Fats (category_id = 3)
            ['name' => 'Saturated Fats', 'category_id' => 3, 'requirement' => 225],
            ['name' => 'Unsaturated Fats', 'category_id' => 3, 'requirement' => 350],
            ['name' => 'Omega-3 Fatty Acids', 'category_id' => 3, 'requirement' => 50],
            ['name' => 'Omega-6 Fatty Acids', 'category_id' => 3, 'requirement' => 150],
            // ['name' => 'Trans Fats', 'category_id' => 3, 'requirement' => 0],

            // Vitamins (category_id = 4)
            ['name' => 'Vitamin A', 'category_id' => 4, 'requirement' => 0.012],
            ['name' => 'Vitamin B1 (Thiamine)', 'category_id' => 4, 'requirement' => 0.17],
            ['name' => 'Vitamin B2 (Riboflavin)', 'category_id' => 4, 'requirement' => 0.017],
            ['name' => 'Vitamin B6 (Pyridoxine)', 'category_id' => 4, 'requirement' => 0.21],
            ['name' => 'Vitamin B12 (Cobalamin)', 'category_id' => 4, 'requirement' => 0.00004], // mg表記
            ['name' => 'Vitamin C', 'category_id' => 4, 'requirement' => 1.15],
            ['name' => 'Vitamin D', 'category_id' => 4, 'requirement' => 0.00015],
            ['name' => 'Vitamin E', 'category_id' => 4, 'requirement' => 0.21],
            ['name' => 'Vitamin K', 'category_id' => 4, 'requirement' => 0.0016],

            // Minerals (category_id = 5)
            ['name' => 'Calcium', 'category_id' => 5, 'requirement' => 14],
            ['name' => 'Iron', 'category_id' => 5, 'requirement' => 0.142],
            ['name' => 'Magnesium', 'category_id' => 5, 'requirement' => 5.7],
            ['name' => 'Potassium', 'category_id' => 5, 'requirement' => 50],
            ['name' => 'Sodium', 'category_id' => 5, 'requirement' => 28],
            ['name' => 'Zinc', 'category_id' => 5, 'requirement' => 0.157],
            ['name' => 'Phosphorus', 'category_id' => 5, 'requirement' => 10],
            ['name' => 'Copper', 'category_id' => 5, 'requirement' => 0.013], // mg表記
            ['name' => 'Manganese', 'category_id' => 5, 'requirement' => 0.033],
            ['name' => 'Fluoride', 'category_id' => 5, 'requirement' => 0.05],
        ];

        // Add timestamps
        foreach ($subCategories as &$subCategory) {
            $subCategory['created_at'] = now();
            $subCategory['updated_at'] = now();
        }

        // Insert data into the database
        DB::table('sub_categories')->insert($subCategories);

        $this->command->info('Sub-categories with mg/kg requirement data have been seeded successfully.');
    }
}
