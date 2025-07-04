<x-guest-layout>
    <div class="text-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-200">Buat Akun Baru</h2>
        <p class="text-gray-600 dark:text-gray-400 mt-1">Satu langkah lagi menuju petualangan!</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div>
            <x-input-label for="name" value="Nama Lengkap" class="dark:text-gray-300" />
            <x-text-input id="name" class="block mt-1 w-full dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 dark:focus:border-green-500 dark:focus:ring-green-500" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" class="dark:text-gray-300" />
            <x-text-input id="email" class="block mt-1 w-full dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 dark:focus:border-green-500 dark:focus:ring-green-500" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" class="dark:text-gray-300" />
            <x-text-input id="password" class="block mt-1 w-full dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 dark:focus:border-green-500 dark:focus:ring-green-500"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="dark:text-gray-300" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 dark:focus:border-green-500 dark:focus:ring-green-500"
                            type="password"
                            name="password_confirmation"
                            required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-green-400 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 dark:focus:ring-offset-gray-800" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3 bg-green-600 hover:bg-green-500 focus:bg-green-700 active:bg-green-800 dark:bg-green-600 dark:hover:bg-green-500">
                {{ __('Register') }}
            </x-primary-button>
        </div>

        <p class="text-center text-sm text-gray-500 dark:text-gray-400 mt-6">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="font-medium text-green-600 dark:text-green-400 hover:underline">
                Login di sini
            </a>
        </p>
    </form>
</x-guest-layout>