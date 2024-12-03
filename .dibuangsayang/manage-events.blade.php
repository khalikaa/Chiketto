{{-- harus ttp dibuatkan controller utk halaman ini soalnya extends itu cm ambil tampilannya, logikannya egk ngikut --}}
@extends('events.index')
@section('title', 'Manage Event')

@section('add_event')
    <a href="{{ route('events.create') }}"
        class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 mb-6 inline-block">
        Buat Event Baru
    </a>

    @if (session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6">
            {{ session('success') }}
        </div>
    @endif

@section('edit_delete')
    <a href="{{ route('events.edit', $event->id) }}" class="text-yellow-500 hover:underline">Edit</a>
    <form action="{{ route('events.destroy', $event->id) }}" method="POST" class="inline-block">
        @csrf
        @method('DELETE')
        <button type="submit" class="text-red-500 hover:underline">Delete</button>
    </form>
@endsection

{{-- bisa ternyata di index sj kau atur return viewnya, kasihkan sj kondisi --}}
