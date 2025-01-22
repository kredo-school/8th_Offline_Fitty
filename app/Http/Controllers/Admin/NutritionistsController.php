<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Nutritionist; // モデルを使用
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NutritionistsController extends Controller
{
    private $user;
    private $user_profile;

    public function __construct(UserProfile $user_profile, User $user)
    {
        $this->user_profile = $user_profile;
        $this->user = $user;
    }
    public function index()
    {


        $nutritionists = Nutritionist::paginate(10); // 1ページあたり10件
        return view('admin.nutritionists.index', compact('nutritionists'));
    }

    public function create()
    {
    $user = Auth::user(); // 現在ログインしているユーザーを取得



        return view('admin.nutritionists.profile.register', compact('user'));

    }
    

}


