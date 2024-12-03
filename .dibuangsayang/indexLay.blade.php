@extends('layouts.app')
@section('title', 'Explore Events')
@section('content')
    @if (Route::currentRouteName() === 'homepage' || Route::currentRouteName() === 'explore-events')
        <img src="/chi-header.png" alt="">
    @endif
    <div class="bg-white px-12 pt-0 pb-20">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center">
                <h1 class="text-5xl leading-relaxed font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-1 to-blue-3 mb-5">Discover Upcoming Events</h1>
                @if (Route::currentRouteName() === 'manage-events' || Route::currentRouteName() === 'my-events')
                    <a href="{{ route('events.create') }}"
                        class="bg-blue-1 text-white px-6 py-3 rounded-lg hover:bg-blue-0 transition-all duration-300 flex items-center space-x-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                clip-rule="evenodd" />
                        </svg>
                        <span>Buat Event Baru</span>
                    </a>
                @endif
            </div>

            {{-- ini harusnya nd ada di index lgsg ato gmn dah gktau jg --}}
            @if (session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            @if ($events->isEmpty())
                <div class="text-center py-12 bg-white rounded-lg shadow-lg">
                    <p class="text-blue-1 text-xl">Tidak ada event yang tersedia.</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach ($events as $event)
                    <a href="{{ route('events.show', $event->id) }}">
                        <div class="bg-white rounded-xl shadow-md overflow-hidden transform hover:-translate-y-2 transition-all duration-300 border-b-4 border-blue-1">
                            <div class="">
                                @if ($event->image_path)
                                    <img src="{{ asset('storage/' . $event->image_path) }}" alt="{{ $event->name }}"
                                        class="w-full h-48 object-cover">
                                @else
                                    <div class="w-full h-48 bg-blue-5 flex items-center justify-center text-blue-1">
                                        <span class="text-lg font-semibold">No Image</span>
                                    </div>
                                @endif
                                <div class="absolute top-0 right-0 m-3 bg-blue-0 text-white px-3 py-1 rounded-full text-sm">
                                    {{ \Carbon\Carbon::parse($event->date_time)->format('d M') }}
                                </div>
                            </div>

                            <div class="p-6">
                                <div class="flex justify-between items-center mb-2">
                                    <h2 class="text-2xl font-bold text-blue-1">{{ $event->name }}</h2>
                                    <p class="text-md text-gray-500"><i class="fas fa-heart text-red-500 mr-1"></i>  {{ $event->favoritedBy()->count() }}
                                    </p>
                                </div>
                                <div class="flex justify-between items-center text-blue-1 mb-2 text-md">
                                    <p><i class="fas fa-map-marker-alt mr-2"></i>{{ $event->location }}</p>
                                    <p><i class="fas fa-clock mr-2"></i>{{ \Carbon\Carbon::parse($event->date_time)->format('H:i') }} WIB</p>                                
                                </div>
                                <div>
                                    <p>Tickets starts at <strong>Rp{{ number_format($event->cheapest_ticket->price, 0, ',', '.') }}</strong> </p>
                                </div>
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endsection