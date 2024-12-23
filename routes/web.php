<?php

use App\Http\Controllers\NutritionistController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/nutri/index', [NutritionistController::class, 'index']);
