<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (!Auth::check()) {
            return view('home'); // 未ログインの場合のリダイレクト先
        }
    
        switch (Auth::user()->role) {
            case 'A':
                return  redirect('/admin/index'); // 管理者
            case 'N':
                return redirect('/nutri/index'); // 栄養士
            case 'U':
                $userId = Auth::user()->id;
                return redirect('/user/'.$userId.'/profile');
            default:
                return view('login');  // その他
        }

    }

    public function landing(){
        return view('landing');
    }

    public function about(){
        return view('about');
    }

    public function team(){
        return view('team');
    }

    public function contact(){
        return view('contact');
    }
}
