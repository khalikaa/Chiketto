<!DOCTYPE html>
<html>

<head>
    <title>Chiketto: @yield('title', 'Book Tickets or Create Events with Ease!')</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-gray-100 text-blue-1">
    <div x-data="{ isSidebarOpen: true }" class="flex">
        <!-- Sidebar -->
        <div :class="isSidebarOpen ? 'w-64' : 'w-20'"
            class="bg-blue-1 text-white h-screen sticky top-0 h-screen flex flex-col transition-all duration-500 ease-in-out">
            <div class="p-6 flex items-center justify-center bg-dark-blue">
                <a href="/" class="font-bold text-2xl flex items-center">
                    <img class="mr-2" src="{{ asset('images/chi-bw.png') }}" alt="chiketto-logo" width="35">
                    <span :class="isSidebarOpen ? 'block' : 'hidden'">Chiketto</span>
                </a>
            </div>

            <nav class="flex-1">
                <div class="mt-10">
                    <h2 :class="isSidebarOpen ? 'px-6 text-sm uppercase text-gray-400 mb-2' : 'hidden'">Dashboard</h2>
                    <!-- Dashboard -->
                    <a href="{{ route('dashboard') }}"
                        :class="isSidebarOpen ? 'flex items-center py-3 px-6' : 'flex justify-center py-4 px-6'"
                        class="flex items-center hover:bg-blue-0 {{ request()->routeIs('dashboard') ? 'bg-blue-0' : 'explore-events' }} text-white">
                        <i class="fas fa-home"></i>
                        <span :class="isSidebarOpen ? 'ml-3 block' : 'hidden'">Dashboard</span>
                    </a>

                    <!-- My Events -->
                    @if (auth()->user()->role == 'organizer')
                        <a href="{{ route('my-events') }}"
                            :class="isSidebarOpen ? 'flex items-center py-3 px-6' : 'flex justify-center py-4 px-6'"
                            class="flex items-center hover:bg-blue-0 {{ request()->routeIs('my-events') ? 'bg-blue-0' : 'explore-events' }} text-white">
                            <i class="fas fa-calendar-alt"></i>
                            <span :class="isSidebarOpen ? 'ml-3 block' : 'hidden'">My Events</span>
                        </a>

                        <!-- Manage Orders -->
                        <a href="{{ route('bookings.index') }}"
                            :class="isSidebarOpen ? 'flex items-center py-3 px-6' : 'flex justify-center py-4 px-6'"
                            class="flex items-center hover:bg-blue-0 {{ request()->routeIs('bookings.index') ? 'bg-blue-0' : 'explore-events' }} text-white">
                            <i class="fas fa-file-alt"></i>
                            <span :class="isSidebarOpen ? 'ml-3 block' : 'hidden'">Manage Orders</span>
                        </a>
                    @elseif (auth()->user()->role == 'admin')
                        <!-- Manage Events -->
                        <a href="{{ route('manage-events') }}"
                            :class="isSidebarOpen ? 'flex items-center py-3 px-6' : 'flex justify-center py-4 px-6'"
                            class="flex items-center hover:bg-blue-0 {{ request()->routeIs('manage-events') ? 'bg-blue-0' : 'explore-events' }} text-white">
                            <i class="fas fa-calendar-alt"></i>
                            <span :class="isSidebarOpen ? 'ml-3 block' : 'hidden'">Manage Events</span>
                        </a>

                        <!-- Manage Orders -->
                        <a href="{{ route('bookings.index') }}"
                            :class="isSidebarOpen ? 'flex items-center py-3 px-6' : 'flex justify-center py-4 px-6'"
                            class="flex items-center hover:bg-blue-0 {{ request()->routeIs('bookings.index') ? 'bg-blue-0' : 'explore-events' }} text-white">
                            <i class="fas fa-file-alt"></i>
                            <span :class="isSidebarOpen ? 'ml-3 block' : 'hidden'">Manage Orders</span>
                        </a>

                        <!-- Manage Users -->
                        <a href="{{ route('users.index') }}"
                            :class="isSidebarOpen ? 'flex items-center py-3 px-6' : 'flex justify-center py-4 px-6'"
                            class="flex items-center hover:bg-blue-0 {{ request()->routeIs('manage-users') ? 'bg-blue-0' : 'explore-events' }} text-white">
                            <i class="fas fa-users"></i>
                            <span :class="isSidebarOpen ? 'ml-3 block' : 'hidden'">Manage Users</span>
                        </a>
                    @else
                        <!-- Explore Events -->
                        <a href="{{ route('explore-events') }}"
                            :class="isSidebarOpen ? 'flex items-center py-3 px-6' : 'flex justify-center py-4 px-6'"
                            class="flex items-center hover:bg-blue-0 {{ request()->routeIs('explore-events') ? 'bg-blue-0' : 'explore-events' }} text-white">
                            <i class="fas fa-compass"></i>
                            <span :class="isSidebarOpen ? 'ml-3 block' : 'hidden'">Explore Events</span>
                        </a>

                        <!-- My Tickets -->
                        <a href="{{ route('bookings.index') }}"
                            :class="isSidebarOpen ? 'flex items-center py-3 px-6' : 'flex justify-center py-4 px-6'"
                            class="flex items-center hover:bg-blue-0 {{ request()->routeIs('bookings.index') ? 'bg-blue-0' : 'explore-events' }} text-white">
                            <i class="fas fa-ticket"></i>
                            <span :class="isSidebarOpen ? 'ml-3 block' : 'hidden'">My Tickets</span>
                        </a>

                        <!-- My Favorites -->
                        <a href="{{ route('my-favorites') }}"
                            :class="isSidebarOpen ? 'flex items-center py-3 px-6' : 'flex justify-center py-4 px-6'"
                            class="flex items-center hover:bg-blue-0 {{ request()->routeIs('my-favorites') ? 'bg-blue-0' : 'explore-events' }} text-white">
                            <i class="fas fa-heart"></i>
                            <span :class="isSidebarOpen ? 'ml-3 block' : 'hidden'">My Favorites</span>
                        </a>
                    @endif
                </div>
                <!-- Account Section -->
                <div class="mt-10">
                    <h2 :class="isSidebarOpen ? 'px-6 text-sm uppercase text-gray-400 mb-2' : 'hidden'">Account</h2>
                    <a href="{{ route('profile.edit') }}"
                        :class="isSidebarOpen ? 'flex items-center py-3 px-6' : 'flex justify-center py-4 px-6'"
                        class="flex items-center hover:bg-blue-0 {{ request()->routeIs('profile.edit') ? 'bg-blue-0' : 'explore-events' }} text-white">
                        <i class="fas fa-user-circle"></i>
                        <span :class="isSidebarOpen ? 'ml-3 block' : 'hidden'">My Profile</span>
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            :class="isSidebarOpen ? 'flex items-center py-3 px-6 w-full' :
                                'flex justify-center py-4 px-6 w-full'"
                            class="text-red-500 hover:bg-blue-0">
                            <i class="fas fa-sign-out"></i>
                            <span :class="isSidebarOpen ? 'ml-3 block' : 'hidden'">Log Out</span>
                        </button>
                    </form>
                </div>
                <div :class="isSidebarOpen ? 'flex items-center py-3 px-6' : 'flex justify-center py-4 px-6'"
                    class="flex items-center py-3 px-6 text-white hover:bg-blue-0 mt-10">
                    <!-- Menu Toggle Icon -->
                    <button @click="isSidebarOpen = !isSidebarOpen"
                        class="flex items-center text-white focus:outline-none">
                        <i class="fas" :class="isSidebarOpen ? 'fa-chevron-left' : 'fa-chevron-right'"></i>
                        <span :class="isSidebarOpen ? 'ml-3' : 'hidden'">Minimize Menu</span>
                    </button>
                </div>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1">
            <div class="flex py-6 px-10 justify-between items-center shadow-md sticky top-0 z-50 bg-white">
                <h1 class="text-3xl font-bold">
                    @switch(Route::currentRouteName())
                        @case('dashboard')
                            Dashboard
                        @break

                        @case('bookings.index')
                            @if (auth()->user()->role == 'customer')
                                My Tickets
                            @else
                                Manage Orders
                            @endif
                        @break

                        @case('my-favorites')
                            My Favorites
                        @break

                        @case('manage-events')
                            Manage Events
                        @break

                        @case('my-events')
                            My Events
                        @break

                        @case('profile')
                            My Profile
                        @break

                        @case('users.index')
                            Manage Users
                        @break
                        @default
                            Dashboard
                    @endswitch
                </h1>
                <div class="flex items-center space-x-4">
                    @if (auth()->user()->role != 'customer')
                        <a href="{{ route('events.create') }}"
                            class="px-4 py-2 border border-blue-1 rounded-lg hover:bg-grey-2 transition">
                            <i class="fas fa-plus-circle mr-1"></i> Create Event
                        </a>
                    @endif
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <!-- Trigger content, like a button or icon -->
                            <button
                                class="flex items-center border border-blue-1 text-center px-4 py-2 rounded-lg hover:bg-grey-2 transition">
                                <i class="fas fa-user mr-2"></i>{{ Auth::user()->name }}
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <!-- Dropdown menu content -->
                            <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-blue-1 hover:bg-gray-100">
                                <i class="fas fa-home mr-3"></i>Dashboard</a>
                            @if (auth()->user()->role == 'organizer')
                                <a href="{{ route('my-events') }}"
                                    class="block px-4 py-2 text-blue-1 hover:bg-gray-100">
                                    <i class="fas fa-calendar-alt mr-3"></i> My Events</a>
                                <a href="{{ route('bookings.index') }}"
                                    class="block px-4 py-2 text-blue-1 hover:bg-gray-100">
                                    <i class="fas fa-file-alt mr-4"></i>Manage Orders</a>
                            @elseif (auth()->user()->role == 'admin')
                                <a href="{{ route('manage-events') }}"
                                    class="block px-4 py-2 text-blue-1 hover:bg-gray-100">
                                    <i class="fas fa-calendar-alt mr-3"></i> Manage Events</a>
                                <a href="{{ route('bookings.index') }}"
                                    class="block px-4 py-2 text-blue-1 hover:bg-gray-100">
                                    <i class="fas fa-file-alt mr-4"></i>Manage Orders</a>
                                <a href="{{ route('users.index') }}"
                                    class="block px-4 py-2 text-blue-1 hover:bg-gray-100">
                                    <i class="fas fa-users mr-3"></i>Manage Users</a>
                            @else
                                <a href="{{ route('explore-events') }}"
                                    class="block px-4 py-2 text-blue-1 hover:bg-gray-100">
                                    <i class="fas fa-compass mr-3"></i>Explore Events</a>
                                <a href="{{ route('bookings.index') }}"
                                    class="block px-4 py-2 text-blue-1 hover:bg-gray-100">
                                    <i class="fas fa-ticket mr-3"></i>My Tickets</a>
                                <a href="{{ route('my-favorites') }}"
                                    class="block px-4 py-2 text-blue-1 hover:bg-gray-100">
                                    <i class="fas fa-heart mr-3"></i>My Favorites</a>
                            @endif

                            <a href="{{ route('profile.edit') }}"
                                class="block px-4 py-2 text-blue-1 hover:bg-gray-100">
                                <i class="fas fa-user-circle mr-3"></i> My Profile</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="w-full text-left px-4 py-2 text-red-600 hover:bg-gray-100">
                                    <i class="fas fa-sign-out mr-3"></i> Log Out
                                </button>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            </div>


            @yield('content')

            <footer>
                <p class="text-md text-blue-1 text-right pt-5 pb-8 px-12 ">&copy; 2024 Chiketto. All rights reserved.
                </p>
            </footer>

        </div>
    </div>
</body>

</html>
