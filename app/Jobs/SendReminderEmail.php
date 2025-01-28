<?php

namespace App\Jobs;

use App\Mail\ReminderEmail;
use App\Models\User;
use App\Models\DailyLog;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendReminderEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // 現在時刻の24時間前を取得
        $yesterday = Carbon::now()->subDay();

        // 24時間以内に記録がないユーザーを取得
        $usersWithoutLogs = User::whereDoesntHave('dailyLogs', function ($query) use ($yesterday) {
            $query->where('created_at', '>=', $yesterday);
        })->get();

        // 対象ユーザーにリマインダーを送信
        foreach ($usersWithoutLogs as $user) {
            Mail::to($user->email)->send(new ReminderEmail($user));
        }
    }
}
