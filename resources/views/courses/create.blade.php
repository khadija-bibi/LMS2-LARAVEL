@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center">
        <h2>Create Courses</h2>
        <a href="{{ route('courses.index') }}" class="btn btn-primary btn-sm">Back</a>
    </div>

    <form method="POST" action="{{ route('courses.store') }}">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label>Name</label>
            <input type="text" value="{{ old('name') }}" name="name" class="form-control">
            @error('name') <p class="text-danger">{{ $message }}</p> @enderror
        </div>
    
        <div class="mb-3">
            <label>Credit Hours</label>
            <input type="number" value="{{ old('credit_hours') }}" name="credit_hours" class="form-control">
            @error('credit_hours') <p class="text-danger">{{ $message }}</p> @enderror
        </div>
    
        <div class="mb-3">
            <label>Semester</label>
            <input type="number" value="{{ old('semester') }}" name="semester" class="form-control">
            @error('semester') <p class="text-danger">{{ $message }}</p> @enderror
        </div>
    
        <div class="mb-3">
            <label>Select Teacher</label>
            <select name="teacher_id" class="form-control">
                <option value="">-- Select Teacher --</option>
                @foreach($teachers as $teacher)
                    <option value="{{ $teacher->id }}">{{ $teacher->user->name }}</option>
                @endforeach
            </select>
            @error('teacher_id') <p class="text-danger">{{ $message }}</p> @enderror
        </div>
    
        <button type="submit" class="btn btn-primary">Add Course</button>
    </form>
    
</div>
@endsection
