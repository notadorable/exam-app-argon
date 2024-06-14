<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Question;
use Yajra\DataTables\DataTables;

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
        if ($request->ajax()) {
            $questions = Question::select(['id', 'name', 'role', 'created_at']);
            return Datatables::of($questions)
                // ->addColumn('action', function ($question) {
                //     return '<a href="' . route('question.edit', $question->id) . '" class="btn btn-primary btn-sm">Edit</a>
                //             <form action="' . route('question.destroy', $question->id) . '" method="POST" style="display: inline-block;">
                //                 @csrf
                //                 @method('DELETE')
                //                 <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                //             </form>';
                // })
                // ->rawColumns(['action'])
                ->make(true);
        }

        return view('question.index');
    }
}
