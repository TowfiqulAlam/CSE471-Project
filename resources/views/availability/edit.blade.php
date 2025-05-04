@extends('layouts.layout')


@section('title', 'Edit Availability')


@section('content')
<div class="form-container">
    <h2 class="mb-4 text-center">Edit Your Availability</h2>


    <form method="POST" action="{{ url('/availability') }}">
        @csrf
        @method('PUT')


        <div id="availability-list">
            @foreach ($availability as $item)
            <div class="mb-3 availability-item">
                <div class="row">
                    <div class="col-md-4">
                        <select name="availability[{{ $loop->index }}][day_of_week]" class="form-control">
                            <option value="Monday" {{ $item->day_of_week == 'Monday' ? 'selected' : '' }}>Monday</option>
                            <option value="Tuesday" {{ $item->day_of_week == 'Tuesday' ? 'selected' : '' }}>Tuesday</option>
                            <option value="Wednesday" {{ $item->day_of_week == 'Wednesday' ? 'selected' : '' }}>Wednesday</option>
                            <option value="Thursday" {{ $item->day_of_week == 'Thursday' ? 'selected' : '' }}>Thursday</option>
                            <option value="Friday" {{ $item->day_of_week == 'Friday' ? 'selected' : '' }}>Friday</option>
                            <option value="Saturday" {{ $item->day_of_week == 'Saturday' ? 'selected' : '' }}>Saturday</option>
                            <option value="Sunday" {{ $item->day_of_week == 'Sunday' ? 'selected' : '' }}>Sunday</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <input type="time" name="availability[{{ $loop->index }}][start_time]" class="form-control" value="{{ $item->start_time }}">
                    </div>
                    <div class="col-md-4">
                        <input type="time" name="availability[{{ $loop->index }}][end_time]" class="form-control" value="{{ $item->end_time }}">
                    </div>
                </div>
            </div>
            @endforeach
        </div>


        <button type="button" class="btn btn-sm btn-secondary" onclick="addAvailabilityInput()">+ Add More</button>


        <button type="submit" class="btn btn-primary w-100">Save Availability</button>
    </form>
</div>


<script>
    function addAvailabilityInput() {
        const index = document.querySelectorAll('.availability-item').length;
        const availabilityItem = document.createElement('div');
        availabilityItem.classList.add('mb-3', 'availability-item');
        availabilityItem.innerHTML = `
            <div class="row">
                <div class="col-md-4">
                    <select name="availability[${index}][day_of_week]" class="form-control">
                        <option value="Monday">Monday</option>
                        <option value="Tuesday">Tuesday</option>
                        <option value="Wednesday">Wednesday</option>
                        <option value="Thursday">Thursday</option>
                        <option value="Friday">Friday</option>
                        <option value="Saturday">Saturday</option>
                        <option value="Sunday">Sunday</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <input type="time" name="availability[${index}][start_time]" class="form-control">
                </div>
                <div class="col-md-4">
                    <input type="time" name="availability[${index}][end_time]" class="form-control">
                </div>
            </div>
        `;
        document.getElementById('availability-list').appendChild(availabilityItem);
    }
</script>
@endsection
