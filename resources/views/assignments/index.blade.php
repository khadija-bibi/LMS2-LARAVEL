@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center">
    <h1>Assignments</h1>
    @can('create assignment')
        <a href="{{ route('assignments.create') }}" class="btn btn-primary btn-sm">Create</a>
    @endcan
</div>


<table class="table table-bordered mt-3">
    <thead>
        <tr>
            <th>Description</th>
            <th>Course</th>
            <th>Created By</th>
            <th>Due Date</th>
            <th>File</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($assignments as $assignment)
        <tr>
            <td>{{ $assignment->description }}</td>
            <td>{{ $assignment->course->name }}</td>
            <td>{{ $assignment->teacher->name }}</td>
            <td>{{ $assignment->due_date }}</td>
            <td><a href="{{ route('assignments.download', $assignment->id) }}" target="_blank">Download</a></td>
            <td>
                @can('view submission')
                    <a href="{{ route('assignments.submit-form', $assignment->id) }}" class="btn btn-primary btn-sm">Submission</a>
                @endcan

                @can('edit assignment')
                    <a href="{{ route('assignments.edit', $assignment->id) }}" class="btn btn-warning btn-sm">Edit</a>
                @endcan

                @can('delete assignment')
                    <a onclick="return confirm('Are you sure?')" href="{{ route('assignments.destroy', encrypt($assignment->id)) }}" class="btn btn-danger btn-sm">Delete</a>            </td>
                @endcan
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
