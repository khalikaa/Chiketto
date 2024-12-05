@extends('layouts.dashboard')

@section('title', 'Organizer Dashboard')

@section('content')
<div class="px-12 pt-0 pb-20 mt-10" style="min-height: calc(100vh - 220px);">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <div class="bg-white shadow-md p-6 rounded-lg">
            <div class="flex justify-between items-center">
                <h3 class="text-xl font-semibold text-blue-1">Total Events</h3>
                <a href="{{ route('my-events') }}" class="text-red-600">Detail</a>
            </div>
            <hr class="border border-blue-grey my-3">
            <div class="flex items-center">
                <p class="text-2xl font-bold mr-2"> {{ $totalEvents }} </p>
                <p>Events</p>
            </div>
        </div>
        
        <div class="bg-white shadow-md p-6 rounded-lg">
            <div class="flex justify-between items-center">
                <h3 class="text-xl font-semibold text-blue-1">Total Ticket Sold</h3>
                <a href="{{ route('bookings.index') }}" class="text-red-600">Detail</a>
            </div>
            <hr class="border border-blue-grey my-3">
            <div class="flex items-center">
                <p class="text-2xl font-bold mr-2"> {{ $totalTicketsSold }} </p>
                <p>Tickets</p>
            </div>
        </div>

        <div class="bg-white shadow-md p-6 rounded-lg">
            <div class="flex justify-between items-center">
                <h3 class="text-xl font-semibold text-blue-1">Total Revenue</h3>
                <a href="{{ route('bookings.index') }}" class="text-red-600">Detail</a>
            </div>
            <hr class="border border-blue-grey my-3">
            <p class="text-2xl font-bold">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
        </div>

        <div class="bg-white shadow-md p-6 rounded-lg">
            <div class="flex justify-between items-center">
                <h3 class="text-xl font-semibold text-blue-1">Total Users</h3>
                <a href="{{ route('users.index') }}" class="text-red-600">Detail</a>
            </div>
            <hr class="border border-blue-grey my-3">
            <p class="text-2xl font-bold">{{ $totalUsers }}</p>
        </div>
        
        <div class="bg-white shadow-md p-6 rounded-lg">
            <div class="flex justify-between items-center">
                <h3 class="text-xl font-semibold text-blue-1">Total Customer</h3>
            </div>
            <hr class="border border-blue-grey my-3">
            <p class="text-2xl font-bold">{{ $totalCust }}</p>
        </div>
        
        <div class="bg-white shadow-md p-6 rounded-lg">
            <div class="flex justify-between items-center">
                <h3 class="text-xl font-semibold text-blue-1">Total Organizer</h3>
            </div>
            <hr class="border border-blue-grey my-3">
            <p class="text-2xl font-bold">{{ $totalOrg }}</p>
        </div>
    </div>
</div>
@endsection