@php
    use Illuminate\Support\Facades\Route;

    $role = auth()->user()->role;
    $routePrefix = match($role) {
        'admin' => 'admin.',
        'staff' => 'staff.',
        'user' => 'user.',
        default => '',
    };

    // Fungsi bantu: cek apakah menu aktif
    function isMenuActive($menuUrl) {
        $currentUrl = url()->current();
        return str_starts_with($currentUrl, $menuUrl) ? ' active' : '';
    }

    // Fungsi bantu: cek apakah submenu ada yang aktif
    function isSubmenuActive($submenu) {
        $currentUrl = url()->current();
        foreach ($submenu as $sub) {
            if (str_starts_with($currentUrl, $sub['url'])) {
                return true;
            }
        }
        return false;
    }

    // Menu data
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
            'name' => 'Apps & Pages',
            'icon' => 'layers',
            'roles' => ['admin', 'staff'],
        ],
        [
            'type' => 'menu',
            'name' => 'Paket Paralayang',
            'url' => route('admin.paragliding-packages.index'),
            'icon' => 'wind',
            'roles' => ['admin'],
        ],
        [
            'type' => 'menu',
            'name' => 'Jadwal Paralayang',
            'url' => route('admin.paragliding-schedules.index'),
            'icon' => 'calendar',
            'roles' => ['admin'],
        ],
        [
            'type' => 'menu',
            'name' => 'Peralatan Camping',
            'url' => route('admin.camping-equipment.index'),
            'icon' => 'briefcase',
            'roles' => ['admin'],
        ],
        [
            'type' => 'header',
            'name' => 'Other',
            'icon' => 'sidebar',
            'roles' => ['admin'],
        ],
        [
            'type' => 'menu',
            'name' => 'Master Data',
            'url' => '#!',
            'icon' => 'database',
            'roles' => ['admin'],
            'submenu' => [
                [
                    'name' => 'Manajemen Admin',
                    'url' => route('admin.users.admin.index'),
                ],
                [
                    'name' => 'Manajemen Users',
                    'url' => route('admin.users.user.index'),
                ],
                [
                    'name' => 'Manajemen Staff',
                    'url' => route('admin.users.staff.index'),
                ],
            ],
        ],
    ];

    // Render submenu secara rekursif
    $renderSubmenu = function ($submenu) use (&$renderSubmenu) {
        foreach ($submenu as $sub) {
            $hasSub = isset($sub['submenu']);
            $active = isMenuActive($sub['url']);
            echo '<li class="pc-item' . ($hasSub ? ' pc-hasmenu' : '') . $active . '">';
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

    // Render menu utama
    $renderMenu = function ($menus) use (&$renderMenu, $renderSubmenu, $role) {
        foreach ($menus as $menu) {
            if (!in_array($role, $menu['roles'])) continue;

            if ($menu['type'] === 'header') {
                echo '<li class="pc-item pc-caption"><label>' . $menu['name'] . '</label>';
                echo '<i data-feather="' . $menu['icon'] . '"></i></li>';
            }

            if ($menu['type'] === 'menu') {
                $hasSub = isset($menu['submenu']);
                $isActive = isMenuActive($menu['url']);
                $isSubmenuActive = $hasSub && isSubmenuActive($menu['submenu']);

                $liClasses = 'pc-item';
                if ($hasSub) $liClasses .= ' pc-hasmenu';
                if ($isActive || $isSubmenuActive) $liClasses .= ' active pc-trigger';

                echo '<li class="' . $liClasses . '">';
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
                <img src="{{ url('/assets/images/logo-white.svg') }}" alt="logo">
            </a>
        </div>
        <div class="navbar-content h-[calc(100vh_-_74px)] py-2.5">
            <ul class="pc-navbar">
                @php $renderMenu($menus); @endphp
            </ul>
        </div>
    </div>
</nav>
