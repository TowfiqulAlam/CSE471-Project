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
                        <form action="{{ route('employer.stripe.pay', $task->id) }}" method="POST">
                                @csrf
                                <div class="mb-2">
                                    <select name="endorsement_tag" class="form-select form-select-sm" required>
                                        <option value="" disabled selected>Select Endorsement</option>
                                        <option value="Fast Worker">Fast Worker</option>
                                        <option value="Reliable">Reliable</option>
                                        <option value="Great Communicator">Great Communicator</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-sm btn-primary">Pay with Card</button>
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
