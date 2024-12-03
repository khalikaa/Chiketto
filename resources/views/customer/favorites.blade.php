@extends('layouts.dashboard')

@section('title', 'My Favorites')

@section('content')
@if ($events -> isEmpty())
    <div class="items-center flex justify-center" style="min-height: calc(100vh - 180px);">
        <p class="text-2xl font-semibold text-blue-1">You haven't added any event to your favorites yet.</p>
    </div>
@else
<div class="mt-10">
    @include('events.index', ['title' => '', 'hasSidebar' => true])
</div>
@endif
@endsection