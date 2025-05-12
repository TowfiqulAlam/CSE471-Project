@extends('layouts.layout')

@section('title', 'Upload Video')

@section('content')
<div class="container mt-4">
    <h2>Upload a New Video</h2>
    <form action="{{ route('videos.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label>Video Title</label>
            <input type="text" name="title" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control"></textarea>
        </div>
        <div class="mb-3">
            <label>Skill Name</label>
            <input type="text" name="skill_name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Upload Video (MP4)</label>
            <input type="file" name="video_file" accept="video/mp4" class="form-control" required>
        </div>
        <button class="btn btn-primary">Upload</button>
    </form>
</div>
@endsection
