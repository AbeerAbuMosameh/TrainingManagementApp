<?php

namespace App\Http\Controllers\Trainee;

use App\Http\Controllers\Controller;
use App\Models\Advisor;
use App\Models\Task;
use App\Models\Trainee;
use App\Models\TrainingProgram;
use App\Models\TrainingTask;
use Google\Cloud\Storage\StorageClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Kreait\Firebase\Contract\Auth;

class TrainingTaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(){
        $id = Trainee::where('email', Auth()->user()->email)->value('id');
        $training_programs = TrainingProgram::where('trainee_id', $id)->where('status', 'accepted')->get();

        $tasks = collect(); // Create an empty collection to store tasks

        foreach ($training_programs as $training_program) {
            if ($training_program->program) {
                $programTasks = $training_program->program->tasks;
                $tasks = $tasks->concat($programTasks);
            }
        }

        foreach ($tasks as $task) {

            $related_files = json_decode($task->related_file);

            $otherFileDownloadUrls = [];


            if (!empty($related_files)) {
                foreach ($related_files as $related_file) {
                    $otherFileDownloadUrls[] = $this->generateDownloadUrl($related_file);
                }
            }

            $task->related_file = $otherFileDownloadUrls;


            $tas=TrainingTask::where('task_id',$task->id)->where('trainee_id',$id)->get();
            $SolutionPath = $tas->solution;
            $SolutionDownloadUrl = $this->generateDownloadUrl($SolutionPath);
            $task->solution = $SolutionDownloadUrl;


        }



        return view('Trainee.TasksManagement.index', compact('tasks'));

    }

    public function create(){
        //
    }

    public function store(Request $request){

        $traineeId = Trainee::where('email', Auth()->user()->email)->value('id');

        $task = Task::findOrFail( $request->input('task_id'));

        if ($task->isSolvedByTrainee($traineeId)) {
            // The task has already been solved by the trainee
            toastr()->error('You have already solved this task , You can edit solution Befor End date');
            return redirect()->route('Training-tasks.index');

        }

        $currentDate = now();
        $endDate = $task->end_date;

        if ($currentDate > $endDate) {
            toastr()->error('The end date for this task has passed. You cannot submit a solution.');
            return redirect()->route('Training-tasks.index');
        }


        // Validate the form input
        $validator = Validator::make($request->all(), [
            'solution' => 'required|file',
        ]);

        // If validation fails, return back with errors
        if (!$validator->fails()) {

            // Get the authenticated trainee ID

            // Initialize Google Cloud Storage
            $storage = new StorageClient([
                'projectId' => 'it-training-app-386209',
                'keyFilePath' => 'C:\xampp\htdocs\TrainingManagementApp\app\Http\Controllers\it-training-app-386209-firebase-adminsdk-20xbx-c933a61e7b.json',
            ]);

            $bucket = $storage->bucket('it-training-app-386209.appspot.com');

            // Create a new TrainingTask instance
            $trainingTask = new TrainingTask();
            $trainingTask->task_id = $request->input('task_id');
            $trainingTask->trainee_id = $traineeId;
            if ($request->hasFile('solution')) {
                $solutionFile = $request->file('solution');
                $solutionPath = 'solutions/' . time() + rand(1, 10000000) . '.' . $solutionFile->getClientOriginalName();
                $test = $bucket->upload(
                    file_get_contents($solutionFile),
                    [
                        'name' => $solutionPath,
                    ]
                );
                $trainingTask->solution = $solutionPath;

            }

            $trainingTask->save();

            toastr()->success('Task  Solved Successfully!');


        } else {
            toastr()->error($validator->getMessageBag()->first());
        }

        // Redirect to a success page or wherever needed
        return redirect()->route('Training-tasks.index');
    }

    function generateDownloadUrl($filePath){
        if (!empty($filePath)) {
            // Initialize Firebase Storage
            $storage = new StorageClient([
                'projectId' => 'it-training-app-386209',
                'keyFilePath' => 'C:\xampp\htdocs\TrainingManagementApp\app\Http\Controllers\it-training-app-386209-firebase-adminsdk-20xbx-c933a61e7b.json',
            ]);

            // Get the bucket name from the Firebase configuration or replace it with your bucket name
            $bucket = $storage->bucket('it-training-app-386209.appspot.com');

            // Generate the signed URL for the file
            $object = $bucket->object($filePath);
            $downloadUrl = $object->signedUrl(now()->addHour());

            return $downloadUrl;
        }

        return null;
    }
    /**
     * Display the specified resource.
     */
    public function show(TrainingTask $trainingTask)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TrainingTask $trainingTask)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TrainingTask $trainingTask)
    {
        // Check if the task has already been solved
        if ($trainingTask->solution) {
            toastr()->error('This task has already been solved. You cannot update the solution.');
            return redirect()->route('Training-tasks.index');
        }

        // Validate the form input
        $validator = Validator::make($request->all(), [
            'solution' => 'required|file',
        ]);

        // If validation fails, return back with errors
        if (!$validator->fails()) {
            // Get the authenticated trainee ID
            $traineeId = Trainee::where('email', Auth()->user()->email)->value('id');

            // Check if the task belongs to the trainee
            if ($trainingTask->trainee_id != $traineeId) {
                toastr()->error('You are not authorized to update this task solution.');
                return redirect()->route('Training-tasks.index');
            }

            // Initialize Google Cloud Storage
            $storage = new StorageClient([
                'projectId' => 'it-training-app-386209',
                'keyFilePath' => 'C:\xampp\htdocs\TrainingManagementApp\app\Http\Controllers\it-training-app-386209-firebase-adminsdk-20xbx-c933a61e7b.json',
            ]);

            $bucket = $storage->bucket('it-training-app-386209.appspot.com');

            // Update the task solution
            if ($request->hasFile('solution')) {
                $solutionFile = $request->file('solution');
                $solutionPath = 'solutions/' . time() + rand(1, 10000000) . '.' . $solutionFile->getClientOriginalName();
                $test = $bucket->upload(
                    file_get_contents($solutionFile),
                    [
                        'name' => $solutionPath,
                    ]
                );
                $trainingTask->solution = $solutionPath;
            }

            $trainingTask->save();

            toastr()->success('Task solution updated successfully!');
        } else {
            toastr()->error($validator->getMessageBag()->first());
        }

        return redirect()->route('Training-tasks.index');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TrainingTask $trainingTask)
    {
        //
    }
}
