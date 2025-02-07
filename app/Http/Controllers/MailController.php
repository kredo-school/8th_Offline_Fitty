<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\User;


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

    public function sendThankYouMail($id)
    {
        // ユーザー情報を取得
        $user = User::find($id);

        // ユーザーが見つからない場合のエラーハンドリング
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        // メールデータをテンプレートに渡す
        $data = [
            'user' => $user,
        ];

        // メール送信
        Mail::send('emails.thanksMail', $data, function ($message) use ($user) {
            $message->to($user->email)
                    ->subject('Thank You for Your Inquiry');
        });

        // 送信完了メッセージ
        return response()->json(['message' => 'Thank you email sent successfully!']);
    }

}
