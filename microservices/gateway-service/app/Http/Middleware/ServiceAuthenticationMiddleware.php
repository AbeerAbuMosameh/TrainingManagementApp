<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ServiceAuthenticationMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $serviceKey = $request->header('Service-Key');
        $expectedKey = env('SERVICE_SECRET', 'SERVICE_SECRET_KEY_2024');

        if (!$serviceKey || $serviceKey !== $expectedKey) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized service access'
            ], 401);
        }

        return $next($request);
    }
} 