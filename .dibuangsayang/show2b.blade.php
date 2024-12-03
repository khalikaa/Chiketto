@extends('layouts.app')
@section('title', 'Booking Details')

@section('content')
<div class="max-w-4xl mx-auto py-6 space-y-6">
        <h2 class="text-2xl font-bold text-blue-900">Booking Details</h2>

        <!-- Booking Overview -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden p-6">
            <h3 class="text-lg font-bold text-blue-900">Event: {{ $booking->event->name }}</h3>
            <p class="text-sm text-gray-600">{{ $booking->event->description }}</p>

            <div class="grid grid-cols-2 gap-4 mt-4">
                <!-- Event Date -->
                <div>
                    <p class="text-sm font-medium text-gray-700">Event Date:</p>
                    <p class="text-lg font-bold text-blue-900">
                        {{ \Carbon\Carbon::parse($booking->event->date_time)->format('l, d F Y') }}
                    </p>
                </div>

                <!-- Booking Status -->
                <div>
                    <p class="text-sm font-medium text-gray-700">Booking Status:</p>
                    <span 
                        class="px-3 py-1 text-sm rounded-lg {{ $booking->status === 'confirmed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                        {{ ucfirst($booking->status) }}
                    </span>
                </div>

                <!-- Total Transaction -->
                <div class="col-span-2">
                    <p class="text-sm font-medium text-gray-700">Total Transaction:</p>
                    <p class="text-xl font-bold text-green-600">
                        Rp {{ number_format($booking->bookingDetail->sum(fn($detail) => $detail->ticket->price), 0, ',', '.') }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Booking Details -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden p-6">
            <h3 class="text-lg font-bold text-blue-900 mb-4">Your Tickets</h3>

            <div class="space-y-6">
                @foreach ($booking->bookingDetail as $detail)
                    <!-- Ticket Design -->
                    <div class="flex items-center p-4 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg shadow-md">
                        <div class="flex-shrink-0 w-1/3">
                            <div class="bg-white text-blue-900 p-4 rounded-md text-center">
                                <p class="text-lg font-bold">Ticket Type</p>
                                <p class="text-sm font-medium">{{ $detail->ticket->name }}</p>
                            </div>
                        </div>
                        <div class="w-2/3 px-4">
                            <p class="text-sm"><strong>Ticket Code:</strong> {{ $detail->ticket_code }}</p>
                            <p class="text-sm"><strong>Holder Name:</strong> {{ $detail->name }}</p>
                            <p class="text-sm"><strong>Email:</strong> {{ $detail->email }}</p>
                            <p class="text-sm"><strong>Gender:</strong> {{ ucfirst($detail->gender) }}</p>
                            <p class="text-sm"><strong>Price:</strong> Rp {{ number_format($detail->ticket->price, 0, ',', '.') }}</p>
                            <p class="text-sm"><strong>Description:</strong> {{ $detail->ticket->description }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Back Button -->
        <div class="mt-6">
            <a href="{{ route('bookings.index') }}"
               class="bg-gradient-to-r from-blue-500 to-blue-600 text-white px-4 py-2 rounded-lg shadow hover:opacity-90 transition">
                Back to My Bookings
            </a>
        </div>
    </div>
@endsection