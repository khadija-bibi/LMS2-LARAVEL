<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AssignmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $assignments = Assignment::with('course','teacher')->get();
        return view('assignments.index',compact('assignments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $courses = Course::all();
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
            'teacher_id' => auth()->id(),
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
        $courses = Course::all(); // To allow course selection in edit form
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
    // Show submission form for students
    public function submitForm($id)
    {
        $assignment = Assignment::findOrFail($id);
        return view('assignments.submit', compact('assignment'));
    }

    // Store student submission
    public function submit(Request $request, $id)
    {
        $request->validate([
            'submission_file' => 'required|mimes:pdf,doc,docx|max:2048',
        ]);

        $assignment = Assignment::findOrFail($id);
        $filePath = $request->file('submission_file')->store('submissions', 'public');
        $assignment->update([
            'submission_file' => $filePath,
        ]);

        return redirect()->route('assignments.index')->with('success', 'Assignment submitted successfully.');
    }

    public function deleteSubmission($id)
{
    $assignment = Assignment::findOrFail(decrypt($id));
    if ($assignment->submission_file) {
        Storage::delete('public/' . $assignment->submission_file);
    }
    $assignment->update(['submission_file' => null]);

    return redirect()->route('assignments.index')->with('success', 'Submission deleted successfully.');
}
}

