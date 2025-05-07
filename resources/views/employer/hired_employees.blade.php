@extends('layouts.layout')

@section('title', 'Hired Employee')

@section('content')
<div class="container">
    <h2 class="mb-4">Hired Employees</h2>

    @foreach($jobs as $job)
        <div class="card mb-4">
            <div class="card-header">
                <strong>{{ $job->title }}</strong> — {{ $job->location }}
            </div>
            <div class="card-body">
                @if($job->applications->count())
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Employee Name</th>
                                <th>Email</th>
                                <th>Chat</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($job->applications as $application)
                                <tr>
                                    <td>{{ $application->jobSeeker->name }}</td>
                                    <td>{{ $application->jobSeeker->email }}</td>
                                    <td>
                                        <a href="{{ route('chat.index', ['job_id' => $job->id, 'user_id' => $application->job_seeker_id]) }}" class="btn btn-sm btn-primary">
                                            Chat
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p>No hired employees for this job.</p>
                @endif
            </div>
        </div>
    @endforeach
</div>
@endsection
