<nav class="bg-gray-800 text-white p-4">
    <div class="container mx-auto flex items-center justify-between">
        <!-- Logo -->
        {{-- {{ route('guest.index') }} --}}
        <a href="" class="font-bold text-xl">Chiketto</a>

        {{-- dropdown tanpa template (ilang2) --}}
        <div class="relative group">
            <button class="flex items-center border text-center px-4 py-2 rounded-lg">
                {{-- <img src="{{ Auth::user()->profile_picture }}" alt="Profile" class="w-8 h-8 rounded-full mr-2"> --}}
                <i class="fas fa-user mr-2"></i>
            {{ Auth::user()->name }}
            </button>
            <div class="absolute hidden group-hover:block bg-white text-gray-800 rounded-lg shadow-lg right-0 mt-2 w-48 z-50">
                <a href="{{ route('dashboard') }}" class="block px-4 py-2 hover:bg-gray-100">Dashboard</a>
                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 hover:bg-gray-100">Profile</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left px-4 py-2 hover:bg-gray-100">
                        Log Out
                    </button>
                </form>
            </div>
        </div>

        <!-- Search Bar -->
        <div class="flex-1 mx-8">
            <div class="relative">
                <input type="text" placeholder="Search events..." 
                    class="w-full px-4 py-2 pl-10 text-gray-800 bg-white rounded-lg focus:outline-none">
                <div class="absolute left-3 top-2.5">
                    <i class="fas fa-search text-gray-500"></i>
                </div>
            </div>
        </div>

        <!-- Navigation Links -->
        <div class="flex items-center space-x-6">
            <a href="{{ route('login') }}" class="hover:text-gray-300">
                <i class="fas fa-plus mr-1"></i> Create Event
            </a>
            {{-- {{ route('guest.index') }} --}}
            <a href="" class="hover:text-gray-300">
                <i class="fas fa-compass mr-1"></i> Explore Events
            </a>
            <div class="flex items-center space-x-4 ml-4">
                <a href="{{ route('login') }}" 
                    class="px-4 py-2 rounded-lg hover:bg-gray-700 transition">
                    Log In
                </a>
                <a href="{{ route('register') }}" 
                    class="px-4 py-2 bg-blue-600 rounded-lg hover:bg-blue-2 transition">
                    Register
                </a>
            </div>
        </div>
    </div>
</nav>