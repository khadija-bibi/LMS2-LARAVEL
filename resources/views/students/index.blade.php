@extends('layouts.app')

@section('title', 'Students')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center">
        <h2>Students List</h2>
        <a href="{{ route('students.create') }}" class="btn btn-primary btn-sm">Create</a>
    </div>    
    
    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Roll No</th>
                <th>Semester</th>
                <th>Department</th>
                <th>Actions</th>  {{-- Edit & Delete Buttons --}}
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
                    <td>{{ $student->department }}</td>
                    <td>
                        {{-- Edit Button --}}
                        <a href="{{ route('students.edit', $student->id) }}" class="btn btn-warning btn-sm">Edit</a>

                        {{-- Delete Button --}}
                        <form action="{{ route('students.destroy', $student->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
