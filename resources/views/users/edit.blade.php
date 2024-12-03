@extends('layouts.dashboard')

@section('content')
<div class="container mx-auto mt-10 px-6">
    <h1 class="text-3xl font-semibold text-blue-1 mb-6 text-center">Edit User</h1>

    <div class="max-w-lg mx-auto bg-white p-6 rounded-lg shadow-md">
        <form action="{{ route('users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="space-y-4">

                <!-- Name Input -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                    <input type="text" name="name" id="name" class="mt-1 block w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400" value="{{ $user->name }}" required>
                </div>

                <!-- Email Input -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" id="email" class="mt-1 block w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400" value="{{ $user->email }}" required>
                </div>

                <!-- Role Input (Dropdown) -->
                <div>
                    <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
                    <select name="role" id="role" class="mt-1 block w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400" required>
                        <option value="organizer" {{ $user->role == 'organizer' ? 'selected' : '' }}>Organizer</option>
                        <option value="customer" {{ $user->role == 'customer' ? 'selected' : '' }}>Customer</option>
                    </select>
                </div>

                <!-- Password Input -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input type="password" name="password" id="password" class="mt-1 block w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400">
                    <small class="text-sm text-gray-500">Leave blank to keep current password</small>
                </div>

                <!-- Confirm Password Input -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="mt-1 block w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400">
                    <small class="text-sm text-gray-500">Re-enter the password</small>
                </div>

                <!-- Submit Button -->
                <div class="mt-6">
                    <button type="submit" class="w-full py-3 px-4 bg-blue-1 text-white font-semibold rounded-lg hover:bg-blue-0 focus:outline-none focus:ring-2 focus:ring-blue-400">
                        Update User
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
