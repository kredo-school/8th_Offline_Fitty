<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\UserController;
use App\Http\Controllers\NutritionistController;
use App\Http\Controllers\MultiStepRegisterController;
use App\Http\Controllers\DailyLogController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\InquiriesController;
use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Admin\NutritionistsController;
use App\Http\Controllers\UserProfileController;



use App\Http\Controllers\ChatGptController;


use App\Http\Controllers\MailController;

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
        Route::get('/sendAdvice/{id}', [AdviceController::class, 'sendAdvice'])->name('sendAdvice');
        Route::post('store', [AdviceController::class, 'store'])->name('store');
        Route::post('updateMemo/{id}', [AdviceController::class, 'updateMemo'])->name('updateMemo');
        Route::get('/{id}/editProfile', [NutritionistController::class, 'editProfile'])->name('editProfile');
        Route::patch('/{id}/updateProfile', [NutritionistController::class, 'updateProfile'])->name('updateProfile');
        Route::patch('/{id}/update', [NutritionistController::class, 'nutriUpdate'])->name('update');
        Route::post('store',[AdviceController::class, 'store'])->name('store');
        Route::post('updateMemo/{id}',[AdviceController::class, 'updateMemo'])->name('updateMemo');
        Route::get('history/{id}', [AdviceController::class, 'history'])->name('history');
        Route::get('{id}/showHistory', [AdviceController::class, 'showHistory'])->name('showHistory');
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


    //mail test
    Route::get('/send-test-mail', [MailController::class, 'sendTestMail']);
    Route::get('/send-thankyou-mail/{id}', [MailController::class, 'sendThankYouMail'])->name('send.thankyou.mail');



    Route::group(['prefix' => 'user', 'as' => 'user.', 'middleware' => 'user'], function () {

        Route::get('/inputmeal', [App\Http\Controllers\UserController::class, 'showinputmeal'])->name('inputmeal');
        Route::post('/inputmeal/store', [App\Http\Controllers\DailyLogController::class, 'store'])->name('inputmeal.store');
        Route::get('/{id}/editprofile', [App\Http\Controllers\UserController::class, 'editprofile'])->name('editprofile');
        Route::patch('/{id}/update', [App\Http\Controllers\UserController::class, 'userUpdate'])->name('update');



        //Users get advices
        Route::get('/advice', [AdviceController::class, 'index'])->name('advice.index');
        Route::get('/{id}/advice/show', [AdviceController::class, 'showAdvice'])->name('advice.showAdvice');
        Route::patch('/{id}/advice/{advice}/read', [AdviceController::class, 'readToggle'])->name('advice.read');
        Route::patch('{id}/advice/{advice}/unread', [AdviceController::class, 'unread'])->name('advice.unread');
        Route::patch('/{id}/advice/{advice}/like', [AdviceController::class, 'likeToggle'])->name('advice.like');
        Route::patch('{id}/advice/{advice}/unlike', [AdviceController::class, 'unlike'])->name('advice.unlike');
        //Users send inquiries
        Route::get('/{id}/sendInquiry', [UserController::class, 'showInquiryForm'])->name('sendInquiry.form');
        Route::post('{id}/sendInquiry', [UserController::class, 'storeInquiry'])->name('sendInquiry.store');

    });


    //any login user can access
    Route::group(['prefix' => 'user', 'as' => 'user.'], function () {
        Route::get('/{id}/profile', [App\Http\Controllers\UserController::class, 'profile'])->name('profile');
        Route::patch('/{id}/changePassword', [App\Http\Controllers\UserController::class, 'changePassword'])->name('change_password');
        Route::get('/{id}/dailylog/{date}', [App\Http\Controllers\DailylogController::class, 'showdailylog'])->name('dailylog');
        Route::get('/{id}/history/events', [DailyLogController::class, 'getEvents'])->name('dailylog.events');
        Route::get('/{id}/history', [App\Http\Controllers\UserController::class, 'showhistory'])->name('history');
        Route::get('/{id}/history/weight-data', [UserController::class, 'showWeightData'])->name('user.weightData');
    });

    // *********************************************
    // *** admin ***
    // *********************************************

    Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'admin'], function () {
        Route::get('/index', [AdminController::class, 'index'])->name('index');

        Route::get('/users', [UsersController::class, 'index'])->name('users.index');
        Route::delete('/users/{user}', [UsersController::class, 'destroy'])->name('users.destroy');
        Route::patch('/{id}/allocateNutritionist', [UsersController::class, 'allocateNutritionist'])->name('users.allocateNutritionist');

        Route::get('/nutritionists', [NutritionistsController::class, 'index'])->name('nutritionists.index');
        Route::post('/nutritionists/store', [NutritionistsController::class, 'store'])->name('nutritionists.store');
        Route::get('/nutritionists/create', [NutritionistsController::class, 'create'])->name('nutritionists.create');
        Route::delete('/nutritionists/{id}', [NutritionistsController::class, 'destroy'])->name('nutritionists.destroy');

        Route::get('/categories', [CategoriesController::class, 'index'])->name('categories.index');
        Route::post('/categories', [CategoriesController::class, 'store'])->name('categories.store');
        Route::patch('/categories/{id}', [CategoriesController::class, 'update'])->name('categories.update');
        Route::delete('/categories/{id}', [CategoriesController::class, 'destroy'])->name('categories.destroy');

        Route::get('/inquiries', [InquiriesController::class, 'index'])->name('inquiries.index'); // 一覧表示
        Route::delete('/inquiries/{id}/delete', [InquiriesController::class, 'destroy'])->name('inquiries.destroy'); // 削除
        Route::get('inquiries/{id}', [InquiriesController::class, 'show'])->name('inquiries.show');
        Route::patch('inquiries/{id}', [InquiriesController::class, 'update'])->name('inquiries.update');
    });


});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');






Route::post('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');
