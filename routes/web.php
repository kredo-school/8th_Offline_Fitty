<?php

use App\Http\Controllers\NutritionistController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UsersController;


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
    return view('landing');
});

Route::get('/about', function () {
    return view('about');
});

Route::get('/team', function () {
    return view('team');
});

Route::get('/contact', function () {
    return view('contact');
});

// 認証ルートを有効化
Auth::routes();



Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/nutri/index', [NutritionistController::class, 'index']);
Route::get('nutri/sendAdvice', [NutritionistController::class, 'sendAdvice']);
Route::get('nutri/history', [NutritionistController::class, 'history']);
Route::get('/nutri/profile', [NutritionistController::class, 'profile']);
Route::get('/nutri/editprofile', [NutritionistController::class, 'editprofile']);



//user dailylog
Route::get('/user/dailylog', [App\Http\Controllers\UserController::class, 'showdailylog'])->name('user.dailylog');
Route::get('/user/inputmeal', [App\Http\Controllers\UserController::class, 'showinputmeal'])->name('user.inputmeal');
Route::get('/user/profile', [App\Http\Controllers\UserController::class, 'profile'])->name('user.profile');
Route::get('/user/editprofile', [App\Http\Controllers\UserController::class, 'editprofile'])->name('user.editprofile');
Route::get('/user/history', [App\Http\Controllers\UserController::class, 'showhistory'])->name('user.history');
Route::get('/user/editprofile', [App\Http\Controllers\UserController::class, 'editprofile'])->name('user.editprofile');
