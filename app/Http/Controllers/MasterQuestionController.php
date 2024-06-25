<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\Question;
use App\Models\QuestionChoice;
use App\Models\Subtest;

class MasterQuestionController extends Controller
{
    // public function index()
    // {
    //     // Logic to fetch questions from the database or other sources
    //     // $questions = Question::all(); // Example using Eloquent

    //     // Pass the questions to the view
    //     return view('pages.question.index', [
    //         'title' => 'Question Index', // Example title for the page
    //         // 'questions' => $questions // Example data to pass to the view
    //     ]);
    // }

    public function index(Request $request)
    {
        $subtests = DB::table('subtests')
            ->select('subtests.id', 'subtests.subtest_name', DB::raw('COUNT(questions.id) as question_count'))
            ->leftJoin('questions', 'subtests.id', '=', 'questions.subtest_id')
            ->groupBy('subtests.id', 'subtests.subtest_name')
            ->get();

        return view('question.index', ['subtests'=>$subtests]);
    }

    public function show($subtest_id) // Changed parameter to Subtest
    {
        $subtest = Subtest::find($subtest_id);

        // Fetch questions associated with the subtest
        $questions = $subtest->questions;

        // Fetch choices for the questions
        $choices = QuestionChoice::whereIn('question_id', $questions->pluck('id'))->get();

        // Pass data to the view
        return view('question.show', compact('subtest', 'questions', 'choices'));
    }

    public function create()
    {
        return view('question.create');
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $validatedData = $request->validate([
            'subtest_name' => 'required|string',
            'duration' => 'required|numeric',
            'question_name' => 'array',
            'question_name.*' => 'required|string',
            'choice_name' => 'array',
            'choice_name.*' => 'array',
            'choice_name.*.*' => 'required|string',
        ]);

        // Create the subtest
        $subtest = Subtest::create([
            'formula_id' => 1,
            'subtest_name' => $validatedData['subtest_name'],
            'duration' => $validatedData['duration'],
            'is_active' => 1,
            'created_by' => Auth::id(),
            'created_time' => now(),
        ]);

        // Create questions and choices
        foreach ($validatedData['question_name'] as $index => $questionName) {
            $question = Question::create([
                'subtest_id' => $subtest->id,
                'question_name' => $questionName,
                'question_detail' => '',
                'is_grup' => 0,
                'is_active' => 1,
                'created_by' => Auth::id(),
                'created_time' => now(),
            ]);

            // Create choices for the question
            if (isset($validatedData['choice_name'][$index])) {
                foreach ($validatedData['choice_name'][$index] as $cdx => $choiceName) {
                    $is_correct = $request->all()['choice_answer'][$index][$cdx] == "true" ? 'Y' : 'N';
                    if($cdx == 0){
                        $choice_type = "A";
                    } else if ($cdx == 1) {
                        $choice_type = "B";
                    } else if ($cdx == 2){
                        $choice_type = "C";
                    } else if ($cdx == 3){
                        $choice_type = "D";
                    }else{
                        $choice_type = "E";
                    }
                    QuestionChoice::create([
                        'question_id' => $question->id,
                        'choice_type' => $choice_type,
                        'choice_name' => $choiceName,
                        'choice_answer' => $is_correct,
                        'is_active' => 1,
                        'created_by' => Auth::id(),
                        'created_time' => now(),
                    ]);
                }
            }
        }

        return redirect()->route('question')->with('success', 'Question created successfully.');
    }

    public function edit($subtest_id)
    {
        // Fetch the subtest using the subtest_id
        $subtest = Subtest::find($subtest_id); // Correctly using subtest_id

        // Fetch the questions associated with the subtest
        $questions = Question::where('subtest_id', $subtest_id)->get();

        // Fetch choices for the questions
        $choices = QuestionChoice::whereIn('question_id', $questions->pluck('id'))->get();

        // Pass data to the view
        return view('question.edit', compact('subtest', 'questions', 'choices'));
    }

    public function update(Request $request, $subtest_id)
    {
        // dd($request->all());
        $validatedData = $request->validate([
            'subtest_name' => 'required|string',
            'duration' => 'required|numeric',
            'question_name' => 'array',
            'question_name.*' => 'required|string',
            'choice_name' => 'array',
            'choice_name.*' => 'array',
            'choice_name.*.*' => 'required|string',
            'choice_answer' => 'array',
            'choice_answer.*' => 'array',
            'choice_answer.*.*' => 'required|string',
        ]);

        // Update the subtest
        $subtest = Subtest::find($subtest_id);
        $subtest->update([
            'subtest_name' => $validatedData['subtest_name'],
            'duration' => $validatedData['duration'],
            'updated_by' => Auth::id(),
            'updated_time' => now(),
        ]);

        foreach ($validatedData['question_name'] as $questionId => $questionName) {
            $question = Question::find($questionId);

            if ($question) {
                $question->update([
                    'subtest_id' => $subtest->id,
                    'question_name' => $questionName,
                    'updated_by' => Auth::id(),
                    'updated_time' => now(),
                ]);
            } else {
                $question = Question::create([
                    'subtest_id' => $subtest->id,
                    'question_name' => $questionName,
                    'question_detail' => '',
                    'is_grup' => 0,
                    'is_active' => 1,
                    'created_by' => Auth::id(),
                    'created_time' => now(),
                ]);
            }

            // Update or create choices for the question
            if (isset($validatedData['choice_name'][$questionId])) {
                foreach ($validatedData['choice_name'][$questionId] as $choiceIndex => $choiceName) {
                    $isCorrect = isset($validatedData['choice_answer'][$questionId][$choiceIndex]) && $validatedData['choice_answer'][$questionId][$choiceIndex] === 'true';
                    QuestionChoice::updateOrCreate(
                        ['question_id' => $question->id, 'choice_type' => chr(65 + $choiceIndex)],
                        [
                            'choice_name' => $choiceName,
                            'choice_answer' => $isCorrect ? 'Y' : 'N', // Convert boolean to string
                            'updated_by' => Auth::id(),
                            'updated_time' => now(),
                        ]
                    );
                }
            }
        }

        return redirect()->route('question')->with('success', 'Subtest updated successfully.');
    }

    public function destroy($subtest_id)
{
        $subtest = Subtest::find($subtest_id);
        if ($subtest) {
            // Delete associated questions
            $questions = Question::where('subtest_id', $subtest_id)->get();
            foreach ($questions as $question) {
                $question->delete();
            }

            // Delete associated question choices
            QuestionChoice::where('question_id', $subtest_id)->delete();

            // Delete the subtest
            $subtest->delete();

            return redirect()->route('question')->with('success', 'Subtest deleted successfully.');
        } else {
            return redirect()->route('question')->with('error', 'Subtest not found.');
        }
    }
}
