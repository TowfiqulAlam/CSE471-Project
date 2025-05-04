@extends('layouts.layout')

@section('title', 'Manage Skills')

@section('content')
<div class="form-container">
    <h2 class="mb-4 text-center">Manage Your Skills</h2>

    <form method="POST" action="{{ url('/skills') }}">
        @csrf

        <div class="mb-3">
            <label>Add Skills (You can add multiple):</label>
            <div id="skill-list">
                @if (count($skills))
                    @foreach ($skills as $skill)
                        <input type="text" name="skills[]" class="form-control mb-2" value="{{ $skill }}">
                    @endforeach
                @else
                    <input type="text" name="skills[]" class="form-control mb-2">
                @endif
            </div>

            <button type="button" class="btn btn-sm btn-secondary" onclick="addSkillInput()">+ Add More</button>
        </div>

        <button type="submit" class="btn btn-primary w-100">Save Skills</button>
    </form>
</div>

<script>
    function addSkillInput() {
        const input = document.createElement("input");
        input.type = "text";
        input.name = "skills[]";
        input.className = "form-control mb-2";
        document.getElementById("skill-list").appendChild(input);
    }
</script>
@endsection
