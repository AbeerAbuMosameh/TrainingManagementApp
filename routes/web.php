<?php

use App\Http\Controllers\API\SocialAuthController;
use App\Http\Controllers\HomeController;
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

Route::get('/', function () {
    return view('auth.login');
});

Route::get('login/google' , [SocialAuthController::class , 'redirectToProvider'])->name('google.login');
Route::get('auth/google/callback' , [SocialAuthController::class , 'handleCallback'])->name('google.login.callback');

Auth::routes(['verify'=>true]);

Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home')->middleware('verified');


});
