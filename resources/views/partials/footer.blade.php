<div class="newsletter-section">
    <div class="container">
        <div class="">
            <div class="newsletter-content position-relative">
                <h3 class="title">Subscribe to Our Newsletter</h3> <!-- Placeholder for $fixed_newsletter_title -->
                <div class="text">
                    Stay updated with our latest news and offers. <!-- Placeholder for $fixed_newsletter_sub_title -->
                </div>
                <form method="post" action="/newsletter/subscribe"> <!-- Update action URL -->
                    <div class="input--grp">
                        <input type="email" name="email" required class="form-control" placeholder="Enter your email address">
                        <button class="search-btn" type="submit">
                            <svg width="46" height="46" viewBox="0 0 46 46" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect width="46" height="46" rx="23" fill="url(#paint0_linear_28_1864)" />
                                <path d="M25.9667 22.997L19.3001 29.2222C19.1353 29.3866 18.8556 29.6667 18.8556 29.6667C18.8556 29.6667 18.691 30.0553 18.8558 30.22L19.3803 30.7443C19.5448 30.9092 19.7648 31 19.9992 31C20.2336 31 20.4533 30.9092 20.618 30.7443L27.7448 23.6176C27.9101 23.4524 28.0006 23.2317 28 22.997C28.0006 22.7613 27.9102 22.5408 27.7448 22.3755L20.6246 15.2557C20.46 15.0908 20.2403 15 20.0057 15C19.7713 15 19.5516 15.0908 19.3868 15.2557L18.8624 15.78C18.5212 16.1212 19.0456 16.4367 19.3868 16.7778L25.9667 22.997Z" fill="white" />
                                <defs>
                                    <linearGradient id="paint0_linear_28_1864" x1="-2.04694e-07" y1="23.4694" x2="47.5207" y2="23.4694" gradientUnits="userSpaceOnUse">
                                        <stop stop-color="#34DD8E" />
                                        <stop offset="1" stop-color="#00D571" />
                                    </linearGradient>
                                </defs>
                            </svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="footer-bottom">
    <div class="container">
        <div class="footer-wrapper ps-xl-5">
            <div class="footer-widget text-white">
                <!-- Logo at the top -->
                <div class="footer-logo mb-2">
                    <a class="logo" href="#">
                        <img src="{{ asset('assets/img/logo.png') }}" alt="Company Logo">
                    </a>
                </div>

                <!-- Social Icons below the logo -->
                <ul class="social-icon d-flex list-unstyled mb-3">
                    <li class="me-2">
                        <a href="#" target="_blank" class="text-white">
                            <i class="fab fa-facebook fa-2x"></i>
                        </a>
                    </li>
                    <li class="me-2">
                        <a href="#" target="_blank" class="text-white">
                            <i class="fab fa-twitter fa-2x"></i>
                        </a>
                    </li>
                    <li class="me-2">
                        <a href="#" target="_blank" class="text-white">
                            <i class="fab fa-instagram fa-2x"></i>
                        </a>
                    </li>
                </ul>




            </div>

            <div class="footer-widget widget-links">
                
                <ul>
                    
                    <li><a href="{{ route('events.viewAll') }}">Events</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('users.search') }}">Member Id</a></li>
                    @if(isset($setting) && $setting->volunteer_application_enabled)
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('volunteer.register') }}">Apply for Volunteer </a>
                    </li>
                    @endif
                    
                    
                    <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Register</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                </ul>
            </div>
            <div class="footer-widget widget-links">
                <h5 class="subtitle mt-2 text-white">contact </h5>
                <ul>
                    <li>
                        <a>
                            <svg width="16" height="16" viewBox="0 0 12 16" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M10.2379 2.73992C9.26683 1.06417 7.54208 0.0403906 5.62411 0.00126563C5.54223 -0.000421875 5.45983 -0.000421875 5.37792 0.00126563C3.45998 0.0403906 1.73523 1.06417 0.764169 2.73992C-0.228393 4.4528 -0.25555 6.5103 0.691513 8.24376L4.65911 15.5059C4.66089 15.5091 4.66267 15.5123 4.66451 15.5155C4.83908 15.8189 5.15179 16 5.50108 16C5.85033 16 6.16304 15.8189 6.33757 15.5155C6.33942 15.5123 6.3412 15.5091 6.34298 15.5059L10.3106 8.24376C11.2576 6.5103 11.2304 4.4528 10.2379 2.73992ZM5.50101 7.25002C4.26036 7.25002 3.25101 6.24067 3.25101 5.00002C3.25101 3.75936 4.26036 2.75002 5.50101 2.75002C6.74167 2.75002 7.75101 3.75936 7.75101 5.00002C7.75101 6.24067 6.7417 7.25002 5.50101 7.25002Z"
                                    fill="white" />
                            </svg>
                            address
                        </a>
                    </li>
                    <li>
                        <a href="">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M0.333768 2.97362C2.52971 4.83334 6.38289 8.10516 7.51539 9.12531C7.66742 9.263 7.83049 9.333 7.99977 9.333C8.16871 9.333 8.33149 9.26366 8.48317 9.12663C9.61664 8.10547 13.4698 4.83334 15.6658 2.97362C15.8025 2.85806 15.8234 2.65494 15.7127 2.51366C15.4568 2.18719 15.0753 2 14.6664 2H1.33311C0.924268 2 0.542737 2.18719 0.286893 2.51369C0.176205 2.65494 0.197049 2.85806 0.333768 2.97362Z"
                                    fill="white" />
                                <path
                                    d="M15.8067 3.98127C15.6885 3.92627 15.5495 3.94546 15.4512 4.02946C13.0159 6.0939 9.90788 8.74008 8.93 9.62124C8.38116 10.1167 7.61944 10.1167 7.06931 9.62058C6.027 8.68146 2.53675 5.71433 0.548813 4.02943C0.449844 3.94543 0.310531 3.9269 0.193344 3.98124C0.0755312 4.03596 0 4.1538 0 4.28368V12.6665C0 13.4019 0.597969 13.9998 1.33334 13.9998H14.6667C15.402 13.9998 16 13.4019 16 12.6665V4.28368C16 4.1538 15.9245 4.03565 15.8067 3.98127Z"
                                    fill="white" />
                            </svg>
                            info.buits@gmail.com
                        </a>
                    </li>
                    <li>
                        <a href="">
                            <svg width="16" height="14" viewBox="0 0 14 14" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M13.6043 10.2746L11.6505 8.32085C10.9528 7.62308 9.76655 7.90222 9.48744 8.80928C9.27812 9.4373 8.58035 9.78618 7.95236 9.6466C6.55683 9.29772 4.67287 7.48353 4.32398 6.01822C4.11465 5.39021 4.53331 4.69244 5.1613 4.48314C6.0684 4.20403 6.3475 3.01783 5.64974 2.32007L3.696 0.366327C3.13778 -0.122109 2.30047 -0.122109 1.81203 0.366327L0.486277 1.69208C-0.839476 3.08761 0.62583 6.78576 3.90533 10.0653C7.18482 13.3448 10.883 14.8799 12.2785 13.4843L13.6043 12.1586C14.0927 11.6003 14.0927 10.763 13.6043 10.2746Z"
                                    fill="white" />
                            </svg>
                            +8801828-653727
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="copyright text-center mt-3">
            &copy; BUITS 2024
        </div>
    </div>
</div>