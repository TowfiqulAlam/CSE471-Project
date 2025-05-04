@extends('layouts.layout')

@section('title', 'Job Seeker Profile')

@section('content')
<div class="container mt-5">
    <h2>{{ $user->name }}'s Profile</h2>

    <hr>
    <h4>Email:</h4>
    <p>{{ $user->email }}</p>

    <h4>Skills:</h4>
    <ul>
        @forelse($user->skills as $skill)
            <li>{{ $skill->name }}</li>
        @empty
            <li>No skills added.</li>
        @endforelse
    </ul>

    <h4>Availability:</h4>
    <ul>
        @forelse($user->availability as $slot)
            <li>{{ $slot->day_of_week }}: {{ $slot->start_time }} - {{ $slot->end_time }}</li>
        @empty
            <li>No availability provided.</li>
        @endforelse
    </ul>

    <h4>Ratings:</h4>
    <ul>
        @forelse($user->ratings as $rating)
            <li>
                <strong>{{ $rating->rater->name }}:</strong>
                {{ $rating->rating }} star(s) - "{{ $rating->feedback }}"
            </li>
        @empty
            <li>No ratings yet.</li>
        @endforelse
    </ul>

    @if($user->portfolio)
        <h4>Portfolio:</h4>
        <p><strong>{{ $user->portfolio->title }}</strong></p>
        <p>{{ $user->portfolio->description }}</p>
        @if($user->portfolio->link)
            <a href="{{ $user->portfolio->link }}" target="_blank">View Portfolio</a>
        @endif
    @endif

</div>
@endsection
