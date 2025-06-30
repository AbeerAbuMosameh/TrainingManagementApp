<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response;

class ServiceCommunicationService
{
    private $serviceUrls = [
        'user-service' => 'http://user-service:80',
        'trainee-service' => 'http://trainee-service:80',
        'advisor-service' => 'http://advisor-service:80',
        'field-service' => 'http://field-service:80',
        'program-service' => 'http://program-service:80',
        'task-service' => 'http://task-service:80'
    ];

    private $serviceSecret;

    public function __construct()
    {
        $this->serviceSecret = env('SERVICE_SECRET', 'SERVICE_SECRET_KEY_2024');
    }

    /**
     * Get program details from Program Service
     */
    public function getProgramDetails(int $programId): ?array
    {
        try {
            $response = $this->get('program-service', "/api/v1/programs/{$programId}");
            
            if ($response->successful()) {
                return $response->json()['data'] ?? null;
            }
        } catch (\Exception $e) {
            \Log::error("Failed to get program details: " . $e->getMessage());
        }
        
        return null;
    }

    /**
     * Get advisor details from Advisor Service
     */
    public function getAdvisorDetails(int $advisorId): ?array
    {
        try {
            $response = $this->get('advisor-service', "/api/v1/advisors/{$advisorId}");
            
            if ($response->successful()) {
                return $response->json()['data'] ?? null;
            }
        } catch (\Exception $e) {
            \Log::error("Failed to get advisor details: " . $e->getMessage());
        }
        
        return null;
    }

    /**
     * Verify advisor exists and is approved
     */
    public function verifyAdvisor(int $advisorId): bool
    {
        try {
            $response = $this->get('advisor-service', "/api/v1/advisors/{$advisorId}/verify");
            return $response->successful();
        } catch (\Exception $e) {
            \Log::error("Failed to verify advisor: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Get user details from User Service
     */
    public function getUserDetails(int $userId): ?array
    {
        try {
            $response = $this->get('user-service', "/api/v1/users/{$userId}");
            
            if ($response->successful()) {
                return $response->json()['data'] ?? null;
            }
        } catch (\Exception $e) {
            \Log::error("Failed to get user details: " . $e->getMessage());
        }
        
        return null;
    }

    /**
     * Get user by email from User Service
     */
    public function getUserByEmail(string $email): ?array
    {
        try {
            $response = $this->get('user-service', "/api/v1/users/email/{$email}");
            
            if ($response->successful()) {
                return $response->json()['data'] ?? null;
            }
        } catch (\Exception $e) {
            \Log::error("Failed to get user by email: " . $e->getMessage());
        }
        
        return null;
    }

    /**
     * Make a GET request to another service
     */
    public function get(string $serviceName, string $endpoint, array $headers = []): Response
    {
        $url = $this->getServiceUrl($serviceName) . $endpoint;
        
        return Http::withHeaders(array_merge([
            'Service-Key' => $this->serviceSecret,
            'Content-Type' => 'application/json'
        ], $headers))
        ->timeout(30)
        ->get($url);
    }

    /**
     * Make a POST request to another service
     */
    public function post(string $serviceName, string $endpoint, array $data = [], array $headers = []): Response
    {
        $url = $this->getServiceUrl($serviceName) . $endpoint;
        
        return Http::withHeaders(array_merge([
            'Service-Key' => $this->serviceSecret,
            'Content-Type' => 'application/json'
        ], $headers))
        ->timeout(30)
        ->post($url, $data);
    }

    /**
     * Make a PUT request to another service
     */
    public function put(string $serviceName, string $endpoint, array $data = [], array $headers = []): Response
    {
        $url = $this->getServiceUrl($serviceName) . $endpoint;
        
        return Http::withHeaders(array_merge([
            'Service-Key' => $this->serviceSecret,
            'Content-Type' => 'application/json'
        ], $headers))
        ->timeout(30)
        ->put($url, $data);
    }

    /**
     * Make a DELETE request to another service
     */
    public function delete(string $serviceName, string $endpoint, array $headers = []): Response
    {
        $url = $this->getServiceUrl($serviceName) . $endpoint;
        
        return Http::withHeaders(array_merge([
            'Service-Key' => $this->serviceSecret,
            'Content-Type' => 'application/json'
        ], $headers))
        ->timeout(30)
        ->delete($url);
    }

    /**
     * Get service URL by service name
     */
    private function getServiceUrl(string $serviceName): string
    {
        return $this->serviceUrls[$serviceName] ?? "http://{$serviceName}:80";
    }

    /**
     * Verify if a service is healthy
     */
    public function isServiceHealthy(string $serviceName): bool
    {
        try {
            $response = $this->get($serviceName, '/api/health');
            return $response->successful();
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Get all service health statuses
     */
    public function getAllServicesHealth(): array
    {
        $healthStatus = [];
        
        foreach (array_keys($this->serviceUrls) as $serviceName) {
            $healthStatus[$serviceName] = $this->isServiceHealthy($serviceName);
        }
        
        return $healthStatus;
    }
} 