@extends('layouts.dashboard')

@section('title', 'Dashboard')
@section('content')
    <div class="px-12 pt-0 pb-20 mt-10" style="min-height: calc(100vh - 220px);">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Total Bookings -->
            <div class="bg-white shadow-md p-6 rounded-lg">
                <div class="flex justify-between items-center">
                    <h3 class="text-xl font-semibold text-blue-1">Total Bookings</h3>
                    <a href="{{ route('bookings.index') }}" class="text-red-600">Detail</a>
                </div>
                <hr class="border border-blue-grey my-3">
                <p class="text-2xl font-bold">{{ $totalBookings }}</p>
            </div>

            <div class="bg-white shadow-md p-6 rounded-lg">
                <div class="flex justify-between items-center">
                    <h3 class="text-xl font-semibold text-blue-1">Total Spent</h3>
                    <a href="{{ route('bookings.index') }}" class="text-red-600">Detail</a>
                </div>
                <hr class="border border-blue-grey my-3">
                <p class="text-2xl font-bold">Rp {{ number_format($totalSpent, 0, ',', '.') }}</p>
            </div>

            <div class="bg-white shadow-md p-6 rounded-lg">
                <div class="flex justify-between items-center">
                    <h3 class="text-xl font-semibold text-blue-1">Total Favorites</h3>
                    <a href="{{ route('my-favorites') }}" class="text-red-600">Detail</a>
                </div>
                <hr class="border border-blue-grey my-3">
                <div class="flex items-center">
                    <p class="text-2xl font-bold mr-2">{{ $totalFavorites }}</p>
                    <p>Event</p>
                </div>
            </div>
        </div>
    </div>
@endsection
