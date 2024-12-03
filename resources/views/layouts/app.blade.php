<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Chiketto: @yield('title', 'Book Tickets or Create Events with Ease!')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    {{-- Flatpickr untuk date n time --}}
    <link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet">
    {{-- Link bootstrap --}}
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> --}}
    <!-- Link untuk Font Awesome versi gratis -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <!-- Scripts -->
    {{-- <link rel="stylesheet" href="style.css"> --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="{{ asset('scripts/favorites.js') }}"></script>

    <link rel="stylesheet" href="{{ asset('styles/style.css') }}">
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen">
        {{-- Semua User Ada Navbarnya --}}
        @include('layouts.navigation')

        {{-- Image For Homepage --}}
        @if (Route::currentRouteName() === 'home')
            <img src="/chi-header.png" alt="">
        @endif

        <main>
            @yield('content')
        </main>

        @include('layouts.footer')
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
{{-- smpe saat ini sy blm pke bootstrap --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</html>
