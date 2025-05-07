@extends('layouts.layout')

@section('title', 'Manage Tasks')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Manage Your Tasks</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row">
        @foreach($tasks as $task)
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        {{ $task->name }}
                    </div>
                    <div class="card-body">
                        <p><strong>Status:</strong> {{ ucfirst(str_replace('_', ' ', $task->status)) }}</p>
                        <p><strong>Payment Amount:</strong> ${{ number_format($task->payment_amount, 2) }}</p>
                        <p><strong>Payment Status:</strong> {{ ucfirst($task->payment_status) }}</p>

                        <form method="POST" action="{{ url('/tasks/'.$task->id.'/update-status') }}">
                            @csrf
                            <div class="form-group">
                                <select name="status" class="form-control">
                                    <option value="in_progress" {{ $task->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                    <option value="completed" {{ $task->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-success btn-sm mt-2">Update Status</button>
                        </form>

                        <!-- Check if the task has a job and if that job has an employer -->
                        @if ($task->job && $task->job->user)
                            <a href="{{ route('chat.index', ['job_id' => $task->job_id, 'user_id' => $task->job->user->id]) }}" class="btn btn-primary btn-sm mt-2">
                                Chat with Employer
                            </a>
                        @else
                            <span class="text-danger">Employer not available</span>
                            <p>Task might not be assigned properly, or the employer may have been removed.</p>

                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
