@extends('layouts.layout')

@section('title', $user->name . "'s Profile")

@section('content')
<div class="container mt-4">
    <h2>{{ $user->name }}'s Profile</h2>

    <hr>
    <h4>Portfolio</h4>
    @if ($portfolio)
        <p><strong>Title:</strong> {{ $portfolio->title }}</p>
        <p><strong>Description:</strong> {{ $portfolio->description }}</p>
        <p><strong>Link:</strong> <a href="{{ $portfolio->link }}" target="_blank">{{ $portfolio->link }}</a></p>
    @else
        <p>No portfolio available.</p>
    @endif

    <hr>
    <h4>Skills</h4>
    @if ($skills)
        <ul>
            @foreach ($skills as $skill)
                <li>{{ $skill->name}}</li>
            @endforeach
        </ul>
    @else
        <p>No skills listed.</p>
    @endif

    <hr>
    <h4>Availability</h4>
    @if ($availability)
        <ul>
            <li>{{ $availability->day_of_week }}: {{ $availability->start_time }} - {{ $availability->end_time }}</li>
        </ul>
    @else
        <p>No availability set.</p>
    @endif

    <hr>
    <h4>Ratings</h4>
    @if (count($ratings))
        @foreach ($ratings as $rating)
            <div class="mb-2">
                <strong>{{ $rating->rating }} Stars</strong> - {{ $rating->feedback }}
            </div>
        @endforeach
    @else
        <p>No ratings yet.</p>
    @endif
    <h3>Job Applications</h3>
            @foreach($jobApplications as $application)
                <p>
                    Status: {{ ucfirst($application->status) }}
                   
                    @if($application->status == 'applied')
                        <form action="{{ route('applications.updateStatus', $application->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" name="status" value="hired" class="btn btn-success">Hire</button>
                            <button type="submit" name="status" value="rejected" class="btn btn-danger">Reject</button>
                        </form>
                    @elseif($application->status == 'hired')
                        <form action="{{ route('applications.updateStatus', $application->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" name="status" value="completed" class="btn btn-info">Complete</button>
                            <button type="submit" name="status" value="rejected" class="btn btn-danger">Reject</button>
                            <!-- Fire Button -->
                            <button type="submit" name="status" value="rejected" class="btn btn-warning">Fire</button>
                        </form>
                    @elseif($application->status == 'rejected' || $application->status == 'completed')
                        <p>Status: {{ ucfirst($application->status) }}</p>
                    @endif
                </p>
            @endforeach

</div>
@endsection
