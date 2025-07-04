<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">

        {{-- Logika Pengecekan Rute --}}
        @if (Route::is('login', 'register'))

            {{-- TAMPILAN KHUSUS UNTUK HALAMAN LOGIN --}}
            <div class="min-h-screen flex bg-gray-900">
                <div class="hidden lg:block w-1/2 relative">
                    <img class="absolute inset-0 w-full h-full object-cover" src="https://images.unsplash.com/photo-1502481851512-e9e2529bfbf9?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="Paragliding Adventure">
                    <div class="absolute inset-0 bg-gray-900 bg-opacity-50"></div>
                    <div class="absolute inset-0 flex items-center justify-center p-12 text-white">
                        <div class="text-center">
                            <h1 class="text-4xl font-extrabold leading-tight tracking-tight">
                                Petualangan Anda Dimulai di Sini
                            </h1>
                            <p class="mt-4 text-lg text-gray-300 max-w-md mx-auto">
                                Login untuk mengelola reservasi, melihat riwayat petualangan, dan mendapatkan penawaran eksklusif.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="w-full lg:w-1/2 flex items-center justify-center p-6 sm:p-12">
                    <div class="w-full max-w-md bg-gray-800 bg-opacity-70 backdrop-blur-sm border border-gray-700 rounded-xl shadow-2xl p-8">
                        {{ $slot }}
                    </div>
                </div>
            </div>

        @else

            {{-- TAMPILAN DEFAULT UNTUK HALAMAN LAIN (REGISTER, LUPA PASSWORD, DLL) --}}
            <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900">
                <div>
                    <a href="/">
                        <h1 class="text-3xl font-extrabold text-white">
                            Klangon<span class="text-green-400">Adventure</span>
                        </h1>
                    </a>
                </div>

                <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
                    {{ $slot }}
                </div>
            </div>

        @endif

    </body>
</html>