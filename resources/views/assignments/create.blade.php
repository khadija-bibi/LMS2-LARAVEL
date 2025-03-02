@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center">
    <h1>Create Assignment</h1>
    <a href="{{ route('assignments.index') }}" class="btn btn-primary btn-sm">Back</a>
</div>
<form action="{{ route('assignments.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <label for="course">Course:</label>
    <select name="course_id" required class="form-control">
        <option value="" disabled selected>Select a course</option> 
        @foreach ($courses as $course)
            <option value="{{ $course->id }}" {{ old('course_id') == $course->id ? 'selected' : '' }}>
                {{ $course->name }}
            </option>
        @endforeach
    </select>
    
    @error('course_id')
        <p class="text-danger font-medium">{{ $message }}</p>  
    @enderror
    
    
    <label for="description">Description:</label>
    <textarea name="description" required class="form-control" value="{{old('description')}}"></textarea>
    @error('description')
        <p class="text-danger font-medium">{{$message}}</p>  
    @enderror

    <label for="due_date">Due Date:</label>
    <input type="datetime-local" name="due_date" required class="form-control" value="{{old('due_date')}}">
    @error('due_date')
        <p class="text-danger font-medium">{{$message}}</p>  
    @enderror

    <label for="assignment_file">Upload Assignment File:</label>
    <input type="file" name="assignment_file" required >
    @error('assignment_file')
        <p class="text-danger font-medium">{{$message}}</p>  
    @enderror

    <button type="submit" class="btn btn-primary">Create</button>
</form>
@endsection
