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

//user dailylog
Route::get('/user/dailylog', [App\Http\Controllers\UserController::class, 'showdailylog'])->name('user.dailylog');
