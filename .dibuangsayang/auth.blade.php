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

<body class="font-sans text-gray-900 antialiased">
    <div class="min-h-screen flex flex-col items-center justify-center bg-gradient-to-br from-blue-5 to-grey-2">
        <img src="{{ asset('images/chi-logo.png') }}" alt="Chiketto Logo" class="w-32 h-auto object-contain">
    
        <div class="w-[70%] sm:max-w-md bg-white shadow-md rounded-lg p-10">
            <!-- Logo -->
            <div class="flex justify-center items-center mb-6 gap-7">
                <img src="{{ asset('images/chi-logo.png') }}" alt="Chiketto Logo" class="w-32 h-auto object-contain">
                <h1 class="text-3xl text-blue-1 font-bold">
                    @if (Route::currentRouteName() == 'login')
                    Log In to <br> Your Account
                    @else (Route::currentRouteName() == 'register')
                    Create a <br> New Account
                    @endif
            </div>

            {{ $slot }}
        </div>
    </div>
</body>

</html>
