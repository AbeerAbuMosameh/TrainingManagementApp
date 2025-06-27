<?php

namespace App\Http\Controllers\Api;

use App\Models\Program;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class ProgramController extends BaseController
{
    /**
     * Display a listing of programs
     */
    public function index(): JsonResponse
    {
        $programs = Program::with('field')->get();
        return $this->sendResponse($programs, 'Programs retrieved successfully');
    }

    /**
     * Store a newly created program
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'type' => 'required|in:free,paid',
            'hours' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'field_id' => 'required|exists:fields,id',
            'advisor_id' => 'required|integer',
            'duration' => 'required|in:days,weeks,months,years',
            'level' => 'required|in:beginner,intermediate,advanced',
            'language' => 'required|in:English,Arabic,French',
            'description' => 'nullable|string',
            'price' => 'nullable|integer|required_if:type,paid',
            'number' => 'required|integer',
            'image' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), 422);
        }

        // Verify advisor exists in advisor service
        if (!$this->verifyAdvisor($request->advisor_id)) {
            return $this->sendError('Advisor not found', [], 404);
        }

        $program = Program::create($request->all());

        return $this->sendResponse(['id' => $program->id], 'Program created successfully', 201);
    }

    /**
     * Display the specified program
     */
    public function show($id): JsonResponse
    {
        $program = Program::with('field')->find($id);
        
        if (!$program) {
            return $this->sendError('Program not found', [], 404);
        }

        // Get advisor details from advisor service
        $advisor = $this->getAdvisorDetails($program->advisor_id);

        $data = $program->toArray();
        if ($advisor) {
            $data['advisor'] = $advisor;
        }

        return $this->sendResponse($data, 'Program details retrieved successfully');
    }

    /**
     * Update the specified program
     */
    public function update(Request $request, Program $program): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            'type' => 'sometimes|required|in:free,paid',
            'hours' => 'sometimes|required|string',
            'start_date' => 'sometimes|required|date',
            'end_date' => 'sometimes|required|date|after:start_date',
            'field_id' => 'sometimes|required|exists:fields,id',
            'advisor_id' => 'sometimes|required|integer',
            'duration' => 'sometimes|required|in:days,weeks,months,years',
            'level' => 'sometimes|required|in:beginner,intermediate,advanced',
            'language' => 'sometimes|required|in:English,Arabic,French',
            'description' => 'nullable|string',
            'price' => 'nullable|integer|required_if:type,paid',
            'number' => 'sometimes|required|integer',
            'image' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), 422);
        }

        if ($request->has('advisor_id') && !$this->verifyAdvisor($request->advisor_id)) {
            return $this->sendError('Advisor not found', [], 404);
        }

        $program->update($request->all());

        return $this->sendResponse(null, 'Program updated successfully');
    }

    /**
     * Remove the specified program
     */
    public function destroy(Program $program): JsonResponse
    {
        $program->delete();
        return $this->sendResponse(null, 'Program deleted successfully');
    }

    /**
     * Verify advisor exists in advisor service
     */
    private function verifyAdvisor(int $advisorId): bool
    {
        try {
            $response = Http::withHeaders([
                'Service-Key' => config('services.advisor.secret'),
            ])->get(config('services.advisor.url') . '/api/v1/advisors/' . $advisorId);

            return $response->successful();
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Get advisor details from advisor service
     */
    private function getAdvisorDetails(int $advisorId): ?array
    {
        try {
            $response = Http::withHeaders([
                'Service-Key' => config('services.advisor.secret'),
            ])->get(config('services.advisor.url') . '/api/v1/advisors/' . $advisorId);

            if ($response->successful()) {
                return $response->json('data');
            }
        } catch (\Exception $e) {
            // Log error if needed
        }

        return null;
    }
}
