<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class UsersTableSeeder extends Seeder
{
    private $user;

    public function __construct(User $user){
        $this->user = $user;
    }
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [];

        // for ($i = 1; $i <= 50; $i++) {
        //     $users[] = [
        //         'name' => 'test' . $i,
        //         'email' => 'test' . $i . '@gmail.com',
        //         'password' => Hash::make('test' . (8000 + $i)),
        //         'birthday' => now()->subYears(rand(20, 40))->format('Y-m-d'),
        //         'height' => rand(150, 200),
        //         'profile_image' => null, // アバター画像は空
        //         'gender' => rand(0, 1) ? 'male' : 'female', // maleまたはfemaleをランダムに設定
        //         'activity_level' => rand(1, 3), // 1~3のランダム値
        //         'nutritionist_memo' => $i % 2 == 0 ? 'Moderate activity level.' : null, // 偶数の人のみメモあり
        //         'role' => 'user', // 全員ユーザー権限
        //         'nutritionist_id' => rand(1, 5),
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ];
        // }

        for ($i = 1; $i <= 50; $i++) {
            $users[] = [
                'name' => 'test' . $i,
                'email' => 'test' . $i . '@gmail.com',
                'password' => Hash::make('test' . (8000 + $i)),
                'birthday' => now()->subYears(rand(20, 40))->format('Y-m-d'),
                'height' => rand(120, 220),
                'profile_image' => 'default_avatar.png', // プロフィール画像はデフォルト
                'gender' => ['male', 'female', 'non_binary', 'other', 'prefer_not_to_say'][rand(0, 4)], // ランダムな性別を設定
                'exercise_frequency' => ['Level_1', 'Level_2', 'Level_3'][rand(0, 2)], // ランダムな運動頻度
                'role' => 'user', // 全員ユーザー権限
                'nutritionist_id' => rand(1, 5), // ランダムな栄養士ID
                'health_conditions' => json_encode($i % 2 == 0 ? ['chronic_disease'] : []), // 偶数の人は「慢性疾患」、それ以外は空
                'dietary_preferences' => json_encode($i % 3 == 0 ? ['vegetarian'] : []), // 3の倍数の人は「ベジタリアン」、それ以外は空
                'food_allergies' => $i % 4 == 0 ? 'peanuts' : null, // 4の倍数の人のみアレルギーあり
                'goals' => $i % 5 == 0 ? 'Weight management' : null, // 5の倍数の人は特定の目標あり
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        
        // データベースに挿入
        
        $this->user->insert($users);

    }
}
