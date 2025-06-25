@php
    $role = auth()->user()->role;
    $routePrefix = match($role) {
        'admin' => 'admin.',
        'staff' => 'staff.',
        'user' => 'user.',
        default => '',
    };

    $menus = [
        [
            'type' => 'header',
            'name' => 'Navigation',
            'icon' => 'menu',
            'roles' => ['admin', 'staff', 'user'],
        ],
        [
            'type' => 'menu',
            'name' => 'Dashboard',
            'url' => route($routePrefix . 'dashboard'),
            'icon' => 'home',
            'roles' => ['admin', 'staff', 'user'],
        ],
        [
            'type' => 'header',
            'name' => 'Other',
            'icon' => 'sidebar',
            'roles' => ['admin'],
        ],
        [
            'type' => 'menu',
            'name' => 'Menu levels',
            'url' => '#!',
            'icon' => 'align-right',
            'roles' => ['admin'],
            'submenu' => [
                [
                    'name' => 'Level 2.1',
                    'url' => '#!',
                ],
                [
                    'name' => 'Level 2.2',
                    'url' => '#!',
                    'submenu' => [
                        ['name' => 'Level 3.1', 'url' => '#!'],
                        ['name' => 'Level 3.2', 'url' => '#!'],
                        [
                            'name' => 'Level 3.3',
                            'url' => '#!',
                            'submenu' => [
                                ['name' => 'Level 4.1', 'url' => '#!'],
                                ['name' => 'Level 4.2', 'url' => '#!'],
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ];

    // Rekursif submenu renderer
    $renderSubmenu = function ($submenu) use (&$renderSubmenu) {
        foreach ($submenu as $sub) {
            $hasSub = isset($sub['submenu']);
            echo '<li class="pc-item' . ($hasSub ? ' pc-hasmenu' : '') . '">';
            echo '<a href="' . $sub['url'] . '" class="pc-link">' . $sub['name'];
            if ($hasSub) {
                echo '<span class="pc-arrow"><i class="ti ti-chevron-right"></i></span>';
            }
            echo '</a>';
            if ($hasSub) {
                echo '<ul class="pc-submenu">';
                $renderSubmenu($sub['submenu']);
                echo '</ul>';
            }
            echo '</li>';
        }
    };

    // Menu utama renderer
    $renderMenu = function ($menus) use (&$renderMenu, $renderSubmenu, $role) {
        foreach ($menus as $menu) {
            if (!in_array($role, $menu['roles'])) continue;

            if ($menu['type'] === 'header') {
                echo '<li class="pc-item pc-caption"><label>' . $menu['name'] . '</label>';
                echo '<i data-feather="' . $menu['icon'] . '"></i></li>';
            }

            if ($menu['type'] === 'menu') {
                $hasSub = isset($menu['submenu']);
                echo '<li class="pc-item' . ($hasSub ? ' pc-hasmenu' : '') . '">';
                echo '<a href="' . $menu['url'] . '" class="pc-link">';
                echo '<span class="pc-micon"><i data-feather="' . $menu['icon'] . '"></i></span>';
                echo '<span class="pc-mtext">' . $menu['name'] . '</span>';
                if ($hasSub) {
                    echo '<span class="pc-arrow"><i class="ti ti-chevron-right"></i></span>';
                }
                echo '</a>';
                if ($hasSub) {
                    echo '<ul class="pc-submenu">';
                    $renderSubmenu($menu['submenu']);
                    echo '</ul>';
                }
                echo '</li>';
            }
        }
    };
@endphp

<nav class="pc-sidebar">
    <div class="navbar-wrapper">
        <div class="m-header flex items-center py-4 px-6 h-header-height">
            <a href="{{ route($routePrefix . 'dashboard') }}" class="b-brand flex items-center gap-3">
                <img src="{{ asset('assets/images/logo-white.svg') }}" class="img-fluid logo logo-lg" alt="logo" />
                <img src="{{ asset('assets/images/favicon.svg') }}" class="img-fluid logo logo-sm" alt="logo" />
            </a>
        </div>
        <div class="navbar-content h-[calc(100vh_-_74px)] py-2.5">
            <ul class="pc-navbar">
                @php $renderMenu($menus); @endphp
            </ul>
        </div>
    </div>
</nav>
