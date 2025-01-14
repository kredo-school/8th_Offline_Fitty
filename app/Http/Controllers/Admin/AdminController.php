<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // トップページ
    public function index()
    {
        return view('admin.index');
    }

    // ユーザー一覧ページ
    public function users()
    {
        return view('admin.users.index');
    }

    // 栄養士一覧ページ
    public function nutritionists()
    {
        return view('admin.nutritionists.index');
    }

    // カテゴリ管理ページ
    public function categories()
    {
        return view('admin.categories.index');
    }

    // 問い合わせ一覧ページ
    public function inquiries()
    {
        return view('admin.inquiries.index');
    }
}
