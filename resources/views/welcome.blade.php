@extends('layouts.landing')

@section('title', 'Welcome to BUITS')

@section('content')
    @include('partials.banner') <!-- Include your banner -->
    @include('partials.about_us') <!-- Include promotional banner -->
    @include('partials.promotional_banner') <!-- Include promotional banner -->
    @include('partials.brand_slider') <!-- Include promotional banner -->
    @include('partials.recents') 
    @include('partials.footer') <!-- Include promotional banner -->
  
@endsection
