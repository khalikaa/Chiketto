@extends('layouts.dashboard')

@section('content')
    <div class="container px-12 pt-12 pb-18">
        <div class="overflow-x-auto rounded-lg">
            <div class="flex justify-between items-center pt-3 pb-6">
                <h1 class="text-3xl font-semibold text-blue-1">User List</h1>
                <a href="{{ route('users.create') }}"
                    class="inline-block bg-blue-1 text-white px-6 py-2 rounded-lg hover:bg-blue-0 focus:outline-none focus:ring-2 focus:ring-blue-400">
                    <i class="fas fa-plus mr-2"></i>Add User
                </a>
            </div>
            <table class="min-w-full table-auto bg-white">
                <thead class="bg-gradient-to-r from-blue-1 to-blue-2 text-white">
                    <tr>
                        <th class="px-4 py-3 text-left">ID</th>
                        <th class="px-4 py-3 text-left">Name</th>
                        <th class="px-4 py-3 text-left">Email</th>
                        <th class="px-4 py-3 text-left">Role</th>
                        <th class="px-4 py-3 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr class="border-b hover:bg-blue-50">
                            <td class="px-4 py-3">{{ $user->id }}</td>
                            <td class="px-4 py-3">{{ $user->name }}</td>
                            <td class="px-4 py-3">{{ $user->email }}</td>
                            <td class="px-4 py-3">{{ $user->role }}</td>
                            <td class="px-4 py-3 text-center">
                                <a href="{{ route('users.show', $user->id) }}"
                                    class="inline-block border border-blue-600 text-blue-600 px-4 py-2 rounded-lg text-sm hover:bg-blue-600 hover:text-white">
                                    <i class="fas fa-info-circle mr-1"></i>View</a>
                                <a href="{{ route('users.edit', $user->id) }}"
                                    class="inline-block border border-yellow-600 text-yellow-600 px-4 py-2 rounded-lg text-sm hover:bg-yellow-500 hover:text-white"><i
                                        class="fas fa-edit mr-1"></i>Edit</a>
                                <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="inline-block border border-red-600 text-red-600 px-4 py-2 rounded-lg text-sm hover:bg-red-600 hover:text-white">
                                        <i class="fas fa-trash mr-1"></i>Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
