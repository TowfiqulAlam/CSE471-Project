@extends('layouts.layout')

@section('title', 'Videos')

@section('content')
<div class="container mt-4">
    <h2>Recommended Videos</h2>

    @forelse ($videos as $video)
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">{{ $video->title }}</h5>
                <p class="card-text">{{ $video->description }}</p>

                <video width="40%" height="auto" controls>
                    <source src="{{ asset($video->url) }}" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>
        </div>
    @empty
        <p>No recommended videos found for your skills.</p>
    @endforelse
</div>
@endsection
