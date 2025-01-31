<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReminderMail;
use App\Models\Dailylog;
use App\Models\User;
use Carbon\Carbon;

class SendReminderEmails extends Command
{
    /**
     * コマンドのシグネチャ（実行するための名前）
     *
     * @var string
     */
    protected $signature = 'email:send-reminders';

    /**
     * コマンドの説明
     *
     * @var string
     */
    protected $description = '前日の食事ログが未入力のユーザーにリマインダーメールを送信する';

    /**
     * コマンドの実行ロジック
     */
    public function handle()
    {
        // 役割が 'U' のユーザーのみ取得（テスト時は2件のみ）
        $users = User::where('role', 'U')->take(2)->get();

        foreach ($users as $user) {
            
            // 前日の食事ログを取得
            $meals = Dailylog::where('user_id', $user->id)
                ->whereDate('created_at', Carbon::yesterday())
                ->pluck('meal_type');

            // 必要な食事タイプ
            $requiredMeals = ['breakfast', 'lunch', 'dinner'];

            // `$meals` が空でも処理できるように対策
            $missingMeals = $meals->isNotEmpty() ? array_diff($requiredMeals, $meals->toArray()) : $requiredMeals;

            if (!empty($missingMeals)) {
                // リマインダーメールを送信
                Mail::to($user->email)->send(new ReminderMail($user, $missingMeals));

                // ターミナルに出力
                $this->info("リマインダーメールを送信しました: {$user->email}");
            }
        }

        $this->info('リマインダーメール送信処理が完了しました。');
    }
}
