@extends('layouts.app')

@section('title', 'Teachers')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center">
        <h2>Teachers List</h2>
        @can('create teacher')
            <a href="{{ route('teachers.create') }}" class="btn btn-primary btn-sm">Create</a>
        @endcan
    </div>
    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Department</th>
                <th>Actions</th> 
            </tr>
        </thead>
        <tbody>
            @foreach($teachers as $key => $teacher)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $teacher->user->name }}</td>
                    <td>{{ $teacher->user->email }}</td>
                    <td>{{ $teacher->department }}</td>
                    <td>
                        @can('edit teacher')
                            <a href="{{ route('teachers.edit', $teacher->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        @endcan

                        @can('delete teacher')
                            <a onclick="return confirm('Are you sure?')" href="{{ route('teachers.destroy', encrypt($teacher->id)) }}" class="btn btn-danger btn-sm">Delete</a>
                        @endcan
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
