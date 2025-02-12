<?php

namespace Database\Seeders;

use App\Models\Nutritionist;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 他のシーダーも必要に応じて追加
        $this->call([
            UsersTableSeeder::class,  // ユーザーのシーダー
            UserProfilesTableSeeder::class,
            NutritionistsProfilesTableSeeder::class,
            CategoriesTableSeeder::class,
            SubCategoriesTableSeeder::class,
            DailyLogSeeder::class,
            InquirySeeder::class,
            AdviceSeeder::class,

        ]);

    }
}
