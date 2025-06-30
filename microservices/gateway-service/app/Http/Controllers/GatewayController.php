<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

class GatewayController extends Controller
{
    public function health(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => 'API Gateway is healthy',
            'timestamp' => now()
        ]);
    }

    public function routes(): JsonResponse
    {
        $routes = [
            'users' => 'User management endpoints',
            'trainees' => 'Trainee management endpoints',
            'advisors' => 'Advisor management endpoints',
            'fields' => 'Field management endpoints',
            'programs' => 'Program management endpoints',
            'tasks' => 'Task management endpoints'
        ];

        return response()->json([
            'success' => true,
            'data' => $routes
        ]);
    }
} 