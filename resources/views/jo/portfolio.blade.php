@extends('layouts.layout')

@section('title', 'Portfolio for ' . $user->name)

@section('content')
    <div class="container mt-5">
        <h2>Portfolio for {{ $user->name }}</h2>
        <ul>
            @foreach($portfolio as $item)
                <li>{{ $item->title }} - <a href="{{ $item->link }}" target="_blank">View Portfolio</a></li>
            @endforeach
        </ul>
    </div>
@endsection
