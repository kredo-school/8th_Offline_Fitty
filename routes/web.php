<?php

use App\Http\Controllers\NutritionistController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;


Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::group(['middleware' => 'auth'], function(){
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::group(['prefix' => 'nutri', 'as' => 'nutri.'], function(){

        Route::get('nutri/sendAdvice', [NutritionistController::class, 'sendAdvice'])->name('sendAdvice');
        Route::get('nutri/history', [NutritionistController::class, 'history']);
    });
});

Route::get('/nutri/index', [NutritionistController::class, 'index'])->name('index');


//user dailylog
Route::get('/user/dailylog', [App\Http\Controllers\UserController::class, 'showdailylog'])->name('user.dailylog');
