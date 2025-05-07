@extends('layouts.layout')

@section('title', 'Chat')

@section('content')
<div class="container">
    <h2>Chat with Employer</h2>
    
    <div class="employer-info">
        <p>Employer: {{ $employer->name }}</p>
        <p>Email: {{ $employer->email }}</p>
        <!-- You can display other employer info here -->
    </div>

    <div class="messages">
        @foreach($messages as $message)
            <div class="message">
                <p><strong>{{ $message->sender->name }}:</strong> {{ $message->message }}</p>
                <small>{{ $message->created_at->diffForHumans() }}</small>
            </div>
        @endforeach
    </div>

    <form action="{{ route('chat.send') }}" method="POST">
        @csrf
        <input type="hidden" name="job_id" value="{{ $jobId }}">
        <input type="hidden" name="receiver_id" value="{{ $userId }}">
        <textarea name="message" rows="3" class="form-control" required></textarea>
        <button type="submit" class="btn btn-primary mt-2">Send Message</button>
    </form>
</div>
@endsection
