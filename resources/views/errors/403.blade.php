@extends('errors.errors_layout')

@section('title', '403 Error')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="text-center mt-4">
            <img class="img-fluid p-4" src="{{ asset('assets/img/illustrations/403-error-forbidden.svg') }}" alt="403 Forbidden" />
            <p class="lead">Oops! You don't have the right permissions to access this page. Maybe try a different door?</p>
            <a class="text-arrow-icon" href="{{ url('/') }}">
                <i class="ms-0 me-1" data-feather="arrow-left"></i>
                Return to Home
            </a>
            @auth
            <br><br>
            <a class="btn btn-primary" href="{{ url('/admin/login') }}">
                <i class="ms-0 me-1" data-feather="log-in"></i>
                Log in again
            </a>
            @endauth
        </div>
    </div>
</div>
@endsection