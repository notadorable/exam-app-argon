<?php

namespace App\Http\Controllers;

use App\Models\Mapping;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Subtest;
use App\Models\Question;
use App\Models\QuestionChoice;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $projects = Project::all();
        return view('project.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $subtests = Subtest::get();

        return view('project.create', compact('subtests'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $validatedData = $request->validate([
            'project_name' => 'required|string',
            'project_description' => 'string',
        ]);

        $project = Project::create([
            'project_name' => $validatedData['project_name'],
            'project_description' => $validatedData['project_description'],
            'is_active' => 1,
            'created_by' => Auth::id(),
            'created_time' => Carbon::now(),
        ]);

        foreach ($request->all()['subtest_id'] as $key => $value) {
            $mapping = Mapping::create([
                'project_id' => $project->id,
                'subtest_id' => $value,
                'durasi' => $request->all()['duration'],
                'is_active' => 1,
                'created_by' => Auth::id(),
                'created_time' => Carbon::now(),
            ]);
        }

        return redirect()->route('project')->with('success', 'Project created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $project = Project::find($id);
        $subtest = Subtest::find($project->subtest_id);
        $questions = Question::where('subtest_id', $project->subtest_id)->get();
        $choices = QuestionChoice::whereIn('question_id', $questions->pluck('question_id'))->get();

        return view('project.show', compact('project', 'subtest', 'questions', 'choices'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $project = Project::find($id);
        $mapping = Mapping::where('project_id', $id)->get();
        $subtests = Subtest::all();
        return view('project.edit', compact('project', 'subtests', 'mapping'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'project_name' => 'required|string',
            'project_description' => 'string',
            'duration' => 'required|numeric', // Assuming duration is a numeric value
            'subtest_id' => 'required|array', // Assuming subtest_id is an array
            'subtest_id.*' => 'exists:subtests,id', // Validate each subtest ID
        ]);

        $project = Project::find($id);

        // Update project details
        $project->update([
            'project_name' => $validatedData['project_name'],
            'project_description' => $validatedData['project_description'],
            'updated_by' => Auth::id(),
            'updated_time' => now(),
        ]);

        // Update or create mappings for subtests
        $existingMappingIds = Mapping::where('project_id', $id)->pluck('subtest_id')->toArray();

        // Delete mappings for subtests that are no longer selected
        Mapping::where('project_id', $id)
            ->whereNotIn('subtest_id', $validatedData['subtest_id'])
            ->delete();

        // Create or update mappings for selected subtests
        foreach ($validatedData['subtest_id'] as $subtestId) {
            if (in_array($subtestId, $existingMappingIds)) {
                // Update existing mapping
                Mapping::where('project_id', $id)
                    ->where('subtest_id', $subtestId)
                    ->update([
                        'durasi' => $validatedData['duration'],
                        'updated_by' => Auth::id(),
                        'updated_time' => now(),
                    ]);
            } else {
                // Create new mapping
                Mapping::create([
                    'project_id' => $id,
                    'subtest_id' => $subtestId,
                    'durasi' => $validatedData['duration'],
                    'is_active' => 1,
                    'created_by' => Auth::id(),
                    'created_time' => Carbon::now(),
                ]);
            }
        }

        return redirect()->route('project')->with('success', 'Project updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $project = Project::find($id);

        if ($project) {
            Mapping::where('project_id', $id)->delete();

            $project->delete();
            return redirect()->route('project')->with('success', 'Project deleted successfully.');
        } else {
            return redirect()->route('project')->with('error', 'Project not found.');
        }
    }
}
