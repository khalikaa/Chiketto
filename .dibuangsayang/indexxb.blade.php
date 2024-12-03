@extends('layouts.app')
@section('title', 'My Tickets')

@section('content')
@if (session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6">
            {{ session('success') }}
        </div>
    @endif

    <div class="max-w-4xl mx-auto py-6 space-y-6">
        <h2 class="text-2xl font-bold text-blue-900">Your Bookings</h2>

        @foreach ($bookings as $booking)
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <!-- Event Image -->
                <div class="relative">
                    <img 
                        src="{{ asset('storage/' . $booking->event->image_path) }}" 
                        alt="{{ $booking->event->name }}" 
                        class="w-full h-48 object-cover">
                </div>

                <!-- Booking Information -->
                <div class="p-6">
                    <h3 class="text-xl font-bold text-blue-900">{{ $booking->event->name }}</h3>
                    <p class="text-gray-600 text-sm mb-4">{{ $booking->event->description }}</p>

                    <div class="flex justify-between items-center">
                        <!-- Event Date -->
                        <div>
                            <p class="text-sm font-medium text-gray-700">Event Date:</p>
                            <p class="text-lg font-bold text-blue-900">
                                {{ \Carbon\Carbon::parse($booking->event->date_time)->format('l, d F Y') }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm font-medium text-gray-700">Total Transaction:</p>
                            <p class="text-lg font-bold text-green-600">
                                Rp {{ number_format(
                                    $booking->bookingDetail ? $booking->bookingDetail->sum(fn($detail) => optional($detail->ticket)->price) : 0,
                                0, ',', '.') }}
                            </p>
                        </div>                        
                    </div>

                    <!-- Booking Status -->
                    <div class="mt-4">
                        <p class="text-sm font-medium text-gray-700">Status:</p>
                        <span 
                            class="px-3 py-1 text-sm rounded-lg {{ $booking->status === 'confirmed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }} ">
                            {{ ucfirst($booking->status) }}
                        </span>
                    </div>

                    <div class="mt-6 flex items-center space-x-4">
                        <!-- Order Details Button -->
                        <a href="{{ route('bookings.show', $booking->id) }}"
                           class="bg-gradient-to-r from-blue-500 to-blue-600 text-white px-4 py-2 rounded-lg shadow hover:opacity-90 transition">
                            View Order Details
                        </a>

                        <!-- Accept Button (Only for Event Owner) -->
                        @if ((Auth::id() === $booking->event->user_id || Auth::user()->role === 'admin') && $booking->status !== 'active')
                            <form action="{{ route('bookings.accept', $booking->id) }}" method="POST">
                                @csrf
                                <button type="submit" 
                                    class="bg-gradient-to-r from-green-500 to-green-600 text-white px-4 py-2 rounded-lg shadow hover:opacity-90 transition">
                                    Accept Booking
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection