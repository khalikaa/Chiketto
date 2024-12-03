<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Event') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg p-6">
                <h1 class="text-2xl font-bold mb-6">{{ $event->name }}</h1>

                <div class="space-y-4">
                    <div>
                        <p class="text-gray-600 text-sm">Deskripsi:</p>
                        <p class="text-gray-800">{{ $event->description }}</p>
                    </div>

                    <div>
                        <p class="text-gray-600 text-sm">Tanggal & Waktu:</p>
                        <p class="text-gray-800">
                            {{ \Carbon\Carbon::parse($event->date_time)->format('d/m/Y H:i') }}
                        </p>
                    </div>

                    <div>
                        <p class="text-gray-600 text-sm">Lokasi:</p>
                        <p class="text-gray-800">{{ $event->location }}</p>
                    </div>

                    <div>
                        <p class="text-gray-600 text-sm">Harga Tiket:</p>
                        <p class="text-gray-800">{{ $event->ticket_price }}</p>
                    </div>

                    <div>
                        <p class="text-gray-600 text-sm">Kuota:</p>
                        <p class="text-gray-800">{{ $event->quota }}</p>
                    </div>

                    @if ($event->image_path)
                        <div>
                            <p class="text-gray-600 text-sm">Gambar:</p>
                            <img src="{{ asset('storage/' . $event->image_path) }}" alt="Event Image" class="w-64 h-64 object-cover rounded mt-2">
                        </div>
                    @endif
                </div>

                <div class="mt-6 flex justify-end space-x-4">
                    <a href="{{ route('guest.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>