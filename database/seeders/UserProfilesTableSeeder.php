<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UserProfile;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserProfilesTableSeeder extends Seeder
{
    public function run()
    {
        $profiles = [];

        // ユーザー情報を取得
        $users = User::where('role', 'U')->get();

        foreach ($users as $user) {
            $profiles[] = [
                'user_id' => $user->id,
                'first_name' => 'First' . $user->id,
                'last_name' => 'Last' . $user->id,
                'gender' => rand(0, 1) ? 'male' : 'female', // maleまたはfemaleをランダムに設定, // usersテーブルのgenderを利用
                'birthday' => now()->subYears(rand(20, 40))->format('Y-m-d'),
                'height' => rand(150, 200),
                'activity_level' => rand(1, 3),
                'profile_image' => null, // デフォルト値
                'memo' => $user->nutritionist_memo, // usersテーブルからコピー
                'nutritionist_memo' => $user->nutritionist_memo,
                'advice_sent_date' => now()->subDays(rand(0, 30)), // 過去30日以内の日付をランダム設定
                'nutritionist_id' => User::where('role', 'N')->inRandomOrder()->value('id'), // usersテーブルのnutritionist_idを使用
                'health_conditions' => json_encode(['Pregnant', 'Mental Health Issues']), // 仮の健康状態
                'dietary_preferences' => json_encode(['Vegetarian', 'Vegan']), // 仮の食事制限
                'food_allergies' => 'peanuts, dairy', // 仮の食物アレルギー
                'goals' => 'Lose weight and improve stamina.', // 仮の目標
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // データを一括挿入
        UserProfile::insert($profiles);

        $this->command->info('User profiles have been seeded successfully.');
    }
}
