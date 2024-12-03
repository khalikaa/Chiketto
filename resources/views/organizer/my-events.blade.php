@extends('layouts.dashboard')

@section('title', 'My Events')

@section('content')
    @include('layouts.sort-event', ['route' => 'my-events'])

    @if ($allEvents->isEmpty()) 
        <div class="items-center flex justify-center" style="min-height: calc(100vh - 260px);">
            <h2 class="text-xl text-blue-1 font-bold">You have no events yet.</h2>
        </div>
    @elseif ($events->isEmpty()) 
        <div class="items-center flex justify-center" style="min-height: calc(100vh - 260px);">
            <h2 class="text-xl text-blue-1 font-bold">There is no event that matches your filter criteria.</h2>
        </div>
    @else
        <div class="mt-7">
            @include('events.index', ['title' => '', 'hasSidebar' => true])
        </div>
    @endif
@endsection