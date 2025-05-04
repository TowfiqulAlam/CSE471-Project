@extends('layouts.layout')

@section('title', 'Register')

@section('content')
<div class="form-container">
    <h2 class="mb-4 text-center">Register</h2>
    <form method="POST" action="{{ url('/register') }}">
        @csrf

        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Confirm Password</label>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Date of Birth</label>
            <input type="date" name="date_of_birth" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Occupation</label>
            <input type="text" name="occupation" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>User Type</label>
            <select name="user_type" class="form-select" required>
                <option value="job_seeker">Job Seeker</option>
                <option value="employer">Employer</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary w-100">Register</button>
    </form>
</div>
@endsection
