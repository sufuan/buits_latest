<main>
    <div class="container mt-3">
        <h1>Previous Events</h1>
        <div class="row">
            @foreach($events as $event)
            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $event->title }}</h5>
                        <p class="card-text">{{ $event->description }}</p>
                        <p class="card-text"><strong>Start:</strong> {{ $event->start }}</p>
                        <p class="card-text"><strong>End:</strong> {{ $event->end }}</p>
                        @if($event->countdown)
                        <div id="countdown-{{ $event->id }}"></div>
                        <script>
                            const countdownElement = document.getElementById('countdown-{{ $event->id }}');
                            const eventStartDate = new Date("{{ $event->start }}").getTime();
                            // Countdown logic here...
                        </script>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</main>