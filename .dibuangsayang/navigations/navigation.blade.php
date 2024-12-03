<nav class="text-white p-4 shadow-lg bg-blue-1">
    <div class="container mx-auto flex items-center justify-between">
        <!-- Logo Section -->
        <div class="flex items-center">
            <a href="" class="font-bold text-2xl flex items-center">
                <i class="fas fa-ticket-alt mr-3 text-white-400"></i>
                <span class="text-white hover:text-blue-300 transition">Chiketto</span>
            </a>
        </div>

        <div class="flex-grow mx-8 max-w-xl">
            <div class="relative">
                <input type="text" placeholder="Search events..."
                    class="w-full px-4 py-2 pl-10 text-gray-800 bg-white rounded-lg focus:ring-blue-2">
                <button
                    class="absolute right-0 top-0 bottom-0 bg-blue-2 text-white px-4 rounded-r-lg hover:bg-blue-3 transition">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
        

        <!-- Navigation Links and Auth Section -->
        <div class="flex items-center space-x-6">
            <!-- Event Actions -->
            <div class="flex items-center space-x-4">
                <a href="{{ route('login') }}" class="flex items-center hover:text-blue-4 transition">
                    <i class="fas fa-plus-circle mr-2"></i>
                    Create Event
                </a>
                <a href="" class="flex items-center hover:text-blue-4 transition">
                    <i class="fas fa-compass mr-2"></i>
                    Explore Events
                </a>
            </div>

            <!-- Authentication Links -->
            <div class="flex items-center space-x-4">
                @auth
                    <div class="relative group">
                        <button class="flex items-center hover:text-blue-300">
                            <img src="{{ Auth::user()->profile_picture }}" alt="Profile" class="w-8 h-8 rounded-full mr-2">
                            {{ Auth::user()->name }}
                        </button>
                        <div class="absolute hidden group-hover:block bg-white text-gray-800 rounded-lg shadow-lg right-0 mt-2 w-48 z-50">
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 hover:bg-gray-100">Profile</a>
                            <a href="{{ route('dashboard') }}" class="block px-4 py-2 hover:bg-gray-100">Dashboard</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 hover:bg-gray-100">
                                    Log Out
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                {{-- belum ada hovernya masih bingung --}}
                    <a href="{{ route('login') }}" 
                        class="px-4 py-2 border rounded-lg  transition">
                        Log In
                    </a>
                    <a href="{{ route('register') }}" 
                        class="px-4 py-2 bg-blue-2 rounded-lg transition">
                        Register
                    </a>
                @endauth
            </div>
        </div>
    </div>
</nav>