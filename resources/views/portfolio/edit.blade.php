@extends('layouts.layout')

@section('title', 'Edit Portfolio')

@section('content')
<div class="form-container">
    <h2 class="mb-4 text-center">Edit Your Portfolio</h2>

    <form method="POST" action="{{ url('/portfolio') }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="title">Portfolio Title:</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ $portfolio->title ?? '' }}">
        </div>

        <div class="mb-3">
            <label for="description">Description:</label>
            <textarea name="description" id="description" class="form-control">{{ $portfolio->description ?? '' }}</textarea>
        </div>

        <div class="mb-3">
            <label for="link">Portfolio Link (URL):</label>
            <input type="url" name="link" id="link" class="form-control" value="{{ $portfolio->link ?? '' }}">
        </div>

        <button type="submit" class="btn btn-primary w-100">Save Portfolio</button>
    </form>
</div>
@endsection
