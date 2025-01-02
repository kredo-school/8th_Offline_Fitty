<?php

use App\Http\Controllers\NutritionistController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;


Route::get('/', function () {
    return view('welcome');
});

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
Route::get('/user/history', [App\Http\Controllers\UserController::class, 'showhistory'])->name('user.history');
