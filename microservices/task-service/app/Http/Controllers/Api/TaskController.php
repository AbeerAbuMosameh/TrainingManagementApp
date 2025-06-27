<?php

namespace App\Http\Controllers\Api;

use App\Models\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class TaskController extends BaseController
{
    /**
     * Display a listing of tasks
     */
    public function index(): JsonResponse
    {
        $tasks = Task::all();
        return $this->sendResponse($tasks, 'Tasks retrieved successfully');
    }

    /**
     * Store a newly created task
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'program_id' => 'required|integer',
            'advisor_id' => 'required|integer',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'mark' => 'required|integer|min:1',
            'description' => 'required|string',
            'related_file' => 'nullable|array',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), 422);
        }

        // Verify program exists in program service
        if (!$this->verifyProgram($request->program_id)) {
            return $this->sendError('Program not found', [], 404);
        }

        // Verify advisor exists in advisor service
        if (!$this->verifyAdvisor($request->advisor_id)) {
            return $this->sendError('Advisor not found', [], 404);
        }

        $task = Task::create($request->all());

        return $this->sendResponse(['id' => $task->id], 'Task created successfully', 201);
    }

    /**
     * Display the specified task
     */
    public function show($id): JsonResponse
    {
        $task = Task::find($id);
        
        if (!$task) {
            return $this->sendError('Task not found', [], 404);
        }

        // Get program details from program service
        $program = $this->getProgramDetails($task->program_id);

        // Get advisor details from advisor service
        $advisor = $this->getAdvisorDetails($task->advisor_id);

        $data = $task->toArray();
        if ($program) {
            $data['program'] = $program;
        }
        if ($advisor) {
            $data['advisor'] = $advisor;
        }

        return $this->sendResponse($data, 'Task retrieved successfully');
    }

    /**
     * Update the specified task
     */
    public function update(Request $request, $id): JsonResponse
    {
        $task = Task::find($id);
        
        if (!$task) {
            return $this->sendError('Task not found', [], 404);
        }

        $validator = Validator::make($request->all(), [
            'program_id' => 'sometimes|required|integer',
            'advisor_id' => 'sometimes|required|integer',
            'start_date' => 'sometimes|required|date',
            'end_date' => 'sometimes|required|date|after:start_date',
            'mark' => 'sometimes|required|integer|min:1',
            'description' => 'sometimes|required|string',
            'related_file' => 'nullable|array',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), 422);
        }

        if ($request->has('program_id') && !$this->verifyProgram($request->program_id)) {
            return $this->sendError('Program not found', [], 404);
        }

        if ($request->has('advisor_id') && !$this->verifyAdvisor($request->advisor_id)) {
            return $this->sendError('Advisor not found', [], 404);
        }

        $task->update($request->all());

        return $this->sendResponse(null, 'Task updated successfully');
    }

    /**
     * Remove the specified task
     */
    public function destroy($id): JsonResponse
    {
        $task = Task::find($id);
        
        if (!$task) {
            return $this->sendError('Task not found', [], 404);
        }

        $task->delete();
        return $this->sendResponse(null, 'Task deleted successfully');
    }

    /**
     * Verify program exists in program service
     */
    private function verifyProgram(int $programId): bool
    {
        try {
            $response = Http::withHeaders([
                'Service-Key' => config('services.program.secret'),
            ])->get(env('PROGRAM_SERVICE_URL') . '/api/v1/programs/' . $programId);

            return $response->successful();
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Verify advisor exists in advisor service
     */
    private function verifyAdvisor(int $advisorId): bool
    {
        try {
            $response = Http::withHeaders([
                'Service-Key' => config('services.advisor.secret'),
            ])->get(env('ADVISOR_SERVICE_URL') . '/api/v1/advisors/' . $advisorId);

            return $response->successful();
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Get program details from program service
     */
    private function getProgramDetails(int $programId): ?array
    {
        try {
            $response = Http::withHeaders([
                'Service-Key' => config('services.program.secret'),
            ])->get(config('services.program.url') . '/v1/api/programs/' . $programId);

            if ($response->successful()) {
                return $response->json('data');
            }
        } catch (\Exception $e) {
            // Log error if needed
        }

        return null;
    }

    /**
     * Get advisor details from advisor service
     */
    private function getAdvisorDetails(int $advisorId): ?array
    {
        try {
            $response = Http::withHeaders([
                'Service-Key' => config('services.advisor.secret'),
            ])->get(config('services.advisor.url') . '/v1/api/advisors/' . $advisorId);

            if ($response->successful()) {
                return $response->json('data');
            }
        } catch (\Exception $e) {
            // Log error if needed
        }

        return null;
    }
}
