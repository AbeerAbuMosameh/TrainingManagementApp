<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Advisor;
use App\Models\Field;
use App\Models\Program;
use Illuminate\Http\Request;

class ProgramController extends Controller
{

    function __construct(){
        $this->middleware('permission:program-list', ['only' => ['index', 'show']]);
        $this->middleware('permission:program-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:program-delete', ['only' => ['destroy']]);
        $this->middleware('permission:program-create')->only(['create', 'store']);
    }
    /**
     * Display a listing of the resource.
     */

    //Program Management -  display View contain all Program with its field or disciplines
    public function index(){
        $fields = Field::all();
        $programs = Program::all();
        return view('Admin.ProgramsManagement.index', compact('programs','fields'));
    }

    //Program Management - display View contain (store new program form) all input required to add new program
    public function create(){
        $fields = Field::all();
        return view('Admin.ProgramsManagement.create', compact('fields'));

    }

    //Program Management - Validate & Store Program
    public function store(Request $request){
        $validator = Validator($request->all(), [
            'image' => 'nullable',
            'name' => 'required|string',
            'hours' => 'required|string',
            'start_date' => 'required|date|date_equals:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'type' => 'required|in:free,paid',
            'price' => 'nullable|integer',
            'number' => 'required|integer',
            'duration' => 'required|in:days,weeks,months,years',
            'level' => 'required|in:beginner,intermediate,advanced',
            'language' => 'required|in:English,Arabic,French',
            'field_id' => 'required|exists:fields,id',
            'description' => 'nullable|string',
        ]);

        if (!$validator->fails()) {

            if ($request->hasFile('image')) {
                $imageName = time() . '.' . $request->file('image')->getClientOriginalExtension();
                $request->file('image')->move(public_path('images'), $imageName);
                $requestData = $request->except('image');
                $requestData['image'] = $imageName;
                Program::create($requestData);
            } else {
                Program::create($request->all());
            }
            return response()->json(['message' =>  'Program Created Successfully!']);

        } else {
            return response()->json(['message' =>  $validator->getMessageBag()->first()]);
        }
    }

    //Program Management - display View contain (edit exist program form) all input required to edit new program
    public function edit($id){
        $program = Program::findOrFail($id);
        $fields = Field::all();
        $advisor = Advisor::findOrFail($program->advisor_id);
        return view('Admin.ProgramsManagement.edit', compact('program','fields','advisor'));
    }

    //Program Management - Validate & Update Program
    public function update(Request $request, $id){
        $validator = Validator($request->all(), [
            'image' => 'nullable',
            'name' => 'required|string',
            'hours' => 'required|string',
            'start_date' => 'required|date|date_equals:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'type' => 'required|in:free,paid',
            'price' => 'nullable|integer',
            'number' => 'required|integer',
            'duration' => 'required|in:days,weeks,months,years',
            'level' => 'required|in:beginner,intermediate,advanced',
            'language' => 'required|in:English,Arabic,French',
            'field_id' => 'required|exists:fields,id',
            'description' => 'nullable|string',
        ]);

        if (!$validator->fails()) {
            $program = Program::findOrFail($id);

            if ($request->hasFile('image')) {
                $imageName = time() . '.' . $request->image->extension();
                $request->image->move(public_path('images'), $imageName);
                $program = Program::create($request->except('image')); // Exclude 'image' field from mass assignment
                $program->image = $imageName; // Set the 'image' attribute with the image file name
            }

            $program->name = $request->name;
            $program->hours = $request->hours;
            $program->level = $request->level;
            $program->type = $request->type;
            $program->field_id = $request->field_id;
            $program->language = $request->language;
            $program->description = $request->description;

            $program->save();

            toastr()->success('Program Updated Successfully!');
        } else {
            toastr()->error($validator->getMessageBag()->first());
        }

        return redirect()->route('programs.index');
    }

    //Program Management - Delete Program
    public function destroy($id)
    {
        Program::findOrFail($id)->delete();
        return response()->json(['message' => 'Advisor deleted.']);
    }
}
