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
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
