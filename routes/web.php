<?php

use App\Http\Controllers\NutritionistController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\NutritionistsController;
use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Admin\InquiriesController;

use Illuminate\Support\Facades\Auth;


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

// Laravelのデフォルト認証ルート
Auth::routes();

// Adminルート
Route::prefix('admin')->name('admin.')->group(function () {

    // // 認証関連のルート
    // Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
    // Route::post('login', [AuthController::class, 'login']);
    // Route::get('password/request', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');

    // Admin Index
    Route::get('/index', [AdminController::class, 'index'])->name('index');

    // リソース別ルート
    Route::get('/users', [UsersController::class, 'index'])->name('users.index');
    Route::delete('/users/{user}', [UsersController::class, 'destroy'])->name('users.destroy');

    Route::get('/nutritionists', [NutritionistsController::class, 'index'])->name('nutritionists.index');
    Route::get('/inquiries', [InquiriesController::class, 'index'])->name('inquiries.index');

    // Categories関連のルート
    Route::get('/categories', [CategoriesController::class, 'index'])->name('categories.index');
    Route::post('/categories', [CategoriesController::class, 'store'])->name('categories.store');
    Route::put('/categories/{id}', [CategoriesController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{id}', [CategoriesController::class, 'destroy'])->name('categories.destroy');
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
Route::get('/user/{id}/editprofile', [App\Http\Controllers\UserController::class, 'editprofile'])->name('user.editprofile');
Route::get('/user/history', [App\Http\Controllers\UserController::class, 'showhistory'])->name('user.history');

