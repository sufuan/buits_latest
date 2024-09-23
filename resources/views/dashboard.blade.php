

@extends('layouts.app')  <!-- Ensure it points to app.blade.php layout -->

@section('content')
    <!-- Add your dashboard-specific content here -->
    <div class="container">
        <h1>Dashboard</h1>

        <div class="">
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

            <a href="{{ route('store_default_post') }}" class="btn btn-primary mb-3" onclick="event.preventDefault(); document.getElementById('store-default-post-form').submit();">
                Apply for volunteer
            </a>

            <form id="store-default-post-form" action="{{ route('store_default_post') }}" method="POST" style="display: none;">
                @csrf
            </form>

    </div>
@endsection
