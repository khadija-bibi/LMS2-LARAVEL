@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center">
        <h2>Create Students</h2>
        <a href="{{ route('students.index') }}" class="btn btn-primary btn-sm">Back</a>
    </div>

    <form method="POST" action="{{ route('students.store') }}">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label>Name</label>
            <input type="text" value="{{old('name')}}" name="name" class="form-control">
            @error('name')
                <p class="text-danger font-medium">{{$message}}</p>  
            @enderror
        </div>
        <div class="mb-3">
            <label>Email</label>
            <input type="email" value="{{old('email')}}" name="email" class="form-control">
            @error('email')
                <p class="text-danger font-medium">{{$message}}</p>  
            @enderror
        </div>
        <div class="mb-3">
            <label>Password</label>
            <input type="password" value="{{old('password')}}" name="password" class="form-control">
            @error('password')
                <p class="text-danger font-medium">{{$message}}</p>  
            @enderror
        </div>
        <div class="mb-3">
            <label>Roll No</label>
            <input type="text" value="{{old('roll_no')}}" name="roll_no" class="form-control">
            @error('roll_no')
                <p class="text-danger font-medium">{{$message}}</p>  
            @enderror
        </div>
        <div class="mb-3">
            <label>Semester</label>
            <input type="text" value="{{old('semester')}}" name="semester" class="form-control">
            @error('semester')
                <p class="text-danger font-medium">{{$message}}</p>  
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Add Student</button>
    </form>
</div>
@endsection
