<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // If the user is authenticated but does not have the role 'A' (admin)
        // Redirect them to the login page
        if (Auth::check() && Auth::user()->role !== 'A') {
            return redirect()->route('login'); // Redirect to the login page
        }
        
        return $next($request);
    }
}
