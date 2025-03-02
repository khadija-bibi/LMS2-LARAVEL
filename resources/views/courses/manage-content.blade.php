@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Content for {{ $course->name }}</h1>
        <a href="{{ route('courses.index') }}" class="btn btn-primary btn-sm">Back</a>
    </div>   
    
    

    @if ($course->contents->count() > 0)
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>#</th>
                    <th>File Name</th>
                    @can('delete content')
                        <th>Actions</th>
                    @endcan
                </tr>
            </thead>
            <tbody>
                @foreach ($course->contents as $key => $content)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>
                            <a href="{{ asset($content->file_path) }}" target="_blank">
                                {{ $content->file_name }}
                            </a>
                        </td>
                        @can('delete content')
                            <td>
                                <a onclick="return confirm('Are you sure?')" href="{{ route('courses.delete-content', encrypt($content->id)) }}" class="btn btn-danger btn-sm">Delete</a>
                            </td>
                        @endcan
                        
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No content uploaded yet.</p>
    @endif
    
    @can('create content')
    <h2>Add Content</h2>
    <form action="{{ route('courses.store-content', $course->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="files[]" multiple required>
        <button type="submit" class="btn btn-primary btn-sm">Upload</button>
    </form>
    @endcan 
@endsection
