<main>
    <div class="container mt-3">
        <h1>Upcoming Events</h1>
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

                            function updateCountdown() {
                                const now = new Date().getTime();
                                const distance = eventStartDate - now;

                                if (distance < 0) {
                                    countdownElement.innerHTML = "Event has started!";
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
                        </script>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</main>