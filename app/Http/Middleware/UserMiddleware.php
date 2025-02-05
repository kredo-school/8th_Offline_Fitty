<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class UserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Redirect users with the role 'N' (nutritionists) to the login page
        // This page is intended for regular users('U') and admins ('A') only
        if (Auth::check() && Auth::user()->role == 'N') {
            return redirect()->route('login'); // Redirect to the login page
        }

        return $next($request);
    }
}
