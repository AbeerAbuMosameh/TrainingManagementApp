<?php

namespace App\Http\Controllers\Admin;

use App\Events\Manager\NewRegistration;
use App\Http\Controllers\Controller;
use App\Mail\TraineeCredentialsMail;
use App\Models\Advisor;
use App\Models\Field;
use App\Models\Notification;
use App\Models\Rule;
use App\Models\Trainee;
use App\Models\User;
use Google\Cloud\Storage\StorageClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AdvisorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $advisors = Advisor::all();

        foreach ($advisors as $advisor) {
            // Get the file paths for CV, certification, and other files
            $cvPath = $advisor->cv;
            $certificationPath = $advisor->certification;
            $otherFiles = json_decode($advisor->otherFile);


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
            $advisor->cv = $cvDownloadUrl;
            $advisor->certification = $certificationDownloadUrl;
            $advisor->otherFile = $otherFileDownloadUrls;

        }

        return view('Admin.AdvisorsManagement.index', ['advisors' => $advisors]);
    }

    /**
     * Generate a signed URL for the given file path
     *
     * @param string $filePath
     * @return string|null
     */
    function generateDownloadUrl($filePath)
    {
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
    public function create()
    {
        $fields =Field::all();
        return view('Admin.AdvisorsManagement.create',compact('fields'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator($request->all(), [
            'image' => 'nullable|mimes:jpeg,png|max:10240', //validate the file types and size
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:advisors|max:255',
            'phone' => 'required|string|max:20',
            'education' => 'required|string|max:255',
            'field' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'payment' => 'nullable|string|in:Card,PayPal,Bank',
            'language' => 'nullable|string|in:French,Arabic,English',
            'cv' => 'required|mimes:pdf,docx|max:10240', //validate the file types and size
            'certification' => 'required|mimes:pdf,docx,jpeg,png|max:10240',
            'otherFile.*' => 'nullable|file|max:10240', // Adjust the maximum file size as needed

        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);

        }

        // Generate a unique ID
        try {
            DB::beginTransaction();
            $advisor = new Advisor();
            $advisor->first_name = $request->input('first_name');
            $advisor->last_name = $request->input('last_name');
            $advisor->email = $request->input('email');
            $advisor->phone = $request->input('phone');
            $advisor->education = $request->input('education');
            $advisor->field = $request->input('field');
            $advisor->address = $request->input('address');
            $advisor->city = $request->input('city');
            $advisor->language = $request->input('language');
            $advisor->password = Hash::make('123456');

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
                $advisor->cv = $cvPath;

            }

            // Store Certification Files
            if ($request->hasFile('certification')) {
                $certificationFile = $request->file('certification');

                $certificationPath = 'Certifications/'. time() + rand(1, 10000000) . '.'  . $certificationFile->getClientOriginalName();
                $bucket->upload(
                    file_get_contents($certificationFile),
                    [
                        'name' => $certificationPath,
                    ]
                );
                $advisor->certification = $certificationPath;

            }

            // Store Other Files
            if ($request->hasFile('otherFile')) {
                $otherFiles = $request->file('otherFile');

                foreach ($otherFiles as $otherFile) {
                    $otherPath = 'otherFiles/' .  time() + rand(1, 10000000) . '.' .$otherFile->getClientOriginalName();
                    $bucket->upload(
                        file_get_contents($otherFile),
                        [
                            'name' => $otherPath,
                        ]
                    );
                    $otherFilePaths[] = $otherPath;
                }

                // Convert file paths to JSON array and save them in the trainee model
                $advisor->otherFile = json_encode($otherFilePaths);
            }

            $advisor->save();


            $user = User::create([
                'name' => $request->input('first_name') . ' ' . $request->input('last_name'),
                'email' => $request->input('email'),
                'password' => Hash::make('123456'),
                'level' => 2,
            ]);

            $notification = new Notification();
            $notification->message = $advisor->first_name. 'is a New trainee registration';
            $notification->status = 'unread';
            $notification->save();

            // Assign the notification to the trainee
            $advisor->notification()->associate($notification);
            $advisor->save();

            DB::commit();


        } catch (\Exception $e) {
            DB::rollBack();
            toastr()->error($e);

        }

    }


    /**
     * Display the specified resource.
     */
    public function accept($id)
    {
        $advisor = Advisor::find($id); // Find the user by ID
        $user = User::where('email', $advisor->email)->first(); // Find the trainee by email
        $advisor_id = uniqid();
        if ($user->unique_id == null) {
            $advisor->is_approved = true;
            $advisor->save();

            $user->unique_id = $advisor_id;
            $pass = Str::random(10);
            $user->password = Hash::make($pass);

            $user->save();

            toastr()->success(' Advisor Is Active  & Mail Send Successfully with login data!');

            Mail::to($user->email)->send(new TraineeCredentialsMail($user->unique_id, $pass));

        } else {
            if ($advisor->is_approved) {
                $advisor->is_approved = false;
                toastr()->warning('Advisor now not active!');

            } else{
                $advisor->is_approved = true;
                toastr()->Info('Advisor Now active');

            }
            $advisor->save();
        }
        return redirect()->route('advisors.index');
    }
    /**
     * Display the specified resource.
     */
    public function show(Advisor $advisor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Advisor $advisor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Advisor $advisor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Advisor::findOrFail($id)->delete();
        return response()->json(['message' => 'Advisor deleted.']);
    }
}
