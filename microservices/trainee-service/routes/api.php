<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TraineeController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Health check endpoint
Route::get('/health', function () {
    return response()->json([
        'success' => true,
        'message' => 'Trainee Service is healthy',
        'timestamp' => now()
    ]);
});

// API v1 routes
Route::prefix('v1')->group(function () {
    // Trainees routes
    Route::get('/trainees', [TraineeController::class, 'index']);
    Route::post('/trainees', [TraineeController::class, 'store']);
    Route::get('/trainees/{id}', [TraineeController::class, 'show']);
    Route::put('/trainees/{id}', [TraineeController::class, 'update']);
    Route::delete('/trainees/{id}', [TraineeController::class, 'destroy']);

    // Additional routes for inter-service communication
    Route::get('trainees/email/{email}', [TraineeController::class, 'getByEmail']);
    Route::patch('trainees/{trainee}/approval', [TraineeController::class, 'updateApproval']);

    // Service-to-service communication routes
    Route::middleware(\App\Http\Middleware\ServiceAuthentication::class)->group(function () {
        Route::get('/trainees/{id}/verify', [TraineeController::class, 'verifyTrainee']);
    });
});
