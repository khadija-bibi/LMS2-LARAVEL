@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Assignment Submissions</h1>
        <a href="{{ route('assignments.index') }}" class="btn btn-primary btn-sm">Back</a>
    </div>

    @if(auth()->user()->hasRole('teacher'))
        <h2>All Submissions</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Student Name</th>
                    <th>Roll No</th>
                    <th>Submission File</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($submission as $s)
                    <tr>
                        <td>{{ $s->student->user->name }}</td>
                        <td>{{ $s->student->roll_no }}</td>
                        <td>
                            <a href="{{ asset('storage/' . $s->submission_file) }}" target="_blank">Download</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <h2>Your Submission</h2>
        @if ($submission)
            <ul>
                <li>
                    <a href="{{ asset('storage/' . $submission->submission_file) }}" target="_blank">
                        {{ basename($submission->submission_file) }}
                    </a>
                    <a onclick="return confirm('Are you sure?')" href="{{ route('assignments.delete-submission', encrypt($submission->id)) }}" class="btn btn-danger btn-sm">Delete</a>
                </li>
            </ul>
        @else
            <p>No submission uploaded yet.</p>
            <h2>Upload Submission</h2>
            <form action="{{ route('assignments.submit', $assignment->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <label for="submission_file">Upload Submission:</label>
                <input type="file" name="submission_file" required>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        @endif
    @endif
@endsection
