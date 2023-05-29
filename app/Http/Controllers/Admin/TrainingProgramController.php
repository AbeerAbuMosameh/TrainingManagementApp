<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Field;
use App\Models\Program;
use App\Models\Trainee;
use App\Models\TrainingProgram;
use Database\Factories\TraineeProgramFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TrainingProgramController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    //Training Program Request - display all trainee request to apply in programs
    public function index()
    {
        $fields = Field::all();
        $traineeId = Trainee::where('email', Auth::user()->email)->value('id');// Assuming the trainee's ID is stored in the 'id' field of the user model

        $programs = TrainingProgram::where('trainee_id', $traineeId)->get();
        foreach ($programs as $program) {
            $program->program_name = Program::where('id', $program->program_id)->value('name');
            $program->program_type = Program::where('id', $program->program_id)->value('type');
        }

        return view('Trainee.ApplyProgramsManagement.index', compact('fields', 'programs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $fields = Field::all();
        return view('Trainee.ApplyProgramsManagement.index', compact('fields'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $traineeId = Trainee::where('email', Auth::user()->email)->first();

// Check if the trainee has already applied for the program
        $existingProgram = TrainingProgram::where('trainee_id', $traineeId->id)
            ->where('program_id', $request->input('program_id'))
            ->first();

        if ($existingProgram) {
            toastr()->warning('You have already applied for this program.');
            return redirect()->route('trainees-programs.index');
        }

        $traineeProgram = new TrainingProgram();
        $traineeProgram->trainee_id = $traineeId->id;
        $traineeProgram->program_id = $request->input('program_id');
        $traineeProgram->status = 'rejected';
        $traineeProgram->save();

        $program = Program::find($request->input('program_id'));

        if ($program->type == 'free') {
            toastr()->success('The application to join the program has been transferred to the Manager. Please await a response');
        } else {
            toastr()->warning('Program is paid you showed pay fees ');

        }

        return redirect()->route('trainees-programs.index');


    }

    /**
     * Display the specified resource.
     */
    public function show(TrainingProgram $trainingProgram)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TrainingProgram $trainingProgram)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TrainingProgram $trainingProgram)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TrainingProgram $trainingProgram)
    {
        //
    }
}
