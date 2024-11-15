<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BUITS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
        crossorigin="anonymous">
    <script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/js/all.min.js" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="{{ asset('assets/landing/css/customize-animate.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/landing/css/odometer.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/landing/css/owl.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/landing/css/main.css') }}" />

    <style type="text/css">
        /* Apply styling specifically to h2.text */
        h2.text {
            font-family: monospace;
            font-size: 3em;
            /* Increase font size */
            display: inline-block;
            white-space: nowrap;
            overflow: hidden;
            border-right: 4px solid black;
            /* Cursor effect */
            animation: blink-caret 0.7s step-end infinite;
            /* Blinking cursor */
        }

        /* Blink animation for the caret */
        @keyframes blink-caret {
            50% {
                border-color: transparent;
            }
        }

        /* Initial state: transparent background and black text */
        .navbar {
            background-color: transparent !important;
            color: black;
            transition: background-color 0.5s ease, color 0.5s ease;
        }

        /* Ensure the navbar brand and hamburger icon are black */
        .navbar-brand,
        .navbar .navbar-toggler-icon {
            color: black !important;
        }

        /* Custom style for the hamburger icon */
        .navbar-dark .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='black' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e") !important;
        }

        /* Ensure the links are black initially */
        .navbar .nav-link {
            color: black !important;
            transition: color 0.5s ease;
        }

        /* When scrolled or when the menu is open, change the background to black and text to white */
        .navbar.scrolled,
        .navbar.show {
            background-color: black !important;
            color: white;
        }

        .navbar.scrolled .nav-link,
        .navbar.show .nav-link {
            color: white !important;
        }

        .navbar.scrolled .navbar-brand,
        .navbar.scrolled .navbar-toggler-icon,
        .navbar.show .navbar-brand,
        .navbar.show .navbar-toggler-icon {
            color: white !important;
        }

        /* White hamburger icon when scrolled or menu is open */
        .navbar.scrolled .navbar-dark .navbar-toggler-icon,
        .navbar.show .navbar-dark .navbar-toggler-icon {
            background-color: white !important;
        }

        .navbar .megamenu {
            padding: 1rem;
        }

        /* Remove unwanted scrollbars when mobile menu is open */
        .navbar-collapse {
            overflow-y: hidden !important;
            max-height: none !important;
        }

        .category-slide-item {
            display: flex;
            justify-content: left;
            align-items: center;
            color: white;
            transition: transform 0.5s ease;
            /* Smooth transition */
            padding-left: 50px;
            /* Adjust this to move the text further left or right */
            text-align: left;
            /* Ensure the text is aligned to the left */
        }

        .big-slide {
            transform: scale(1.1);
            /* Make active slide bigger */
            z-index: 1;
            /* Ensure it appears above other slides */
        }

        .small-slide {
            transform: scale(0.9);
            /* Make other slides smaller */
            opacity: 0.7;
            /* Slightly faded effect for smaller slides */
        }

        .big-slide,
        .small-slide {
            width: 100%;
            /* Ensure all slides have the same width */
            height: 300px;
            /* Set the height for big slides */
        }

        .small-slide {
            height: 150px;
            /* Set the height for small slides */
        }

        .category-slide-item .title {
            font-size: 2rem;
            margin-bottom: 10px;
        }

        .category-slide-item .text {
            font-size: 1.2rem;
        }

        /* CSS for consistent spacing and alignment */
        .brand-carousel .owl-item {
            margin: 16px 0;
            /* Adds 6px padding around each item */
        }

        .brand-carousel .single-logo {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 150px;
            /* Consistent width for images */
            max-height: 80px;
        }

        .brand-carousel .single-logo img {
            width: 100%;
            /* Allows image to take full width of its container */
            height: auto;
            object-fit: contain;
        }



        @media all and (min-width: 992px) {
            .navbar .has-megamenu {
                position: static !important;
            }

            .navbar .megamenu {
                left: 0;
                right: 0;
                width: 100%;
                margin-top: 0;
            }
        }

        @media (max-width: 991px) {

            .navbar.fixed-top .navbar-collapse,
            .navbar.sticky-top .navbar-collapse {
                overflow-y: hidden !important;
                max-height: none !important;
                margin-top: 10px;
            }
        }




        .single-logo {
            margin: 0;
            padding: 0;
        }

        .section-padding {
            padding: 2rem 0;
        }

        .gap {
            margin-top: 2rem;
        }

        .brand-carousel {
            margin-top: 1rem;
            /* Adjust to decrease vertical gap */
            margin-bottom: 1rem;
            /* Adjust to decrease vertical gap */
        }

        .py-3 {
            padding-top: 0.5rem;
            /* Optional: adjust padding for spacing */
            padding-bottom: 0.5rem;
        }






        /* Add padding to the top of the body to prevent content overlap */
        body {
            padding-top: 56px;
            /* Adjust according to the height of the navbar */
        }


        /* recent events page css */


        

    </style>



