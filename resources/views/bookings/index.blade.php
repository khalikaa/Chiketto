<div class="max-w-4xl mx-auto py-6 space-y-6">
    <div class="flex space-x-2 mb-4">
        <a href="{{ route('bookings.index', ['status' => 'all']) }}"
            class="px-4 py-2 rounded-lg hover:bg-blue-1 hover:text-white transition {{ $status === 'all' ? 'bg-blue-1 text-white' : 'border border-blue-1 text-blue-1' }}">
            All Status
        </a>
        <a href="{{ route('bookings.index', ['status' => 'canceled']) }}"
            class="px-4 py-2 rounded-lg hover:bg-blue-1 hover:text-white transition {{ $status === 'canceled' ? 'bg-blue-1 text-white' : 'border border-blue-1 text-blue-1' }}">
            Canceled
        </a>
        <a href="{{ route('bookings.index', ['status' => 'pending']) }}"
            class="px-4 py-2 rounded-lg hover:bg-blue-1 hover:text-white transition {{ $status === 'pending' ? 'bg-blue-1 text-white' : 'border border-blue-1 text-blue-1' }}">
            Pending
        </a>
        <a href="{{ route('bookings.index', ['status' => 'active']) }}"
            class="px-4 py-2 rounded-lg hover:bg-blue-1 hover:text-white transition {{ $status === 'active' ? 'bg-blue-1 text-white' : 'border border-blue-1 text-blue-1' }}">
            Active
        </a>
    </div>
    @if ($bookings->isEmpty())
        @if ($status != 'all')
            <p class="text-lg pt-8 text-blue-1 text-center">There is no {{ $status }} booking</p>
        @else
            <p class="text-lg pt-8 text-blue-1 text-center">There is no booking</p>
        @endif
    @endif
    @foreach ($bookings as $booking)
        <div class="flex bg-white shadow-md rounded-lg overflow-hidden h-80">
            <!-- Event Image -->
            <div class="w-2/3 relative">
                <img src="{{ asset('storage/' . $booking->event->image_path) }}" alt="{{ $booking->event->name }}"
                    class="w-full h-full object-cover"> </img>
            </div>

            <!-- Booking Information -->
            <div class="w-1/3 p-6">
                <!-- Header -->
                <div class="flex justify-end items-center">
                    <p
                        class="px-4 py-1 text-sm rounded-lg font-bold w-max 
                    {{ $booking->status === 'active'
                        ? 'bg-green-100 text-green-800 border border-green-800'
                        : ($booking->status === 'canceled'
                            ? 'bg-red-100 text-red-800 border border-red-800'
                            : 'bg-yellow-100 text-yellow-800 border border-yellow-800') }}">
                        {{ ucfirst($booking->status) }}
                    </p>
                </div>


                <!-- Event Date & Total Transaction -->
                <div>
                    <div>
                        <h3 class="mt-5 text-xl font-bold text-blue-1 truncate">{{ $booking->event->name }}</h3>
                        <p class="text-md text-blue-1">
                            {{ \Carbon\Carbon::parse($booking->event->date_time)->format('l, d F Y') }}
                        </p>
                        <p class="text-lg font-bold text-blue-1">
                            <i class="fas fa-ticket"></i> {{ $booking->bookingDetail->count() }} Tickets Ordered
                        </p>
                    </div>
                    <div>
                        <p class="text-right font-medium text-md text-blue-1 mt-12">Total Transaction:</p>
                        <p class="text-lg text-right font-bold text-blue-1">
                            Rp{{ number_format(
                                $booking->bookingDetail ? $booking->bookingDetail->sum(fn($detail) => optional($detail->ticket)->price) : 0,
                                0,
                                ',',
                                '.',
                            ) }}
                        </p>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center space-x-1 justify-between mt-3">
                    @if ((Auth::id() === $booking->event->user_id || Auth::user()->role === 'admin') && $booking->status === 'pending')
                        <form action="{{ route('bookings.accept', $booking->id) }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="border border-green-600 text-green-600 p-2 rounded-lg text-sm">
                                <i class="fas fa-check-circle mr-[1px]"></i> Accept
                            </button>
                        </form>
                        <form action="{{ route('bookings.cancel', $booking->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="border border-red-600 text-red-600 p-2 rounded-lg text-sm">
                                <i class="fas fa-times-circle mr-[1px]"></i> Cancel
                            </button>
                        </form>
                    @endif
                    <a href="{{ route('bookings.show', $booking->id) }}"
                        class="border border-blue-600 text-blue-600 p-2 rounded-lg text-sm">
                        Details <i class="ml-[1px] fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    @endforeach
