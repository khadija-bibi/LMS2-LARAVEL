@extends('layouts.app')

@section('title', 'Students')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center">
        <h2>Courses List</h2>
        <a href="{{ route('courses.create') }}" class="btn btn-primary btn-sm">Create</a>
    </div>    
    
    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Credit Hours</th>
                <th>Actions</th>  
            </tr>
        </thead>
        <tbody>
            @foreach($courses as $key => $course)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $course->name }}</td>
                    <td>{{ $course->credit_hours }}</td>
                    <td>
                        <a href="{{ route('courses.manage-content', $course->id) }}" class="btn btn-primary btn-sm">Manage Content</a>
                        <a href="{{ route('courses.edit', $course->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <a onclick="return confirm('Are you sure?')" href="{{ route('courses.destroy', encrypt($course->id)) }}" class="btn btn-danger btn-sm">Delete</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
