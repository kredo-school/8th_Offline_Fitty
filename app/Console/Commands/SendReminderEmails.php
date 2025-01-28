<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReminderMail;

class SendReminderEmails extends Command
{
    protected $signature = 'reminder:send';
    protected $description = 'Send daily reminder emails';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $users = \App\Models\User::all(); // 送信対象のユーザーを取得

        foreach ($users as $user) {
            $data = [
                'message' => "Hello {$user->name}, this is your daily reminder!"
            ];
            Mail::to($user->email)->send(new ReminderMail($data));
        }

        $this->info('Reminder emails have been sent successfully.');
    }
}
