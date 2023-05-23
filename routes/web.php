<?php

use App\Http\Controllers\Admin\AdvisorController;
use App\Http\Controllers\Admin\FieldController;
use App\Http\Controllers\Admin\ProgrameController;
use App\Http\Controllers\Admin\TraineeController;
use App\Http\Controllers\API\SocialAuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\WebSiteController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/' , [WebSiteController::class , 'index'])->name('home_page');


Route::resource('advisors' , AdvisorController::class )->only('store','create');
Route::resource('trainees' , TraineeController::class )->only('store','create');



Route::get('login/google' , [SocialAuthController::class , 'redirectToProvider'])->name('google.login');
Route::get('auth/google/callback' , [SocialAuthController::class , 'handleCallback'])->name('google.login.callback');





Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::resource('advisors' , AdvisorController::class )->except('store','create');
    Route::resource('trainees' , TraineeController::class )->except('store','create');
    Route::resource('programs' , ProgrameController::class );
    Route::resource('fields' , FieldController::class );

    Route::get('/sendemail/{id}', [TraineeController::class, 'accept'])->name('sendemail');
    Route::get('/sendmail/{id}', [AdvisorController::class, 'accept'])->name('sendmailtoavisor');
    Route::get('/updatePassword', [TraineeController::class, 'password'])->name('password');;
    Route::post('/updatePassword/{id}', [TraineeController::class, 'updatePassword'])->name('updatePassword');


});

