@extends('layouts.layout')

@section('title', 'Search Jobs')

@section('content')
<div class="container mt-5">
    <h2>Find Your Job</h2>

    {{-- Search Form --}}
    <form method="GET" action="{{ route('jobs.search') }}" class="mb-4">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Search by job title..." value="{{ request('search') }}">
            <button class="btn btn-primary">Search</button>
        </div>
    </form>

    {{-- Job List --}}
    @forelse($jobs as $job)
        <div class="card mb-3">
            <div class="card-header">
                <h5>{{ $job->title }}</h5>
            </div>
            <div class="card-body">
                <p><strong>Location:</strong> {{ $job->location }}</p>
                <p><strong>Salary:</strong> ৳{{ $job->salary }}</p>
                <p><strong>Description:</strong> {{ $job->description }}</p>
                @if($job->starting_time && $job->ending_time)
                    <p><strong>Time:</strong> {{ $job->starting_time }} to {{ $job->ending_time }}</p>
                @endif

                {{-- Apply Button --}}
                <form method="POST" action="{{ route('jobs.apply', $job->id) }}">
                    @csrf
                    <button type="submit" class="btn btn-success btn-sm">Apply Now</button>
                </form>
            </div>
        </div>
    @empty
        <p>No jobs found.</p>
    @endforelse
</div>
@endsection
