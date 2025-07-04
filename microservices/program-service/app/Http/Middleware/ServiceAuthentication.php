<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ServiceAuthentication
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $serviceKey = $request->header('Service-Key');
        $expectedKey = config('services.program.secret', 'SERVICE_SECRET');

        if ($serviceKey !== $expectedKey) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized service access'
            ], 401);
        }

        return $next($request);
    }
} 