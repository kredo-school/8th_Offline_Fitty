<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    // ログインフォームの表示
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    // ログイン処理
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (auth()->attempt($credentials)) {
            return redirect()->route('admin.users.index'); // ダッシュボードにリダイレクト
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    // パスワードリセットフォーム
    public function showForgotPasswordForm()
    {
        return view('admin.auth.passwords.email');
    }
}


