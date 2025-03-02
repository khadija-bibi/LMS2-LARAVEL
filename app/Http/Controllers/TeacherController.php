<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $teachers = Teacher::with('user')->get();
        return view('teachers.index',compact('teachers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('teachers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255|min:3',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6'
        ]);
        if ($validator->passes()) {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);
    
            $user->assignRole('teacher'); 
            
            Teacher::create([
                'user_id' => $user->id,
            ]);
    
            return redirect()->route('teachers.index')->with('success', 'Teacher added successfully!');
        }
        else{
            return redirect()->route('teachers.create')->withInput()->withErrors($validator);
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
        $teacher = Teacher::findOrFail($id);
        return view('teachers.edit', compact('teacher')); 
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $teacher = Teacher::findOrFail($id);
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:50|min:3',
            'email' => 'required|email|unique:users,email,' . $teacher->user_id,
        ]);

        if ($validator->passes()) {
            $teacher->user->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);
    
            return redirect()->route('teachers.index')->with('success', 'Teacher updated successfully!');
        }
        else{
            return redirect()->route('teachers.edit',$id)->withInput()->withErrors($validator);
        }
        
    }
   
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $teacher = Teacher::findOrFail(decrypt($id));
        $teacher->user->delete(); 
        $teacher->delete();
        return redirect()->route('teachers.index')->with('success', 'Student deleted successfully!');
    }
}
