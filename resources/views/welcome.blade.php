<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">

    <link rel="stylesheet" href="css/customize-animate.css" />
    <link rel="stylesheet" href="css/odometer.css" />
    <link rel="stylesheet" href="css/owl.min.css" />
    <link rel="stylesheet" href="css/toastr.css" />
    <link rel="stylesheet" href="css/main.css" />

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

        White hamburger icon when scrolled or menu is open
        .navbar.scrolled .navbar-dark .navbar-toggler-icon,
        .navbar.show .navbar-dark .navbar-toggler-icon {
            background-color:white !important;
        }

        .navbar .megamenu {
            padding: 1rem;
        }

        /* Remove unwanted scrollbars when mobile menu is open */
        .navbar-collapse {
            overflow-y: hidden !important;
            max-height: none !important;
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
            padding-top: 56px; /* Adjust according to the height of the navbar */
        }
    </style>

</head>

<body>

<section>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Brand</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#main_nav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="main_nav">
                <ul class="navbar-nav">
                    <li class="nav-item active"><a class="nav-link" href="#">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Services</a></li>
                    <li class="nav-item dropdown has-megamenu">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Mega menu</a>
                        <div class="dropdown-menu megamenu" role="menu">
                            <div class="row g-3">
                                <div class="col-lg-3 col-6">
                                    <div class="col-megamenu">
                                        <h6 class="title">Title Menu One</h6>
                                        <ul class="list-unstyled">
                                            <li><a href="#">Custom Menu</a></li>
                                            <li><a href="#">Custom Menu</a></li>
                                            <li><a href="#">Custom Menu</a></li>
                                            <li><a href="#">Custom Menu</a></li>
                                            <li><a href="#">Custom Menu</a></li>
                                            <li><a href="#">Custom Menu</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
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


<h1>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quam, ducimus! Quisquam molestiae alias commodi. Velit tempore repellat sit maxime! Corporis fugiat perspiciatis, pariatur voluptatem earum quas ducimus nam quisquam debitis!</h1>


<br><h1>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quam, ducimus! Quisquam molestiae alias commodi. Velit tempore repellat sit maxime! Corporis fugiat perspiciatis, pariatur voluptatem earum quas ducimus nam quisquam debitis!</h1><br><br><h1>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quam, ducimus! Quisquam molestiae alias commodi. Velit tempore repellat sit maxime! Corporis fugiat perspiciatis, pariatur voluptatem earum quas ducimus nam quisquam debitis!</h1>
<br><br><br><br>
<h1>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quam, ducimus! Quisquam molestiae alias commodi. Velit tempore repellat sit maxime! Corporis fugiat perspiciatis, pariatur voluptatem earum quas ducimus nam quisquam debitis!</h1>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="js/jquery-3.6.0.min.js"></script>
<script src="js/viewport.jquery.js"></script>
<script src="js/wow.min.js"></script>
<script src="js/odometer.min.js"></script>
<script src="js/owl.min.js"></script>
<script src="js/main.js"></script>
<script src="js/toastr.js"></script>

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
        navbarCollapse.addEventListener('show.bs.collapse', function () {
            const nav = document.querySelector('.navbar');
            nav.classList.add('show'); // Add 'show' class when menu opens
        });

        navbarCollapse.addEventListener('hide.bs.collapse', function () {
            const nav = document.querySelector('.navbar');
            nav.classList.remove('show'); // Remove 'show' class when menu closes
        });
    });
</script>

</body>

</html>





