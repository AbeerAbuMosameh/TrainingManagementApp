<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BaseController;
use App\Http\Middleware\ServiceAuthentication;

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
        'message' => 'User Service is running',
        'timestamp' => now(),
        'service' => 'user-service'
    ]);
});

// Public routes
Route::prefix('v1')->group(function () {
    // Auth routes
    Route::post('/auth/register', [AuthController::class, 'register']);
    Route::post('/auth/login', [AuthController::class, 'login']);

    // Protected routes
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/auth/logout', [AuthController::class, 'logout']);
        Route::get('/auth/profile', [AuthController::class, 'profile']);
        Route::put('/auth/profile', [AuthController::class, 'updateProfile']);
        Route::post('/auth/change-password', [AuthController::class, 'changePassword']);
    });

    // Service-to-service communication routes (protected by service authentication)
    Route::middleware(ServiceAuthentication::class)->group(function () {
        Route::get('/users/email/{email}', [AuthController::class, 'getUserByEmail']);
        Route::get('/users/{id}', [AuthController::class, 'getUserById']);
        Route::get('/users', [AuthController::class, 'getAllUsers']);
    });

    // Admin routes
    Route::middleware(['auth:sanctum', 'admin'])->group(function () {
        Route::get('/admin/users', [AuthController::class, 'getAllUsers']);
        Route::put('/admin/users/{id}/role', [AuthController::class, 'updateUserRole']);
        Route::delete('/admin/users/{id}', [AuthController::class, 'deleteUser']);
    });
});
