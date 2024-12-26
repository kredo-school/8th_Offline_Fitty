<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Welcomeページ
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// 認証ルートを有効化
Auth::routes();

// ホームページルート
Route::get('/home', [HomeController::class, 'index'])->name('home');

// Registerページルート
Route::get('/register', function () {
    return view('auth.register'); // resources/views/auth/register.blade.php
})->name('register');
