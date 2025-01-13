<?php

use App\Http\Controllers\MultiStepRegisterController;


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
//  Auth::routes();
 Auth::routes(['register' => false]); 
//  デフォルトの /register を無効化


// Register
Route::prefix('register')->group(function () {
    Route::get('/step1', [MultiStepRegisterController::class, 'showStep1'])->name('register.step1');
    Route::post('/step1', [MultiStepRegisterController::class, 'processStep1'])->name('register.step1.submit');
    Route::get('/step2', [MultiStepRegisterController::class, 'showStep2'])->name('register.step2');
    Route::patch('/step2', [MultiStepRegisterController::class, 'processStep2'])->name('register.step2.submit');
});



Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/nutri/index', [NutritionistController::class, 'index']);
Route::get('nutri/sendAdvice', [NutritionistController::class, 'sendAdvice']);
Route::get('nutri/history', [NutritionistController::class, 'history']);


//user dailylog
Route::get('/user/dailylog', [App\Http\Controllers\UserController::class, 'showdailylog'])->name('user.dailylog');
Route::get('/user/inputmeal', [App\Http\Controllers\UserController::class, 'showinputmeal'])->name('user.inputmeal');
Route::get('/user/history', [App\Http\Controllers\UserController::class, 'showhistory'])->name('user.history');
