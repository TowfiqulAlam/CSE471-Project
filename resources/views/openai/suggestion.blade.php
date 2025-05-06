@extends('layouts.layout')


@section('title', 'Quick AI')


@section('content')
<div class="container mt-4">
    <h3 class="mb-3 fw-bold">AI Job Suggestions</h3>


    <div class="card">
        <div class="card-header bg-primary text-white">
            <strong>Question</strong>
        </div>
        <div class="card-body">
            <p>{{ $question }}</p>
        </div>
        <div class="card-footer">
            <strong>Answer</strong>
            <pre class="mt-2">{{ $answer }}</pre>
        </div>
    </div>


   
</div>
@endsection
