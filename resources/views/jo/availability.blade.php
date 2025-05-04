@extends('layouts.layout')

@section('title', 'Availability for ' . $user->name)

@section('content')
    <div class="container mt-5">
        <h2>Availability for {{ $user->name }}</h2>
        <ul>
            @foreach($availability as $slot)
                <li>{{ $slot->day }}: {{ $slot->start_time }} - {{ $slot->end_time }}</li>
            @endforeach
        </ul>
    </div>
@endsection
