@extends('layouts.dashboard')

@section('content')
<div class="container mx-auto mt-10 px-6">
    <h1 class="text-3xl font-semibold text-blue-1 mb-6 text-center">Create User</h1>

    <div class="max-w-lg mx-auto bg-white p-6 rounded-lg shadow-md">
        <form action="{{ route('users.store') }}" method="POST">
            @csrf
            <div class="space-y-4">
                <!-- Name Input -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                    <input type="text" id="name" name="name" class="mt-1 block w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400" required>
                </div>

                <!-- Email Input -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" id="email" name="email" class="mt-1 block w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400" required>
                </div>

                <div>
                    <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
                    <select name="role" id="role" class="mt-1 block w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400" required>
                        <option value="organizer">Organizer</option>
                        <option value="customer">Customer</option>
                    </select>
                </div>

                <!-- Password Input -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input type="password" id="password" name="password" class="mt-1 block w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400" required>
                </div>

                <!-- Submit Button -->
                <div class="mt-6">
                    <button type="submit" class="w-full py-3 px-4 bg-blue-1 text-white font-semibold rounded-lg hover:bg-blue-0 focus:outline-none focus:ring-2 focus:ring-blue-400">
                        Create User
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
