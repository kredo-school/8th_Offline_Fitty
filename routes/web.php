<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('/landing', function () {
    return view('landing');
});

Route::get('/about', function () {
    return view('about');
});

Route::get('/team', function(){
    return view('team');
});

Route::get('/contact', function(){
    return view('contact');
});
