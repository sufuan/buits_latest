@extends('errors.errors_layout')

@section('title', '404 Error')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="text-center mt-4">
            <img class="img-fluid p-4" src="{{ asset('assets/img/illustrations/404-error.svg') }}" alt="404 Error" />
            <p class="lead">The requested URL was not found on this server.</p>
            <a class="text-arrow-icon" href="{{ url('/') }}">
                <i class="ms-0 me-1" data-feather="arrow-left"></i>
                Return to Home
            </a>
        </div>
    </div>
</div>
@endsection