<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            ['name' => 'Carbohydrates', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Proteins', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Fats', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Vitamins', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Minerals', 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('categories')->insert($categories);

        $this->command->info('Categories for the 5 major nutrients have been seeded successfully.');
    }
}
