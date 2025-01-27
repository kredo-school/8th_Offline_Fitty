<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function sendTestMail()
    {
        // 送信先メールアドレス
        $toEmail = 'test@example.com';

        // データをテンプレートに渡す
        $data = [
            'name' => 'テストユーザー',
            'messageContent' => 'これはテストメールです。'
        ];

        // メール送信
        Mail::send('emails.reminder', $data, function($message) use ($toEmail) {
            $message->to($toEmail)
                    ->subject('テストメール送信');
        });

        // 送信完了メッセージ
        return response()->json(['message' => 'テストメールを送信しました！']);
    }
}
