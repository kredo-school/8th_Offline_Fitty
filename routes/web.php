<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\NutritionistController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\AdviceController;

use App\Models\Advice;

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

Route::get('/about', [App\Http\Controllers\Controller::class, 'about'])->name('about');
Route::get('/team', [App\Http\Controllers\Controller::class, 'team'])->name('team');
Route::get('/contact', [App\Http\Controllers\Controller::class, 'contact'])->name('contact');


// 認証ルートを有効化
Auth::routes();

Route::group(['middleware' => 'auth'], function(){
    Route::group(['prefix' => 'nutri', 'as' => 'nutri.'], function(){
        Route::get('index', [NutritionistController::class, 'index'])->name('index');
        Route::get('/sendAdvice/{id}', [NutritionistController::class, 'sendAdvice'])->name('sendAdvice');
        Route::post('store',[AdviceController::class, 'store'])->name('store');
        Route::post('/updateMemo/{id}', [AdviceController::class, 'updateMemo'])->name('updateMemo');

        Route::get('history/{id}', [AdviceController::class, 'history'])->name('history');
    });
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/nutri/profile', [NutritionistController::class, 'profile']);
Route::get('/nutri/editprofile', [NutritionistController::class, 'editprofile']);



//user dailylog
Route::get('/user/dailylog', [App\Http\Controllers\UserController::class, 'showdailylog'])->name('user.dailylog');
Route::get('/user/inputmeal', [App\Http\Controllers\UserController::class, 'showinputmeal'])->name('user.inputmeal');
Route::get('/user/profile', [App\Http\Controllers\UserController::class, 'profile'])->name('user.profile');
Route::get('/user/{id}/editprofile', [App\Http\Controllers\UserController::class, 'editprofile'])->name('user.editprofile');
Route::patch('/user/{id}/update', [App\Http\Controllers\UserController::class, 'profileupdate'])->name('user.update');
Route::patch('/user/{id}/changePassword', [App\Http\Controllers\UserController::class, 'changePassword'])->name('user.change_password');
Route::get('/user/history', [App\Http\Controllers\UserController::class, 'showhistory'])->name('user.history');

