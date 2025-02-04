<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class NutritionistMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // ユーザーが認証されていて、roleが'N'でない場合
        if (Auth::check() && Auth::user()->role == 'U') {
            // ログインページにリダイレクト
            return redirect()->route('login');
        }

        return $next($request);

    }
}