</head>

<body>


    @include('partials.header') <!-

        @yield('content')







        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
        <script src="{{ asset('assets/landing/js/jquery-3.6.0.min.js') }}"></script>
        <script src="{{ asset('assets/landing/js/viewport.jquery.js') }}"></script>
        <script src="{{ asset('assets/landing/js/wow.min.js') }}"></script>
        <script src="{{ asset('assets/landing/js/odometer.min.js') }}"></script>
        <script src="{{ asset('assets/landing/js/owl.min.js') }}"></script>
        <script src="{{ asset('assets/landing/js/main.js') }}"></script>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                window.addEventListener('scroll', function() {
                    const nav = document.querySelector('.navbar');
                    if (window.scrollY > 30) {
                        nav.classList.add('scrolled');
                    } else {
                        nav.classList.remove('scrolled');
                    }
                });

                // Listen for the Bootstrap collapse event
                const navbarCollapse = document.querySelector('#main_nav');
                navbarCollapse.addEventListener('show.bs.collapse', function() {
                    const nav = document.querySelector('.navbar');
                    nav.classList.add('show'); // Add 'show' class when menu opens
                });

                navbarCollapse.addEventListener('hide.bs.collapse', function() {
                    const nav = document.querySelector('.navbar');
                    nav.classList.remove('show'); // Remove 'show' class when menu closes
                });
            });

            $(document).ready(function() {
                const $slider = $('.main-category-slider');

                $slider.owlCarousel({
                    loop: true,
                    margin: 12,
                    nav: false,
                    autoplay: true,
                    autoplayTimeout: 4000,
                    autoplayHoverPause: true,
                    responsive: {
                        0: {
                            items: 1
                        },
                        600: {
                            items: 2
                        },
                        1000: {
                            items: 1
                        }
                    }
                });

                // Adjust slide sizes when the carousel changes
                $slider.on('translated.owl.carousel', function(event) {
                    // Remove 'big-slide' class from all slides
                    $('.category-slide-item').removeClass('big-slide').addClass('small-slide');

                    // Get the index of the current active item
                    const currentIndex = event.item.index;

                    // Add 'big-slide' class to the current active item
                    $slider.find('.owl-item').eq(currentIndex).find('.category-slide-item').removeClass('small-slide').addClass('big-slide');
                });

                // Initial adjustment when the page loads
                const initialIndex = 0; // Assuming first slide starts at 0
                $slider.find('.owl-item').eq(initialIndex).find('.category-slide-item').removeClass('small-slide').addClass('big-slide');
            });
        </script>

        <script>
            $('.brand-carousel').owlCarousel({
                loop: true,
                margin: -5, // Decrease margin further between items
                stagePadding: 0,
                autoplay: true,
                responsive: {
                    0: {
                        items: 1
                    },
                    600: {
                        items: 3
                    },
                    1000: {
                        items: 5
                    }
                }
            });
        </script>

        @stack('scripts')

</body>

</html>