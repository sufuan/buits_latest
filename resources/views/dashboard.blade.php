@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Dashboard</h1>

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif

    <!-- @if($setting && $setting->volunteer_application_enabled) -->
    <!-- Show the Apply for Volunteer button -->
    <!-- <a href="{{ route('store_default_post') }}" class="btn btn-primary mb-3" onclick="event.preventDefault(); document.getElementById('store-default-post-form').submit();"> -->
        <!-- Apply for Volunteer -->
    <!-- </a> -->

    <!-- Form to apply automatically -->
    <form id="store-default-post-form" action="{{ route('store_default_post') }}" method="POST" style="display: none;">
        @csrf
    </form>
    @else
    <!-- Show the message that applications are closed -->
    <p class="text-warning">Volunteer application is currently closed. Please wait for it to open.</p>
    @endif




</div>
@endsection