@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Edit Assignment</h1>
        <a href="{{ route('assignments.index') }}" class="btn btn-primary btn-sm">Back</a>
    </div>
    
    <form action="{{ route('assignments.update', $assignment->id) }}" method="POST">
        @csrf
        @method('PUT')

        <label for="course_id">Course:</label>
        <select name="course_id" required class="form-control">
            @foreach ($courses as $course)
                <option value="{{ $course->id }}" {{ $assignment->course_id == $course->id ? 'selected' : '' }}>
                    {{ $course->name }}
                </option>
            @endforeach
        </select>
        @error('course_id')
            <p class="text-danger font-medium">{{$message}}</p>  
        @enderror
        
        <label for="description">Description:</label>
        <textarea name="description" value="{{ $assignment->descryption }}" required class="form-control">{{ $assignment->description }}</textarea>
        @error('description')
            <p class="text-danger font-medium">{{$message}}</p>  
        @enderror
        
        <label for="due_date">Due Date:</label>
        <input type="date" name="due_date" value="{{ $assignment->due_date }}" required class="form-control">
        @error('due_date')
            <p class="text-danger font-medium">{{$message}}</p>  
        @enderror
        
        <label for="assignment_file">Replace File (Optional):</label>
        <input type="file" name="assignment_file" class="form-control">
        @error('assignment_file')
            <p class="text-danger font-medium">{{$message}}</p>  
        @enderror
        
        <button type="submit">Update Assignment</button>
    </form>
@endsection
