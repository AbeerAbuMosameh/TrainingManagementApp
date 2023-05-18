<?php

use App\Http\Controllers\Admin\AdvisorController;
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


Route::post('/traineess', [TraineeController::class, 'store'])->name('traineessss');


Route::get('login/google' , [SocialAuthController::class , 'redirectToProvider'])->name('google.login');
Route::get('auth/google/callback' , [SocialAuthController::class , 'handleCallback'])->name('google.login.callback');



Route::resource('advisors' , AdvisorController::class );
Route::resource('trainees' , TraineeController::class );



Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    Route::get('/sendmail/{id}', [TraineeController::class, 'accept'])->name('sendmail');
    Route::get('/home', [HomeController::class, 'index'])->name('home');

});

