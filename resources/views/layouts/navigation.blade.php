<nav x-data="{ open: false, showSearch: false }" class="bg-blue-1 text-white shadow-lg sticky top-0 z-50 shadow-md">
    {{-- fixed top-0 left-0 w-full --}}
    <div class="container mx-auto px-10 py-2">
        <div class="flex justify-between items-center h-16">
            <!-- Logo -->
            <div class="flex items-center">
                <a href="/" class="font-bold text-2xl flex items-center">
                    <img class="mr-2" src="{{ asset('images/chi-bw.png') }}" alt="chiketto-logo" width="35">
                    <span>Chiketto</span>
                </a>
            </div>

            <!-- Search Bar (Always visible on large screens) -->
            <div class="hidden lg:flex flex-grow max-w-lg mx-8">
                <div class="relative w-full">
                    <form action="{{ route('events.search') }}" method="GET">
                        <input type="text" placeholder="Search Events" name="query" value="{{ request('query') }}"
                            class="w-full px-4 py-2 pl-4 text-gray-800 bg-white rounded-lg focus:ring-blue-2">
                        <button type="submit"
                            class="absolute right-0 top-0 bottom-0 bg-blue-2 text-white px-4 rounded-r-lg hover:bg-blue-grey transition">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Desktop Links -->
            <div class="hidden lg:flex space-x-6 mr-8">
                @if (auth()->guest())
                    <a href="{{ route('explore-events') }}" class="hover:text-blue-6">
                        <i class="fas fa-compass mr-1"></i> Explore Events
                    </a>
                    <a href="{{ route('register') }}" class="hover:text-blue-6">
                        <i class="fas fa-plus-circle mr-1"></i> Create Event
                    </a>
                @elseif (auth()->user()->role == 'customer')
                    <a href="{{ route('explore-events') }}" class="hover:text-blue-6">
                        <i class="fas fa-compass mr-1"></i> Explore Events
                    </a>
                    <a href="{{ route('bookings.index') }}" class="hover:text-blue-6">
                        <i class="fas fa-ticket mr-1"></i> My Tickets
                    </a>
                @else
                    <a href="{{ route('dashboard') }}" class="hover:text-blue-6">
                        <i class="fas fa-home mr-1"></i> Dashboard
                    </a>
                    <a href="{{ route('events.create') }}" class="hover:text-blue-6">
                        <i class="fas fa-plus-circle mr-1"></i> Create Event
                    </a>
                @endif
        </div>

        <!-- Auth Links -->
        <div class="hidden lg:flex space-x-3 items-center">
            @auth
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <!-- Trigger content, like a button or icon -->
                        <button class="flex items-center border text-center px-4 py-2 rounded-lg">
                            <i class="fas fa-user mr-2"></i>{{ Auth::user()->name }}
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <!-- Dropdown menu content -->
                        <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-blue-1 hover:bg-gray-100">
                            <i class="fas fa-home mr-3"></i> Dashboard</a>
                        @if (auth()->user()->role == 'organizer')
                            <a href="{{ route('my-events') }}" class="block px-4 py-2 text-blue-1 hover:bg-gray-100">
                                <i class="fas fa-calendar-alt mr-3"></i> My Events</a>
                            <a href="{{ route('bookings.index') }}"
                                class="block px-4 py-2 text-blue-1 hover:bg-gray-100">
                                <i class="fas fa-file-alt mr-4"></i>Orders</a>
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
                                <i class="fas fa-compass mr-3"></i> Explore Events
                            </a>
                            <a href="{{ route('bookings.index') }}"
                                class="block px-4 py-2 text-blue-1 hover:bg-gray-100">
                                <i class="fas fa-ticket mr-3"></i> My Tickets
                            </a>
                            <a href="{{ route('my-favorites') }}"
                                class="block px-4 py-2 text-blue-1 hover:bg-gray-100">
                                <i class="fas fa-heart mr-3"></i> My Favorites
                            </a>
                        @endif
                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-blue-1 hover:bg-gray-100">
                            <i class="fas fa-user-circle mr-3"></i> My Profile</a>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 text-red-600 hover:bg-gray-100">
                                <i class="fas fa-sign-out mr-3"></i>Log Out
                            </button>
                        </form>
                    </x-slot>
                </x-dropdown>
            @else
                <a href="{{ route('login') }}" class="px-4 py-2 border rounded-lg hover:text-blue-6 transition">Log
                    In</a>
                <a href="{{ route('register') }}"
                    class="px-4 py-2 bg-blue-2 rounded-lg hover:bg-blue-0 transition">Register</a>
            @endauth
        </div>

        <!-- Mobile Icons -->
        <div class="lg:hidden flex items-center space-x-4">
            <button @click="showSearch = !showSearch" class="text-white hover:text-blue-6 transition">
                <i class="fas fa-search"></i>
            </button>
            <button @click="open = !open" class="text-white hover:text-blue-6 transition">
                <i class="fas fa-bars"></i>
            </button>
        </div>
    </div>

    <!-- Search Bar (Mobile Only, Toggled) -->
    <div x-show="showSearch" class="mb-3 lg:hidden">
        <div class="relative w-full">
            <form action="{{ route('events.search') }}" method="GET">
                <input type="text" placeholder="Search Events" name="query" value="{{ request('query') }}"
                    class="w-full px-4 py-2 pl-4 text-gray-800 bg-white rounded-lg focus:ring-blue-2">
                <button type="submit"
                    class="absolute right-0 top-0 bottom-0 bg-blue-2 text-white px-4 rounded-r-lg hover:bg-blue-grey transition">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>
    </div>
</div>
<!-- Mobile Menu -->
<div x-show="open" class="lg:hidden space-y-1">
    @auth
        <a href="{{ route('dashboard') }}" class="block hover:bg-blue-0 transition ease-in-out px-4 py-2">
            <i class="fas fa-home mr-1"></i>
            Dashboard</a>
    @endauth
    <a href="{{ route('events.index') }}" class="block hover:bg-blue-0 transition ease-in-out px-4 py-2">
        <i class="fas fa-compass mr-1"></i> Explore Events</a>
    <a href="{{ route('login') }}" class="block hover:bg-blue-0 transition ease-in-out px-4 py-2">
        <i class="fas fa-plus-circle mr-1"></i> Create Event</a>
    @auth
        <a href="{{ route('bookings.index') }}" class="block hover:bg-blue-0 transition ease-in-out px-4 py-2">
            <i class="fas fa-ticket-alt mr-1"></i> My Tickets</a>
        <a href="{{ route('profile.edit') }}" class="block hover:bg-blue-0 transition ease-in-out px-4 py-2">
            <i class="fas fa-user mr-1"></i>
            My Profile</a>
        <form method="POST" action="{{ route('logout') }}"
            class="block hover:bg-blue-0 transition ease-in-out px-4 py-2">
            @csrf
            <button type="submit" class="w-full text-left hover:text-blue-6">
                <i class="fas fa-sign-out-alt mr-1"></i> Log Out</button>
        </form>
    @else
        <a href="{{ route('login') }}" class="block hover:bg-blue-0 transition ease-in-out px-4 py-2">
            <i class="fas fa-sign-in-alt mr-1"></i>Log In</a>
        <a href="{{ route('register') }}" class="block hover:bg-blue-0 transition ease-in-out px-4 py-2">
            <i class="fas fa-user-plus mr-1"></i> Register</a>
    @endauth
</div>

</nav>
