@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-blue-1 leading-tight">
        {{ __('Create New Event') }}
    </h2>
@endsection

@section('content')
    <div class="py-12 bg-grey-1">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg sm:rounded-lg overflow-hidden">
                <div class="bg-gradient-to-r from-blue-1 to-blue-2 p-8 py-3">
                    <h1 class="text-3xl font-bold text-white">Create New Event</h1>
                </div>

                <form action="{{ route('events.store') }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-6">
                    @csrf

                    <!-- Event Information -->
                    <div class="grid md:grid-cols-2 gap-6">
                        <!-- Event Name -->
                        <div class="col-span-2">
                            <label for="name" class="block text-sm font-medium text-blue-1 mb-2">Event Name</label>
                            <input type="text" name="name" id="name"
                                class="block w-full border-blue-3 rounded-lg shadow-sm focus:border-blue-2 focus:ring focus:ring-blue-4"
                                value="{{ old('name') }}">
                            @error('name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="organizer_name" class="block text-sm font-medium text-blue-1 mb-2">Organizer
                                Name</label>
                            <input type="text" name="organizer_name" id="organizer_name"
                                class="block w-full border-blue-3 rounded-lg shadow-sm focus:border-blue-2 focus:ring focus:ring-blue-4"
                                value="{{ old('organizer_name') }}">
                            @error('organizer_name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Category -->
                        <div>
                            <label for="category_id" class="block text-sm font-medium text-blue-1 mb-2">Category</label>
                            <select name="category_id" id="category_id"
                                class="block w-full border-blue-3 rounded-lg shadow-sm focus:border-blue-2 focus:ring focus:ring-blue-4">
                                <option value="">Select Category</option>

                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="col-span-2">
                            <label for="description" class="block text-sm font-medium text-blue-1 mb-2">Description</label>
                            <textarea name="description" id="description" rows="4"
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
                            <input type="text" name="time" id="timePicker"
                                class="block w-full border-blue-3 rounded-lg shadow-sm focus:border-blue-2 focus:ring focus:ring-blue-4"
                                value="{{ old('time') }}">
                            @error('time')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Location -->
                        <div class="col-span-2">
                            <label for="location" class="block text-sm font-medium text-blue-1 mb-2">Location</label>
                            <input type="text" name="location" id="location"
                                class="block w-full border-blue-3 rounded-lg shadow-sm focus:border-blue-2 focus:ring focus:ring-blue-4"
                                value="{{ old('location') }}">
                            @error('location')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="col-span-2 mb-10">
                            <label for="image" class="block text-sm font-medium text-blue-1 mb-2">Event Image</label>
                            <div
                                class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-blue-3 border-dashed rounded-lg">
                                <div class="space-y-1 text-center">
                                    <!-- Cropping Area -->
                                    <div id="cropping-area" style="display: none; max-height: 320px; overflow: hidden;">
                                        <img id="cropping-image" class="rounded-md" src="" alt="Crop Preview">
                                    </div>

                                    <!-- Image Preview -->
                                    <div class="relative">

                                        <img id="image-preview" class="hidden max-w-full h-auto rounded-lg" alt="Preview">
                                        <input type="file" id="image" name="image" class="hidden" accept="image/*"
                                            onchange="previewImage(event)">
                                    </div>

                                    <!-- Input File -->
                                    <div class="flex text-sm text-blue-grey justify-center items-center">
                                        <label for="image"
                                            class="cursor-pointer bg-white rounded-md font-medium text-blue-2 hover:text-blue-1">
                                            <input id="image" name="image" type="file" class="sr-only"
                                                accept="image/*" onchange="previewImage(event)">
                                            <div id="image-placeholder">
                                                <i class="fas fa-image text-4xl text-blue-grey mb-3"></i>
                                                <p class="text-blue-1 text-sm" id="upload-text">Upload an image</p>
                                                <p class="text-xs text-blue-grey">PNG, JPG up to 10MB</p>
                                            </div>
                                        </label>
                                    </div>

                                    <!-- Crop and Save Buttons -->
                                    <div id="crop-buttons" class="flex justify-center space-x-4 mt-3"
                                        style="display: none;">
                                        <button type="button" id="crop-image"
                                            class="bg-gradient-to-r from-blue-1 to-blue-2 text-white px-4 py-2 rounded-lg hover:opacity-90 transition">
                                            Save Image
                                        </button>
                                        <button type="button" id="cancel-crop"
                                            class="bg-red-700 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition">
                                            Cancel
                                        </button>
                                    </div>

                                    <!-- Edit Image Button -->
                                    <button id="edit-image"
                                        class="bg-gradient-to-r from-blue-1 to-blue-2 text-white px-4 py-2 rounded-lg hover:opacity-90 transition mt-3"
                                        style="display: none;">
                                        Edit Image
                                    </button>

                                    <button id="change-image"
                                        class="bg-gradient-to-r from-blue-1 to-blue-2 text-white px-4 py-2 rounded-lg hover:opacity-90 transition mt-3"
                                        style="display: none;">
                                        Change Image
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Tickets Section -->
                        <div class="bg-grey-1 p-6 rounded-lg col-span-2">
                            <h3 class="text-lg font-medium text-blue-1">Tickets</h3>

                            <div id="tickets-container">
                                <!-- Loop through the tickets dynamically -->
                                <div class="ticket-item">
                                    <div class="relative bg-white shadow-md rounded-lg p-6 mt-4 space-y-4">
                                        <button type="button"
                                            class="absolute top-5 right-5 text-red-500 hover:text-red-700 remove-ticket">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>

                                        <div class="grid md:grid-cols-3 gap-6">
                                            <div>
                                                <label class="block text-sm font-medium text-blue-1 mb-2">Ticket
                                                    Name</label>
                                                <input type="text" name="tickets[0][name]"
                                                    class="block w-full border-blue-3 rounded-lg shadow-sm focus:border-blue-2 focus:ring focus:ring-blue-4">
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-blue-1 mb-2">Price</label>
                                                <input type="number" name="tickets[0][price]"
                                                    class="block w-full border-blue-3 rounded-lg shadow-sm focus:border-blue-2 focus:ring focus:ring-blue-4">
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-blue-1 mb-2">Quota</label>
                                                <input type="number" name="tickets[0][quota]"
                                                    class="block w-full border-blue-3 rounded-lg shadow-sm focus:border-blue-2 focus:ring focus:ring-blue-4">
                                            </div>
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-blue-1 mb-2">Description</label>
                                            <input type="text" name="tickets[0][description]"
                                                class="block w-full border-blue-3 rounded-lg shadow-sm focus:border-blue-2 focus:ring focus:ring-blue-4">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Add Ticket -->
                            <button type="button" id="add-ticket"
                                class="mt-4 bg-gradient-to-r from-blue-1 to-blue-2 text-white px-4 py-2 rounded-lg hover:opacity-90 transition">
                                + Add Ticket
                            </button>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="mt-8 text-center">
                        <button type="submit"
                            class="bg-gradient-to-r from-blue-1 to-blue-2 text-white px-6 py-3 rounded-lg hover:opacity-90 transition">
                            Save Event
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('add-ticket').addEventListener('click', function() {
            const ticketItem = document.querySelector('.ticket-item').cloneNode(true);
            const ticketsContainer = document.getElementById('tickets-container');
            const index = ticketsContainer.children.length;
            ticketItem.querySelectorAll('input').forEach(input => {
                input.name = input.name.replace(/\[\d+\]/, `[${index}]`);
            });
            ticketsContainer.appendChild(ticketItem);
        });

        document.getElementById('tickets-container').addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-ticket')) {
                e.target.closest('.ticket-item').remove();
            }
        });

        let cropper;
        let lastCroppedImageURL = "";
        const imageInput = document.getElementById('image');
        const imagePreview = document.getElementById('image-preview');
        const croppingArea = document.getElementById('cropping-area');
        const croppingImage = document.getElementById('cropping-image');
        const cropButtons = document.getElementById('crop-buttons');
        const editImageButton = document.getElementById('edit-image');
        const changeImageButton = document.getElementById('change-image');
        const imagePlaceholder = document.getElementById('image-placeholder');

        // Fungsi untuk menginisialisasi Cropper.js
        function initCropper() {
            if (cropper) cropper.destroy();
            cropper = new Cropper(croppingImage, {
                aspectRatio: 710 / 320,
                viewMode: 1,
                autoCropArea: 1,
                scalable: true,
                zoomable: true,
            });
            croppingArea.style.display = 'block';
            cropButtons.style.display = 'flex';
            imagePreview.style.display = 'none';
            editImageButton.style.display = 'none';
            changeImageButton.style.display = 'none';
        }

        // Ketika file diubah
        imageInput.addEventListener('change', (event) => {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    croppingImage.src = e.target.result;
                    croppingImage.onload = function() {
                        initCropper();
                    };
                };
                reader.readAsDataURL(file);

                imagePlaceholder.style.display = 'none';
            }
        });

        // Ketika tombol Crop ditekan
        document.getElementById('crop-image').addEventListener('click', () => {
            const canvas = cropper.getCroppedCanvas({
                width: 710,
                height: 320,
            });

            canvas.toBlob((blob) => {
        // Create a File object from the blob
        const file = new File([blob], "cropped_image.jpg", {
            type: "image/jpeg",
            lastModified: new Date().getTime()
        });

        // Create a new FileList containing the File object
        const dataTransfer = new DataTransfer();
        dataTransfer.items.add(file);

        // Update the file input with the new FileList
        const fileInput = document.querySelector('input[name="image"]');
        fileInput.files = dataTransfer.files;

        // Update preview
        const url = URL.createObjectURL(blob);
        lastCroppedImageURL = url;
        imagePreview.src = url;
        imagePreview.style.display = 'block';
        croppingArea.style.display = 'none';
        cropButtons.style.display = 'none';
        editImageButton.style.display = 'inline-block';
        changeImageButton.style.display = 'inline-block';

        // Log to verify file attachment
        console.log('File attached:', fileInput.files[0]);
    }, 'image/jpeg', 0.8); // 0.8 quality
});
        //     canvas.toBlob((blob) => {
        //         const url = URL.createObjectURL(blob);
        //         lastCroppedImageURL = url; // Simpan gambar terakhir yang di-crop
        //         imagePreview.src = url;
        //         imagePreview.style.display = 'block';
        //         croppingArea.style.display = 'none';
        //         cropButtons.style.display = 'none';
        //         editImageButton.style.display = 'inline-block';
        //         changeImageButton.style.display = 'inline-block';

        //         // Update input file dengan hasil crop
        //         const file = new File([blob], "cropped_image.jpg", {
        //             type: "image/jpeg"
        //         });
        //         const dataTransfer = new DataTransfer();
        //         dataTransfer.items.add(file);
        //         imageInput.files = dataTransfer.files;
        // });

        // Ketika tombol Cancel ditekan
        document.getElementById('cancel-crop').addEventListener('click', () => {
            if (lastCroppedImageURL) {
                // Kembalikan ke gambar terakhir yang di-crop
                imagePreview.src = lastCroppedImageURL;
                imagePreview.style.display = 'block';
                croppingArea.style.display = 'none';
                cropButtons.style.display = 'none';
                editImageButton.style.display = 'inline-block';
                changeImageButton.style.display = 'inline-block';
            } else {
                // Jika tidak ada gambar sebelumnya, tampilkan placeholder
                imagePreview.style.display = 'none';
                croppingArea.style.display = 'none';
                cropButtons.style.display = 'none';
                imagePlaceholder.style.display = 'block';
                editImageButton.style.display = 'none';
                changeImageButton.style.display = 'none';
            }
        });

        // Ketika tombol Edit Image ditekan
        editImageButton.addEventListener('click', () => {
            event.preventDefault();
            croppingImage.src = lastCroppedImageURL; // Set ulang ke gambar terakhir yang di-crop
            croppingArea.style.display = 'block';
            cropButtons.style.display = 'flex';
            imagePreview.style.display = 'none';
            editImageButton.style.display = 'none';
            initCropper();
        });

        // Ketika tombol Change Image ditekan
        changeImageButton.addEventListener('click', () => {
            event.preventDefault();
            croppingArea.style.display = 'none';
            cropButtons.style.display = 'none';
            imagePreview.style.display = 'none';
            editImageButton.style.display = 'none';
            changeImageButton.style.display = 'none';
            imagePlaceholder.style.display = 'block';

            imageInput.value = ''; // Kosongkan input file
            imageInput.click(); // Trigger klik untuk memilih file baru
        });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
@endsection
