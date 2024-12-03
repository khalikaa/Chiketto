@extends('layouts.dashboard')

@section('content')
<div class="container mx-auto mt-10 px-12">
    <h1 class="text-3xl font-semibold text-blue-1 mb-6">User Details</h1>

    <div class="max-w-3xl bg-white p-6 rounded-lg shadow-md">
        <div class="mb-4">
            <h2 class="text-2xl font-semibold text-blue-1">{{ $user->name }}</h2>
        </div>
        <div class="space-y-4">
            <p><strong class="font-bold text-gray-700">Email:</strong> <span class="text-gray-500">{{ $user->email }}</span></p>
            <p><strong class="font-bold text-gray-700">Role:</strong> <span class="text-gray-500">{{ $user->role }}</span></p>
            <p><strong class="font-bold text-gray-700">Created At:</strong> <span class="text-gray-500">{{ $user->created_at->format('d M Y, H:i') }}</span></p>
            <p><strong class="font-bold text-gray-700">Updated At:</strong> <span class="text-gray-500">{{ $user->updated_at->format('d M Y, H:i') }}</span></p>
        </div>
    </div>

    <div class="mt-6">
        <a href="{{ route('users.index') }}" class="inline-block bg-blue-1 text-white px-6 py-2 rounded-lg hover:bg-blue-0 focus:outline-none focus:ring-2 focus:ring-blue-400">
            Back to User List
        </a>
    </div>
</div>
@endsection
