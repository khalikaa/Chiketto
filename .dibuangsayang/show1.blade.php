
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-blue-1 leading-tight">
            {{ __('Event Details') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-grey-1">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg sm:rounded-lg overflow-hidden">
                <!-- Header -->
                <div class="bg-gradient-to-r from-blue-1 to-blue-2 p-6">
                    <h1 class="text-3xl font-bold text-white">{{ $event->name }}</h1>
                    <p class="text-white mt-2">{{ $event->description }}</p>
                </div>

                <!-- Event Image -->
                <div class="p-6">
                    <img src="{{ asset('storage/' . $event->image_path) }}" alt="Event Image"
                        class="w-16 h-16 object-cover">
                </div>

                <!-- Event Information -->
                <div class="px-8 py-6 space-y-6">
                    <!-- Organizer and Category -->
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-lg font-medium text-blue-1">Organizer</h3>
                            <p class="text-grey-700">{{ $event->organizer_name }}</p>
                        </div>
                        <div>
                            <h3 class="text-lg font-medium text-blue-1">Category</h3>
                            <p class="text-grey-700">{{ $event->category->name ?? 'No Category' }}</p>
                        </div>
                    </div>

                    <!-- Date and Time -->
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-lg font-medium text-blue-1">Date</h3>
                            <p class="text-grey-700">{{ \Carbon\Carbon::parse($event->date_time)->format('l, d F Y') }}
                            </p>
                        </div>
                        <div>
                            <h3 class="text-lg font-medium text-blue-1">Time</h3>
                            <p class="text-grey-700">{{ \Carbon\Carbon::parse($event->date_time)->format('H:i') }}</p>
                        </div>
                    </div>

                    <!-- Location -->
                    <div>
                        <h3 class="text-lg font-medium text-blue-1">Location</h3>
                        <p class="text-grey-700">{{ $event->location }}</p>
                    </div>
                </div>

                <!-- Tickets Section -->
                <div class="bg-grey-1 p-6">
                    <h3 class="text-xl font-bold text-blue-1">Tickets</h3>
                    <div class="space-y-4 mt-4">
                        @foreach ($event->tickets as $ticket)
                            <div class="bg-white p-6 rounded-lg shadow-md">
                                <div class="grid md:grid-cols-3 gap-6">
                                    <!-- Ticket Name -->
                                    <div>
                                        <h4 class="text-lg font-medium text-blue-1">Ticket Name</h4>
                                        <p class="text-grey-700">{{ $ticket->name }}</p>
                                    </div>
                                    <!-- Price -->
                                    <div>
                                        <h4 class="text-lg font-medium text-blue-1">Price</h4>
                                        <p class="text-grey-700">Rp {{ number_format($ticket->price, 0, ',', '.') }}
                                        </p>
                                    </div>
                                    <!-- Quota -->
                                    <div>
                                        <h4 class="text-lg font-medium text-blue-1">Quota</h4>
                                        <p class="text-grey-700">{{ $ticket->quota }} tickets</p>
                                    </div>
                                </div>
                                <!-- Description -->
                                <div class="mt-4">
                                    <h4 class="text-lg font-medium text-blue-1">Description</h4>
                                    <p class="text-grey-700">{{ $ticket->description }}</p>
                                </div>
                                <div>
                                    <button class="w-8 bg-gray-700 text-white px-2 py-1 rounded-l-lg"
                                        onclick="updateQuantity('quantity-{{ $ticket->id }}', -1)">-</button>
                                    <input type="number" id="quantity-{{ $ticket->id }}" value="0" style="appearance: none; -moz-appearance: none; -webkit-appearance: none;" 
                                        min="0" class="w-12 px-2 py-1 text-center text-gray-700 appearance-none">
                                    <button class="w-8 bg-gray-700 text-white px-2 py-1 rounded-r-lg"
                                        onclick="updateQuantity('quantity-{{ $ticket->id }}', 1)">+</button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Back Button -->
                <div class="px-8 py-6">
                    <a href="{{ route('events.index') }}"
                        class="bg-gradient-to-r from-blue-1 to-blue-2 text-white px-6 py-2 rounded-lg hover:opacity-90 transition">
                        Back to Events
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    function updateQuantity(inputId, delta) {
        // Dapatkan elemen input berdasarkan ID
        const inputElement = document.getElementById(inputId);

        // Parsing nilai saat ini dari input
        let currentValue = parseInt(inputElement.value) || 0;

        // Update nilai dengan delta
        currentValue += delta;

        // Validasi agar nilai tidak kurang dari 0
        if (currentValue < 0) {
            currentValue = 0;
        }

        // Update nilai input
        inputElement.value = currentValue;
    }

        //     function redirectToBookingForm() {
    //     const selectedTickets = [];
    //     document.querySelectorAll("input[name^='tickets']").forEach(input => {
    //         const ticketQuantity = parseInt(input.value) || 0;
    //         if (ticketQuantity > 0) {
    //             selectedTickets.push({
    //                 id: input.name.match(/\d+/)[0],
    //                 quantity: ticketQuantity
    //             });
    //         }
    //     });

    //     if (selectedTickets.length === 0) {
    //         alert('Please select at least one ticket.');
    //         return;
    //     }

    //     const form = document.createElement('form');
    //     form.method = 'GET';
    //     form.action = "{{ route('bookings.create') }}";
    //     selectedTickets.forEach(ticket => {
    //         form.innerHTML += `<input type="hidden" name="tickets[${ticket.id}]" value="${ticket.quantity}">`;
    //     });
    //     form.innerHTML += `<input type="hidden" name="event_id" value="{{ $event->id }}">`;
    //     document.body.appendChild(form);
    //     form.submit();
    // }
</script>