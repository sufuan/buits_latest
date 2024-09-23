<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard')</title>
    <!-- Link to CSS file -->
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
    <!-- Link to favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon.png') }}">
    <!-- Font Awesome -->
    <script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/js/all.min.js" crossorigin="anonymous"></script>
    <!-- Feather Icons -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.29.0/feather.min.js" crossorigin="anonymous"></script>
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" />
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <!-- sweet alert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @stack('css')
</head>

<body class="nav-fixed">
    @include('backend.layouts.partials.header')

    @include('sweetalert::alert')


    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            @include('backend.layouts.partials.sidebar')
        </div>
        <div id="layoutSidenav_content">
            @yield('admin-content')
            @include('backend.layouts.partials.footer')
        </div>
    </div>





    <!-- scripts starts -->





    <!-- sweet alert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" crossorigin="anonymous"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <!-- Local Scripts -->
    <script src="{{ asset('js/scripts.js') }}"></script>


    @stack('scripts')



    <!-- Feather Icons Initialization -->
    <script>
        feather.replace();
    </script>

    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>

    <!-- DataTables Initialization -->
    <script>
        $(document).ready(function() {
            $('#datatablesSimple').DataTable();
        });
    </script>
</body>

</html>