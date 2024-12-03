<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Chiketto: @yield('title')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-blue-1 antialiased">
    <div class="min-h-screen flex flex-col items-center justify-center bg-gradient-to-br from-blue-5 to-grey-2">
        <div class="flex flex-col lg:flex-row items-center w-full max-w-4xl p-4 sm:px-4 bg-white rounded-lg shadow-lg">
            
            <!-- Logo Section -->
            {{-- @if (Route::currentRouteName() == 'login' || Route::currentRouteName() == 'register') --}}
            <div class="w-full lg:w-1/2 flex flex-col justify-center items-center mb-6 sm:mb-0">
                <a href="{{ route('home') }}">
                    <img src="{{ asset('images/chi-logo.png') }}" alt="Chiketto Logo" class="w-64 h-auto object-contain">
                    </a>
                @if (Route::currentRouteName() == 'login' || Route::currentRouteName() == 'register')
            
                <p class="text-center font-bold text-2xl text-blue-1 mt-4">Never Miss Your Favorite Events</p>
                <p class="text-center text-md text-blue-1 mt-2">Join now and effortlessly manage and purchase <br> event tickets with <strong>Chiketto!</strong></p>
                @endif
            </div>
            {{-- @endif --}}

            <!-- Divider (Optional) -->
            {{-- <div class="border-l-2 border-gray-300 h-full sm:block hidden mx-6"></div> --}}

            <!-- Form Section -->
            <div class="w-full lg:w-1/2 p-7">
                {{ $slot }}
            </div>
        </div>
    </div>
</body>

</html>
