@extends('layouts.app')

@section('title', 'Students')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center">
        <h2>Students List</h2>
        @can('create student')
        <a href="{{ route('students.create') }}" class="btn btn-primary btn-sm">Create</a>  
        @endcan
    </div>    
    
    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Roll No</th>
                <th>Semester</th>
                <th>Actions</th>  
            </tr>
        </thead>
        <tbody>
            @foreach($students as $key => $student)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $student->user->name }}</td>
                    <td>{{ $student->user->email }}</td>
                    <td>{{ $student->roll_no }}</td>
                    <td>{{ $student->semester }}</td>
                    <td>
                        @can('edit student')
                            <a href="{{ route('students.edit', $student->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        @endcan

                        @can('delete student')
                            <a onclick="return confirm('Are you sure?')" href="{{ route('students.destroy', encrypt($student->id)) }}" class="btn btn-danger btn-sm">Delete</a>
                        @endcan
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
