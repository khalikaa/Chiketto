@section('title', 'Log In')

<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />


    <!-- Login Form -->
    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required
                autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center">
            <input id="remember_me" type="checkbox"
                class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
            <label for="remember_me" class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</label>
        </div>

        <!-- Actions -->
        <div class="flex items-center justify-between">
            @if (Route::has('password.request'))
                <a class="text-sm text-indigo-600 hover:text-indigo-900"
                    href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-auth-button>
                {{ __('Log in') }}
            </x-auth-button>
        </div>
    </form>

    <!-- Register Link -->
    <div class="mt-8 text-center">
        <p class="text-sm text-gray-600">
            {{ __("Don't have an account?") }}
            <a href="{{ route('register') }}" class="text-indigo-600 hover:text-indigo-900">
                {{ __('Register here') }}
            </a>
        </p>
    </div>
</x-guest-layout>
