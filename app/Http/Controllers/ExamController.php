<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Jadwal;
use App\Models\Participant;
use App\Models\Subtest;
use Illuminate\Http\Request;

class ExamController extends Controller
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
        $participant = Participant::where('nik', auth()->user()->username)->get();

        return view('exam.index', [
            'participant' => $participant
        ]);
    }

    public function question($subtest_id, $participant_id)
    {
        $subtest = Subtest::where('id', $subtest_id)->first();
        $participant = Participant::where('id', $participant_id)->first();

        return view('exam.question', compact('subtest', 'subtest_id', 'participant', 'participant_id'));
    }

    public function submit(Request $request)
    {
        // Validasi data
        // $validated = $request->validate([
        //     'name' => 'required|string|max:255',
        //     'email' => 'required|email|max:255',
        // ]);
        $project_id = $request->input('project_id');
        $participant_id = $request->input('participant_id');
        $subtest_id = $request->input('subtest_id');
        $answer = $request->input('answer');

        foreach ($answer as $key => $a) {
            $ans = new Answer();
            $ans->project_id = $project_id;
            $ans->participant_id = $participant_id;
            $ans->question_id = $a['question_id'];
            $ans->choice_id = $a['choice_id'];
            $ans->choice_type = $a['choice_type'];
            $ans->created_by = auth()->user()->email;
            $ans->save();
        }

        $jadwal = Jadwal::where('participant_id', $participant_id)->first();
        $jadwal->status_test = 1;
        $jadwal->updated_time = date('Y-m-d H:i:s');
        $jadwal->save();

        return response()->json(['success' => true, 'message' => 'Jawaban berhasil disubmit!']);
    }

}
