<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- <title>{{ config('app.name', 'Chiketto') }}</title> --}}
    <title>Chiketto: @yield('title', 'Book Tickets or Create Events with Ease!')</title>

    <title>Chiketto: @yield('title', 'Book Tickets or Create Events with Ease!')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <div class="flex">
        <!-- Sidebar -->
        <div class="w-64 bg-blue-1 text-white h-screen">
            <div class="p-6">
                <h1 class="text-2xl font-bold">LOKÉT</h1>
            </div>
            <nav class="mt-10">
                <a href="#" class="flex items-center py-2 px-6 bg-blue-700 text-white">
                    <i class="fas fa-home mr-3"></i>
                    Dashboard
                </a>
                <a href="#" class="flex items-center py-2 px-6 text-white hover:bg-blue-700">
                    <i class="fas fa-calendar-alt mr-3"></i>
                    Event Saya
                </a>
                <div class="mt-10">
                    <h2 class="px-6 text-sm uppercase text-gray-400">Akun</h2>
                    <a href="#" class="flex items-center py-2 px-6 text-white hover:bg-blue-700">
                        <i class="fas fa-info-circle mr-3"></i>
                        Informasi Dasar
                    </a>
                    <a href="#" class="flex items-center py-2 px-6 text-white hover:bg-blue-700">
                        <i class="fas fa-cog mr-3"></i>
                        Pengaturan
                    </a>
                    <a href="#" class="flex items-center py-2 px-6 text-white hover:bg-blue-700">
                        <i class="fas fa-file-alt mr-3"></i>
                        Informasi Legal
                    </a>
                    <a href="#" class="flex items-center py-2 px-6 text-white hover:bg-blue-700">
                        <i class="fas fa-university mr-3"></i>
                        Rekening
                    </a>
                </div>
                <div class="mt-10">
                    <h2 class="px-6 text-sm uppercase text-gray-400">Mode User</h2>
                    <a href="#" class="flex items-center py-2 px-6 text-white hover:bg-blue-700">
                        <i class="fas fa-exchange-alt mr-3"></i>
                        Beralih ke Akun Pembeli
                    </a>
                </div>
                <div class="mt-10">
                    <a href="#" class="flex items-center py-2 px-6 text-white hover:bg-blue-700">
                        <i class="fas fa-bars mr-3"></i>
                        Singkat Menu
                    </a>
                </div>
            </nav>
        </div>
        <!-- Main Content -->
        <div class="flex-1 p-10">
            <div class="flex justify-between items-center">
                <h1 class="text-3xl font-bold">Home</h1>
                <div class="flex items-center space-x-4">
                    <button class="bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-md">Buat
                        Event</button>
                    <div class="flex items-center space-x-2">
                        <i class="fas fa-user-circle text-2xl text-gray-700"></i>
                        <span>khalikaaaaaa@gmail.com</span>
                    </div>
                </div>
            </div>
            <div class="mt-6 bg-blue-100 p-6 rounded-md">
                <h2 class="text-lg font-semibold">Ayo selesaikan misi! Lengkapi akun profilmu.</h2>
                <div class="flex space-x-4 mt-4">
                    <div class="bg-white p-4 rounded-md shadow-md flex-1">
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-check-circle text-green-500"></i>
                            <span>Verifikasi nomor ponselmu</span>
                        </div>
                        <button class="mt-4 bg-blue-600 text-white px-4 py-2 rounded-md">Verifikasi</button>
                    </div>
                    <div class="bg-white p-4 rounded-md shadow-md flex-1">
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-user text-blue-500"></i>
                            <span>Lengkapi detail informasi dasar</span>
                        </div>
                        <button class="mt-4 bg-blue-600 text-white px-4 py-2 rounded-md">Lengkapi</button>
                    </div>
                    <div class="bg-white p-4 rounded-md shadow-md flex-1">
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-file-alt text-blue-500"></i>
                            <span>Lengkapi detail informasi legal</span>
                        </div>
                        <button class="mt-4 bg-blue-600 text-white px-4 py-2 rounded-md">Lengkapi</button>
                    </div>
                </div>
            </div>
            <div class="mt-6 grid grid-cols-3 gap-4">
                <div class="bg-white p-6 rounded-md shadow-md">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-semibold">Event Aktif</h3>
                        <span class="text-red-500">DETAIL</span>
                    </div>
                    <p class="mt-4 text-2xl font-bold">0</p>
                    <p>Event</p>
                </div>
                <div class="bg-white p-6 rounded-md shadow-md">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-semibold">Event Draf</h3>
                        <span class="text-red-500">DETAIL</span>
                    </div>
                    <p class="mt-4 text-2xl font-bold">0</p>
                    <p>Event</p>
                </div>
                <div class="bg-white p-6 rounded-md shadow-md">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-semibold">Total Transaksi</h3>
                        <span class="text-red-500">DETAIL</span>
                    </div>
                    <p class="mt-4 text-2xl font-bold">0</p>
                </div>
                <div class="bg-white p-6 rounded-md shadow-md">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-semibold">Total Tiket Terjual</h3>
                        <span class="text-red-500">DETAIL</span>
                    </div>
                    <p class="mt-4 text-2xl font-bold">0</p>
                </div>
                <div class="bg-white p-6 rounded-md shadow-md">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-semibold">Total Penjualan</h3>
                        <span class="text-red-500">DETAIL</span>
                    </div>
                    <p class="mt-4 text-2xl font-bold">0</p>
                </div>
                <div class="bg-white p-6 rounded-md shadow-md">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-semibold">Total Pengunjung</h3>
                        <span class="text-red-500">DETAIL</span>
                    </div>
                    <p class="mt-4 text-2xl font-bold">0</p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
