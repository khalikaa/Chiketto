@extends('layouts.app')
@section('title', 'Create Event')
@section('content')
    <div class="py-12 bg-grey-1">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg sm:rounded-lg overflow-hidden">

                <div class="bg-gradient-to-r from-blue-1 to-blue-2 p-10 py-5">
                    <h1 class="text-3xl font-bold text-white"> <i class="fas fa-calendar-alt mr-2"></i> Create New Event</h1>
                </div>

                <form action="{{ route('events.store') }}" method="POST" enctype="multipart/form-data" class="px-10 space-y-6"
                    id="ticketForm">
                    @csrf

                    <!-- Event Information -->
                    <div class="grid md:grid-cols-2 gap-6">
                        <!-- Event Name -->
                        <div class="col-span-2">
                            <label for="name" class="block text-sm font-medium text-blue-1 mb-2">Event Name</label>
                            <input type="text" name="name" id="name" placeholder="Enter Event Name"
                                class="block w-full border-blue-3 rounded-lg shadow-sm focus:border-blue-2 focus:ring focus:ring-blue-4"
                                value="{{ old('name') }}">
                            @error('name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <input type="hidden" name="organizer_name" value="{{ Auth::user()->name }}">

                        <!-- Category -->
                        <div class="col-span-2">
                            <label for="category" class="block text-sm font-medium text-blue-1 mb-2">Category</label>
                            <select name="category" id="category"
                                class="block w-full border-blue-3 rounded-lg shadow-sm focus:border-blue-2 focus:ring focus:ring-blue-4">
                                <option value="">Select Event Category</option>

                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ old('category') == $category->id ? 'selected' : '' }}>{{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="col-span-2">
                            <label for="description" class="block text-sm font-medium text-blue-1 mb-2">Description</label>
                            <textarea name="description" id="description" rows="4" placeholder="Describe Event Details"
                                class="block w-full border-blue-3 rounded-lg shadow-sm focus:border-blue-2 focus:ring focus:ring-blue-4">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="date" class="block text-sm font-medium text-blue-1 mb-2">Date</label>
                            <input type="text" name="date" id="date"
                                class="block w-full border-blue-3 rounded-lg shadow-sm focus:border-blue-2 focus:ring focus:ring-blue-4"
                                placeholder="DD/MM/YYYY" value="{{ old('date') }}">
                            @error('date')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="time" class="block text-sm font-medium text-blue-1 mb-2">Time</label>
                            <input type="text" name="time" id="timePicker" placeholder="HH:MM"
                                class="block w-full border-blue-3 rounded-lg shadow-sm focus:border-blue-2 focus:ring focus:ring-blue-4"
                                value="{{ old('time') }}">
                            @error('time')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Location -->
                        <div class="col-span-2">
                            <label for="location" class="block text-sm font-medium text-blue-1 mb-2">Location</label>
                            <input type="text" name="location" id="location" placeholder="Enter Event Location"
                                class="block w-full border-blue-3 rounded-lg shadow-sm focus:border-blue-2 focus:ring focus:ring-blue-4"
                                value="{{ old('location') }}">
                            @error('location')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Image Upload -->
                        <div class="col-span-2 mb-10">
                            <label for="image" class="block text-sm font-medium text-blue-1 mb-2">Event Image</label>
                            <div
                                class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-blue-3 border-dashed rounded-lg">
                                <div class="space-y-1 text-center">
                                    <img id="image-preview" src="" alt="Preview" class="w-full rounded-md mb-4"
                                        style="max-height: 300px; object-fit: cover; display: none;">
                                    <i id="image-placeholder" class="fas fa-image text-4xl text-blue-grey mb-3"></i>
                                    <div class="flex text-sm text-blue-grey justify-center items-center">
                                        <label for="image"
                                            class="relative cursor-pointer bg-white rounded-md font-medium text-blue-2 hover:text-blue-1">
                                            <span>Upload an Image</span>
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


            <!-- Tickets Section -->
            <div class="shadow-lg sm:rounded-lg overflow-hidden mt-10 bg-white">
                <div class="bg-gradient-to-r from-blue-1 to-blue-2 p-10 py-5">
                    <h1 class="text-3xl font-bold text-white"> <i class="fas fa-ticket mr-2"></i> Create Ticket</h1>
                </div>
                <div class="bg-white p-10 pt-2 rounded-lg col-span-2">
                    <div id="tickets-container">
                        <div class="ticket-item">
                            <div class="relative bg-gray-200 shadow-md rounded-lg p-8 pt-4 space-y-4 mt-8">
                                <button type="button"
                                    class="remove-ticket absolute top-5 right-5 text-red-600 hover:text-red-500">
                                    <i class="fas fa-trash"></i>
                                </button>

                                <div class="grid md:grid-cols-3 gap-6">
                                    <div>
                                        <label class="block text-sm font-medium text-blue-1 mb-2">Ticket Name</label>
                                        <input type="text" name="tickets[0][name]" placeholder="Enter Ticket Name"
                                            required
                                            class="block w-full border-blue-3 rounded-lg shadow-sm focus:border-blue-2 focus:ring focus:ring-blue-4">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-blue-1 mb-2">Price</label>
                                        <input type="number" name="tickets[0][price]" placeholder="Enter Ticket Price"
                                            min="0" required
                                            class="block w-full border-blue-3 rounded-lg shadow-sm focus:border-blue-2 focus:ring focus:ring-blue-4">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-blue-1 mb-2">Quota</label>
                                        <input type="number" name="tickets[0][quota]" placeholder="Enter Ticket Quota"
                                            min="1" required
                                            class="block w-full border-blue-3 rounded-lg shadow-sm focus:border-blue-2 focus:ring focus:ring-blue-4">
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-blue-1 mb-2">Description</label>
                                    <input type="text" name="tickets[0][description]"
                                        placeholder="Enter Ticket Description"
                                        class="block w-full border-blue-3 rounded-lg shadow-sm focus:border-blue-2 focus:ring focus:ring-blue-4">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Add Ticket -->
                    <div class="flex justify-end mt-3">
                        <button type="button" id="add-ticket"
                            class="mt-4 bg-gradient-to-r from-blue-1 to-blue-2 text-white px-4 py-2 rounded-lg hover:opacity-90 transition">
                            <i class="fas fa-plus mr-2"></i> Add Ticket
                        </button>
                    </div>
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="flex justify-end gap-x-4 mt-6">
                <button type="button" id="back-button" onclick="window.history.back()"
                    class="bg-red-700 text-white px-6 py-2 rounded-lg hover:bg-red-600 transition">
                    Cancel
                </button>

                <button type="submit"
                    class="bg-gradient-to-r from-blue-1 to-blue-2 text-white px-6 py-2 rounded-lg hover:opacity-90 transition">
                    Create Event
                </button>
            </div>
            </form>
        </div>
    </div>
    </div>

    <script src="{{ asset('scripts/flatpickr.js') }}"></script>
    <script src="{{ asset('scripts/preview-image.js') }}"></script>
    <script src="{{ asset('scripts/create-ticket.js') }}"></script>
@endsection
