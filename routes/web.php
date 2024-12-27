<?php

use App\Http\Controllers\NutritionistController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;


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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/nutri/index', [NutritionistController::class, 'index']);
Route::get('nutri/sendAdvice', [NutritionistController::class, 'sendAdvice']);

//user dailylog
Route::get('/user/dailylog', [App\Http\Controllers\UserController::class, 'showdailylog'])->name('user.dailylog');
