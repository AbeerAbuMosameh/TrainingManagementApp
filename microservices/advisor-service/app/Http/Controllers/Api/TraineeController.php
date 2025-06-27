<?php

namespace App\Http\Controllers\Api;

use App\Models\Trainee;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TraineeController extends BaseController
{
    /**
     * Display a listing of trainees
     */
    public function index(): JsonResponse
    {
        $trainees = Trainee::all();
        return $this->sendResponse($trainees, 'Trainees retrieved successfully');
    }

    /**
     * Store a newly created trainee
     */
    public function store(Request $request): JsonResponse
    {
        $validator = \Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:trainees,email',
            'phone' => 'required|string|max:20',
            'education' => 'required|string|max:255',
            'gpa' => 'required|string|max:10',
            'address' => 'required|string|max:500',
            'city' => 'nullable|string|max:255',
            'payment' => 'nullable|string|max:255',
            'language' => 'nullable|in:English,Arabic,French',
            'cv' => 'nullable|string',
            'certification' => 'nullable|string',
            'otherFile' => 'nullable|array',
            'is_approved' => 'boolean',
            'password' => 'required|string|min:6',
            'notification_id' => 'nullable|exists:notifications,id'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), 422);
        }

        $data = $validator->validated();
        $data['password'] = \Hash::make($data['password']);

        $trainee = Trainee::create($data);

        return $this->sendResponse(['id' => $trainee->id], 'Trainee created successfully', 201);
    }

    /**
     * Display the specified trainee
     */
    public function show($id): JsonResponse
    {
        $trainee = Trainee::find($id);
        
        if (!$trainee) {
            return $this->sendError('Trainee not found', [], 404);
        }
        
        $data = [
            'id' => $trainee->id,
            'first_name' => $trainee->first_name,
            'last_name' => $trainee->last_name,
            'email' => $trainee->email,
            'phone' => $trainee->phone,
            'education' => $trainee->education,
            'gpa' => $trainee->gpa,
            'address' => $trainee->address,
            'city' => $trainee->city,
            'payment' => $trainee->payment,
            'language' => $trainee->language,
            'is_approved' => $trainee->is_approved,
            'created_at' => $trainee->created_at,
        ];

        return $this->sendResponse($data, 'Trainee found');
    }

    /**
     * Update the specified trainee
     */
    public function update(Request $request, $id): JsonResponse
    {
        $trainee = Trainee::find($id);
        
        if (!$trainee) {
            return $this->sendError('Trainee not found', [], 404);
        }

        $validator = \Validator::make($request->all(), [
            'first_name' => 'sometimes|required|string|max:255',
            'last_name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|unique:trainees,email,' . $trainee->id,
            'phone' => 'sometimes|required|string|max:20',
            'education' => 'sometimes|required|string|max:255',
            'address' => 'sometimes|required|string|max:500',
            'gpa' => 'nullable|string|max:10',
            'city' => 'nullable|string|max:100',
            'payment' => 'nullable|string|max:255',
            'language' => 'nullable|in:English,Arabic,French',
            'cv' => 'nullable|string',
            'certification' => 'nullable|string',
            'otherFile' => 'nullable|array',
            'image' => 'nullable|string',
            'is_approved' => 'sometimes|boolean',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), 422);
        }

        $trainee->update($request->all());

        return $this->sendResponse(null, 'Trainee updated successfully');
    }

    /**
     * Remove the specified trainee
     */
    public function destroy($id): JsonResponse
    {
        $trainee = Trainee::find($id);
        
        if (!$trainee) {
            return $this->sendError('Trainee not found', [], 404);
        }

        $trainee->delete();
        return $this->sendResponse(null, 'Trainee deleted successfully');
    }

    /**
     * Get approved trainees only
     */
    public function approved(): JsonResponse
    {
        $trainees = Trainee::where('is_approved', true)->get();
        
        return $this->sendResponse($trainees, 'Approved trainees retrieved successfully');
    }

    /**
     * Filter trainees by language
     */
    public function byLanguage($language): JsonResponse
    {
        $trainees = Trainee::where('language', $language)->get();
        
        return $this->sendResponse($trainees, 'Trainees filtered by language successfully');
    }

    /**
     * Get trainee by email (for inter-service communication)
     */
    public function getByEmail(string $email): JsonResponse
    {
        $trainee = Trainee::where('email', $email)->first();

        if (!$trainee) {
            return $this->sendError('Trainee not found', [], 404);
        }

        return $this->sendResponse($trainee, 'Trainee found');
    }

    /**
     * Update trainee approval status
     */
    public function updateApproval(Request $request, $id): JsonResponse
    {
        $trainee = Trainee::find($id);
        
        if (!$trainee) {
            return $this->sendError('Trainee not found', [], 404);
        }

        $validator = \Validator::make($request->all(), [
            'is_approved' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), 422);
        }

        $trainee->update(['is_approved' => $request->is_approved]);

        $message = $request->is_approved ? 'Trainee approved successfully' : 'Trainee approval revoked';
        return $this->sendResponse(null, $message);
    }
}
