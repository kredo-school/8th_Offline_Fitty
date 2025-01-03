<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\NutritionistsController;
use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Admin\InquiriesController;

// Welcomeページ
Route::get('/', function () {
    return view('welcome');
});

// Laravelのデフォルト認証ルート
Auth::routes();

// Adminルート
Route::prefix('admin')->name('admin.')->group(function () {

    // 認証関連のルート
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AuthController::class, 'login']);
    Route::get('password/request', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');

    // Admin Dashboard
    Route::get('/index', [AdminController::class, 'index'])->name('index');

    // リソース別ルート
    Route::get('/users', [UsersController::class, 'index'])->name('users.index');
    Route::get('/nutritionists', [NutritionistsController::class, 'index'])->name('nutritionists.index');
    Route::get('/inquiries', [InquiriesController::class, 'index'])->name('inquiries.index');

    // Categories関連のルート
    Route::get('/categories', [CategoriesController::class, 'index'])->name('categories.index');
    Route::post('/categories', [CategoriesController::class, 'store'])->name('categories.store');
    Route::put('/categories/{id}', [CategoriesController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{id}', [CategoriesController::class, 'destroy'])->name('categories.destroy');
}); 

