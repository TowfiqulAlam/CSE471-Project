@extends('layouts.layout')

@section('title', 'Give Rating')

@section('content')
<div class="container mt-5">
    <h2>Give Rating to {{ $user->name }}</h2>

    <form action="{{ route('ratings.store') }}" method="POST">
        @csrf
        <input type="hidden" name="user_id" value="{{ $user->id }}">

        <!-- Job ID (optional) -->
        <div class="form-group">
            <label for="job_id">Job</label>
            <select name="job_id" class="form-control" id="job_id">
                <option value="">Select a Job (optional)</option>
                @foreach($user->jobs as $job)
                    <option value="{{ $job->id }}">{{ $job->title }}</option>
                @endforeach
            </select>
        </div>

        <!-- Rating -->
        <div class="form-group mt-3">
            <label for="rating">Rating</label>
            <select name="rating" id="rating" class="form-control" required>
                <option value="">Choose Rating</option>
                <option value="1">1 Star</option>
                <option value="2">2 Stars</option>
                <option value="3">3 Stars</option>
                <option value="4">4 Stars</option>
                <option value="5">5 Stars</option>
            </select>
        </div>

        <!-- Feedback -->
        <div class="form-group mt-3">
            <label for="feedback">Feedback</label>
            <textarea name="feedback" id="feedback" class="form-control" rows="4" placeholder="Leave feedback (optional)"></textarea>
        </div>

        <button type="submit" class="btn btn-primary mt-4">Submit Rating</button>
    </form>
</div>
@endsection
