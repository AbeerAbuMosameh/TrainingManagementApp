<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GatewayController;
use App\Http\Middleware\GatewayMiddleware;

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

// Health check endpoint
Route::get('/health', function () {
    return response()->json([
        'success' => true,
        'message' => 'Gateway Service is healthy',
        'timestamp' => now()
    ]);
});

// Gateway info routes
Route::get('/gateway/routes', [GatewayController::class, 'routes']);

// All API routes go through the gateway middleware
Route::middleware(GatewayMiddleware::class)->group(function () {
    Route::any('{any}', function () {
        // This will be handled by the middleware
    })->where('any', '.*');
}); 