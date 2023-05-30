<?php

namespace App\Http\Controllers\Advisor;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\downloadUrtTrait;
use App\Models\Advisor;
use App\Models\Program;
use App\Models\Task;
use App\Models\TrainingTask;
use Google\Cloud\Storage\StorageClient;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Kreait\Firebase\Contract\Auth;

class TaskController extends Controller
{

    use downloadUrtTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $id = Advisor::where('email', Auth()->user()->email)->value('id');
        $tasks = Task::where('advisor_id', $id)->get();
        $programs = Program::where('advisor_id', $id)->get();
        foreach ($tasks as $task) {

            $related_files = json_decode($task->related_file);

            $otherFileDownloadUrls = [];


            if (!empty($related_files)) {
                foreach ($related_files as $related_file) {
                    $otherFileDownloadUrls[] = $this->generateDownloadUrl($related_file);
                }
            }

            $task->related_file = $otherFileDownloadUrls;

            foreach ($task->trainingTasks as $trainingTask) {
                $solutionPath = $trainingTask->solution;

                // Generate download links or display the files
                $SolutionDownloadUrl = $this->generateDownloadUrl($solutionPath);

                // Assign the download URLs to the trainee object
                $trainingTask->solution = $SolutionDownloadUrl;
            }


        }


        return view('Advisor.TasksManagement.index', compact('tasks', 'programs'));

    }





    public function index1()
    {
        $advisorId = Advisor::where('email', Auth()->user()->email)->value('id');

        // Get the tasks with programs and solutions belonging to the advisor
        $tasks = Task::whereHas('program', function ($query) use ($advisorId) {
            $query->where('advisor_id', $advisorId);
        })->with(['program', 'trainingTasks' => function ($query) {
            $query->with('trainee');
        }])->get();
        // Read solution file for each task
        foreach ($tasks as $task) {
            foreach ($task->trainingTasks as $trainingTask) {
                $solutionPath = $trainingTask->solution;

                // Generate download links or display the files
                $SolutionDownloadUrl = $this->generateDownloadUrl($solutionPath);

                // Assign the download URLs to the trainee object
                $trainingTask->solution = $SolutionDownloadUrl;
            }
        }

        return view('Advisor.TasksManagement.tasksSolutions', compact('tasks'));
    }

    public function saveMark(Request $request)
    {
        $trainingTaskId = $request->input('trainingTaskId');
        $mark = $request->input('mark');

        // Find the training task by ID
        $trainingTask = TrainingTask::findOrFail($trainingTaskId);


        // Update the mark
        $trainingTask->mark = $mark;
        $trainingTask->save();

        toastr()->success('Mark saved successfully!');

        return redirect()->route('Training-tasks.solution');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request){
        // Validate the form input
        $validator = Validator::make($request->all(), [
            'description' => 'required',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
            'mark' => 'required|numeric',
            'related_file.*' => 'file',
        ]);

        // If validation fails, return back with errors

        if (!$validator->fails()) {
            $id = Advisor::where('email', Auth()->user()->email)->value('id');

            $task = new Task();
            $task->description = $request->input('description');
            $task->program_id = $request->input('program_id');
            $task->advisor_id = $id;
            $task->start_date = $request->input('start_date');
            $task->end_date = $request->input('end_date');
            $task->mark = $request->input('mark');


            // Initialize Google Cloud Storage
            $storage = new StorageClient([
                'projectId' => 'it-training-app-386209',
                'keyFilePath' => 'C:\xampp\htdocs\TrainingManagementApp\app\Http\Controllers\it-training-app-386209-firebase-adminsdk-20xbx-c933a61e7b.json',
            ]);

            $bucket = $storage->bucket('it-training-app-386209.appspot.com');

            // Store  Files
            if ($request->hasFile('related_file')) {
                $otherFiles = $request->file('related_file');
                $otherFilePaths = [];

                foreach ($otherFiles as $otherFile) {
                    $otherPath = 'related_file/' . time() + rand(1, 10000000) . '.' . $otherFile->getClientOriginalName();
                    $bucket->upload(
                        file_get_contents($otherFile),
                        [
                            'name' => $otherPath,
                        ]
                    );
                    $otherFilePaths[] = $otherPath;
                }

                // Convert file paths to JSON and save them in the request
                $task->related_file = json_encode($otherFilePaths);
            }

            $task->save();
            toastr()->success('Task added successfully');

        } else {
            toastr()->error($validator->getMessageBag()->first());
        }
        return redirect()->route('tasks.index');
    }


    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        //
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $taskId)
    {
        // Validate the form input
        $validator = Validator::make($request->all(), [
            'description' => 'required',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
            'mark' => 'required|numeric',
            'related_file.*' => 'file',
        ]);

        if ($validator->fails()) {
            toastr()->error($validator->getMessageBag()->first());
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $id = Advisor::where('email', Auth()->user()->email)->value('id');

        // Find the task by ID
        $task = Task::findOrFail($taskId);
        $task->description = $request->input('description');
        $task->program_id = $request->input('program_id');
        $task->advisor_id = $id;
        $task->start_date = $request->input('start_date');
        $task->end_date = $request->input('end_date');
        $task->mark = $request->input('mark');

        // Initialize Google Cloud Storage
        $storage = new StorageClient([
            'projectId' => 'it-training-app-386209',
            'keyFilePath' => 'C:\xampp\htdocs\TrainingManagementApp\app\Http\Controllers\it-training-app-386209-firebase-adminsdk-20xbx-c933a61e7b.json',
        ]);

        $bucket = $storage->bucket('it-training-app-386209.appspot.com');

        // Store Other Files
        if ($request->hasFile('related_file')) {
            $otherFiles = $request->file('related_file');
            $otherFilePaths = [];

            foreach ($otherFiles as $otherFile) {
                $otherPath = 'related_file/' . time() + rand(1, 10000000) . '.' . $otherFile->getClientOriginalName();
                $bucket->upload(
                    file_get_contents($otherFile),
                    [
                        'name' => $otherPath,
                    ]
                );
                $otherFilePaths[] = $otherPath;
            }

            // Convert file paths to JSON and save them in the task model
            $task->related_file = json_encode($otherFilePaths);
        }

        $task->save();
        toastr()->success('Task updated successfully');

        // Redirect to a success page or wherever needed
        return redirect()->route('tasks.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Task::findOrFail($id)->delete();
        return response()->json(['message' => 'Task deleted.']);
    }


}
