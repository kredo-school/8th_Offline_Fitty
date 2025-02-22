<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Advice;
use App\Models\User;

class AdviceSeeder extends Seeder
{
    public function run()
    {
        $advices = [];

        // ユーザー情報を取得
        $users = User::where('role', 'U')->take(2)->get();

        foreach ($users as $user) {
            for ($i = 1; $i <= 100; $i++) {
                $advices[] = [
                    'overall' => rand(1, 5), // ランダムな評価（1〜5）
                    'message' => 'Advice message for user ' . $user->id, // 仮のアドバイス内容
                    'user_id' => $user->id, // ユーザーIDを紐付け
                    'nutritionist_id' => $user->id + 50, // ユーザーIDを紐付け
                    'created_at' => now()->subDays(7*$i), // 過去30日以内のランダムな日付
                    'updated_at' => now(),
                ];
            }
        }

        // データを一括挿入
        Advice::insert($advices);

        $this->command->info('Advice data has been seeded successfully.');
    }
}
