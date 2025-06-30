<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AuthController extends BaseController
{
    /**
     * Register a new user
     */
    public function register(Request $request): JsonResponse
    {
        Log::info('Register POST data:', $request->all());
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'level' => 'sometimes|integer|in:1,2,3',
            'google_id' => 'nullable|string|unique:users',
            'unique_id' => 'nullable|string|unique:users',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'level' => $request->level ?? 3, // Default to trainee
            'google_id' => $request->google_id,
            'unique_id' => $request->unique_id ?? Str::uuid(),
            'email_verified_at' => now(), // Auto-verify for now
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return $this->sendResponse([
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'level' => $user->level,
                'role' => $user->role,
            ],
            'token' => $token,
            'token_type' => 'Bearer',
        ], 'User registered successfully', 201);
    }

    /**
     * Login user
     */
    public function login(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), 422);
        }

        if (!Auth::attempt($request->only('email', 'password'))) {
            return $this->sendError('Invalid credentials', [], 401);
        }

        $user = User::where('email', $request->email)->firstOrFail();
        $token = $user->createToken('auth_token')->plainTextToken;

        return $this->sendResponse([
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'level' => $user->level,
                'role' => $user->role,
            ],
            'token' => $token,
            'token_type' => 'Bearer',
        ], 'User logged in successfully');
    }

    /**
     * Logout user
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return $this->sendResponse(null, 'User logged out successfully');
    }

    /**
     * Get authenticated user profile
     */
    public function profile(Request $request): JsonResponse
    {
        $user = $request->user();

        return $this->sendResponse([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'level' => $user->level,
            'role' => $user->role,
            'email_verified_at' => $user->email_verified_at,
            'created_at' => $user->created_at,
        ], 'User profile retrieved successfully');
    }

    /**
     * Update user profile
     */
    public function updateProfile(Request $request): JsonResponse
    {
        $user = $request->user();

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|email|max:255|unique:users,email,' . $user->id,
            'level' => 'sometimes|integer|in:1,2,3',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), 422);
        }

        $user->update($request->only(['name', 'email', 'level']));

        return $this->sendResponse([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'level' => $user->level,
            'role' => $user->role,
        ], 'User profile updated successfully');
    }

    /**
     * Change password
     */
    public function changePassword(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), 422);
        }

        $user = $request->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return $this->sendError('Current password is incorrect', [], 400);
        }

        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return $this->sendResponse(null, 'Password changed successfully');
    }

    /**
     * Get user by email (for inter-service communication)
     */
    public function getUserByEmail(string $email): JsonResponse
    {
        $user = User::where('email', $email)->first();

        if (!$user) {
            return $this->sendError('User not found', [], 404);
        }

        return $this->sendResponse([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'level' => $user->level,
            'role' => $user->role,
        ], 'User found');
    }

    /**
     * Get user by ID (for inter-service communication)
     */
    public function getUserById(int $id): JsonResponse
    {
        $user = User::find($id);

        if (!$user) {
            return $this->sendError('User not found', [], 404);
        }

        return $this->sendResponse([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'level' => $user->level,
            'role' => $user->role,
        ], 'User found');
    }

    /**
     * Get all users (for inter-service communication)
     */
    public function getAllUsers(): JsonResponse
    {
        $users = User::select('id', 'name', 'email', 'level', 'created_at')
            ->orderBy('created_at', 'desc')
            ->get();

        return $this->sendResponse($users, 'Users retrieved successfully');
    }

    /**
     * Update user role (admin only)
     */
    public function updateUserRole(Request $request, int $id): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'level' => 'required|integer|in:1,2,3',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), 422);
        }

        $user = User::find($id);

        if (!$user) {
            return $this->sendError('User not found', [], 404);
        }

        $user->update(['level' => $request->level]);

        return $this->sendResponse([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'level' => $user->level,
            'role' => $user->role,
        ], 'User role updated successfully');
    }

    /**
     * List all users (admin only)
     */
    public function index(Request $request): JsonResponse
    {
        $user = $request->user();

        if (!$user->isAdmin()) {
            return $this->sendError('Unauthorized', [], 403);
        }

        $users = User::select('id', 'name', 'email', 'level', 'created_at')
            ->orderBy('created_at', 'desc')
            ->get();

        return $this->sendResponse($users, 'Users retrieved successfully');
    }

    /**
     * Delete user (admin only)
     */
    public function destroy(Request $request, int $id): JsonResponse
    {
        $user = $request->user();

        if (!$user->isAdmin()) {
            return $this->sendError('Unauthorized', [], 403);
        }

        $targetUser = User::find($id);

        if (!$targetUser) {
            return $this->sendError('User not found', [], 404);
        }

        if ($targetUser->id === $user->id) {
            return $this->sendError('Cannot delete yourself', [], 400);
        }

        $targetUser->delete();

        return $this->sendResponse(null, 'User deleted successfully');
    }
}
