@section('title', 'Register')

<x-guest-layout>
    <!-- Register Form Section (Updated) -->
    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required
                autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Role Selection -->
        <div>
            <x-input-label for="role" :value="__('Role')" />
            <select id="role" name="role" required
                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-5 focus:border-blue-5 sm:text-sm">
                <option value="" disabled {{ old('role') == '' ? 'selected' : '' }}>Select role</option>
                <option class="hover:bg-blue-2 py-2" value="customer" {{ old('role') == 'customer' ? 'selected' : '' }}>Customer</option>
                <option value="organizer" {{ old('role') == 'organizer' ? 'selected' : '' }}>Organizer</option>
            </select>
            <x-input-error :messages="$errors->get('role')" class="mt-2" />
        </div>
        

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div>
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Action buttons -->
        <div class="flex items-center justify-between mt-4">
            <x-auth-button>
                {{ __('Register') }}
            </x-auth-button>
        </div>
    </form>

    <div class="mt-8 text-center">
        <p class="text-sm text-gray-600">
            {{ __("Already have an account?") }}
            <a href="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-900">
                {{ __('Log In here') }}
            </a>
        </p>
    </div>
</x-guest-layout>
