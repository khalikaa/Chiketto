@extends('layouts.app')

@section('content')
    {{-- Top Events Section --}}
    @include('events.index', ['events' => $topEvents], ['title' => 'Our Top Events'])

    {{-- Recently Added Events Section --}}
    @include('events.index', ['events' => $recentEvents], ['title' => 'Recently Added Events'])

@endsection