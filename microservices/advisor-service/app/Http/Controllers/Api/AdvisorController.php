<?php

namespace App\Http\Controllers\Api;

use App\Models\Advisor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdvisorController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $advisors = Advisor::all();
        return $this->sendResponse($advisors, 'Advisors retrieved successfully');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'nullable|string',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:advisors,email',
            'phone' => 'required|string|max:20',
            'education' => 'required|string|max:255',
            'address' => 'required|string|max:500',
            'city' => 'nullable|string|max:255',
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

        // Hash the password
        $data = $validator->validated();
        $data['password'] = Hash::make($data['password']);

        $advisor = Advisor::create($data);

        return $this->sendResponse(['id' => $advisor->id], 'Advisor created successfully', 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $advisor = Advisor::find($id);
        
        if (!$advisor) {
            return $this->sendError('Advisor not found', [], 404);
        }

        return $this->sendResponse($advisor, 'Advisor retrieved successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $advisor = Advisor::find($id);
        
        if (!$advisor) {
            return $this->sendError('Advisor not found', [], 404);
        }

        $validator = Validator::make($request->all(), [
            'image' => 'nullable|string',
            'first_name' => 'sometimes|required|string|max:255',
            'last_name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|unique:advisors,email,' . $advisor->id,
            'phone' => 'sometimes|required|string|max:20',
            'education' => 'sometimes|required|string|max:255',
            'address' => 'sometimes|required|string|max:500',
            'city' => 'nullable|string|max:255',
            'language' => 'nullable|in:English,Arabic,French',
            'cv' => 'nullable|string',
            'certification' => 'nullable|string',
            'otherFile' => 'nullable|array',
            'is_approved' => 'boolean',
            'password' => 'sometimes|required|string|min:6',
            'notification_id' => 'nullable|exists:notifications,id'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), 422);
        }

        $data = $validator->validated();

        // Hash the password if provided
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        $advisor->update($data);

        return $this->sendResponse($advisor, 'Advisor updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $advisor = Advisor::find($id);
        
        if (!$advisor) {
            return $this->sendError('Advisor not found', [], 404);
        }

        $advisor->delete();

        return $this->sendResponse([], 'Advisor deleted successfully');
    }

    /**
     * Verify advisor by ID (for service-to-service communication)
     */
    public function verifyAdvisor($id)
    {
        $advisor = Advisor::find($id);
        
        if (!$advisor) {
            return $this->sendError('Advisor not found', [], 404);
        }

        return $this->sendResponse($advisor, 'Advisor verified successfully');
    }

    /**
     * Get approved advisors only
     */
    public function approved()
    {
        $advisors = Advisor::approved()->get();
        
        return $this->sendResponse($advisors, 'Approved advisors retrieved successfully');
    }

    /**
     * Filter advisors by language
     */
    public function byLanguage($language)
    {
        $advisors = Advisor::byLanguage($language)->get();
        
        return $this->sendResponse($advisors, 'Advisors filtered by language successfully');
    }
}
