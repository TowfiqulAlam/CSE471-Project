@extends('layouts.layout')

@section('title', 'Post a Job')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Post a New Job</h2>

    <form method="POST" action="{{ route('jobs.store') }}">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Job Title</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Job Description</label>
            <textarea class="form-control" id="description" name="description" required></textarea>
        </div>

        <div class="mb-3">
            <label for="location" class="form-label">Job Location</label>
            <input type="text" class="form-control" id="location" name="location" required>
        </div>

        <div class="mb-3">
            <label for="salary" class="form-label">Salary</label>
            <input type="number" step="0.01" class="form-control" id="salary" name="salary" required>
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select class="form-select" id="status" name="status" required>
                <option value="open">Open</option>
                <option value="closed">Closed</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="starting_time" class="form-label">Starting Time</label>
            <input type="time" class="form-control" id="starting_time" name="starting_time">
        </div>

        <div class="mb-3">
            <label for="ending_time" class="form-label">Ending Time</label>
            <input type="time" class="form-control" id="ending_time" name="ending_time">
        </div>

        <button type="submit" class="btn btn-primary">Post Job</button>
        @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

    </form>
</div>
@endsection
