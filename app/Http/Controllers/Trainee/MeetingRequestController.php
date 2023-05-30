<?php

namespace App\Http\Controllers\Trainee;

use App\Http\Controllers\Controller;
use App\Models\MeetingRequest;
use App\Models\Trainee;
use Illuminate\Http\Request;
use Kreait\Firebase\Contract\Auth;

class MeetingRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(){
        $id = Trainee::where('email', Auth()->user()->email)->value('id');
        $meetings = MeetingRequest::where('trainee_id', $id)->get();

        $advisors = collect(); // Create an empty collection to store advisors

//        // Get the programs for the trainee and retrieve the advisors for each program
//        $programs = Program::whereIn('id', $meetings->pluck('program_id'))->get();
//        foreach ($programs as $program) {
//            $advisors = $advisors->concat($program->advisors);
//        }

        return view('Trainee.MeetingManagement.index', compact('meetings', 'advisors'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(MeetingRequest $meetingRequest)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MeetingRequest $meetingRequest)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MeetingRequest $meetingRequest)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MeetingRequest $meetingRequest)
    {
        //
    }
}
