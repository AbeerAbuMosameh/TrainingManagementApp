<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Trainee;
use Illuminate\Http\Request;
use App\Http\Controllers\Traits\imageTrait;
use Illuminate\Support\Facades\Storage;


class TraineeController extends Controller
{
    use imageTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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


        $validator = Validator($request->all(),[
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:trainees|max:255',
            'phone' => 'required|string|max:20',
            'education' => 'required|string|max:255',
            'gpa' => 'nullable|numeric|min:0|max:4',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'payment' => 'nullable|string|in:card,paypal,bank',
            'language' => 'nullable|string||in:french,arabic,english',
            'cv' => 'nullable|mimes:pdf,docx,jpeg,png|max:10240', //validate the file types and size
            'certification' => 'nullable|mimes:pdf,docx,jpeg,png|max:10240',
            'otherFile' => 'nullable|mimes:pdf,docx,jpeg,png|max:10240',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);

        }


            // checking file is valid.
            if ($request->hasFile('cv')) {
                $file = $request->file('cv');
                $path = "uploads/files/";
                $filename = time() + rand(1, 10000000) . '.' . $file->getClientOriginalExtension();
                Storage::put($path . $filename, file_get_contents($filename));
                $request['cv'] = $path . $filename;
            }

        // save the user instance to the database
          Trainee::create($request->all());
    }


    /**
     * Display the specified resource.
     */
    public function show(Trainee $trainee)
    {
        //
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
    public function update(Request $request, Trainee $trainee)
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
