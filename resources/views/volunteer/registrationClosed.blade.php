@extends('layouts.app') <!-- Assuming you are using layouts.app -->

@section('content')
    <div class="container text-center">
        <h1>Volunteer Application Closed</h1>
        <p>Volunteer application is currently closed. Please wait for it to open.</p>

        <!-- Button to return to the home page -->
        <a href="{{ url('/') }}" class="btn btn-primary">Return to Home</a>
    </div>
@endsection
