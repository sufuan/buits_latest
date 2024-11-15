<!-- resources/views/header.blade.php -->
<section>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
        <div class="container-fluid mx-4">

            <a class="navbar-brand" href="{{ route('home') }}">
                <img src="{{ asset('assets/img/logo.png') }}" alt="Brand Logo" style="height: 55px;">
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#main_nav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="main_nav">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Home</a></li>


                    <!-- Events Dropdown with Upcoming and Previous Events -->
                    <li class="nav-item dropdown has-megamenu">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Events</a>
                        <div class="dropdown-menu megamenu" role="menu">
                            <div class="row g-3">
                                <div class="col-lg-3 col-6">
                                    <div class="col-megamenu">
                                        <ul class="list-unstyled">
                                            <li><a href="{{ route('events.upcoming') }}">Upcoming Events</a></li>
                                            <li><a href="{{ route('events.previous') }}">Previous Events</a></li>
                                            <li><a href="{{ route('events.viewAll') }}">View All Events</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>

                    <!-- About and Services Pages -->
                    <li class="nav-item"><a class="nav-link" href="{{ route('about_us') }}">About Us</a></li>


                    <!-- User Search -->
                    <li class="nav-item"><a class="nav-link" href="{{ route('users.search') }}">Member Id</a></li>

                    @if(isset($setting) && $setting->volunteer_application_enabled)
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('volunteer.register') }}">Apply for Volunteer </a>
                    </li>
                    @endif

                </ul>

                <!-- Right-aligned Login/Register Links -->
                <ul class="navbar-nav ms-auto">
                    @if (Route::has('login'))
                    @auth
                    <li class="nav-item"><a class="nav-link" href="{{ url('/dashboard') }}">Dashboard</a></li>
                    @else
                    <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                    @if (Route::has('register'))
                    <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Register</a></li>
                    @endif
                    @endauth
                    @endif
                </ul>
            </div>
        </div>
    </nav>
</section>