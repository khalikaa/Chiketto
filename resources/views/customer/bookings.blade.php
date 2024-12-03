@extends('layouts.dashboard')

@section('title', 'My Tickets')

@section('content')
<div class="mt-10">
    @include('bookings.index')
</div>
@endsection