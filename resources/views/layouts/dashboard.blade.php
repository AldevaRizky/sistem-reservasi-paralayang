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
            {{-- Breadcrumb Otomatis --}}
            @php
                use Illuminate\Support\Facades\Request;

                $segments = Request::segments();

                if (!empty($segments[0]) && in_array($segments[0], ['admin', 'staff', 'user'])) {
                    array_shift($segments);
                }

                $breadcrumbs = [];
                $url = '';
                foreach ($segments as $segment) {
                    $url .= '/' . $segment;
                    $breadcrumbs[] = [
                        'name' => ucfirst(str_replace(['-', '_'], ' ', $segment)),
                        'url' => url($url)
                    ];
                }

                $pageTitle = ucfirst(str_replace(['-', '_'], ' ', last($segments) ?? 'Dashboard'));
            @endphp

            <div class="page-header">
                <div class="page-block">
                    <div class="page-header-title">
                        <h5 class="mb-0 font-medium">{{ $pageTitle }}</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                        @foreach ($breadcrumbs as $breadcrumb)
                            @if ($loop->last)
                                <li class="breadcrumb-item active" aria-current="page">{{ $breadcrumb['name'] }}</li>
                            @else
                                <li class="breadcrumb-item"><a href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['name'] }}</a></li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div>
            {{-- End Breadcrumb --}}

            @yield('content')
        </div>
    </div>

    @include('partials.footer')
    @include('partials.scripts')
    @stack('scripts')
</body>
</html>
