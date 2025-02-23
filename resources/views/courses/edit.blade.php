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
            @error('name')
                <p class="text-danger font-medium">{{$message}}</p>  
            @enderror
        </div>
        <div class="mb-3">
            <label>Credit Hours</label>
            <input type="number" name="credit_hours" class="form-control" value="{{ $course->credit_hours }}">
            @error('credit_hours')
                <p class="text-danger font-medium">{{$message}}</p>  
            @enderror
        </div>
        
        <button type="submit" class="btn btn-primary">Update Course</button>
    </form>
</div>
@endsection
