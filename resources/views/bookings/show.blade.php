@extends('layouts.app')
@section('title', 'Booking Details')

@section('content')
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 mb-3">
        <!-- Page Title -->
        <div class="flex justify-between items-center mt-3">
            <h2
                class="text-5xl leading-relaxed font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-1 to-blue-3 my-3">
                Booking Details
            </h2>
            <div>
                <span
                    class="px-6 py-2 text-2xl rounded-full font-bold 
                {{ $booking->status === 'active'
                    ? 'bg-green-100 text-green-800 border border-green-800'
                    : ($booking->status === 'canceled'
                        ? 'bg-red-100 text-red-800 border border-red-800'
                        : 'bg-yellow-100 text-yellow-800 border border-yellow-800') }}">
                    Status: {{ ucfirst($booking->status) }}
                </span>

            </div>
        </div>

        <div class="flex flex-col lg:flex-row gap-6 p-0">
            <!-- Image Section (2/3 Width) -->
            <div class="w-full lg:w-2/3">
                <img src="{{ asset('storage/' . $booking->event->image_path) }}" alt="Example"
                    class="w-full h-80 object-cover rounded-xl">
            </div>
            <!-- Other Section (1/3 Width) -->
            <div class="w-full lg:w-1/3 rounded-xl shadow-xl">
                <div class="flex justify-between items-center bg-gradient-to-r from-blue-1 to-blue-2 px-4 rounded-t-xl">
                    <h1 class="text-xl font-bold text-white py-3">
                        {{ \Illuminate\Support\Str::limit($booking->event->name, 30, '...') }}</h1>
                </div>
                <div class="p-5 bg-white rounded-b-xl">
                    <div class="mb-2">
                        <h3 class="text-lg font-medium text-blue-1"> <i class="fas fa-calendar-alt mr-2"></i>Date</h3>
                        <p class="text-grey-700">
                            {{ \Carbon\Carbon::parse($booking->event->date_time)->format('l, d F Y - H:i') }}
                        </p>
                    </div>
                    <div class="mb-2">
                        <h3 class="text-lg font-medium text-blue-1"><i class="fas fa-tags mr-2"></i>Category</h3>
                        <p class="text-grey-700">{{ $booking->event->category->name }}</p>
                    </div>
                    <div class="mb-2">
                        <h3 class="text-lg font-medium text-blue-1"> <i class="fas fa-map-marker-alt mr-2"></i> Location
                        </h3>
                        <p class="text-grey-700">{{ $booking->event->location }}</p>
                    </div>
                    <hr class="border border-blue-grey">
                    <div class="mt-2">
                        <h3 class="text-lg font-medium text-blue-1"> <i class="fas fa-user-tie mr-2"></i>Organized by
                            <strong>{{ $booking->event->organizer_name }}</strong>
                        </h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-8 space-y-8">
            @if ($booking->status === 'active')
                @foreach ($booking->bookingDetail as $detail)
                    <div class="bg-white border-2 border-blue-2 rounded-lg w-full">
                        <div
                            class="flex justify-between items-center bg-gradient-to-r from-blue-1 to-blue-2 py-4 px-8 p-6 rounded-t-lg">
                            <h1 class="text-2xl font-bold text-white items-center"><i
                                    class="fas fa-ticket text-2xl mr-3"></i>{{ $detail->ticket->name }}</h1>
                            <h1 class="text-2xl font-bold text-white">#{{ $detail->ticket_code }}</h1>
                        </div>
                        <hr class="border-dashed border-t-2 border-blue-1 mb-3">

                        <div class="pl-8">
                            <h2
                                class="text-3xl leading-relaxed font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-1 to-blue-3">
                                {{ $booking->event->name }} E-Ticket</h2>
                            </h2>
                        </div>
                        <div class="flex pl-8 justify-start gap-x-10 items-start mb-4">
                            <div class="flex items-center text-blue-1">
                                <i class="far fa-calendar-alt text-xl"></i>
                                <span class="ml-2 text-lg text-blue-1">
                                    {{ \Carbon\Carbon::parse($booking->event->date_time)->format('l, d F Y') }}</span>
                            </div>
                            <div class="flex items-center text-blue-1">
                                <i class="far fa-clock text-xl"></i>
                                <span class="ml-2 text-lg text-blue-1">
                                    {{ \Carbon\Carbon::parse($booking->event->date_time)->format('H:i') }} </span>
                            </div>
                            <div class="flex items-center text-blue-1">
                                <i class="fas fa-map-marker-alt text-xl"></i>
                                <span class="ml-2 text-lg text-blue-1">{{ $booking->event->location }}</span>
                            </div>
                        </div>
                        <hr class="border-dashed border-t-2 border-black">
                        <div class="flex items-center px-8 py-4 gap-x-20">
                            <div>
                                <span class="block font-bold text-md text-blue-1 text-md text-blue-1">Name</span>
                                <span class="block">{{ $detail->name }}</span>
                            </div>
                            <div>
                                <span class="block font-bold text-md text-blue-1">Email</span>
                                <span class="block">{{ $detail->email }}</span>
                            </div>
                            <div>
                                <span class="block font-bold text-md text-blue-1">Gender</span>
                                <span class="block"> {{ ucfirst($detail->gender) }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif

            <div class="bg-white shadow-md rounded-lg overflow-hidden p-6">
                <!-- Detail Transaction -->
                <div class="col-span-3">
                    <p class="text-2xl font-bold text-blue-1">Transaction Details</p>
                    <hr class="my-2 border border-blue-grey">

                    <div class="space-y-2">
                        <!-- Group dan hitung total tiket -->
                        @php
                            $groupedDetails = $booking->bookingDetail->groupBy('ticket_id');
                            $total = 0;
                        @endphp

                        @foreach ($groupedDetails as $ticketId => $details)
                            @php
                                $ticket = $details->first()->ticket; // Ambil data tiket
                                $quantity = $details->count(); // Hitung jumlah tiket
                                $subtotal = $ticket->price * $quantity; // Hitung subtotal
                                $total += $subtotal; // Tambahkan ke total keseluruhan
                            @endphp
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="text-xl font-bold text-gray-700">
                                        {{ $ticket->name }}
                                    </p>
                                    <p class="text-lg text-gray-700">
                                        Rp {{ number_format($ticket->price, 0, ',', '.') }} x {{ $quantity }}
                                    </p>
                                </div>
                                <p class="text-xl text-gray-700">
                                    Rp {{ number_format($subtotal, 0, ',', '.') }}
                                </p>
                            </div>
                        @endforeach
                    </div>
                    <hr class="my-2 border border-blue-grey">
                    <!-- Total -->
                    <p class="text-2xl font-bold text-blue-1 text-end">
                        Total: Rp {{ number_format($total, 0, ',', '.') }}
                    </p>
                </div>

            </div>
        </div>
        <div class="flex justify-between my-6">
            <a href="{{ route('bookings.index') }}"
                class="bg-gradient-to-r from-blue-1 to-blue-2 text-white px-6 py-2 rounded-lg shadow-lg hover:opacity-90 transition">
                <i class="fas fa-arrow-left mr-2"></i> Back
            </a>
            @if ($booking->status === 'pending')
            <div class="flex gap-x-2">
                <form action="{{ route('bookings.accept', $booking->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-gradient-to-r from-green-500 to-green-600 text-white px-6 py-2 rounded-lg shadow-lg hover:opacity-90 transition">
                        <i class="fas fa-check-circle mr-2"></i> Accept
                    </button>
                </form>
                <form action="{{ route('bookings.cancel', $booking->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-gradient-to-r from-red-500 to-red-600 text-white px-6 py-2 rounded-lg shadow-lg hover:opacity-90 transition">
                        <i class="fas fa-times-circle mr-[1px]"></i> Cancel
                    </button>
                </form>
            </div>

                {{-- <a href="{{ route('bookings.index') }}"
                    class="bg-gradient-to-r from-red-500 to-red-600 text-white px-6 py-2 rounded-lg shadow-lg hover:opacity-90 transition">
                    <i class="fas fa-times mr-2"></i> Cancel Booking
                </a> --}}
            @endif
        </div>
    </div>
@endsection
