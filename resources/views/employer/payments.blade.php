@extends('layouts.layout')

@section('title', 'Manage Payments')

@section('content')
<div class="container mt-5">
    <h2>Hired Employees - Pending Payments</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($tasks->isEmpty())
        <p>No hired employees found.</p>
    @else
        <table class="table table-bordered mt-4">
            <thead>
                <tr>
                    <th>Job Title</th>
                    <th>Employee</th>
                    <th>Payment Amount</th>
                    <th>Task Status</th>
                    <th>Payment Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tasks as $task)
                    <tr>
                        <td>{{ $task->job->title }}</td>
                        <td>{{ $task->seeker->name }}</td>
                        <td>${{ $task->payment_amount }}</td>
                        <td>{{ ucfirst($task->status) }}</td>
                        <td>{{ ucfirst($task->payment_status) }}</td>
                        <td>
                            @if ($task->status === 'completed' && $task->payment_status !== 'paid')
                                <form action="{{ route('employer.pay', $task->id) }}" method="POST">
                                    @csrf
                                    <button class="btn btn-sm btn-success">Mark as Paid</button>
                                </form>
                            @elseif ($task->payment_status === 'paid')
                                <span class="badge bg-success">Already Paid</span>
                            @else
                                <span class="badge bg-warning text-dark">Task In Progress</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
