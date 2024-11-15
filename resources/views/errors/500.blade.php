@extends('errors.errors_layout')

@section('title', '500 Error')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="text-center mt-4">
            <img class="img-fluid p-4" src="{{ asset('assets/img/illustrations/500-internal-server-error.svg') }}" alt="500 Internal Server Error" />
            <p class="lead">Well, this is embarrassing. Something went wrong on our end. Our team of highly trained monkeys is working on it!</p>
            <a class="text-arrow-icon" href="{{ url('/') }}">
                <i class="ms-0 me-1" data-feather="arrow-left"></i>
                Return to Home
            </a>
        </div>
    </div>
</div>
@endsection