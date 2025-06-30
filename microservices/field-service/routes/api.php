<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\FieldController;

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
        'message' => 'Field Service is healthy',
        'timestamp' => now()
    ]);
});

// API v1 routes
Route::prefix('v1')->group(function () {
    // Fields routes
    Route::get('/fields', [FieldController::class, 'index']);
    Route::post('/fields', [FieldController::class, 'store']);
    Route::get('/fields/{id}', [FieldController::class, 'show']);
    Route::put('/fields/{id}', [FieldController::class, 'update']);
    Route::delete('/fields/{id}', [FieldController::class, 'destroy']);

    // Additional field routes
    Route::get('/fields/active/list', [FieldController::class, 'active']);

    // Service-to-service communication routes
    Route::middleware(\App\Http\Middleware\ServiceAuthentication::class)->group(function () {
        Route::get('/fields/{id}/verify', [FieldController::class, 'verifyField']);
    });
});
