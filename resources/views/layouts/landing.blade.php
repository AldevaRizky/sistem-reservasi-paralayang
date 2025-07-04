<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Beranda')</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700;900&family=Poppins:wght@400;500;600;700;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/feather-icons"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
</head>
<body class=" ">
    @include('partials.landing.navbar')
    @yield('content')

    @include('partials.landing.footer')
</body>
</html>

