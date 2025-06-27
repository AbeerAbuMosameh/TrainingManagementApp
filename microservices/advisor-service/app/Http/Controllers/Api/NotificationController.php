<?php

namespace App\Http\Controllers\Api;

use App\Models\Notification;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NotificationController extends BaseController
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Display a listing of notifications
     */
    public function index()
    {
        $notifications = Notification::with('user')->get();
        return $this->sendResponse($notifications, 'Notifications retrieved successfully');
    }

    /**
     * Store a newly created notification
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'type' => 'nullable|string|max:255',
            'user_id' => 'nullable|integer',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), 422);
        }

        $data = $validator->validated();

        // Verify user_id if provided
        if (!empty($data['user_id'])) {
            $userVerification = $this->userService->verifyUserById($data['user_id']);

            if (!$userVerification['success']) {
                return $this->sendError('User verification failed', [
                    'user_id' => $userVerification['message']
                ], 422);
            }
        }

        $notification = Notification::create($data);

        return $this->sendResponse(['id' => $notification->id], 'Notification created successfully', 201);
    }

    /**
     * Display the specified notification
     */
    public function show(string $id)
    {
        $notification = Notification::with('user')->find($id);

        if (!$notification) {
            return $this->sendError('Notification not found', [], 404);
        }

        return $this->sendResponse($notification, 'Notification retrieved successfully');
    }

    /**
     * Update the specified notification
     */
    public function update(Request $request, $id)
    {
        $notification = Notification::find($id);

        if (!$notification) {
            return $this->sendError('Notification not found', [], 404);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|required|string|max:255',
            'message' => 'sometimes|required|string',
            'type' => 'nullable|string|max:255',
            'is_read' => 'boolean',
            'user_id' => 'nullable|integer',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), 422);
        }

        $data = $validator->validated();

        // Verify user_id if provided and changed
        if (!empty($data['user_id']) && $data['user_id'] !== $notification->user_id) {
            $userVerification = $this->userService->verifyUserById($data['user_id']);

            if (!$userVerification['success']) {
                return $this->sendError('User verification failed', [
                    'user_id' => $userVerification['message']
                ], 422);
            }
        }

        $notification->update($data);

        return $this->sendResponse($notification, 'Notification updated successfully');
    }

    /**
     * Remove the specified notification
     */
    public function destroy(string $id)
    {
        $notification = Notification::find($id);

        if (!$notification) {
            return $this->sendError('Notification not found', [], 404);
        }

        $notification->delete();

        return $this->sendResponse([], 'Notification deleted successfully');
    }

    /**
     * Mark notification as read
     */
    public function markAsRead(string $id)
    {
        $notification = Notification::find($id);

        if (!$notification) {
            return $this->sendError('Notification not found', [], 404);
        }

        $notification->update(['is_read' => true]);

        return $this->sendResponse($notification, 'Notification marked as read');
    }

    /**
     * Get unread notifications
     */
    public function unread()
    {
        $notifications = Notification::unread()->with('user')->get();

        return $this->sendResponse($notifications, 'Unread notifications retrieved successfully');
    }

    /**
     * Get notifications by type
     */
    public function byType($type)
    {
        $notifications = Notification::byType($type)->with('user')->get();

        return $this->sendResponse($notifications, 'Notifications filtered by type successfully');
    }
}
