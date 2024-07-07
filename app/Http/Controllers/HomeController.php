<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Subtest;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
        /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $projects = Project::select('projects.*', DB::raw('count(DISTINCT participants.nik) as jumlah_peserta'))
        ->leftJoin('participants', 'projects.id', '=', 'participants.project_id')
        ->groupBy('projects.id')
        ->get();
        return view('pages.dashboard', compact('projects'));
    }

    public function questionindex()
    {
        return view('question.index');
    }

    public function showSubtests($id)
    {
        $subtests = Subtest::select('subtests.*')
            ->join('mappings', 'subtests.id', '=', 'mappings.subtest_id')
            ->where('mappings.project_id', $id)
            ->get();
            
        return view('pages.subtest', ['project_id'=>$id,'subtests'=>$subtests]);
    }

    public function showSubtestDetails($projectId, $subtestId)
    {
        $subtestName = Subtest::find($subtestId)->subtest_name;
        $participants = DB::table('participants')
            ->select('participants.id', 'participants.name', 
                DB::raw('SUM(CASE WHEN tr_answers.choice_id = question_choices.id AND question_choices.choice_answer = "Y" THEN 1 ELSE 0 END) as score'))
            ->leftjoin('tr_answers', function ($join) use ($projectId) {
                $join->on('participants.id', '=', 'tr_answers.participant_id')
                     ->where('tr_answers.project_id', '=', $projectId);
            })
            ->leftjoin('question_choices', 'tr_answers.choice_id', '=', 'question_choices.id')
            ->where('participants.project_id', $projectId)
            ->where('participants.subtest_id', $subtestId)
            ->groupBy('participants.id', 'participants.name')
            ->get();

        return view('pages.subtest-detail', [
            'participants' => $participants,
            'subtestId' => $subtestId,
            'projectId' => $projectId,
            'subtestName' => $subtestName
        ]);
    }
}
