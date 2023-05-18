<?php

namespace App\Http\Controllers;

use App\Models\Advisor;
use App\Models\Trainee;
use Illuminate\Http\Request;

class WebSiteController extends Controller
{
    public function index()
    {
        $trainee_num = Trainee::all()->count();
        $advisor_num = Advisor::all()->count();
        return view('Website.mainpage',compact('trainee_num','advisor_num'));
    }
}
