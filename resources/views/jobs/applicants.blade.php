@extends('layouts.layout')


@section('title', 'Applicants for ' . ($selectedJob->title ?? ''))


@section('content')
<div class="container mt-5">
    <h2>Applicant List</h2>


    <!-- Job Selection Dropdown -->
    <form method="GET" action="{{ route('jobs.applicants') }}" class="mb-4">
        <div class="form-group">
            <label for="job_id">Select Job</label>
            <select name="job_id" id="job_id" class="form-control" onchange="this.form.submit()">
                @foreach($jobs as $job)
                    <option value="{{ $job->id }}" {{ ($selectedJob && $selectedJob->id == $job->id) ? 'selected' : '' }}>
                        {{ $job->title }}
                    </option>
                @endforeach
            </select>
        </div>
    </form>


    @if(!$selectedJob)
        <p>No jobs found. Please post a job first.</p>
    @elseif($applications->isEmpty())
        <p>No applicants yet for this job.</p>
    @else
        <h4>Applicants for: {{ $selectedJob->title }}</h4>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Applicant Name</th>
                    <th>Email</th>
                    <th>Application Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($applications as $application)
                    <tr>
                        <td>{{ $application->user->name ?? 'Unknown' }}</td>
                        <td>{{ $application->user->email ?? 'Unknown' }}</td>
                        <td>{{ ucfirst($application->status) }}</td>
                        <td>
                            @if($application->status == 'applied')
                                <form action="{{ route('jobs.hire', $application->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-success btn-sm">Hire</button>
                                </form>
                            @elseif($application->status == 'hired')
                                <form action="{{ route('jobs.fire', $application->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-danger btn-sm">Fire</button>
                                </form>
                            @else
                                <span class="badge badge-secondary">{{ ucfirst($application->status) }}</span>
                            @endif
                        </td>


                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
