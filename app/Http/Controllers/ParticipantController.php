<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\Question;
use App\Models\QuestionChoice;
use App\Models\Subtest;

class ParticipantController extends Controller
{
    public function index(Request $request)
    {

        return view('participant.index', []);
    }
}
