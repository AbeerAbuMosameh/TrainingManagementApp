<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\FieldController;
use App\Http\Controllers\Api\ProgramController;

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
        'status' => true,
        'message' => 'Program Service is running',
        'timestamp' => now(),
        'service' => 'program-service'
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

    // Programs routes
    Route::get('/programs', [ProgramController::class, 'index']);
    Route::post('/programs', [ProgramController::class, 'store']);
    Route::get('/programs/{id}', [ProgramController::class, 'show']);
    Route::put('/programs/{id}', [ProgramController::class, 'update']);
    Route::delete('/programs/{id}', [ProgramController::class, 'destroy']);

    // Service-to-service communication routes
    Route::middleware('service.auth')->group(function () {
        Route::get('/programs/{id}/verify', [ProgramController::class, 'verifyProgram']);
        Route::get('/fields/{id}/verify', [FieldController::class, 'verifyField']);
    });
});
