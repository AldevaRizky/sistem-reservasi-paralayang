<x-guest-layout>
    <div class="text-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-200">Login ke Akun Anda</h2>
        <p class="text-gray-600 dark:text-gray-400 mt-1">Selamat datang kembali!</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div>
            <x-input-label for="email" :value="__('Email')" class="dark:text-gray-300" />
            <x-text-input id="email" class="block mt-1 w-full dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 dark:focus:border-green-500 dark:focus:ring-green-500" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" class="dark:text-gray-300" />
            <x-text-input id="password" class="block mt-1 w-full dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 dark:focus:border-green-500 dark:focus:ring-green-500"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-green-600 shadow-sm focus:ring-green-500 dark:focus:ring-green-600 dark:focus:ring-offset-gray-800" name="remember">
                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-green-400 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 dark:focus:ring-offset-gray-800" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3 bg-green-600 hover:bg-green-500 focus:bg-green-700 active:bg-green-800 dark:bg-green-600 dark:hover:bg-green-500">
                {{ __('Log in') }}
            </x-primary-button>
        </div>

        <p class="text-center text-sm text-gray-500 dark:text-gray-400 mt-6">
            Belum punya akun?
            <a href="{{ route('register') }}" class="font-medium text-green-600 dark:text-green-400 hover:underline">
                Daftar di sini
            </a>
        </p>
    </form>
</x-guest-layout>