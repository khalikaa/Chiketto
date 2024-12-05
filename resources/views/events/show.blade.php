@extends('layouts.app')
@section('title', 'Event Details')
@section('content')
    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <h2
                class="text-5xl leading-relaxed font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-1 to-grey-1 mb-3">
                {{ $event->name }}
            </h2>
            <div class="flex flex-col lg:flex-row gap-6 bg-transparent h-80">
                <!-- Image Section (2/3 Width) -->
                <div class="w-full lg:w-2/3">
                    <img src="{{ asset('storage/' . $event->image_path) }}" alt="Example"
                        class="w-full h-full object-cover rounded-xl shadow-xl">
                </div>
                <!-- Other Section (1/3 Width) -->
                <div class="w-full lg:w-1/3 h-full rounded-xl shadow-xl">
                    <div class="flex justify-between items-center bg-gradient-to-r from-blue-1 to-blue-2 px-6 rounded-t-xl">
                        <h1 class="text-xl font-bold text-white py-3">
                            {{ \Illuminate\Support\Str::limit($event->name, 25, '...') }}</h1>
                        @if (Auth::check() && Auth::user()->role === 'customer')
                            <button id="favorite-btn-{{ $event->id }}" data-event-id="{{ $event->id }}"
                                data-url="{{ route('favorites.toggle') }}" data-csrf="{{ csrf_token() }}"
                                class="p-2 rounded-full flex items-center justify-center">
                                <i id="favorite-icon-{{ $event->id }}"
                                    class="{{ $isFavorited ? 'fas fa-heart text-red-500' : 'far fa-heart text-white' }} text-xl">
                                </i>
                            </button>
                        @endif
                    </div>
                    <div class="p-6 bg-white rounded-b-xl">
                        <div class="mb-2">
                            <h3 class="text-lg font-medium text-blue-1"> <i class="fas fa-calendar-alt mr-2"></i>Date</h3>
                            <p class="text-grey-700">
                                {{ \Carbon\Carbon::parse($event->date_time)->format('l, d F Y - H:i') }}</p>
                        </div>
                        <div class="mb-2">
                            <h3 class="text-lg font-medium text-blue-1"> <i class="fas fa-tags mr-2"></i>Category</h3>
                            <p class="text-grey-700">{{ $event->category->name }}</p>
                        </div>
                        <div class="mb-2">
                            <h3 class="text-lg font-medium text-blue-1"> <i class="fas fa-map-marker-alt mr-2"></i> Location
                            </h3>
                            <p class="text-grey-700">{{ $event->location }}</p>
                        </div>
                        <hr class="border border-blue-grey">
                        <div class="mt-2">
                            <h3 class="text-lg font-medium text-blue-1"> <i class="fas fa-user-tie mr-2"></i>Organized by
                                <strong>{{ $event->organizer_name }}</strong>
                            </h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-6 rounded-xl bg-white shadow-xl">
                <div class="bg-gradient-to-r from-blue-1 to-blue-2 px-6 py-2 rounded-t-xl">
                    <h1 class="text-2xl font-bold text-white">About This Event</h1>
                </div>
                <div class="px-6 py-3">
                    <p class="text-blue-1 text-md">{{ $event->description }}</p>
                </div>
            </div>

            {{-- Tickets Section --}}
            <h2
                class="text-3xl mt-4 leading-relaxed font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-1 to-grey-1 mb-3">
                Select Tickets
            </h2>

            {{-- Ticket Selection and summary --}}
            <div class="flex flex-col lg:flex-row gap-6 bg-transparent mt-0">
                <!-- Ticket Selection -->
                <div class="w-full lg:w-1/2">
                    <form action="{{ route('bookings.select') }}" method="POST">
                        @csrf
                        <input type="hidden" name="event_id" value="{{ $event->id }}">

                        @foreach ($event->tickets as $ticket)
                            <div class="bg-white rounded-lg mb-6 shadow-lg">
                                <div class="rounded-xl">
                                    <!-- Ticket Name -->
                                    <div
                                        class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-x-10 p-6 py-4 bg-gray-200 rounded-t-xl">
                                        <div>
                                            <h4 class="text-2xl font-bold text-blue-1"><i class="fas fa-ticket mr-2"></i>
                                                {{ $ticket->name }}</h4>
                                            <p class="text-grey-700">{{ $ticket->description }}</p>
                                        </div>
                                        <div>
                                            <h4 class="text-lg font-medium text-blue-1 text-right"><i
                                                    class="fas fa-check-circle mr-2 text-lg"></i>{{ $ticket->quota }}
                                                Tickets Available</h4>
                                        </div>
                                    </div>

                                    <div class="flex items-center justify-between px-4 py-4">
                                        <div>
                                            <h4 class="text-2xl font-bold text-blue-1">
                                                Rp{{ number_format($ticket->price, 0, ',', '.') }}</h4>
                                        </div>
                                        <div>
                                            @if (auth()->check() && auth()->user()->role === 'customer')
                                                <div class="flex items-center rounded-lg border border-black">
                                                    <button type="button"
                                                        class="w-8 bg-gray-700 text-white py-1 rounded-l-lg"
                                                        onclick="updateQuantity('quantity-{{ $ticket->id }}', -1)">-</button>
                                                    {{-- readonly --}}
                                                    <input type="number" id="quantity-{{ $ticket->id }}"
                                                        name="tickets[{{ $ticket->id }}]" value="0" min="0"
                                                        max="{{ $ticket->quota }}" data-price="{{ $ticket->price }}"
                                                        data-name="{{ $ticket->name }}"
                                                        data-description="{{ $ticket->description }}"
                                                        class="no-spinner w-12 py-1 text-center text-gray-700 border-none"
                                                        onchange="updateSummary()">
                                                    <button type="button"
                                                        class="w-8 bg-gray-700 text-white py-1 rounded-r-lg"
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
                                </div>
                            </div>
                        @endforeach
                </div>
                <!-- Summary Section -->
                <div class="w-full h-min lg:w-1/2 bg-white rounded-xl shadow-xl border">
                    @if (auth()->check() && auth()->user()->role === 'customer')
                        <div class="p-[25px]">
                            <div id="summary-list" class="space-y-4">
                                <p class="text-xl text-gray-600">No tickets selected yet</p>
                            </div>
                            <p class="text-2xl font-bold text-blue-1 space-x-1 mt-3">Total Payment:
                                <span id="total-price" class="font-bold">Rp0</span>
                            </p>

                            <div class="mt-3 flex justify-end">
                                <button type="submit"
                                    class="bg-gradient-to-r from-blue-1 to-blue-2 text-white px-6 py-2 rounded-lg hover:opacity-90 transition">
                                    <i class="fas fa-shopping-cart mr-3"></i> Book Tickets
                                </button>
                            </div>
                        </div>
                    @endif
                    </form>
                </div>
            </div>
            <a href="{{ url()->previous() }}"
                class="bg-gradient-to-r from-blue-1 to-blue-2 text-white px-6 py-2 rounded-lg hover:opacity-90 transition mt-4 inline-block">
                <i class="fas fa-arrow-left mr-2"></i> Back
            </a>
        </div>
    </div>
    <script src="{{ asset('scripts/favorites.js') }}"></script>
    <script src="{{ asset('scripts/book-ticket.js') }}"></script>
    <script src="{{ asset('scripts/flatpickr.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Select the favorite button
            const button = document.querySelector('[id^=favorite-btn-]');
            const icon = document.querySelector('[id^=favorite-icon-]');

            if (button) {
                button.addEventListener('click', function() {
                    const eventId = this.dataset.eventId; // Get event_id from data attribute
                    const url = this.dataset.url; // Get the URL from data attribute
                    const csrfToken = this.dataset.csrf; // Get CSRF token from data attribute

                    fetch(url, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken
                            },
                            body: JSON.stringify({
                                event_id: eventId
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.status === 'added') {
                                // Update to liked state
                                icon.classList.remove('far',
                                'text-white'); // Remove outlined heart and gray color
                                icon.classList.add('fas',
                                'text-red-500'); // Add solid heart and red color
                            } else if (data.status === 'removed') {
                                // Update to unliked state
                                icon.classList.remove('fas',
                                'text-red-500'); // Remove solid heart and red color
                                icon.classList.add('far',
                                'text-white'); // Add outlined heart and gray color
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });
                });
            }
        });
    </script>
@endsection
