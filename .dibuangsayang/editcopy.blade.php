@extends('layouts.app')
<x-slot name="header">
    <h2 class="font-semibold text-xl text-blue-1 leading-tight">
        {{ __('Edit Event') }}
    </h2>
</x-slot>
@section('title', 'Edit Event')
@section('content')

    <div class="py-12 bg-grey-1">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg sm:rounded-lg overflow-hidden">

                <div class="bg-gradient-to-r from-blue-1 to-blue-2 p-10 py-5">
                    <h1 class="text-3xl font-bold text-white"> <i class="fas fa-calendar-alt mr-2"></i> Edit Event</h1>
                </div>

                <form action="{{ route('events.update', $event->id) }}" method="POST" enctype="multipart/form-data"
                    class="px-10 space-y-6">
                    @csrf
                    @method('PUT')
                    <!-- Event Information -->
                    <div class="grid md:grid-cols-2 gap-6">
                        <div class="col-span-2">
                            <label for="name" class="block text-sm font-medium text-blue-1 mb-2 mt-1">Event Name</label>
                            <input type="text" name="name" id="name"
                                class="block w-full border-blue-3 rounded-lg shadow-sm focus:border-blue-2 focus:ring focus:ring-blue-4"
                                value="{{ old('name', $event->name) }}" required>
                        </div>

                        <div>
                            <label for="organizer_name" class="block text-sm font-medium text-blue-1 mb-2">Organizer
                                Name</label>
                            <input type="text" name="organizer_name" id="organizer_name"
                                class="block w-full border-blue-3 rounded-lg shadow-sm focus:border-blue-2 focus:ring focus:ring-blue-4"
                                value="{{ old('organizer_name', $event->organizer_name) }}" required>
                        </div>

                        <div>
                            <label for="category_id" class="block text-sm font-medium text-blue-1 mb-2">Category</label>
                            <select name="category_id" id="category_id"
                                class="block w-full border-blue-3 rounded-lg shadow-sm focus:border-blue-2 focus:ring focus:ring-blue-4"
                                required>
                                <option value="">Select Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ old('category_id', $event->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-span-2">
                            <label for="description" class="block text-sm font-medium text-blue-1 mb-2">Description</label>
                            <textarea name="description" id="description" rows="4"
                                class="block w-full border-blue-3 rounded-lg shadow-sm focus:border-blue-2 focus:ring focus:ring-blue-4" required>{{ old('description', $event->description) }}</textarea>
                        </div>

                        <div>
                            <label for="date" class="block text-sm font-medium text-blue-1 mb-2">Date</label>
                            <input type="text" name="date" id="date"
                                class="block w-full border-blue-3 rounded-lg shadow-sm focus:border-blue-2 focus:ring focus:ring-blue-4"
                                placeholder="DD/MM/YYYY"
                                value="{{ old('date', \Carbon\Carbon::parse($event->date_time)->format('d/m/Y')) }}"
                                required>
                        </div>

                        <div>
                            <label for="time" class="block text-sm font-medium text-blue-1 mb-2">Time</label>
                            <input type="text" name="time" id="timePicker"
                                class="block w-full border-blue-3 rounded-lg shadow-sm focus:border-blue-2 focus:ring focus:ring-blue-4"
                                value="{{ old('time', \Carbon\Carbon::parse($event->date_time)->format('H:i')) }}" required>
                        </div>

                        <div class="col-span-2">
                            <label for="location" class="block text-sm font-medium text-blue-1 mb-2">Location</label>
                            <input type="text" name="location" id="location"
                                class="block w-full border-blue-3 rounded-lg shadow-sm focus:border-blue-2 focus:ring focus:ring-blue-4"
                                value="{{ old('location', $event->location) }}" required>
                        </div>

                        <div class="col-span-2 mb-10">
                            <label for="image" class="block text-sm font-medium text-blue-1 mb-2">Event Image</label>
                            <div
                                class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-blue-3 border-dashed rounded-lg">
                                <div class="space-y-1 text-center">
                                    <!-- Preview Gambar -->
                                    <img id="image-preview" 
                                         src="{{ $event->image_path ? asset('storage/' . $event->image_path) : '' }}" 
                                         alt="Preview" 
                                         class="w-full rounded-md mb-4"
                                         style="max-height: 300px; object-fit: cover; {{ $event->image_path ? '' : 'display: none;' }}">
                                    <!-- Placeholder Ikon -->
                                    <i id="image-placeholder" 
                                       class="fas fa-image text-4xl text-blue-grey mb-3" 
                                       style="{{ $event->image_path ? 'display: none;' : '' }}"></i>
                                    <!-- Input File -->
                                    <div class="flex text-sm text-blue-grey justify-center items-center">
                                        <label for="image"
                                               class="cursor-pointer bg-white rounded-md font-medium text-blue-2 hover:text-blue-1">
                                            <span>Edit Image</span>
                                            <input id="image" name="image" type="file" class="sr-only"
                                                   accept="image/*" onchange="previewImage(event)">
                                        </label>
                                    </div>
                                    <p class="text-xs text-blue-grey">PNG, JPG up to 10MB</p>
                                </div>
                            </div>
                            @error('image')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                                                
                    </div>
            </div>


            <div class="shadow-lg sm:rounded-lg overflow-hidden mt-6">
                <div class="bg-gradient-to-r from-blue-1 to-blue-2 p-10 py-5">
                    <h1 class="text-3xl font-bold text-white"> <i class="fas fa-ticket mr-2"></i> Edit Ticket</h1>
                </div>

                <!-- Tickets Section -->
                <div class="bg-white p-10 rounded-lg col-span-2">
                    <div id="tickets-container">
                        <!-- Existing Tickets -->
                        @foreach ($event->tickets as $index => $ticket)
                            <div class="ticket-item">
                                <div class="relative bg-gray-200 shadow-md rounded-lg p-8 pt-4 space-y-4">
                                    <input type="hidden" name="tickets[{{ $index }}][id]"
                                        value="{{ $ticket->id }}">
                                    <button type="button"
                                        class="absolute top-1 right-5 text-red-600 hover:text-red-500 remove-ticket">
                                        <i class="fas fa-trash"></i>
                                    </button>

                                    <div class="grid md:grid-cols-3 gap-6">
                                        <div>
                                            <label class="block text-sm font-medium text-blue-1 mb-2">Ticket
                                                Name</label>
                                            <input type="text" name="tickets[{{ $index }}][name]"
                                                class="block w-full border-blue-3 rounded-lg shadow-sm focus:border-blue-2 focus:ring focus:ring-blue-4"
                                                value="{{ old("tickets.$index.name", $ticket->name) }}" required>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-blue-1 mb-2">Price</label>
                                            <input type="number" name="tickets[{{ $index }}][price]"
                                                class="block w-full border-blue-3 rounded-lg shadow-sm focus:border-blue-2 focus:ring focus:ring-blue-4"
                                                value="{{ old("tickets.$index.price", $ticket->price) }}" required>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-blue-1 mb-2">Quota</label>
                                            <input type="number" name="tickets[{{ $index }}][quota]"
                                                class="block w-full border-blue-3 rounded-lg shadow-sm focus:border-blue-2 focus:ring focus:ring-blue-4"
                                                value="{{ old("tickets.$index.quota", $ticket->quota) }}" required>
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-blue-1 mb-2">Description</label>
                                        <input type="text" name="tickets[{{ $index }}][description]"
                                            class="block w-full border-blue-3 rounded-lg shadow-sm focus:border-blue-2 focus:ring focus:ring-blue-4"
                                            value="{{ old("tickets.$index.description", $ticket->description) }}">
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Add New Ticket -->
                    <div class="flex justify-end mt-3">
                        <button type="button" id="add-ticket"
                            class="mt-4 bg-gradient-to-r from-blue-1 to-blue-2 text-white px-4 py-2 rounded-lg hover:opacity-90 transition">
                            <i class="fas fa-plus mr-2"></i> Add Ticket
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Submit Buttons -->
        <div class="col-span-2 flex justify-end space-x-4 mt-6">
            <a href="{{ route('events.index') }}"
                class="bg-red-700 text-white px-6 py-2 rounded-lg hover:bg-red-600 transition">
                Cancel
            </a>
            <button type="submit"
                class="bg-gradient-to-r from-blue-1 to-blue-2 text-white px-6 py-2 rounded-lg hover:opacity-90 transition">
                Save Changes
            </button>
        </div>
        </form>
    </div>
    </div>

    <script>
        document.getElementById('add-ticket').addEventListener('click', function () {
        const ticketsContainer = document.getElementById('tickets-container');
        const ticketCount = ticketsContainer.children.length;
    
        const newTicket = document.createElement('div');
        newTicket.classList.add('ticket-item');
        newTicket.innerHTML = `
            <div class="relative bg-gray-200 shadow-md rounded-lg p-8 pt-4 space-y-4 mt-10">
                <button type="button" class="absolute top-5 right-5 text-red-600 hover:text-red-500 remove-ticket">
                    <i class="fas fa-trash"></i>
                </button>
    
                <div class="grid md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-blue-1 mb-2">Ticket Name</label>
                        <input type="text" name="tickets[${ticketCount}][name]"
                            class="block w-full border-blue-3 rounded-lg shadow-sm focus:border-blue-2 focus:ring focus:ring-blue-4" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-blue-1 mb-2">Price</label>
                        <input type="number" name="tickets[${ticketCount}][price]"
                            class="block w-full border-blue-3 rounded-lg shadow-sm focus:border-blue-2 focus:ring focus:ring-blue-4" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-blue-1 mb-2">Quota</label>
                        <input type="number" name="tickets[${ticketCount}][quota]"
                            class="block w-full border-blue-3 rounded-lg shadow-sm focus:border-blue-2 focus:ring focus:ring-blue-4" required>
                    </div>
                </div>
    
                <div>
                    <label class="block text-sm font-medium text-blue-1 mb-2">Description</label>
                    <input type="text" name="tickets[${ticketCount}][description]"
                        class="block w-full border-blue-3 rounded-lg shadow-sm focus:border-blue-2 focus:ring focus:ring-blue-4">
                </div>
            </div>
        `;
        ticketsContainer.appendChild(newTicket);
    
        // Tambahkan event listener untuk tombol hapus
        newTicket.querySelector('.remove-ticket').addEventListener('click', function () {
            ticketsContainer.removeChild(newTicket);
        });
    });
    
    </script>
    @endsection


{{-- <script>
    document.getElementById('add-ticket').addEventListener('click', function() {
        const ticketsContainer = document.getElementById('tickets-container');
        const ticketCount = ticketsContainer.children.length;

        const newTicket = document.createElement('div');
        newTicket.classList.add('ticket-item');
        newTicket.innerHTML = `
            <div class="relative bg-white shadow-md rounded-lg p-6 space-y-4">
                <button type="button" class="absolute top-10 right-10 text-red-500 hover:text-red-700 remove-ticket">
                    <i class="fas fa-trash-alt"></i>
                </button>

                <div class="grid md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-blue-1 mb-2">Ticket Name</label>
                        <input type="text" name="tickets[${ticketCount}][name]"
                            class="block w-full border-blue-3 rounded-lg shadow-sm focus:border-blue-2 focus:ring focus:ring-blue-4" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-blue-1 mb-2">Price</label>
                        <input type="number" name="tickets[${ticketCount}][price]"
                            class="block w-full border-blue-3 rounded-lg shadow-sm focus:border-blue-2 focus:ring focus:ring-blue-4" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-blue-1 mb-2">Quota</label>
                        <input type="number" name="tickets[${ticketCount}][quota]"
                            class="block w-full border-blue-3 rounded-lg shadow-sm focus:border-blue-2 focus:ring focus:ring-blue-4" required>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-blue-1 mb-2">Description</label>
                    <input type="text" name="tickets[${ticketCount}][description]"
                        class="block w-full border-blue-3 rounded-lg shadow-sm focus:border-blue-2 focus:ring focus:ring-blue-4">
                </div>
            </div>
        `;
        ticketsContainer.appendChild(newTicket);

        newTicket.querySelector('.remove-ticket').addEventListener('click', function() {
            ticketsContainer.removeChild(newTicket);
        });
    });
</script> --}}
