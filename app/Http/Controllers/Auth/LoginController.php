<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Redirect users after login based on their role.
     *
     * @return string
     */
    protected function redirectTo()
    {
        $role = Auth::user()->role;

        switch ($role) {
            case 'A':
                return '/admin/home'; // 管理者のリダイレクト先
            case 'N':
                return '/nutri/index'; // 栄養士のリダイレクト先
            case 'U':
                return '/user/profile'; // 一般ユーザーのリダイレクト先
            default:
                return '/home'; // デフォルトのリダイレクト先
        }
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }
}
