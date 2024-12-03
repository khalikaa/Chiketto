@extends('layouts.app')
@section('title', 'Book Tickets')
<x-slot name="header">
    <h2 class="font-semibold text-xl text-blue-1 leading-tight">
        {{ __('Enter Ticket Holder Details') }}
    </h2>
</x-slot>

@section('content')
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <h2
                class="text-5xl leading-relaxed font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-1 to-grey-1 mb-3">
                Ticket Holder Details
            </h2>

            <div class="overflow-hidden">
                <form action="{{ route('bookings.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="event_id" value="{{ $event->id }}">

                    <div class="space-y-10">

                        @foreach ($selectedTickets as $ticket)
                            @for ($i = 0; $i < $ticket['quantity']; $i++)
                                <div class="p-10 bg-gray-200 rounded-lg shadow-xl">
                                    <h4 class="text-2xl font-bold text-blue-1">{{ $ticket['name'] }} - Holder
                                        {{ $i + 1 }}</h4>
                                    <p class="text-gray-700">{{ $ticket['description'] }}</p>

                                    <div class="grid grid-cols-1 gap-3 mt-4">
                                        <div>
                                            <label class="block text-sm font-medium text-blue-1">Full Name</label>
                                            <input type="text"
                                                placeholder="Enter full name"
                                                name="holders[{{ $ticket['id'] }}][{{ $i }}][name]"
                                                value="{{ old('holders.' . $ticket['id'] . '.' . $i . '.name') }}" required
                                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-1 focus:border-blue-1 sm:text-sm">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-blue-1">Email</label>
                                            <input type="email"
                                                placeholder="Enter email address"
                                                name="holders[{{ $ticket['id'] }}][{{ $i }}][email]"
                                                value="{{ old('holders.' . $ticket['id'] . '.' . $i . '.email') }}"
                                                required
                                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-1 focus:border-blue-1 sm:text-sm">
                                        </div>
                                        <div>
                                            <label for="gender"
                                                class="block text-sm font-medium text-blue-1">Gender</label>
                                            <select id="gender"
                                                name="holders[{{ $ticket['id'] }}][{{ $i }}][gender]" required
                                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-1 focus:border-blue-1 sm:text-sm">
                                                <option value="" disabled
                                                    {{ old('holders.' . $ticket['id'] . '.' . $i . '.gender') == '' ? 'selected' : '' }}>
                                                    Select Gender</option>
                                                <option value="male"
                                                    {{ old('holders.' . $ticket['id'] . '.' . $i . '.gender') == 'male' ? 'selected' : '' }}>
                                                    Male</option>
                                                <option value="female"
                                                    {{ old('holders.' . $ticket['id'] . '.' . $i . '.gender') == 'female' ? 'selected' : '' }}>
                                                    Female</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            @endfor
                        @endforeach
                    </div>
                    <div class="flex justify-between mt-4">
                        {{-- ini gak kesimpan history sblmnya --}}
                        <a href="{{ url()->previous() }}" class="bg-gradient-to-r from-blue-1 to-blue-2 text-white px-6 py-2 rounded-lg hover:opacity-90 transition">
                            <i class="fas fa-arrow-left mr-2"></i> Back
                        </a>            
                        <button type="submit"
                            class="bg-gradient-to-r from-blue-1 to-blue-2 text-white px-6 py-2 rounded-lg hover:opacity-90 transition">
                            <i class="fas fa-check-circle mr-3"></i>Confirm Booking
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
