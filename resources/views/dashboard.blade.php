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

        <!-- Check if the volunteer application is enabled -->
        @if($setting->volunteer_application_enabled)
            <!-- Show the Apply for Volunteer button -->
            <a href="{{ route('store_default_post') }}" class="btn btn-primary mb-3" onclick="event.preventDefault(); document.getElementById('store-default-post-form').submit();">
                Apply for Volunteer
            </a>

            <!-- Form to apply automatically -->
            <form id="store-default-post-form" action="{{ route('store_default_post') }}" method="POST" style="display: none;">
                @csrf
            </form>
        @else
            <!-- Show the message that applications are closed -->
            <p class="text-warning">Volunteer application is currently closed. Please wait for it to open.</p>
        @endif


        <h1>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Aliquam iure voluptate quisquam rerum, sint, commodi quibusdam omnis aut quam, possimus harum. Exercitationem at ad, voluptatibus placeat hic odio adipisci itaque.</h1><h1>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Aliquam iure voluptate quisquam rerum, sint, commodi quibusdam omnis aut quam, possimus harum. Exercitationem at ad, voluptatibus placeat hic odio adipisci itaque.</h1><br><h1>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Aliquam iure voluptate quisquam rerum, sint, commodi quibusdam omnis aut quam, possimus harum. Exercitationem at ad, voluptatibus placeat hic odio adipisci itaque.</h1><h1>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Aliquam iure voluptate quisquam rerum, sint, commodi quibusdam omnis aut quam, possimus harum. Exercitationem at ad, voluptatibus placeat hic odio adipisci itaque.</h1><h1>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Aliquam iure voluptate quisquam rerum, sint, commodi quibusdam omnis aut quam, possimus harum. Exercitationem at ad, voluptatibus placeat hic odio adipisci itaque.</h1><h1>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Aliquam iure voluptate quisquam rerum, sint, commodi quibusdam omnis aut quam, possimus harum. Exercitationem at ad, voluptatibus placeat hic odio adipisci itaque.</h1>
        <br><br><br><br><br>
        <h1>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Aliquam iure voluptate quisquam rerum, sint, commodi quibusdam omnis aut quam, possimus harum. Exercitationem at ad, voluptatibus placeat hic odio adipisci itaque.</h1><h1>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Aliquam iure voluptate quisquam rerum, sint, commodi quibusdam omnis aut quam, possimus harum. Exercitationem at ad, voluptatibus placeat hic odio adipisci itaque.</h1><h1>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Aliquam iure voluptate quisquam rerum, sint, commodi quibusdam omnis aut quam, possimus harum. Exercitationem at ad, voluptatibus placeat hic odio adipisci itaque.</h1>
        <br><br><br><br><br><br><br>
        <h1>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Aliquam iure voluptate quisquam rerum, sint, commodi quibusdam omnis aut quam, possimus harum. Exercitationem at ad, voluptatibus placeat hic odio adipisci itaque.</h1><h1>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Aliquam iure voluptate quisquam rerum, sint, commodi quibusdam omnis aut quam, possimus harum. Exercitationem at ad, voluptatibus placeat hic odio adipisci itaque.</h1>
    </div>
@endsection
