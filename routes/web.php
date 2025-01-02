<?php

use App\Http\Controllers\NutritionistController;
use Illuminate\Support\Facades\Route;
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
    return view('welcome');
})->name('welcome');

// 認証ルートを有効化
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/nutri/index', [NutritionistController::class, 'index']);

//user dailylog
Route::get('/user/dailylog', [App\Http\Controllers\UserController::class, 'showdailylog'])->name('user.dailylog');
