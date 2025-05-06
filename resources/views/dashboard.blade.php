@extends('layouts.layout')

@section('title', 'Dashboard')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Welcome, {{ Auth::user()->name }}!</h2>
    @if(auth()->user()->unreadNotifications->count())
        <div class="alert alert-info">
            <h5>Your Notifications</h5>
            <ul class="mb-0">
                @foreach(auth()->user()->unreadNotifications as $notification)
                    <li>{{ $notification->data['message'] ?? 'New notification' }}</li>
                @endforeach
            </ul>
        </div>

        @php
            auth()->user()->unreadNotifications->markAsRead();
        @endphp
    @endif


    <div class="row">
        {{-- Common for all users --}}
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header bg-primary text-white">Your Profile</div>
                <div class="card-body">
                    <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
                    <p><strong>Occupation:</strong> {{ Auth::user()->occupation }}</p>
                    <p><strong>Date of Birth:</strong> {{ Auth::user()->date_of_birth }}</p>
                    <a href="{{ url('/profile') }}" class="btn btn-sm btn-outline-primary">Edit Profile</a>
                </div>
            </div>
        </div>

        @if(Auth::user()->user_type === 'job_seeker')
        {{-- Job seeker-specific cards --}}
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header bg-success text-white">Manage Skills</div>
                <div class="card-body">
                    <p>Update your skills, availability, and portfolio.</p>
                    <a href="{{ url('/skills') }}" class="btn btn-sm btn-outline-success">Go to Skills</a>
                    <a href="{{ url('/availability') }}" class="btn btn-sm btn-outline-info mt-2">Go to Availability</a>
                    <a href="{{ url('/portfolio') }}" class="btn btn-sm btn-outline-warning mt-2">Go to Portfolio</a>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header bg-secondary text-white">Your Badges</div>
                <div class="card-body">
                    <p>View endorsement tags you've earned from completed jobs.</p>
                    <a href="{{ route('endorsements.index') }}" class="btn btn-sm btn-outline-secondary">View Badges</a>
                </div>
            </div>
        </div>


        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header bg-info text-white">Job Suggestions</div>
                <div class="card-body">
                    <p>See AI-based job suggestions based on your skills.</p>
                    <a href="{{ route('job.suggestion') }}" class="btn btn-info fw-bold mt-3">Get Suggestion</a>
                    <a href="{{ route('jobs.search') }}" class="btn btn-outline-primary">Search Jobs</a>
                    <a href="{{ url('/videos') }}" class="btn btn-success">Upgrade Your Skills</a>
                    <a href="{{ url('/tasks') }}" class="btn btn-sm btn-outline-primary mt-2">Manage Tasks</a>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header bg-warning text-dark">Ratings & Feedback</div>
                <div class="card-body">
                    @php
                        $ratings = Auth::user()->receivedRatings()->orderBy('created_at', 'desc')->get();
                    @endphp

                    @if($ratings->isEmpty())
                        <p>No ratings yet.</p>
                    @else
                        <ul class="list-group">
                            @foreach($ratings as $rating)
                                <li class="list-group-item">
                                    <strong>Rating:</strong> {{ $rating->rating }}/5<br>
                                    <strong>Feedback:</strong> {{ $rating->feedback ?? 'No feedback given.' }}
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>

        @elseif(Auth::user()->user_type === 'employer')
        {{-- Employer-specific cards --}}
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header bg-success text-white">Post a Job</div>
                <div class="card-body">
                    <p>Post a new job and hire job seekers easily.</p>
                    <a href="{{ url('/jobs/create') }}" class="btn btn-sm btn-outline-success">Post Job</a>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header bg-info text-white">View Applications</div>
                <div class="card-body">
                    <p>See who applied to your jobs and hire instantly.</p>
                    
                    @if($job)
                        <a href="{{ route('jobs.applicants', ['jobId' => $job->id]) }}" class="btn btn-sm btn-outline-warning mt-2">View Applicants</a>
                    @else
                        <p>No jobs found yet.</p>
                    @endif

                    <a href="{{ route('ratings.create', ['userId' => Auth::user()->id]) }}" class="btn btn-primary">Give Rating</a>
                    <a href="{{ route('employer.payments') }}" class="btn btn-sm btn-outline-danger">Go to Payments</a>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header bg-dark text-white">Upload Learning Video</div>
                <div class="card-body">
                    <p>Share videos that help job seekers improve relevant skills.</p>
                    <a href="{{ route('videos.upload') }}" class="btn btn-sm btn-outline-dark">Upload Video</a>
                </div>
            </div>
        </div>


        @endif
    </div>
</div>
@endsection
