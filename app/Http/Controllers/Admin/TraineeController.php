<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\TraineeCredentialsMail;
use App\Models\Notification;
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

    function __construct()
    {
//        $this->middleware('permission:trainee-list', ['only' => ['index', 'show']]);
//        $this->middleware('permission:trainee-accept', ['only' => ['accept']]);
//        $this->middleware('permission:trainee-edit', ['only' => ['edit', 'update']]);
//        $this->middleware('permission:trainee-delete', ['only' => ['destroy']]);
//        $this->middleware('permission:trainee-create')->only(['create', 'store']);

    }

    /**
     * Display a listing of the resource.
     */
    public function index(){
        $trainees = Trainee::all();

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


        return view('Admin.TraineesManagement.index', ['trainees' => $trainees]);
    }

    /**
     * Generate a signed URL for the given file path
     *
     * @param string $filePath
     * @return string|null
     */
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
     * Show the form for creating a new resource.
     */
    public function create(){
        return view('Admin.TraineesManagement.create');
    }


    public function store(Request $request)
    {
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
            'payment' => 'nullable|string|in:Card,PayPal,Bank',
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

            $trainee->save();


            $user = User::create([
                'name' => $request->input('first_name') . ' ' . $request->input('last_name'),
                'email' => $request->input('email'),
                'password' => Hash::make('123456'),
                'level' => 3,
            ]);

            // Create a new notification for the manager
            $notification = new Notification();
            $notification->message = $trainee->first_name. 'is a New trainee registration';
            $notification->status = 'unread';
            $notification->save();

            // Assign the notification to the trainee
            $trainee->notification()->associate($notification);
            $trainee->save();

            DB::commit();

            // Save the trainee instance and other data to the database


            // save the trainee instance to the database

        } catch (\Exception $e) {
            DB::rollBack();
            toastr()->error($e);

        }

    }


    /**
     * Display the specified resource.
     */
    public
    function accept($id)
    {
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
            toastr()->success('Trainee Is Active  & Mail Send Successfully with login data!');

            Mail::to($user->email)->send(new TraineeCredentialsMail($user->unique_id, $pass));

        } else {
            if ($trainee->is_approved) {
                $trainee->is_approved = false;
                toastr()->warning('Trainee now not active!');

            } else {
                $trainee->is_approved = true;
                toastr()->Info('Trainee now active');

            }
            $trainee->save();
        }
        return redirect()->route('trainees.index');
    }

    public
    function show(Trainee $trainee)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public
    function edit(Trainee $trainee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public
    function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public
    function destroy($id)
    {
        Trainee::findOrFail($id)->delete();
        return response()->json(['message' => 'Trainee deleted.']);
    }


    public function password()
    {
        return view('Admin.updatePassword');
    }


    public function updatePassword(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $validator = Validator($request->all(), [
            'oldPassword' => 'required',
            'password' => 'required|string|confirmed',
        ]);
        if ($validator->fails() && !$validator->errors()->has('password_confirmation')) {
            toastr()->warning('All fields should be entered');
        } elseif ($validator->errors()->has('password_confirmation')) {
            toastr()->warning('Password confirmation does not match');
        } else {
            // Check if the previous password matches the one stored in the database
            if (!Hash::check($request->input('oldPassword'), $user->password)) {
                toastr()->warning('Previous password is incorrect');
            } else {
                // Update the password
                $user->password = Hash::make($request->input('password'));
                $user->save();
                toastr()->success('Password updated successfully');
            }
        }
        return redirect()->route('password');

    }
}
