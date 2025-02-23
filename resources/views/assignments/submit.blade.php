@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Submission</h1>
        <a href="{{ route('assignments.index') }}" class="btn btn-primary btn-sm">Back</a>
    </div>
    @if ($assignment->submission_file)
        <ul>
            <li>
                <a href="{{ asset('storage/' . $assignment->submission_file) }}" target="_blank">
                    {{ basename($assignment->submission_file) }}
                </a>
                @can('delete submission')
                    <a onclick="return confirm('Are you sure?')" href="{{ route('assignments.delete-submission', encrypt($assignment->id)) }}" class="btn btn-danger btn-sm">Delete</a>           
                @endcan

            </li>
        </ul>
    @else
        <p>No submission uploaded yet.</p>
        @can('create submission')
            <h2>Upload Submission</h2>
            <form action="{{ route('assignments.submit', $assignment->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <label for="submission_file">Upload Submission:</label>
                <input type="file" name="submission_file" required>

                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        @endcan
        
    @endif
@endsection
