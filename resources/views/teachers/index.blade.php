@extends('layouts.app')

@section('title', 'Teachers')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center">
        <h2>Teachers List</h2>
        <a href="{{ route('teachers.create') }}" class="btn btn-primary btn-sm">Create</a>
    </div>
    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Department</th>
                <th>Actions</th> {{-- Edit & Delete Buttons --}}
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
                        {{-- Edit Button --}}
                        <a href="{{ route('teachers.edit', $teacher->id) }}" class="btn btn-warning btn-sm">Edit</a>

                        {{-- Delete Button --}}
                        <form action="{{ route('teachers.destroy', $teacher->id) }}" method="POST" style="display:inline;">
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
