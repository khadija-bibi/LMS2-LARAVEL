<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseContent;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    
    public function index()
    {
        $user = auth()->user();

        if ($user->hasRole('student')) {
            $student = $user->student;
            $courses = Course::where('semester', $student->semester)->get();
        } 
        else if ($user->hasRole('teacher')) {
            $teacher = $user->teacher;
            $courses = $teacher->courses; 
        } 
        else {
            $courses = Course::all();
        }

        return view('courses.index', compact('courses'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $teachers = Teacher::with('user')->get(); 
        return view('courses.create', compact('teachers'));
    }


    /**
     * Store a newly created resource in storage.
     */
   
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|min:3',
            'credit_hours' => 'required|integer|min:1|max:6',
            'semester' => 'required|integer|between:1,8',
            'teacher_id' => 'required|exists:teachers,id', 
        ]);

        if ($validator->passes()) {
            Course::create([
                'name' => $request->name,
                'credit_hours' => $request->credit_hours,
                'semester' => $request->semester,
                'teacher_id' => $request->teacher_id, 
            ]);

            return redirect()->route('courses.index')->with('success', 'Course added successfully!');
        } 
        else {
            return redirect()->route('courses.create')->withInput()->withErrors($validator);
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
    public function edit(string $id)
    {
        $course = Course::findOrFail($id);
        $teachers = Teacher::with('user')->get(); 
        return view('courses.edit', compact('course', 'teachers'));
    }

    /**
     * Update the specified resource in storage.
     */
     
    public function update(Request $request, string $id)
    {
        $course = Course::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|min:3',
            'credit_hours' => 'required|integer|min:1|max:6',
            'semester' => 'required|integer|between:1,8',
            'teacher_id' => 'required|exists:teachers,id', 
        ]);

        if ($validator->passes()) {
            $course->update([
                'name' => $request->name,
                'credit_hours' => $request->credit_hours,
                'semester' => $request->semester,
                'teacher_id' => $request->teacher_id, 
            ]);

            return redirect()->route('courses.index')->with('success', 'Course updated successfully!');
        } else {
            return redirect()->route('courses.edit', $id)->withInput()->withErrors($validator);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $course = Course::findOrFail(decrypt($id));
        $course->delete();
        return redirect()->route('courses.index')->with('success', 'Course deleted successfully!');
    }


    // Course Content controller
    public function manageContent($id) {
        $course = Course::with('contents')->findOrFail($id);
        return view('courses.manage-content', compact('course'));
    }

    public function storeContent(Request $request, $id) {
        $request->validate([
            'files.*' => 'required|mimes:pdf,doc,docx,ppt,pptx,jpg,png|max:2048'
        ]);

        foreach ($request->file('files') as $file) {
            $fileName = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('course_contents', $fileName, 'public');

            if (!$path) {
                return back()->with('error', 'File upload failed.');
            }

            CourseContent::create([
                'course_id' => $id,
                'file_name' => $file->getClientOriginalName(),
                'file_path' => 'storage/' . $path 
            ]);
        }

        return redirect()->route('courses.manage-content', $id)->with('success', 'Files uploaded successfully!');
    }
    public function deleteContent($id)
    {
        $content = CourseContent::findOrFail(decrypt($id));
        Storage::delete('public/' . $content->file_path); 
        $content->delete(); 
        
        return redirect()->back()->with('success', 'File deleted successfully!');
    }

}
