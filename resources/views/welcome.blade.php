@extends('layouts.layout')

@section('title', 'Welcome to QuickHire')

@section('content')
<div class="form-container text-center">
    <h2 class="mb-4">Welcome to QuickHire</h2>
    <p class="mb-4">Find or offer part-time and short-term jobs with ease.</p>

    <div class="d-grid gap-3">
        <a href="{{ route('register') }}" class="btn btn-primary btn-lg">Register</a>
        <a href="{{ route('login') }}" class="btn btn-outline-primary btn-lg">Login</a>
    </div>
</div>
@endsection
