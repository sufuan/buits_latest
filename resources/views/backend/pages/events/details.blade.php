@extends('backend.layouts.master')

@section('admin-content')

@if (isset($message))
    <div class="alert alert-success">
        {{ $message }}
    </div>
@endif

@if (isset($error))
    <div class="alert alert-danger">
        {{ $error }}
    </div>
@endif
<div class="container">
    <h1>Event Details: {{ $event->title }}</h1>
    <p><strong>Start:</strong> {{ $event->start }}</p>
    <p><strong>End:</strong> {{ $event->end }}</p>
    <p><strong>Description:</strong> {{ $event->description }}</p>

    @if($event->countdown)
    <h3>Countdown Timer</h3>
    <div id="countdown"></div>
    @endif
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const countdownElement = document.getElementById('countdown');
        const eventStartDate = new Date("{{ $event->start }}").getTime();
        const eventEndDate = new Date("{{ $event->end }}").getTime();
        const now = new Date().getTime();

        function updateCountdown() {
            const distance = eventStartDate - now;

            if (distance < 0 && (now - eventEndDate) < 0) {
                countdownElement.innerHTML = "Event is ongoing!";
                return;
            } else if (distance < 0) {
                countdownElement.innerHTML = "Event has finished!";
                clearInterval(countdownInterval);
                return;
            }

            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            countdownElement.innerHTML = `${days}d ${hours}h ${minutes}m ${seconds}s `;
        }

        const countdownInterval = setInterval(updateCountdown, 1000);
        updateCountdown(); // Initial call to display immediately
    });
</script>

@endpush
@endsection