<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\TraineeCredentialsMail;
use App\Models\Trainee;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Traits\imageTrait;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\File\UploadedFile;


class TraineeController extends Controller
{
    use imageTrait;

//    function __construct()
//    {
//        $this->middleware('permission:trainee-list', ['only' => ['index', 'show']]);
//     //   $this->middleware('permission:trainee-create', ['only' => ['create', 'store','accept']]);
//    //    $this->middleware('permission:trainee-accept', ['only' => ['accept']]);
//        $this->middleware('permission:trainee-edit', ['only' => ['edit', 'update']]);
//        $this->middleware('permission:trainee-delete', ['only' => ['destroy']]);
//    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $trainees = Trainee::all();
        return view('Admin.TraineesManagement.index', ['trainees' => $trainees]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
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
            'cv' => 'nullable|mimes:pdf,docx|max:10240', //validate the file types and size
            'certification' => 'nullable|mimes:pdf,docx,jpeg,png|max:10240',
            'otherFile' => 'nullable|mimes:pdf,docx,jpeg,png|max:10240',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);

        }

        // Generate a unique ID


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

        // checking if cv file is uploaded and valid.
        if ($request->hasFile('cv')) {
            $file = $request->file('cv');
            $path = "uploads/Trainee_files/cvs/";
            $filename = time() + rand(1, 10000000) . '.' . $file->getClientOriginalName();
            $file->move($path, $filename);
            $trainee->cv = $path . $filename;
        }

        // checking if certification file is uploaded and valid.
        if ($request->hasFile('certification')) {
            $file = $request->file('certification');
            $path = "uploads/Trainee_files/certifications/";
            $filename = time() + rand(1, 10000000) . '.' . $file->getClientOriginalName();
            $file->move($path, $filename);
            $trainee->certification = $path . $filename;
        }

        // checking if otherFile file is uploaded and valid.
        if ($request->hasFile('otherFile')) {
            $file = $request->file('otherFile');
            $path = "uploads/Trainee_files/otherFiles/";
            $filename = time() + rand(1, 10000000) . '.' . $file->getClientOriginalName();
            $file->move($path, $filename);
            $trainee->otherFile = $path . $filename;
        }

        // save the trainee instance to the database
        $trainee->save();


        $user = User::create([
            'name' => $request->input('first_name') . ' ' . $request->input('last_name'),
            'email' => $request->input('email'),
            'password' => Hash::make('123456'),
            'level' => 3,
        ]);

    }




    /**
     * Display the specified resource.
     */
    public function accept($id)
    {
        $trainee = Trainee::find($id); // Find the user by ID
        $user = User::where('email', $trainee->email)->first(); // Find the trainee by email
        $trainee_id = uniqid();
       if($trainee->is_approved == 0) {
           $trainee->is_approved = true;
           $trainee->save();

           $user->trainee_id = $trainee_id;
           $pass = Str::random(10);
           $user->password = Hash::make($pass);

           $user->save();

           toastr()->success('Approved Trainee & Mail Send Successfully!');

           Mail::to($user->email)->send(new TraineeCredentialsMail($user->trainee_id, $pass));

       }else{
           toastr()->error('You Approved this Trainee & send Email Before!');
       }
        return redirect()->route('trainees.index');
    }

    public function show(Trainee $trainee)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Trainee $trainee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Trainee $trainee)
    {
        //
    }
}
