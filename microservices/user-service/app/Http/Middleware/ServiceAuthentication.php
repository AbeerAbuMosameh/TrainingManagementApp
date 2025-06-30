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
        $expectedKey = config('services.user.secret', 'SERVICE_SECRET_KEY_2024');

        if (!$serviceKey || $serviceKey !== $expectedKey) {
            return response()->json([
                'error' => 'Unauthorized service access',
                'message' => 'Invalid or missing service key'
            ], 401);
        }

        return $next($request);
    }
}
