<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GatewayController;

Route::get('/', function () {
    return view('welcome');
});

// Gateway health and info routes (web accessible)
Route::get('/health', [GatewayController::class, 'health']);
Route::get('/gateway/routes', [GatewayController::class, 'routes']);
