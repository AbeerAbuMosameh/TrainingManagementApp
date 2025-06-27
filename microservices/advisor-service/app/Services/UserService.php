<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class UserService
{
    protected $baseUrl;
    protected $secret;

    public function __construct()
    {
        $this->baseUrl = config('services.user.url');
        $this->secret = config('services.user.secret');
    }

    /**
     * Verify if a user exists by ID
     */
    public function verifyUserById($userId)
    {
        try {
            $response = Http::withHeaders([
                'Service-Key' => $this->secret,
                'Accept' => 'application/json',
            ])->get("{$this->baseUrl}/api/v1/users/{$userId}");

            if ($response->successful()) {
                return [
                    'success' => true,
                    'user' => $response->json('data')
                ];
            }

            return [
                'success' => false,
                'message' => 'User not found or service unavailable'
            ];

        } catch (\Exception $e) {
            Log::error('User service communication error: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Unable to verify user - service communication error'
            ];
        }
    }

    /**
     * Get user by email
     */
    public function getUserByEmail($email)
    {
        try {
            $response = Http::withHeaders([
                'Service-Key' => $this->secret,
                'Accept' => 'application/json',
            ])->get("{$this->baseUrl}/api/v1/users/email/{$email}");

            if ($response->successful()) {
                return [
                    'success' => true,
                    'user' => $response->json('data')
                ];
            }

            return [
                'success' => false,
                'message' => 'User not found'
            ];

        } catch (\Exception $e) {
            Log::error('User service communication error: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Unable to get user - service communication error'
            ];
        }
    }
} 