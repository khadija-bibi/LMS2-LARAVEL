@extends('layouts.app')

@section('title', 'Edit Student')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center">
        <h2>Edit Course</h2>
        <a href="{{ route('courses.index') }}" class="btn btn-primary btn-sm">Back</a>
    </div>
    <form method="POST" action="{{ route('courses.update', $course->id) }}">
        @csrf
        @method('PUT')
    
        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" value="{{ $course->name }}">
            @error('name') <p class="text-danger">{{ $message }}</p> @enderror
        </div>
    
        <div class="mb-3">
            <label>Credit Hours</label>
            <input type="number" name="credit_hours" class="form-control" value="{{ $course->credit_hours }}">
            @error('credit_hours') <p class="text-danger">{{ $message }}</p> @enderror
        </div>
    
        <div class="mb-3">
            <label>Semester</label>
            <input type="number" value="{{ $course->semester }}" name="semester" class="form-control">
            @error('semester') <p class="text-danger">{{ $message }}</p> @enderror
        </div>
    
        <div class="mb-3">
            <label>Select Teacher</label>
            <select name="teacher_id" class="form-control">
                <option value="">-- Select Teacher --</option>
                @foreach($teachers as $teacher)
                    <option value="{{ $teacher->id }}" {{ $course->teacher_id == $teacher->id ? 'selected' : '' }}>
                        {{ $teacher->user->name }}
                    </option>
                @endforeach
            </select>
            @error('teacher_id') <p class="text-danger">{{ $message }}</p> @enderror
        </div>
    
        <button type="submit" class="btn btn-primary">Update Course</button>
    </form>
    
</div>
@endsection
