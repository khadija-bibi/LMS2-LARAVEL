<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AssignmentController extends Controller
{

    public function index()
    {
        $user = auth()->user();

        if ($user->hasRole('teacher')) {
            $teacher = $user->teacher;
            $assignments = Assignment::with('course')
                ->whereHas('course', function ($query) use ($teacher) {
                    $query->where('teacher_id', $teacher->id);
                })->get();
        } 
        if ($user->hasRole('student')) {
            $student = $user->student;
            $assignments = Assignment::whereHas('course', function ($query) use ($student) {
                $query->where('semester', $student->semester); 
            })->get();
        } 
        return view('assignments.index', compact('assignments'));
    }


    public function create()
    {
        $teacher = auth()->user()->teacher; 
        $courses = $teacher->courses;
        return view('assignments.create', compact('courses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'course_id' => 'required|exists:courses,id',
            'description' => 'required|string',
            'due_date' => 'required|date',
            'assignment_file' => 'required|mimes:pdf,doc,docx|max:2048',
        ]);
       
        $filePath = $request->file('assignment_file')->store('assignments', 'public');

        if ($validator->passes()) {
             Assignment::create([
            'course_id' => $request->course_id,
            'teacher_id' => auth()->user()->teacher->id,
            'description' => $request->description,
            'due_date' => $request->due_date,
            'assignment_file' => $filePath,
        ]);

        return redirect()->route('assignments.index')->with('success', 'Assignment created successfully.');
        }
        else{
            return redirect()->route('assignments.create')->withInput()->withErrors($validator);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $assignment = Assignment::findOrFail($id);
        $courses = Course::all(); 
        return view('assignments.edit', compact('assignment', 'courses'));
    }

    // Update Assignment
    public function update(Request $request, $id)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'description' => 'required|string',
            'due_date' => 'required|date',
            'assignment_file' => 'nullable|mimes:pdf,doc,docx|max:2048',
        ]);

        $assignment = Assignment::findOrFail($id);

        if ($request->hasFile('assignment_file')) {
            
            Storage::delete('public/' . $assignment->assignment_file);
            
            $filePath = $request->file('assignment_file')->store('assignments', 'public');
            $assignment->assignment_file = $filePath;
        }

        $assignment->update([
            'course_id' => $request->course_id,
            'description' => $request->description,
            'due_date' => $request->due_date,
        ]);

        return redirect()->route('assignments.index')->with('success', 'Assignment updated successfully.');
    }

    // Delete Assignment
    public function destroy($id)
    {
        $assignment = Assignment::findOrFail(decrypt($id));

        Storage::delete('public/' . $assignment->assignment_file);
        Storage::delete('public/' . $assignment->submission_file);

        $assignment->delete();

        return redirect()->route('assignments.index')->with('success', 'Assignment deleted successfully.');
    }

    public function download(string $id)
    {
        $assignment = Assignment::findOrFail($id);
        $filePath = str_replace('public/', '', $assignment->assignment_file);

        return response()->download(storage_path("app/public/{$filePath}"));
    }
    // Assignment submission controller
    public function submitForm($id)
    {
        $assignment = Assignment::findOrFail($id);
        $user = auth()->user();

        if ($user->hasRole('student')) {
            $submission = $assignment->submissions()->where('student_id', $user->student->id)->first();
        } 
        if ($user->hasRole('teacher')) {
            $submission = $assignment->submissions()->with('student.user')->get();
        } 

        return view('assignments.submit', compact('assignment', 'submission'));
    }

    public function submit(Request $request, $id)
    {
        $request->validate([
            'submission_file' => 'required|mimes:pdf,doc,docx|max:2048',
        ]);

        $assignment = Assignment::findOrFail($id);
        $student = auth()->user()->student;
        $filePath = $request->file('submission_file')->store('submissions', 'public');

        $assignment->submissions()->create([
            'student_id' => $student->id,
            'submission_file' => $filePath,
        ]);

        return redirect()->route('assignments.index')->with('success', 'Assignment submitted successfully.');
    }

    public function deleteSubmission($id)
    {
        $submission = \App\Models\Submission::findOrFail(decrypt($id));
        Storage::delete('public/' . $submission->submission_file);
        $submission->delete();

        return redirect()->route('assignments.index')->with('success', 'Submission deleted successfully.');
    }
    }

