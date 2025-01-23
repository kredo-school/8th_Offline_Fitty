<?php

use App\Http\Controllers\MultiStepRegisterController;


use App\Http\Controllers\Controller;
use App\Http\Controllers\NutritionistController;
use App\Http\Controllers\DailyLogController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\NutritionistsController;
use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\ChatGptController;
// use App\Http\Controllers\Admin\InquiriesController;

use Illuminate\Support\Facades\Auth;
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

// Laravelのデフォルト認証ルート
Auth::routes();

// Adminルート
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/index', [AdminController::class, 'index'])->name('index');
    Route::get('s', [UsersController::class, 'index'])->name('users.index');
    Route::delete('s/{user}', [UsersController::class, 'destroy'])->name('users.destroy');

    Route::get('/nutritionists', [NutritionistsController::class, 'index'])->name('nutritionists.index');
    Route::get('/nutritionists/create', [NutritionistsController::class, 'create'])->name('nutritionists.create');

    //Route::get('/inquiries', [InquiriesController::class, 'index'])->name('inquiries.index');

    Route::get('/categories', [CategoriesController::class, 'index'])->name('categories.index');
    Route::post('/categories', [CategoriesController::class, 'store'])->name('categories.store');
    Route::put('/categories/{id}', [CategoriesController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{id}', [CategoriesController::class, 'destroy'])->name('categories.destroy');
});

Route::get('/about', function () {
    return view('about');
});
Route::get('/about', [App\Http\Controllers\Controller::class, 'about'])->name('about');
Route::get('/team', [App\Http\Controllers\Controller::class, 'team'])->name('team');
Route::get('/contact', [App\Http\Controllers\Controller::class, 'contact'])->name('contact');


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



Route::group(['middleware' => 'auth'], function () {
    // *********************************************
    // *** nutritionists ***
    // *********************************************
    Route::group(['prefix' => 'nutri', 'as' => 'nutri.', 'middleware' => 'nutri'], function () {
        Route::get('/index', [NutritionistController::class, 'index'])->name('index');
        Route::get('/sendAdvice/{id}', [NutritionistController::class, 'sendAdvice'])->name('sendAdvice');
        Route::post('store', [AdviceController::class, 'store'])->name('store');
        Route::post('updateMemo/{id}', [AdviceController::class, 'updateMemo'])->name('updateMemo');
        Route::get('/{id}/editProfile', [NutritionistController::class, 'editProfile'])->name('editProfile');
        Route::patch('/{id}/update', [NutritionistController::class, 'nutriUpdate'])->name('update');
        Route::post('store',[AdviceController::class, 'store'])->name('store');
        Route::post('updateMemo/{id}',[AdviceController::class, 'updateMemo'])->name('updateMemo');
        Route::get('history/{id}', [AdviceController::class, 'history'])->name('history');
    });

    //any login user can access
    Route::group(['prefix' => 'nutri', 'as' => 'nutri.'], function () {
        Route::get('/{id}/profile', [NutritionistController::class, 'profile'])->name('profile');
    });


    // *********************************************
    // *** users ***
    // *********************************************

    //acess chatgpt api
    Route::post('/api/chatgpt', [ChatGptController::class, 'handleRequest']);
    
    Route::group(['prefix' => 'user', 'as' => 'user.', 'middleware' => 'user'], function () {
        Route::get('/dailylog', [App\Http\Controllers\UserController::class, 'showdailylog'])->name('dailylog');
        Route::get('/inputmeal', [App\Http\Controllers\UserController::class, 'showinputmeal'])->name('inputmeal');
        Route::post('/inputmeal/store', [App\Http\Controllers\DailyLogController::class, 'store'])->name('inputmeal.store');
        Route::get('/{id}/editprofile', [App\Http\Controllers\UserController::class, 'editprofile'])->name('editprofile');
        Route::patch('/{id}/update', [App\Http\Controllers\UserController::class, 'userUpdate'])->name('update');
        Route::patch('/{id}/changePassword', [App\Http\Controllers\UserController::class, 'changePassword'])->name('change_password');
        Route::get('/history', [App\Http\Controllers\UserController::class, 'showhistory'])->name('history');
    });
    
    //any login user can access
    Route::group(['prefix' => 'user', 'as' => 'user.'], function () {
        Route::get('/{id}/profile', [App\Http\Controllers\UserController::class, 'profile'])->name('profile');
    });


    /**/ /**/ 
});


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');



