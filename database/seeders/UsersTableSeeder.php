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

        for ($i = 1; $i <= 50; $i++) {
            $users[] = [
                'name' => 'test' . $i,
                'email' => 'test' . $i . '@gmail.com',
                'password' => Hash::make('test' . (8000 + $i)),
                'birthday' => now()->subYears(rand(20, 40))->format('Y-m-d'),
                'height' => rand(150, 200),
                'avatar' => null, // アバター画像は空
                'gender' => rand(0, 1) ? 'male' : 'female', // maleまたはfemaleをランダムに設定
                'activity_level' => rand(1, 3), // 1~3のランダム値
                'nutritionist_memo' => $i % 2 == 0 ? 'Moderate activity level.' : null, // 偶数の人のみメモあり
                'role' => 'user', // 全員ユーザー権限
                'nutritionist_id' => rand(1, 5),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        $this->user->insert($users);

    }
}
