<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <title>Shreenath Ji Darshan</title>
        
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <meta name="description" content="Book your Shreenath Ji Darshan online. Nathdwara Darshan Booking, Shree Ji Darshan, Online Mandir Darshan with Pichwai art inspired packages.">
        <meta name="keywords" content="Shree Ji Darshan, Shreenath Ji Darshan, Nathdwara Darshan Booking, Online Mandir Darshan, Shreenath Ji Pichwai Booking">
        <link rel="icon" type="image/x-icon" href="{{ asset('images/about us by client.jpeg') }}">
        <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Noto+Serif+Devanagari:wght@400;500;600&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">


        <link rel="stylesheet" href="{{ asset('css/style.css') }}">

        @yield('css')

        {{-- theme style end  --}}


        @livewireStyles <!-- Livewire styles -->

        <!-- Meta Tags (conditionally included) -->
        @hasSection('meta-tags')
            @yield('meta-tags')
        @endif
        <style>

        </style>
        <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-8097277234924832"
            crossorigin="anonymous">
        </script>
    </head>
    <body>
        <!-- Navigation -->
        @include('layouts.nav')

        <!-- Main Content Section -->
        <main>
            @yield('content') <!-- Content will be injected here -->
        </main>

        <!-- Footer Section -->
        @include('layouts.footer')

        <!-- Scripts -->
        @livewireScripts <!-- Livewire scripts -->

        <script src="{{ asset('js/main.js') }}"></script>
        @yield('js') <!-- Additional JS scripts can be added here -->
    </body>
</html>