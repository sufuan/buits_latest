@extends('backend.layouts.master')

@section('admin-content')

<div class="container">
    <h1>Edit Event Details</h1>
    <form action="{{ route('events.update', $event->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $event->title) }}" required>
        </div>
        <div class="form-group">
            <label for="start">Start Date</label>
            <input type="text" class="form-control" id="start" name="startDate" value="{{ old('startDate', $event->start) }}" required>
        </div>
        <div class="form-group">
            <label for="end">End Date</label>
            <input type="text" class="form-control" id="end" name="endDate" value="{{ old('endDate', $event->end) }}" required>
        </div>
        <div class="form-group">
            <label for="is_all_day">All Day</label>
            <input type="hidden" name="is_all_day" value="0"> <!-- default to false -->
            <input type="checkbox" id="is_all_day" name="is_all_day" value="1" {{ old('is_all_day', $event->is_all_day) ? 'checked' : '' }}>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" id="description" name="description">{{ old('description', $event->description) }}</textarea>
        </div>
        <div class="form-group">
            <label for="countdown">Countdown</label>
            <input type="hidden" name="countdown" value="0"> <!-- default to false -->
            <input type="checkbox" id="countdown" name="countdown" value="1" {{ old('countdown', $event->countdown) ? 'checked' : '' }}>
        </div>
        <button type="submit" class="btn btn-primary">Save Changes</button>
    </form>
</div>
@endsection