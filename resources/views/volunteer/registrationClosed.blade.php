@extends('layouts.landing') <!-- Assuming you are using layouts.app -->

@section('content')
   <main >
   <div class="container text-center mt-5">
        <h1>Volunteer Application Closed</h1> <br>
        <p>Volunteer application is currently closed. Please wait for it to open.</p>

        <!-- Button to return to the home page -->
        <a href="{{ url('/') }}" class="btn btn-primary">Return to Home</a>
    </div>
   </main>
@endsection
