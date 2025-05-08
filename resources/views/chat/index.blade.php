@extends('layouts.layout')

@section('title', 'Chat')

@section('content')
@php
    $currentUser = auth()->user();
    $isEmployer = $currentUser->user_type === 'employer';
    $chatWith = $isEmployer ? $receiver : $employer;
    $chatTitle = $isEmployer ? 'Chat with Employee' : 'Chat with Employer';
@endphp

<div class="container py-4">
    <div class="card shadow-sm rounded-4">
        <div class="card-header bg-primary text-white rounded-top-4">
            <h4 class="mb-0">{{ $chatTitle }}</h4>
        </div>
        <div class="card-body">
            <!-- Chat User Info -->
            <div class="mb-3">
                <p class="mb-1"><strong>Name:</strong> {{ $chatWith->name }}</p>
                <p class="mb-0"><strong>Email:</strong> {{ $chatWith->email }}</p>
            </div>

            <!-- Chat Messages Area -->
            <div class="chat-box border rounded p-3 mb-4" style="height: 300px; overflow-y: auto; background-color: #f8f9fa;">
                @forelse($messages as $message)
                    <div class="mb-3">
                        <div class="d-flex {{ $message->sender_id === $currentUser->id ? 'justify-content-end' : 'justify-content-start' }}">
                            <div class="p-2 rounded" style="max-width: 75%; background-color: {{ $message->sender_id === $currentUser->id ? '#d1e7dd' : '#e2e3e5' }};">
                                <p class="mb-1"><strong>{{ $message->sender->name }}:</strong> {{ $message->message }}</p>
                                <small class="text-muted">{{ $message->created_at->diffForHumans() }}</small>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-muted">No messages yet.</p>
                @endforelse
            </div>

            <!-- Send Message Form -->
            <form action="{{ route('chat.send') }}" method="POST">
                @csrf
                <input type="hidden" name="job_id" value="{{ $jobId }}">
                <input type="hidden" name="receiver_id" value="{{ $chatWith->id }}">
                <div class="mb-3">
                    <textarea name="message" rows="3" class="form-control" placeholder="Type your message..." required></textarea>
                </div>
                <div class="text-end">
                    <button type="submit" class="btn btn-success">Send Message</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
