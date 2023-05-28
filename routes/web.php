<?php

use App\Http\Controllers\Admin\AdvisorController;
use App\Http\Controllers\Admin\AdvisorFieldController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\FieldController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\ProgramController;
use App\Http\Controllers\Admin\TraineeController;
use App\Http\Controllers\Admin\TraineeProgramController;
use App\Http\Controllers\Admin\TrainingProgramController;
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


//authorize using google
Route::get('login/google' , [SocialAuthController::class , 'redirectToProvider'])->name('google.login');
Route::get('auth/google/callback' , [SocialAuthController::class , 'handleCallback'])->name('google.login.callback');


Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    //main page
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    //Advisors Component
    Route::resource('advisors' , AdvisorController::class )->except('store','create');
    Route::get('/get-advisors/{fieldId}', [AdvisorController::class, 'getAdvisors']);
    Route::get('/advisors-fields', [AdvisorController::class, 'advisorsFields'])->name('advisors-fields');
    Route::put('/update-status/{id}', [AdvisorFieldController::class, 'updateStatus'])->name('advisor-field.update-status');

    //Trainee Component
    Route::resource('trainees' , TraineeController::class )->except('store','create');

    //Payment Component
    Route::resource('payments' , PaymentController::class );

    //Trainee Programs Request Component
    Route::resource('trainees-programs' , TrainingProgramController::class );

    //Program Component
    Route::resource('programs' , ProgramController::class );

    //Fields or Discipline  Component
    Route::resource('fields' , FieldController::class );

    //accept registration Advisor or Trainee
    Route::get('/sendemail/{id}', [TraineeController::class, 'accept'])->name('sendemail');
    Route::get('/sendmail/{id}', [AdvisorController::class, 'accept'])->name('sendmailtoavisor');

    //Change Password Component
    Route::get('/updatePassword', [TraineeController::class, 'password'])->name('password');;
    Route::put('/password/update/{id}', [TraineeController::class, 'updatePassword'])->name('password.update');


});

