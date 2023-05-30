<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\downloadUrtTrait;
use App\Mail\TraineeCredentialsMail;
use App\Models\Advisor;
use App\Models\Notification;
use App\Models\Payment;
use App\Models\Program;
use App\Models\Trainee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Google\Cloud\Storage\StorageClient;

class TraineeController extends Controller
{

    use downloadUrtTrait;

    function __construct(){
        $this->middleware('permission:trainee-accept', ['only' => ['accept']]);
        $this->middleware('permission:trainee-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:trainee-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */

    //Trainee Management - display View contain all Trainees & his documents and files stored in firebase
    public function index(){
        $trainees = Trainee::all();
        foreach ($trainees as $trainee) {
            $payment = Payment::where('id', $trainee->payment)->first();
            if ($payment == null) {
                $trainee->payment = 'not Selected';
            } else {
                $trainee->payment = $payment->name;
            }



        // Get the file paths for CV, certification, and other files
            $cvPath = $trainee->cv;
            $certificationPath = $trainee->certification;
            $otherFiles = json_decode($trainee->otherFile);


            // Generate download links or display the files
            $cvDownloadUrl = $this->generateDownloadUrl($cvPath);
            $certificationDownloadUrl = $this->generateDownloadUrl($certificationPath);
            $otherFileDownloadUrls = [];


            // Handle the case when $otherFiles is empty or null
            if (!empty($otherFiles)) {
                foreach ($otherFiles as $otherFile) {
                    $otherFileDownloadUrls[] = $this->generateDownloadUrl($otherFile);
                }
            }


            // Assign the download URLs to the trainee object
            $trainee->cv = $cvDownloadUrl;
            $trainee->certification = $certificationDownloadUrl;
            $trainee->otherFile = $otherFileDownloadUrls;

        }


        return view('Admin.TraineesManagement.index', ['trainees' => $trainees]);
    }


    //Trainee Management - display View contain all payment way to register new trainee
    public function create(){
        $payments =Payment::all();
        return view('Admin.TraineesManagement.create',compact('payments'));
    }

    //Trainee Management - Validate & Store trainee Information in database (Sql-NoSQL)
    public function store(Request $request){
        $validator = Validator($request->all(), [
            'image' => 'nullable|mimes:jpeg,png|max:10240', //validate the file types and size
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:trainees|max:255',
            'phone' => 'required|string|max:20',
            'education' => 'required|string|max:255',
            'gpa' => 'nullable|numeric|min:0|max:4',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'payment' => 'nullable|string',
            'language' => 'nullable|string|in:French,Arabic,English',
            'cv' => 'required|mimes:pdf,docx,jpeg,png|max:10240', //validate the file types and size
            'certification' => 'required|mimes:pdf,docx,jpeg,png|max:10240',
            'otherFile.*' => 'nullable|file|max:10240', // Adjust the maximum file size as needed

        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);

        }

        // Generate a unique ID
        try {
            DB::beginTransaction();
            $trainee = new Trainee();
            $trainee->first_name = $request->input('first_name');
            $trainee->last_name = $request->input('last_name');
            $trainee->email = $request->input('email');
            $trainee->phone = $request->input('phone');
            $trainee->education = $request->input('education');
            $trainee->gpa = $request->input('gpa');
            $trainee->address = $request->input('address');
            $trainee->city = $request->input('city');
            $trainee->payment = $request->input('payment');
            $trainee->language = $request->input('language');
            $trainee->password = Hash::make('123456');

            // Initialize Google Cloud Storage
            $storage = new StorageClient([
                'projectId' => 'it-training-app-386209',
                'keyFilePath' => 'C:\xampp\htdocs\TrainingManagementApp\app\Http\Controllers\it-training-app-386209-firebase-adminsdk-20xbx-c933a61e7b.json',
            ]);

            $bucket = $storage->bucket('it-training-app-386209.appspot.com');

            // Store CV Files
            if ($request->hasFile('cv')) {
                $cvFile = $request->file('cv');
                $cvPath = 'CVs/' . time() + rand(1, 10000000) . '.' . $cvFile->getClientOriginalName();
                $test = $bucket->upload(
                    file_get_contents($cvFile),
                    [
                        'name' => $cvPath,
                    ]
                );
                $trainee->cv = $cvPath;

            }

            // Store Certification Files
            if ($request->hasFile('certification')) {
                $certificationFile = $request->file('certification');

                $certificationPath = 'Certifications/' . time() + rand(1, 10000000) . '.' . $certificationFile->getClientOriginalName();
                $bucket->upload(
                    file_get_contents($certificationFile),
                    [
                        'name' => $certificationPath,
                    ]
                );
                $trainee->certification = $certificationPath;

            }

            // Store Other Files
            if ($request->hasFile('otherFile')) {
                $otherFiles = $request->file('otherFile');

                foreach ($otherFiles as $otherFile) {
                    $otherPath = 'otherFiles/' . time() + rand(1, 10000000) . '.' . $otherFile->getClientOriginalName();
                    $bucket->upload(
                        file_get_contents($otherFile),
                        [
                            'name' => $otherPath,
                        ]
                    );
                    $otherFilePaths[] = $otherPath;
                }

                // Convert file paths to JSON array and save them in the trainee model
                $trainee->otherFile = json_encode($otherFilePaths);
            }



            $notification = Notification::create([
                'message' => $trainee->first_name . ' is a new trainee registration',
                'status' => 'unread',
                'level' => 1,

            ]);

            $trainee->notification_id = $notification->id;
            $trainee->save();


            User::create([
                'name' => $request->input('first_name') . ' ' . $request->input('last_name'),
                'email' => $request->input('email'),
                'password' => Hash::make('123456'),
                'level' => 3,
            ]);



            DB::commit();

            // Save the trainee instance and other data to the database


            // save the trainee instance to the database

        } catch (\Exception $e) {
            DB::rollBack();
            toastr()->error($e);

        }

    }

    //send email contain unique ID and password and change status if first time or change activation of this advisor
    public function accept($id){
        $trainee = Trainee::find($id); // Find the user by ID
        $user = User::where('email', $trainee->email)->first(); // Find the trainee by email
        $unique_id = uniqid();
        if ($user->unique_id == null) {
            $trainee->is_approved = true;
            $trainee->save();

            $user->unique_id = $unique_id;
            $pass = Str::random(10);
            $user->password = Hash::make($pass);

            $user->save();
            Mail::to($user->email)->send(new TraineeCredentialsMail($user->unique_id, $pass));

            return response()->json(['message' =>'Trainee Is Active  & Mail Send Successfully with login data!']);


        } else {
            if ($trainee->is_approved) {
                $trainee->is_approved = false;
                $trainee->save();

                return response()->json(['message' => "Trainee Not Active Now"]);

            } else {
                $trainee->is_approved = true;
                $trainee->save();

                return response()->json(['message' => "Trainee Active Now"]);

            }
        }
    }

    //Trainee Management - Show specific trainee Information and their Documents & files
    public function show($id){
        $trainee = Trainee::findOrFail($id);
        // Get the file paths for CV, certification, and other files
        $cvPath = $trainee->cv;
        $certificationPath = $trainee->certification;
        $otherFiles = json_decode($trainee->otherFile);


        // Generate download links or display the files
        $cvDownloadUrl = $this->generateDownloadUrl($cvPath);
        $certificationDownloadUrl = $this->generateDownloadUrl($certificationPath);
        $otherFileDownloadUrls = [];


        // Handle the case when $otherFiles is empty or null
        if (!empty($otherFiles)) {
            foreach ($otherFiles as $otherFile) {
                $otherFileDownloadUrls[] = $this->generateDownloadUrl($otherFile);
            }
        }


        // Assign the download URLs to the trainee object
        $trainee->cv = $cvDownloadUrl;
        $trainee->certification = $certificationDownloadUrl;
        $trainee->otherFile = $otherFileDownloadUrls;

//        Notification::where('id', $trainee->notification_id)->update(['status' => 'read']);
        return view('Admin.TraineesManagement.show', compact('trainee'));
    }

    //Advisor Management - delete specific advisor
    public function destroy($id)
    {
        Trainee::findOrFail($id)->delete();
        return response()->json(['message' => 'Trainee deleted.']);
    }

    //All Actors - display View To change Password
    public function password(){
        return view('Admin.updatePassword');
    }

    //All Actors - Validate &  change Password
    public function updatePassword(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validator = Validator($request->all(), [
            'oldPassword' => 'required',
            'password' => 'required|string|confirmed',
        ]);

        if ($validator->fails()) {
            if ($validator->errors()->has('password')) {
                return response()->json(['message' => $validator->errors()->first('password')], 422);
            } else {
                return response()->json(['message' => 'All fields should be entered'], 422);
            }
        } else {
            // Check if the previous password matches the one stored in the database
            if (!Hash::check($request->input('oldPassword'), $user->password)) {
                return response()->json(['message' => 'Previous password is incorrect'], 422);
            } else {
                // Update the password
                $user->password = Hash::make($request->input('password'));
                $user->save();
                return response()->json(['message' => 'Password updated successfully']);
            }
        }
    }


    //display trainee to specific advisor
    public function displayTrainees(){
        $advisorId = Advisor::where('email', Auth()->user()->email)->value('id');
        $programIds = Program::where('advisor_id', $advisorId)->pluck('id');

        $trainees = Trainee::whereHas('programs', function ($query) use ($programIds) {
            $query->whereIn('program_id', $programIds)
                ->where('status', 'accepted');
        })->with(['programs' => function ($query) use ($programIds) {
            $query->whereIn('program_id', $programIds)->where('status', 'accepted')->select('name');
        }])->get();

        return view('Advisor.TraineesManagement.index', compact('trainees'));
    }

    //Trainee Management - Show specific trainee Information and their Documents & files
    public function showTrainees($id){
        $trainee = Trainee::findOrFail($id);
        // Get the file paths for CV, certification, and other files
        $cvPath = $trainee->cv;
        $certificationPath = $trainee->certification;
        $otherFiles = json_decode($trainee->otherFile);


        // Generate download links or display the files
        $cvDownloadUrl = $this->generateDownloadUrl($cvPath);
        $certificationDownloadUrl = $this->generateDownloadUrl($certificationPath);
        $otherFileDownloadUrls = [];


        // Handle the case when $otherFiles is empty or null
        if (!empty($otherFiles)) {
            foreach ($otherFiles as $otherFile) {
                $otherFileDownloadUrls[] = $this->generateDownloadUrl($otherFile);
            }
        }


        // Assign the download URLs to the trainee object
        $trainee->cv = $cvDownloadUrl;
        $trainee->certification = $certificationDownloadUrl;
        $trainee->otherFile = $otherFileDownloadUrls;

//        Notification::where('id', $trainee->notification_id)->update(['status' => 'read']);
        return view('Advisor.TraineesManagement.show', compact('trainee'));
    }

    public function showTraineesinProgram($programId){
        // Retrieve the trainees associated with the program ID where status is accepted
        $trainees = Trainee::whereHas('programs', function ($query) use ($programId) {
            $query->where('program_id', $programId)
                ->where('status', 'accepted');
        })->get();

        $programName = Program::where('id', $programId)->value('name');

        foreach ($trainees as $trainee) {
            // Get the file paths for CV, certification, and other files
            $cvPath = $trainee->cv;
            $certificationPath = $trainee->certification;
            $otherFiles = json_decode($trainee->otherFile);


            // Generate download links or display the files
            $cvDownloadUrl = $this->generateDownloadUrl($cvPath);
            $certificationDownloadUrl = $this->generateDownloadUrl($certificationPath);
            $otherFileDownloadUrls = [];


            // Handle the case when $otherFiles is empty or null
            if (!empty($otherFiles)) {
                foreach ($otherFiles as $otherFile) {
                    $otherFileDownloadUrls[] = $this->generateDownloadUrl($otherFile);
                }
            }


            // Assign the download URLs to the trainee object
            $trainee->cv = $cvDownloadUrl;
            $trainee->certification = $certificationDownloadUrl;
            $trainee->otherFile = $otherFileDownloadUrls;

        }


        return view('Advisor.TraineesManagement.index', compact('trainees' , 'programName'));
    }

}
