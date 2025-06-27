<?php

namespace App\Http\Controllers\Api;

use App\Models\Field;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FieldController extends BaseController
{
    /**
     * Display a listing of fields
     */
    public function index(): JsonResponse
    {
        $fields = Field::all();
        return $this->sendResponse($fields, 'Fields retrieved successfully');
    }

    /**
     * Store a newly created field
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:fields,name',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), 422);
        }

        $field = Field::create($request->all());

        return $this->sendResponse(['id' => $field->id], 'Field created successfully', 201);
    }

    /**
     * Display the specified field
     */
    public function show(Field $field): JsonResponse
    {
        return $this->sendResponse($field, 'Field retrieved successfully');
    }

    /**
     * Update the specified field
     */
    public function update(Request $request, Field $field): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:fields,name,' . $field->id,
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), 422);
        }

        $field->update($request->all());

        return $this->sendResponse(null, 'Field updated successfully');
    }

    /**
     * Remove the specified field
     */
    public function destroy(Field $field): JsonResponse
    {
        $field->delete();
        return $this->sendResponse(null, 'Field deleted successfully');
    }
} 