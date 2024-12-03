@extends('layouts.app')

@section('title', 'Explore Events')

@section('content')
@include('events.index', ['title' => 'Discover Upcoming Events'])
@endsection