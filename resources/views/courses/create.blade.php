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
            <input type="text" value="{{old('name')}}" name="name" class="form-control">
            @error('name')
                <p class="text-danger font-medium">{{$message}}</p>  
            @enderror
        </div>
        <div class="mb-3">
            <label>Credit Hour</label>
            <input type="number" value="{{old('credit_hours')}}" name="credit_hours" class="form-control">
            @error('credit_hours')
                <p class="text-danger font-medium">{{$message}}</p>  
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Add Student</button>
    </form>
</div>
@endsection
