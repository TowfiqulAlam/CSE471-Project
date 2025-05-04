@extends('layouts.layout')

@section('title', 'Ratings for ' . $user->name)

@section('content')
    <div class="container mt-5">
        <h2>Ratings for {{ $user->name }}</h2>
        <ul>
            @foreach($ratings as $rating)
                <li>{{ $rating->review }} - Rating: {{ $rating->score }}</li>
            @endforeach
        </ul>
    </div>
@endsection
