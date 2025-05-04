
@extends('layouts.layout')

@section('title', 'Videos')


@section('content')
<div class="container">
    <h1>Recommended Videos</h1>

    @forelse ($videos as $video)
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">{{ $video->title }}</h5>
                <p class="card-text">{{ $video->description }}</p>
                <a href="{{ $video->url }}" target="_blank" class="btn btn-primary">Watch Video</a>
            </div>
        </div>
    @empty
        <p>No recommended videos found for your skills.</p>
    @endforelse
</div>
@endsection
