<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserProfile;

use Illuminate\Support\Facades\Auth;



class NutritionistController extends Controller
{
    private $user;
    private $user_profile;

    public function __construct(User $user, UserProfile $user_profile)
    {
        $this->user = $user;
        $this->user_profile = $user_profile;

    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        // 栄養士に関連するユーザー情報を取得
        $user_profiles = $this->user_profile->where('nutritionist_id', Auth::user()->id)->get();

        // 栄養士とその関連ユーザー情報をビューに渡す
        return view('nutritionists.index', compact('user_profiles'));
    }


    function sendAdvice($id){
        $user_profile = $this->user_profile->where('user_id', $id)->first();


        return view('nutritionists.sendAdvice', compact('user_profile'));
    }






    function profile(){
        return view('nutritionists.profile');
    }
    function editprofile(){
        return view('nutritionists.editprofile');
    }

    /**
     * Show the form for creating a new resource.
     */

}
