@extends('layouts.dashboard')

@section('title', 'Manage Orders')

@section('content')
<div class="mt-10">
    @include('bookings.index')
    {{-- ['title' => 'Manage Events'] --}}
</div>
@endsection