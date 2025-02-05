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
        // Redirect users with the role 'U' (regular users) to the login page
        // This page is intended for nutritionists ('N') and admins ('A') only
        if (Auth::check() && Auth::user()->role == 'U') {
            return redirect()->route('login'); // Redirect to the login page
        }

        return $next($request);

    }
}
