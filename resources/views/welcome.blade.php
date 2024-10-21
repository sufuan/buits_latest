<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BUITS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
        crossorigin="anonymous">

    <link rel="stylesheet" href="{{ asset('assets/landing/css/customize-animate.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/landing/css/odometer.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/landing/css/owl.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/landing/css/main.css') }}" />

    <style type="text/css">
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

        /* Add padding to the top of the body to prevent content overlap */
        body {
            padding-top: 56px;
            /* Adjust according to the height of the navbar */
        }
    </style>

</head>

<body>

    @include('header') <!-- This includes the header -->
    @include('partials.banner') <!-- This includes the banner -->

    @php
    $promotion_banners = \App\Models\AdminPromotionalBanner::where('status', 1)->get();
    @endphp

    @if ($promotion_banners && count($promotion_banners) > 0)
    <section class="main-category overflow-hidden pt-30 pb-50">
        <div class="container">
            <div class="main-category-slider wl-theme owl-carousel">
                @if (count($promotion_banners) > 0)
                <div class="category-slide-item big-slide"
                    style="background: url('{{ asset('storage/' . $promotion_banners[0]->image) }}') no-repeat center center;">
                    <div>
                        <h2 class="title">{{ $promotion_banners[0]->title ?? '' }}</h2>
                        <div class="text">{{ $promotion_banners[0]->sub_title ?? '' }}</div>
                    </div>
                </div>
                @endif

                @for ($i = 1; $i < count($promotion_banners); $i++)
                    <div class="category-slide-item small-slide"
                    style="background: url('{{ asset('storage/' . $promotion_banners[$i]->image) }}') no-repeat center center;">
                    <div>
                        <h2 class="title">{{ $promotion_banners[$i]->title ?? '' }}</h2>
                        <div class="text">{{ $promotion_banners[$i]->sub_title ?? '' }}</div>
                    </div>
            </div>
            @endfor
        </div>
        </div>
    </section>
    @endif

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

</body>

</html>
