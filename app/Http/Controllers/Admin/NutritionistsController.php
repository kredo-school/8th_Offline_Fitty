<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Nutritionist; // モデルを使用
use Illuminate\Http\Request;

class NutritionistsController extends Controller
{
    public function index()
    {
        $nutritionists = Nutritionist::paginate(10); // 1ページあたり10件
        return view('admin.nutritionists.index', compact('nutritionists'));
    }

    public function create()
    {
        $user = auth()->user(); // 認証されたユーザーを取得
        return view('admin.nutritionists.', compact('user'));
    }
}


