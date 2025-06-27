<?php

namespace App\Http\Controllers\Api;

use App\Models\Field;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FieldController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $fields = Field::all();
        return $this->sendResponse($fields, 'Fields retrieved successfully');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:fields,name',
            'description' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), 422);
        }

        $field = Field::create($validator->validated());

        return $this->sendResponse(['id' => $field->id], 'Field created successfully', 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $field = Field::find($id);
        
        if (!$field) {
            return $this->sendError('Field not found', [], 404);
        }

        return $this->sendResponse($field, 'Field retrieved successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $field = Field::find($id);
        
        if (!$field) {
            return $this->sendError('Field not found', [], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255|unique:fields,name,' . $field->id,
            'description' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), 422);
        }

        $field->update($validator->validated());

        return $this->sendResponse($field, 'Field updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $field = Field::find($id);
        
        if (!$field) {
            return $this->sendError('Field not found', [], 404);
        }

        $field->delete();

        return $this->sendResponse([], 'Field deleted successfully');
    }

    /**
     * Verify field by ID (for service-to-service communication)
     */
    public function verifyField($id)
    {
        $field = Field::find($id);
        
        if (!$field) {
            return $this->sendError('Field not found', [], 404);
        }

        return $this->sendResponse($field, 'Field verified successfully');
    }

    /**
     * Get active fields only
     */
    public function active()
    {
        $fields = Field::active()->get();
        
        return $this->sendResponse($fields, 'Active fields retrieved successfully');
    }
} 