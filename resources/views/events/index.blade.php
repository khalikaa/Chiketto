{{-- Event Catalog Section --}}
<div class="px-12 pt-0 pb-20">

    {{-- Session Section --}}
    {{-- @yield('session') --}}
    <div class="container">
        <h2
            class="text-5xl leading-relaxed font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-1 to-grey-1 mb-3">
            {{ $title }}
        </h2>

        {{-- <x-header-text> {{ $title }} </x-header-text> --}}
        @if ($events->isEmpty())        
            <p class="text-blue-1 text-xl">There is no available event</p>
        @else
            <div
                class="grid grid-cols-1  {{ isset($hasSidebar) && $hasSidebar ? 'lg:grid-cols-2 md:grid-cols-1' : 'lg:grid-cols-3 md:grid-cols-2' }} gap-8">
                @foreach ($events as $event)
                    @if (Route::currentRouteName() != 'manage-events' && Route::currentRouteName() != 'my-events')
                        <a href="{{ route('events.show', $event->id) }}">
                    @endif
                    <div
                        class="bg-white rounded-xl shadow-lg overflow-hidden transform hover:-translate-y-2 transition-all duration-300 border-b-4 border-blue-1">
                        <div class="">
                            @if ($event->image_path)
                                <img src="{{ asset('storage/' . $event->image_path) }}" alt="{{ $event->name }}"
                                    class="w-full h-48 object-cover">
                            @else
                                <div class="w-full h-48 bg-blue-5 flex items-center justify-center text-blue-1">
                                    <span class="text-lg text-blue-2 font-semibold">No Image</span>
                                </div>
                            @endif
                            <div
                                class="absolute top-0 right-0 m-3 bg-gradient-to-r text-white px-5 py-1 rounded-xl text-md from-gray-800 to-gray-600">
                                {{ $event->category->name }}
                            </div>
                        </div>

                        <div class="px-6 py-4">
                            <div class="flex justify-between items-center mb-2">
                                <h2 class="text-2xl font-bold text-blue-1">{{ $event->name }}</h2>
                                <p class="text-lg text-gray-500"><i class="fas fa-heart text-red-500 mr-1"></i>
                                    {{ $event->favoritedBy()->count() }}
                                </p>
                            </div>
                            <hr class="border-blue-1">
                            <div>
                                <p class="text-lg text-blue-2 mt-2"><i
                                        class="fas fa-calendar-alt mr-2"></i>{{ \Carbon\Carbon::parse($event->date_time)->format('D, d-m-Y, H:i') }}
                                    WIB</p>
                            </div>
                            <div>
                                <p class="text-lg text-blue-2 mt-1"><i
                                        class="fas fa-map-marker-alt mr-2"></i>{{ $event->location }}</p>
                            </div>
                            <div>
                                <p class="text-lg text-blue-2 mt-1 mb-2"><i class="fas fa-user-tie mr-1"></i>Event by
                                    <strong>{{ $event->organizer_name }}</strong>
                                </p>
                            </div>
                            <hr class="border-blue-1">
                            @if (Route::currentRouteName() === 'manage-events' || Route::currentRouteName() === 'my-events')
                            <div class="flex justify-between">
                                <div class="mt-2">
                                    <p class="text-lg mt-3 text-blue-1 text-right">Tickets starts at
                                        <strong>Rp{{ number_format($event->cheapest_ticket->price, 0, ',', '.') }}</strong>
                                    </p>
                                </div>
                                <div class="flex justify-end gap-x-2 items-center text-lg text-blue-2 mt-4">
                                    <a href="{{ route('events.show', $event->id) }}"
                                        class="text-blue-500  border-blue-500 border px-3 p-2 rounded-lg hover:bg-blue-500 hover:text-white transition flex items-center">
                                        <i class="fas fa-info-circle"></i>
                                    </a>
                                    <a href="{{ route('events.edit', $event->id) }}"
                                        class="text-yellow-500 border border-yellow-500 px-3 p-2 rounded-lg hover:bg-yellow-500 hover:text-white transition flex items-center">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('events.destroy', $event->id) }}" method="POST"
                                        class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="text-red-500 border border-red-500 px-3 p-2 rounded-lg hover:bg-red-500 hover:text-white transition flex items-center">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                                
                            @else
                                <div class="mt-2">
                                    <p class="text-lg mt-3 text-blue-1 text-right">Tickets starts at
                                        <strong>Rp{{ number_format($event->cheapest_ticket->price, 0, ',', '.') }}</strong>
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                    @if (Route::currentRouteName() != 'manage-events' && Route::currentRouteName() != 'my-events')
                        </a>
                    @endif
                @endforeach
            </div>
        @endif
    </div>
</div>
