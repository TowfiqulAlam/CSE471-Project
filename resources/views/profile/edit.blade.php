@extends('layouts.layout')

@section('title', 'Edit Profile')

@section('content')
<div class="form-container mt-5">
    <h2 class="text-center mb-4">Edit Profile</h2>

    <form method="POST" action="{{ url('/profile') }}">
        @csrf

        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
        </div>

        <div class="mb-3">
            <label>Date of Birth</label>
            <input type="date" name="date_of_birth" class="form-control" value="{{ old('date_of_birth', $user->date_of_birth) }}" required>
        </div>

        <div class="mb-3">
            <label>Occupation</label>
            <input type="text" name="occupation" class="form-control" value="{{ old('occupation', $user->occupation) }}" required>
        </div>

        <button type="submit" class="btn btn-primary w-100">Save Changes</button>

        @if ($errors->any())
            <div class="mt-3 text-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </form>
</div>
@endsection
