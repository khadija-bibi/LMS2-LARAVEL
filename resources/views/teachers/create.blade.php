@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center">
        <h2>Students List</h2>
        <a href="{{ route('teachers.index') }}" class="btn btn-primary btn-sm">Back</a>
    </div>
    <form method="POST" action="{{ route('teachers.store') }}">
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
            <label>Department</label>
            <select name="department" class="form-control" required>
                <option value="">Select Department</option>
                @foreach ($departments as $department)
                    <option value="{{ $department->id }}">{{ $department->name }}</option>
                @endforeach
            </select>            
            @error('department')
                <p class="text-danger font-medium">{{$message}}</p>  
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Add Teacher</button>
    </form>
</div>
@endsection
