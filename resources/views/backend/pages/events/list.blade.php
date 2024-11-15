@extends('backend.layouts.master')

@section('admin-content')
<div class="container">
    <h1>Events List</h1>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Title</th>
                <th>Start</th>
                <th>End</th>
                <th>Details</th>
                <th>Countdown</th>
            </tr>
        </thead>
        <tbody>
            @foreach($events as $event)
            <tr>
                <td>{{ $event->title }}</td>
                <td>{{ $event->start }}</td>
                <td>{{ $event->end }}</td>
                <td>
                    <a href="{{ route('events.editDetails', $event->id) }}" class="btn btn-primary">Add Details</a>
                    <a href="{{ route('events.showDetails', $event->id) }}" class="btn btn-secondary">View Details</a>
                </td>
                <td>
                    <div class="d-flex justify-content-center">
                        <div class="form-check form-switch">
                            <input class="form-check-input countdown-switch" type="checkbox" role="switch" id="countdownSwitch{{ $event->id }}" data-event-id="{{ $event->id }}" {{ $event->countdown ? 'checked' : '' }}>
                            <label class="form-check-label" for="countdownSwitch{{ $event->id }}">Countdown</label>
                        </div>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.countdown-switch').forEach(function(switchElement) {
            switchElement.addEventListener('change', function() {
                const eventId = this.dataset.eventId;
                const countdownStatus = this.checked ? 1 : 0;

                fetch(`{{ url('/admin/events') }}/${eventId}/countdown`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            countdown: countdownStatus
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            console.log('Countdown status updated successfully');
                        } else {
                            console.error('Failed to update countdown status');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            });
        });
    });
</script>
@endpush