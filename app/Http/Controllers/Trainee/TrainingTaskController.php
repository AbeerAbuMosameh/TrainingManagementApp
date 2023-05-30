<?php

namespace App\Http\Controllers\Trainee;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\downloadUrtTrait;
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

    use downloadUrtTrait;
    /**
     * Display a listing of the resource.
     */

    public function task($task_id)
    {
        $task = Task::findOrFail($task_id);

        $related_files = json_decode($task->related_file);

        $otherFileDownloadUrls = [];

        if (!empty($related_files)) {
            foreach ($related_files as $related_file) {
                $otherFileDownloadUrls[] = $this->generateDownloadUrl($related_file);
            }
        }

        $task->related_file = $otherFileDownloadUrls;

        $traineeId = Trainee::where('email', Auth()->user()->email)->value('id');

        $trainingTask = TrainingTask::where('task_id', $task_id)
            ->where('trainee_id', $traineeId)
            ->first();

        if ($trainingTask){
            $cvPath = $trainingTask->solution;

           $cvDownloadUrl = $this->generateDownloadUrl($cvPath);

           $task->solution = $cvDownloadUrl;
           $task->marks = $trainingTask->mark;
       }

        return view('Trainee.TasksManagement.task', compact('task'));
    }



    public function index(){
        $id = Trainee::where('email',Auth()->user()->email)->value('id');

        // Retrieve the accepted program IDs for the trainee
        $acceptedProgramIds = TrainingProgram::where('trainee_id', $id )
            ->where('status', 'accepted')
            ->pluck('program_id');

        // Retrieve the tasks related to the accepted programs
        $tasks = Task::whereIn('program_id', $acceptedProgramIds)
            ->with('program', 'advisor')
            ->get();

        foreach ($tasks as $task) {
            $relatedFiles = json_decode($task->related_file);
            $fileDownloadUrls = [];
            if (!empty($relatedFiles)) {
                foreach ($relatedFiles as $relatedFile) {
                    $fileDownloadUrls[] = $this->generateDownloadUrl($relatedFile);
                }
            }
            $task->related_file = $fileDownloadUrls;
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

    public function update(Request $request, $id){
        // Get the authenticated trainee ID
        $traineeId = Trainee::where('email', Auth()->user()->email)->value('id');

        // Retrieve the training task
        $trainingTask = TrainingTask::where('task_id', $id)
            ->where('trainee_id', $traineeId)
            ->first();

        // Validate the form input
        $validator = Validator::make($request->all(), [
            'solution' => 'required|file',
        ]);

        // If validation fails, return back with errors
        if ($validator->fails()) {
            toastr()->error($validator->getMessageBag()->first());
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Initialize Google Cloud Storage
        $storage = new StorageClient([
            'projectId' => 'it-training-app-386209',
            'keyFilePath' => 'C:\xampp\htdocs\TrainingManagementApp\app\Http\Controllers\it-training-app-386209-firebase-adminsdk-20xbx-c933a61e7b.json',
        ]);

        $bucket = $storage->bucket('it-training-app-386209.appspot.com');

        // Upload the new solution file to storage
        if ($request->hasFile('solution')) {
            $solutionFile = $request->file('solution');
            $solutionPath = 'solutions/' . time() + rand(1, 10000000) . '.' . $solutionFile->getClientOriginalName();
            $bucket->upload(
                file_get_contents($solutionFile),
                [
                    'name' => $solutionPath,
                ]
            );
            $trainingTask->solution = $solutionPath;
        }

        $trainingTask->save();

        toastr()->success('Solution updated successfully!');

        return redirect()->route('Training-tasks.index');
    }

    public function destroy(TrainingTask $trainingTask)
    {
        //
    }


}
