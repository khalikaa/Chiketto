<style>
    input[type="number"]::-webkit-inner-spin-button,
    input[type="number"]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    input[type="number"] {
        -moz-appearance: textfield;
    }
</style>
@extends('layouts.app')
{{-- <x-slot name="header">
    <h2 class="font-semibold text-xl text-blue-1 leading-tight">
        {{ __('Event Details') }}
    </h2>
</x-slot> --}}
@section('title', 'Event Details')
@section('content')
    <div class="py-12 bg-grey-1">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg sm:rounded-lg overflow-hidden">
                <!-- Event Header -->
                <div class="bg-gradient-to-r from-blue-1 to-blue-2 p-6">
                    <h1 class="text-3xl font-bold text-white">{{ $event->name }}</h1>
                    <p class="text-white mt-2">{{ $event->description }}</p>
                </div>

                @if (Auth::check() && Auth::user()->role === 'customer')
                    <button id="favorite-btn-{{ $event->id }}" data-event-id="{{ $event->id }}"
                        data-url="{{ route('favorites.toggle') }}" data-csrf="{{ csrf_token() }}"
                        class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded">
                        {{ $isFavorited ? 'Remove from Favorites' : 'Add to Favorites' }}
                    </button>
                @endif

                   <div class="p-6 border-b border-grey-2">
                <div class="aspect-w-16 aspect-h-9 rounded-lg overflow-hidden">
                    <img src="{{ asset('storage/' . $event->image_path) }}" 
                         alt="{{ $event->name }}" 
                         class="object-cover w-full h-64 rounded-lg">
                </div>
            </div>


                <!-- Event Information -->
                <div class="px-8 py-6 space-y-6">
                    <!-- Organizer and Category -->
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-lg font-medium text-blue-1">Organizer</h3>
                            <p class="text-grey-700">{{ $event->organizer_name }}</p>
                        </div>
                        <div>
                            <h3 class="text-lg font-medium text-blue-1">Category</h3>
                            <p class="text-grey-700">{{ $event->category->name ?? 'No Category' }}</p>
                        </div>
                    </div>

                    <!-- Date and Time -->
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-lg font-medium text-blue-1">Date</h3>
                            <p class="text-grey-700">{{ \Carbon\Carbon::parse($event->date_time)->format('l, d F Y') }}
                            </p>
                        </div>
                        <div>
                            <h3 class="text-lg font-medium text-blue-1">Time</h3>
                            <p class="text-grey-700">{{ \Carbon\Carbon::parse($event->date_time)->format('H:i') }}</p>
                        </div>
                    </div>

                    <!-- Location -->
                    <div>
                        <h3 class="text-lg font-medium text-blue-1">Location</h3>
                        <p class="text-grey-700">{{ $event->location }}</p>
                    </div>
                </div>


                <!-- Ticket Booking Form -->
                <form action="{{ route('bookings.select') }}" method="POST">
                    @csrf
                    <input type="hidden" name="event_id" value="{{ $event->id }}">
                    <!-- Ticket Selection -->
                    <div class="p-6 space-y-6">
                        <h3 class="text-xl font-bold text-blue-1">Select Tickets</h3>
                        @foreach ($event->tickets as $ticket)
                            <div class="bg-grey-1 p-4 rounded-lg shadow-md">
                                <div class="grid md:grid-cols-3 gap-6">
                                    <!-- Ticket Name -->
                                    <div>
                                        <h4 class="text-lg font-medium text-blue-1">{{ $ticket->name }}</h4>
                                        <p class="text-grey-700">{{ $ticket->description }}</p>
                                    </div>
                                    <!-- Price -->
                                    <div>
                                        <h4 class="text-lg font-medium text-blue-1">Price</h4>
                                        <p class="text-grey-700">Rp {{ number_format($ticket->price, 0, ',', '.') }}</p>
                                    </div>
                                    {{-- Quota --}}
                                    <div>
                                        <h4 class="text-lg font-medium text-blue-1">Quota</h4>
                                        <p class="text-grey-700">{{ $ticket->quota }}</p>
                                    </div>

                                    <!-- Quantity -->
                                    @if (auth()->check() && auth()->user()->role === 'customer')
                                        <div class="flex items-center space-x-2">
                                            <button type="button" class="w-8 bg-gray-700 text-white px-2 py-1 rounded-l-lg"
                                                onclick="updateQuantity('quantity-{{ $ticket->id }}', -1)">-</button>
                                            {{-- readonly --}}
                                            <input type="number" id="quantity-{{ $ticket->id }}"
                                                name="tickets[{{ $ticket->id }}]" value="0" min="0"
                                                max="{{ $ticket->quota }}" data-price="{{ $ticket->price }}"
                                                data-name="{{ $ticket->name }}"
                                                data-description="{{ $ticket->description }}"
                                                class="w-12 px-2 py-1 text-center text-gray-700" onchange="updateSummary()">
                                            <button type="button" class="w-8 bg-gray-700 text-white px-2 py-1 rounded-r-lg"
                                                onclick="updateQuantity('quantity-{{ $ticket->id }}', 1)">+</button>
                                        </div>
                                    @elseif(Auth::guest())
                                        <a href="{{ route('login') }}"
                                            class="bg-gradient-to-r from-blue-1 to-blue-2 text-white px-6 py-2 rounded-lg hover:opacity-90 transition w-[150px] text-center">
                                            Book Ticket
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>

                    @if (auth()->check() && auth()->user()->role === 'customer')
                        <!-- Summary -->
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-blue-1">Summary</h3>
                            <div id="summary-list" class="space-y-4 mt-4">
                                <p class="text-grey-700">No tickets selected yet.</p>
                            </div>
                            <p class="text-grey-700 mt-4 font-bold">Total Price:
                                <span id="total-price" class="font-bold">Rp 0</span>
                            </p>
                        </div>

                        <!-- Submit Button -->
                        <div class="p-6">
                            {{-- onclick="redirectToBookingForm()" --}}
                            <button type="submit"
                                class="bg-gradient-to-r from-blue-1 to-blue-2 text-white px-6 py-2 rounded-lg hover:opacity-90 transition">
                                Book Tickets
                            </button>
                        </div>
                    @endif
                </form>
            </div>
        </div>
    </div>

    <script src="{{ asset('scripts/favorites.js') }}"></script>
    <script src="{{ asset('scripts/book-ticket.js') }}"></script>
    <script src="{{ asset('scripts/flatpickr.js') }}"></script>
    <script src="{{ asset('scripts/preview-image.js') }}"></script>
@endsection
