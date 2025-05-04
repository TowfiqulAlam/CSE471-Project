@extends('layouts.layout')

@section('title', 'Skills for ' . $user->name)

@section('content')
    <div class="container mt-5">
        <h2>Skills for {{ $user->name }}</h2>
        <ul>
            @foreach($skills as $skill)
                <li>{{ $skill->name }}</li>
            @endforeach
        </ul>
    </div>
@endsection
