<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\NutritionistsProfile;

class NutritionistsProfilesTableSeeder extends Seeder
{
    public function run(): void
    {
        $profiles = [];

        // roleが'nutritionist'のユーザーを取得
        $users = User::where('role', 'N')->get();

        foreach ($users as $user) {
            $profiles[] = [
                'user_id' => $user->id,
                'first_name' => 'First' . $user->id, // 仮の名前
                'last_name' => 'Last' . $user->id,  // 仮の名字
                'introduction' => 'This is a memo for nutritionist ' . $user->id, // 仮のメモ
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // データを一括挿入
        NutritionistsProfile::insert($profiles);

        $this->command->info('Nutritionists profiles have been seeded successfully.');
    }
}
