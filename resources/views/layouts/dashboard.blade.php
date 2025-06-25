<!doctype html>
<html lang="en" data-pc-preset="preset-1" data-pc-sidebar-caption="true" data-pc-direction="ltr" dir="ltr" data-pc-theme="light">
<head>
    @include('partials.head')
    <title>@yield('title', 'Dashboard')</title>
</head>
<body>
    @include('partials.sidebar')
    @include('partials.header')

    <div class="pc-container">
        <div class="pc-content">
            @yield('content')
        </div>
    </div>

    @include('partials.footer')
    @include('partials.scripts')

    @stack('scripts')
</body>
</html>
