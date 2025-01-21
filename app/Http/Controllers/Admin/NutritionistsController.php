<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Nutritionist; // モデルを使用
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NutritionistsController extends Controller
{
    public function index()
    {
        $nutritionists = Nutritionist::paginate(10); // 1ページあたり10件
        return view('admin.nutritionists.index', compact('nutritionists'));
    }

    public function create()
    {
    $user = Auth::user(); // 現在ログインしているユーザーを取得

        // $user = auth()->user(); // 認証されたユーザーを取得
        // if (!$user) {
        //     // ユーザーが認証されていない場合、ログイン画面にリダイレクト
        //     return redirect()->route('login')->with('error', 'Please login to access this page.');
        // }

        // ダミー
        $user = (object)[
            'profile_photo_path' => null, // 画像パスを null に設定
            'name' => 'Sample User',
            'email' => 'sample@example.com',
            'memo' => 'This is a sample memo.'
        ];
    
        return view('admin.nutritionists.profile.register', compact('user'));

    }
    

}


