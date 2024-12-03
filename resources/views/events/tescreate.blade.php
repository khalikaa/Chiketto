@exte
    <div class="py-12 bg-grey-1">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg sm:rounded-lg overflow-hidden">
                <div class="bg-gradient-to-r from-blue-1 to-blue-2 p-6">
                    <h1 class="text-3xl font-bold text-white">Create New Event</h1>
                </div>

                <form action="{{ route('events.store') }}" method="POST" enctype="multipart/form-data"
                    class="p-8 space-y-6">
                    @csrf

                    <!-- Event Information -->
                    <div class="grid md:grid-cols-2 gap-6">
                        <!-- Event Name -->
                        <div class="col-span-2">
                            <label for="name" class="block text-sm font-medium text-blue-1 mb-2">Event Name</label>
                            <input type="text" name="name" id="name"
                                class="block w-full border-blue-3 rounded-lg shadow-sm focus:border-blue-2 focus:ring focus:ring-blue-4"
                                value="{{ old('name') }}" required>
                            @error('name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="organizer_name" class="block text-sm font-medium text-blue-1 mb-2">Organizer Name</label>
                            <input type="text" name="organizer_name" id="organizer_name"
                                class="block w-full border-blue-3 rounded-lg shadow-sm focus:border-blue-2 focus:ring focus:ring-blue-4"
                                value="{{ old('organizer_name') }}" required>
                            @error('organizer_name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Category -->
                        <div>
                            <label for="category_id" class="block text-sm font-medium text-blue-1 mb-2">Category</label>
                            <select name="category_id" id="category_id"
                                class="block w-full border-blue-3 rounded-lg shadow-sm focus:border-blue-2 focus:ring focus:ring-blue-4"
                                required>
                                <option value="">Select Category</option>
                                
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="col-span-2">
                            <label for="description"
                                class="block text-sm font-medium text-blue-1 mb-2">Description</label>
                            <textarea name="description" id="description" rows="4"
                                class="block w-full border-blue-3 rounded-lg shadow-sm focus:border-blue-2 focus:ring focus:ring-blue-4" required>{{ old('description') }}</textarea>
                            @error('description')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="date" class="block text-sm font-medium text-blue-1 mb-2">Date</label>
                            <input type="text" name="date" id="date"
                                class="block w-full border-blue-3 rounded-lg shadow-sm focus:border-blue-2 focus:ring focus:ring-blue-4"
                                placeholder="DD/MM/YYYY" value="{{ old('date') }}" required>
                            @error('date')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="time" class="block text-sm font-medium text-blue-1 mb-2">Time</label>
                            <input type="text" name="time" id="timePicker"
                                class="block w-full border-blue-3 rounded-lg shadow-sm focus:border-blue-2 focus:ring focus:ring-blue-4"
                                value="{{ old('time') }}" required>
                            @error('time')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Location -->
                        <div class="col-span-2">
                            <label for="location" class="block text-sm font-medium text-blue-1 mb-2">Location</label>
                            <input type="text" name="location" id="location"
                                class="block w-full border-blue-3 rounded-lg shadow-sm focus:border-blue-2 focus:ring focus:ring-blue-4"
                                value="{{ old('location') }}" required>
                            @error('location')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Image Upload -->
                        <div class="col-span-2">
                            <label for="image" class="block text-sm font-medium text-blue-1 mb-2">Event Image</label>
                            <div
                                class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-blue-3 border-dashed rounded-lg">
                                <div class="space-y-1 text-center">
                                    <img id="image-preview" src="" alt="Preview" class="w-full rounded-md mb-4"
                                        style="max-height: 300px; object-fit: cover; display: none;">
                                    <i id="image-placeholder" class="fas fa-image text-4xl text-blue-grey mb-3"></i>
                                    <div class="flex text-sm text-blue-grey">
                                        <label for="image"
                                            class="relative cursor-pointer bg-white rounded-md font-medium text-blue-2 hover:text-blue-1">
                                            {{-- atur biar cakep dah --}}
                                            <span>Upload an image</span>
                                            <input id="image" name="image" type="file" class="sr-only"
                                                accept="image/*" required onchange="previewImage(event)">
                                        </label>
                                    </div>
                                    <p class="text-xs text-blue-grey">PNG, JPG up to 10MB</p>
                                </div>
                            </div>
                            @error('image')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tickets Section -->
                        <div class="bg-grey-1 p-6 rounded-lg col-span-2">
                            <h3 class="text-lg font-medium text-blue-1">Tickets</h3>

                            <div x-data="{ tickets: [{ name: '', price: '', quota: '', description: '' }] }">
                                <!-- Loop Tiket -->
                                <template x-for="(ticket, index) in tickets" :key="index">
                                    <div class="relative bg-white shadow-md rounded-lg p-6 mt-4 space-y-4">

                                        <!-- Hapus Tiket -->
                                        <button type="button" @click="tickets.splice(index, 1)"
                                            class="absolute top-5 right-5 text-red-500 hover:text-red-700"
                                            x-show="tickets.length > 1">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>

                                        <div class="grid md:grid-cols-3 gap-6">
                                            <!-- Ticket Name -->
                                            <div>
                                                <label class="block text-sm font-medium text-blue-1 mb-2">Ticket
                                                    Name</label>
                                                <input type="text" x-model="ticket.name"
                                                    :name="'tickets[' + index + '][name]'"
                                                    class="block w-full border-blue-3 rounded-lg shadow-sm focus:border-blue-2 focus:ring focus:ring-blue-4"
                                                    required>
                                            </div>
                                            <!-- Ticket Price -->
                                            <div>
                                                <label class="block text-sm font-medium text-blue-1 mb-2">Price</label>
                                                <input type="number" x-model="ticket.price"
                                                    :name="'tickets[' + index + '][price]'"
                                                    class="block w-full border-blue-3 rounded-lg shadow-sm focus:border-blue-2 focus:ring focus:ring-blue-4"
                                                    required>
                                            </div>
                                            <!-- Ticket Quota -->
                                            <div>
                                                <label class="block text-sm font-medium text-blue-1 mb-2">Quota</label>
                                                <input type="number" x-model="ticket.quota"
                                                    :name="'tickets[' + index + '][quota]'"
                                                    class="block w-full border-blue-3 rounded-lg shadow-sm focus:border-blue-2 focus:ring focus:ring-blue-4"
                                                    required>
                                            </div>
                                        </div>
                                        <!-- Ticket Description -->
                                        <div>
                                            <label
                                                class="block text-sm font-medium text-blue-1 mb-2">Description</label>
                                            <input type="text" x-model="ticket.description"
                                                :name="'tickets[' + index + '][description]'"
                                                class="block w-full border-blue-3 rounded-lg shadow-sm focus:border-blue-2 focus:ring focus:ring-blue-4"
                                                >
                                        </div>
                                    </div>
                                </template>

                                <!-- Tambah Tiket -->
                                <button type="button"
                                    @click="tickets.push({ name: '', price: '', quota: '', description: '' })"
                                    class="mt-4 bg-gradient-to-r from-blue-1 to-blue-2 text-white px-4 py-2 rounded-lg hover:opacity-90 transition">
                                    + Add Ticket
                                </button>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="col-span-2 flex justify-end space-x-4">
                            <a href="{{ route('events.index') }}"
                                class="bg-blue-grey text-white px-6 py-2 rounded-lg hover:bg-grey-2 transition">
                                Cancel
                            </a>
                            <button type="submit"
                                class="bg-gradient-to-r from-blue-1 to-blue-2 text-white px-6 py-2 rounded-lg hover:opacity-90 transition">
                                Save Event
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

<script src="{{ asset('scripts/event.js') }}"></script>
