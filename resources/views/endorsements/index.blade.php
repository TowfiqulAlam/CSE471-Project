@extends('layouts.layout')

@section('title', 'Your Badges')

@section('content')
<div class="container mt-5">
    <h2>Your Endorsement Badges</h2>

    @if($endorsements->isEmpty())
        <p>You have not received any badges yet.</p>
    @else
        <ul class="list-group mt-3">
            @foreach($endorsements as $endorsement)
                <li class="list-group-item">
                    <strong>Badge:</strong> {{ $endorsement->tag }}<br>
                    <strong>Job:</strong> {{ $endorsement->task->job->title ?? 'N/A' }}<br>
                    <strong>Date:</strong> {{ $endorsement->created_at->format('M d, Y') }}
                </li>
            @endforeach
        </ul>
    @endif
</div>
@endsection
