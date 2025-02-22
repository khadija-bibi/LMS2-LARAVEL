@extends('layouts.app')

@section('title', 'Edit Student')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center">
        <h2>Edit Student</h2>
        <a href="{{ route('students.index') }}" class="btn btn-primary btn-sm">Back</a>
    </div>
    <form method="POST" action="{{ route('students.update', $student->id) }}">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" value="{{ $student->user->name }}">
            @error('name')
                <p class="text-danger font-medium">{{$message}}</p>  
            @enderror
        </div>
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="{{ $student->user->email }}">
            @error('email')
                <p class="text-danger font-medium">{{$message}}</p>  
            @enderror
        </div>
        <div class="mb-3">
            <label>Roll No</label>
            <input type="text" name="roll_no" class="form-control" value="{{ $student->roll_no }}">
            @error('roll_no')
                <p class="text-danger font-medium">{{$message}}</p>  
            @enderror
        </div>
        <div class="mb-3">
            <label>Semester</label>
            <input type="text" name="semester" class="form-control" value="{{ $student->semester }}">
            @error('semester')
                <p class="text-danger font-medium">{{$message}}</p>  
            @enderror
        </div>
        <div class="mb-3">
            <label>Department</label>
            <select name="department" class="form-control">
                @foreach($departments as $department)
                    <option value="{{ $department->id }}" {{ $student->department == $department->id ? 'selected' : '' }}>
                        {{ $department->name }}
                    </option>
                @endforeach
            </select>            
            @error('department')
                <p class="text-danger font-medium">{{$message}}</p>  
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Update Student</button>
    </form>
</div>
@endsection
