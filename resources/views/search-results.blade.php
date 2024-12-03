@extends('layouts.app')

@section('title', 'Explore Events')

@section('content')

@if ($events -> isEmpty())
<div class="items-center flex justify-center" style="min-height: calc(100vh - 136px);">
    <h2 class="text-xl text-blue-1 font-bold">There is no event match your search '{{ $query }}'</h2>
</div>
@else
<div class="mt-10 px-12">
    <h2 class="text-xl text-blue-1 font-bold"> <i class="fas fa-search mr-2"></i>Search result for '{{ $query }}'</h2>
</div>
@include('events.index', ['title' => ''])
@endif
@endsection