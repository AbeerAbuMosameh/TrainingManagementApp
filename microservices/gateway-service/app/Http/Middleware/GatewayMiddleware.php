<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class GatewayMiddleware
{
    private $serviceRoutes = [
        'users' => 'user-service',
        'trainees' => 'trainee-service',
        'advisors' => 'advisor-service',
        'fields' => 'field-service',
        'programs' => 'program-service',
        'tasks' => 'task-service'
    ];

    public function handle(Request $request, Closure $next): Response
    {
        $path = $request->path();
        $segments = explode('/', $path);

        // Debug logging
        Log::info('Gateway received request', [
            'path' => $path,
            'segments' => $segments,
            'method' => $request->method()
        ]);

        // Skip if it's a health check or internal gateway route
        if ($segments[0] === 'health' || $segments[0] === 'gateway') {
            return $next($request);
        }

        // Determine target service from URL path
        $targetService = $this->getTargetService($segments[0]);

        // Use Docker DNS for service discovery (always use port 80 internally)
        $serviceUrl = "http://{$targetService}:80";

        Log::info('Gateway determined service', [
            'target_service' => $targetService,
            'service_url' => $serviceUrl
        ]);

        if (!$targetService) {
            return response()->json([
                'success' => false,
                'message' => 'Service not found'
            ], 404);
        }

        // Forward the request to the target service
        return $this->forwardRequest($request, $serviceUrl);
    }

    private function getTargetService(string $path): ?string
    {
        return $this->serviceRoutes[$path] ?? null;
    }

    private function forwardRequest(Request $request, string $targetUrl): Response
    {
        $method = $request->method();
        $segments = explode('/', $request->path());
        array_shift($segments); // Remove the service prefix (e.g., 'advisors')
        $forwardPath = implode('/', $segments);
        $url = $targetUrl . '/' . $forwardPath;
        $headers = $request->headers->all();
        $data = $request->all();

        // Debug logging
        Log::info('Gateway forwarding request', [
            'original_path' => $request->path(),
            'target_url' => $url,
            'method' => $method,
            'headers' => array_keys($headers)
        ]);

        // Remove gateway-specific and sensitive headers
        unset($headers['host'], $headers['cookie'], $headers['x-csrf-token'], $headers['x-xsrf-token'],
            $headers['x-requested-with'], $headers['referer'], $headers['accept-language'],
            $headers['accept-encoding'], $headers['connection'], $headers['user-agent']);

        // Always set Content-Type: application/json for API requests
        $headers['Content-Type'] = ['application/json'];
        $headers['Accept'] = ['application/json'];

        // Ensure Service-Key header is correctly cased
        if (isset($headers['service-key'])) {
            $headers['Service-Key'] = $headers['service-key'];
            unset($headers['service-key']);
        }

        try {

            $response = Http::withHeaders($headers)
                ->timeout(30)
                ->send($method, $url, [
                    'json' => $data,
                    'query' => $request->query()
                ]);

            Log::info('Gateway received response', [
                'status' => $response->status(),
                'body_length' => strlen($response->body())
            ]);

            // Remove all problematic headers
            $responseHeaders = $response->headers();
            foreach ([
                'transfer-encoding', 'Transfer-Encoding',
                'connection', 'Connection',
                'keep-alive', 'Keep-Alive',
                'server', 'Server',
                'content-length', 'Content-Length'
            ] as $h) {
                unset($responseHeaders[$h]);
            }
            $responseHeaders['Content-Length'] = strlen($response->body());
            $body = (string) $response->body();
            $contentType = $response->header('Content-Type');

            // If the response is JSON, return as JSON
            if ($contentType && str_contains($contentType, 'application/json')) {
                $json = json_decode($body, true);
                return response()->json($json, $response->status(), $responseHeaders);
            }

            // Otherwise, return as plain text
            return response($body, $response->status(), $responseHeaders);
        } catch (\Exception $e) {
            Log::error('Gateway forwarding error', [
                'error' => $e->getMessage(),
                'url' => $url
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Service communication error: ' . $e->getMessage()
            ], 500);
        }
    }
}
