<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class BaseController extends Controller
{
    /**
     * Success response
     */
    protected function sendResponse($data, $message = '', $code = 200): JsonResponse
    {
        $response = [
            'status' => true,
            'message' => $message,
            'data' => $data
        ];

        return response()->json($response, $code);
    }

    /**
     * Error response
     */
    protected function sendError($message, $errors = [], $code = 400): JsonResponse
    {
        $response = [
            'status' => false,
            'message' => $message,
        ];

        if (!empty($errors)) {
            $response['errors'] = $errors;
        }

        return response()->json($response, $code);
    }
} 