@extends('layouts.app')

@section('title', 'Edit Teacher')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center">
        <h2>Edit Teacher</h2>
        <a href="{{ route('teachers.index') }}" class="btn btn-primary btn-sm">Back</a>
    </div>
    <form method="POST" action="{{ route('teachers.update', $teacher->id) }}">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" value="{{ $teacher->user->name }}">
            @error('name')
                <p class="text-danger font-medium">{{$message}}</p>  
            @enderror
        </div>
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="{{ $teacher->user->email }}">
            @error('email')
                <p class="text-danger font-medium">{{$message}}</p>  
            @enderror
        </div>
        <div class="mb-3">
            <label>Department</label>
            <select name="department" class="form-control">
                @foreach($departments as $department)
                    <option value="{{ $department->id }}" {{ $teacher->department == $department->id ? 'selected' : '' }}>
                        {{ $department->name }}
                    </option>
                @endforeach
            </select>           
            @error('department')
                <p class="text-danger font-medium">{{$message}}</p>  
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Update Teacher</button>
    </form>
</div>
@endsection
