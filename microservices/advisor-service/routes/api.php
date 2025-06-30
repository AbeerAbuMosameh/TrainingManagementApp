<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AdvisorController;
use App\Http\Controllers\Api\NotificationController;

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
        'message' => 'Advisor Service is healthy',
        'timestamp' => now()
    ]);
});

// API v1 routes
Route::prefix('v1')->group(function () {
    // Advisors routes
    Route::get('/advisors', [AdvisorController::class, 'index']);
    Route::post('/advisors', [AdvisorController::class, 'store']);
    Route::get('/advisors/{id}', [AdvisorController::class, 'show']);
    Route::put('/advisors/{id}', [AdvisorController::class, 'update']);
    Route::delete('/advisors/{id}', [AdvisorController::class, 'destroy']);

    // Additional advisor routes
    Route::get('/advisors/approved/list', [AdvisorController::class, 'approved']);
    Route::get('/advisors/language/{language}', [AdvisorController::class, 'byLanguage']);

    // Notifications routes
    Route::get('/notifications', [NotificationController::class, 'index']);
    Route::post('/notifications', [NotificationController::class, 'store']);
    Route::get('/notifications/{id}', [NotificationController::class, 'show']);
    Route::put('/notifications/{id}', [NotificationController::class, 'update']);
    Route::delete('/notifications/{id}', [NotificationController::class, 'destroy']);
    Route::put('/notifications/{id}/read', [NotificationController::class, 'markAsRead']);
    Route::get('/notifications/unread/list', [NotificationController::class, 'unread']);
    Route::get('/notifications/type/{type}', [NotificationController::class, 'byType']);

    // Service-to-service communication routes
    Route::middleware(\App\Http\Middleware\ServiceAuthentication::class)->group(function () {
        Route::get('/advisors/{id}/verify', [AdvisorController::class, 'verifyAdvisor']);
    });
});
