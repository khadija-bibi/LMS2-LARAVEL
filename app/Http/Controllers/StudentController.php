<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = Student::with('user')->get();
        return view('students.index',compact('students'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $departments = Department::all();
        return view('students.create', compact('departments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255|min:3',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8',
            'roll_no' => 'required|string|unique:students',
            'semester' => 'required',
            'department' => 'required'
        ]);
       
        if ($validator->passes()) {
            $user = User::create([
                'name'=>$request->name,
                'email'=>$request->email,
                'password'=>Hash::make($request->name),
    
            ]);
    
            $user->assignRole('student');

            Student::create([
                'user_id' => $user->id,
                'roll_no'=>$request->roll_no,
                'semester'=>$request->semester,
                'department'=>$request->department,
            ]);
            return redirect()->route('students.index')->with('success', 'Student added successfully!');
        }
        else{
            return redirect()->route('students.create')->withInput()->withErrors($validator);
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
        $student = Student::findOrFail($id);
        return view('students.edit', compact('student')); 
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $student = Student::findOrFail($id);
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:50|min:3',
            'email' => 'required|email|unique:users,email,' . $student->user_id,
            'roll_no' => 'required|string|unique:students,roll_no,' . $student->id,
            'semester' => 'required',
            'department' => 'required'
        ]);

        if ($validator->passes()) {
            $student->user->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);
    
            $student->update([
                'roll_no' => $request->roll_no,
                'semester' => $request->semester,
                'department' => $request->department,
            ]);
    
            return redirect()->route('students.index')->with('success', 'Student updated successfully!');
        }
        else{
            return redirect()->route('students.edit',$id)->withInput()->withErrors($validator);
        }
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $student = Student::findOrFail(decrypt($id));
        $student->user->delete(); 
        $student->delete();
        return redirect()->route('students.index')->with('success', 'Student deleted successfully!');
    
    }
}
