<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
    @if (Route::is('register'))
        Register
    @elseif (Route::is('login'))
        Login
    @else
        {{ config('app.name', 'BUITS') }}
    @endif
</title>


    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href='https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css' rel='stylesheet'>
    <link href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.css' rel='stylesheet'>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-gray-900 antialiased bg-white"> <!-- Changed to bg-white -->
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0"> <!-- Removed dark:bg-gray-900 -->
        <div>
            <a href="/">
            <img src="{{ asset('assets/img/logo.png') }}" width="150" height="150" alt="logo">


            </a>
        </div>

        <div class="w-full sm:max-w-lg mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg"> <!-- Changed max width to lg -->
            {{ $slot }}
        </div>
    </div>
</body>
</html>