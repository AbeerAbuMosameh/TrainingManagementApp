<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\TraineeCredentialsMail;
use App\Models\Advisor;
use App\Models\AdvisorField;
use App\Models\Field;
use App\Models\Notification;
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

    function __construct(){
        $this->middleware('permission:advisor-list', ['only' => ['index', 'show']]);
        $this->middleware('permission:advisor-accept', ['only' => ['accept']]);
        $this->middleware('permission:advisor-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:advisor-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */

    //Advisor Management - display View contain all advisors & his documents and files stored in firebase
    public function index(){
        $advisors = Advisor::with('fields')->get();

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

    //generate URL for each file or document stored in firebase
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

    //Advisor Management - display View contain all field to register new advisor
    public function create(){
        $fields =Field::all();
        return view('Admin.AdvisorsManagement.create',compact('fields'));
    }

    //Advisor Management - Validate & Store advisor Information in database (Sql-NoSQL)
    public function store(Request $request){
        $validator = Validator($request->all(), [
            'image' => 'nullable|mimes:jpeg,png|max:10240', //validate the file types and size
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:advisors|max:255',
            'phone' => 'required|string|max:20',
            'education' => 'required|string|max:255',
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

        try {
            DB::beginTransaction();
            $advisor = new Advisor();
            $advisor->first_name = $request->input('first_name');
            $advisor->last_name = $request->input('last_name');
            $advisor->email = $request->input('email');
            $advisor->phone = $request->input('phone');
            $advisor->education = $request->input('education');
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
                $bucket->upload(
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


            $notification = Notification::create([
                'message' => $advisor->first_name . ' is a new Advisor registration',
                'status' => 'unread'
            ]);

            $advisor->notification_id = $notification->id;
            $advisor->save();


            //Store each field to this advior then accept or not-accept
            $selectedFieldIds = $request->input('field');
            foreach ($selectedFieldIds as $fieldId) {
                AdvisorField::create([
                    'advisor_id' => $advisor->id,
                    'field_id' => $fieldId,
                ]);
            }

            User::create([
                'name' => $request->input('first_name') . ' ' . $request->input('last_name'),
                'email' => $request->input('email'),
                'password' => Hash::make('123456'),
                'level' => 2,
            ]);
            DB::commit();


        } catch (\Exception $e) {
            DB::rollBack();
            toastr()->error($e);

        }

    }

     //send email contain  unique ID and password and change status if first time or change activation of this advisor
    public function accept($id){
        $advisor = Advisor::find($id); // Find the user by ID
        $user = User::where('email', $advisor->email)->first(); // Find the trainee by email
        $advisor_id = uniqid();
        if ($user->unique_id == null) {
            $advisor->is_approved = true;
            $advisor->save();


            //by defualt accept all field he specific it in registeration
            $advisor = Advisor::find($id);
            $fields = $advisor->fields;
            foreach ($fields as $field) {
                AdvisorField::where('advisor_id', $id)->where('field_id', $field->id)->update(['status' => 'accept']);
            }


            $user->unique_id = $advisor_id;
            $pass = Str::random(10);
            $user->password = Hash::make($pass);

            $user->save();


            Mail::to($user->email)->send(new TraineeCredentialsMail($user->unique_id, $pass));
            return response()->json(['message' =>'Advisor Is Active  & Mail Send Successfully with login data!']);


        } else {
            if ($advisor->is_approved) {
                $advisor->is_approved = false;
                $advisor->save();

                return response()->json(['message' => "Advisor Not Active Now"]);

            } else {
                $advisor->is_approved = true;
                $advisor->save();

                return response()->json(['message' => "Advisor Active Now"]);

            }
        }
    }

    //Advisor Management - Show specific advisor Information and their Documents & files
    public function show($id){

        $advisor = Advisor::findOrFail($id);
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
//        Notification::where('id', $advisor->notification_id)->update(['status' => 'read']);
        return view('Admin.AdvisorsManagement.show', compact('advisor'));
    }

    //Advisor Management - get all Advisor in specific Fields
    public function getAdvisors($fieldId){
        $field = Field::find($fieldId);
        $advisors = $field->advisors()->wherePivot('status', 'accept')->get();
        return response()->json($advisors);
    }

    //Advisor Management - display View contain all advisors and their field to accept or reject
    public function advisorsFields(){
        $advisor_fields= AdvisorField::all();
        return view('Admin.AdvisorsManagement.advisors_fields', compact('advisor_fields'));

    }

    //Advisor Management - delete specific advisor
    public function destroy($id)
    {
        Advisor::findOrFail($id)->delete();
        return response()->json(['message' => 'Advisor deleted.']);
    }
}
