@extends('layouts.app')

@section('title', 'Explore Events')

@section('content')
@include('layouts.sort-event', ['route' => 'sort.events'])
    @if ($events->isEmpty())
        <div class="items-center flex justify-center" style="min-height: calc(100vh - 230px);">
            <h2 class="text-xl text-blue-1 font-bold">There is no event match your filter</h2>
        </div>
    @else
        @include('events.index', ['title' => ''])
    @endif
    @endsection
