@extends('layouts.app')

@section('title', 'Explore Events')

@section('content')

    <div class="flex flex-col lg:flex-row justify-between items-center px-12 pt-8 mb-5 text-blue-1">
        <h2 class="text-2xl font-bold lg:mb-5">Filter Event</h2>
        <div>
            <form method="GET" action="{{ route('sort.events') }}" class="lg:flex gap-2">
                <!-- Filter Kategori -->
                <select name="category" class="pl-4 py-2 rounded-lg border border-blue-1 focus:ring-blue-2">
                    <option value="">All Categories</option>
                    @foreach ($category as $cat)
                        <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>

                <!-- Filter Lokasi -->
                <input type="text" name="location" value="{{ request('location') }}" placeholder="Location"
                    class="pl-4 py-2 rounded-lg border border-blue-1">

                <!-- Sorting -->
                <select name="sort_by_price" class="pl-4 py-2 rounded-lg border border-blue-1">
                    <option value="">Sort By Price</option>
                    <option value="price_asc" {{ request('sort_by_price') == 'price_asc' ? 'selected' : '' }}>Low to High
                    </option>
                    <option value="price_desc" {{ request('sort_by_price') == 'price_desc' ? 'selected' : '' }}>High to Low
                    </option>
                </select>

                <select name="sort_by" class="pl-4 py-2 rounded-lg border border-blue-1">
                    <option value="">Sort By Date</option>
                    <option value="date_asc" {{ request('sort_by_date') == 'date_asc' ? 'selected' : '' }}>Oldest</option>
                    <option value="date_desc" {{ request('sort_by_date') == 'date_desc' ? 'selected' : '' }}>Newest</option>
                </select>

                <!-- Tombol Submit -->
                <button type="submit" class="px-4 py-2 bg-blue-1 text-white rounded-lg hover:bg-blue-0">Filter</button>
            </form>
        </div>
    </div>
    @include('events.index', ['title' => ''])
@endsection
