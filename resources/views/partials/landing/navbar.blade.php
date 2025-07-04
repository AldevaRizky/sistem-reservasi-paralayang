<nav class="bg-[#0A2025] shadow-lg py-4 sticky top-0 z-40">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center">
        <a href="{{ url('/') }}" class="text-2xl font-extrabold text-gray-100">
            Klangon<span class="text-green-500">Adventure</span>
        </a>

        <div class="hidden md:flex items-center space-x-8">
            <ul class="flex items-center space-x-8 font-medium text-gray-300">
                <li><a href="#hero" class="hover:text-white hover:-translate-y-0.5 transition-all duration-300 block">Beranda</a></li>
                <li><a href="#about" class="hover:text-white hover:-translate-y-0.5 transition-all duration-300 block">Tentang</a></li>
                <li class="relative">
                    <button id="product-menu-button" class="flex items-center gap-1 hover:text-white hover:-translate-y-0.5 transition-all duration-300">
                        <span>Produk</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div id="product-menu-dropdown" class="absolute hidden mt-3 w-56 -translate-x-1/4 bg-[#1e343b] border border-gray-700 rounded-lg shadow-xl py-2 z-50">
                        <a href="#paragliding-packages" class="block px-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-white">Paket Paralayang</a>
                        <a href="#camping-gear-packages" class="block px-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-white">Paket Alat Camping</a>
                    </div>
                </li>
                <li><a href="#contact" class="hover:text-white hover:-translate-y-0.5 transition-all duration-300 block">Kontak</a></li>
            </ul>

            <div class="flex items-center space-x-5">
                @guest
                    {{-- TAMPILAN UNTUK PENGGUNA YANG BELUM LOGIN --}}
                    <a href="{{ route('login') }}" class="px-5 py-2 bg-gray-600 text-white font-semibold rounded-lg shadow-sm hover:bg-gray-500 hover:-translate-y-0.5 transition-all duration-300">
                        Login
                    </a>
                    <a href="{{ route('register') }}" class="px-5 py-2 bg-green-600 text-white font-semibold rounded-lg shadow-sm hover:bg-green-500 hover:-translate-y-0.5 transition-all duration-300">
                        Register
                    </a>
                @endguest

                @auth
                    {{-- TAMPILAN UNTUK PENGGUNA YANG SUDAH LOGIN --}}
                    <a href="/booking" class="px-5 py-2 bg-green-600 text-white font-semibold rounded-lg shadow-sm hover:bg-green-500 hover:-translate-y-0.5 transition-all duration-300">
                        Booking Now
                    </a>
                    <div class="relative">
                        <button id="user-menu-button" class="block">
                            <img class="h-10 w-10 rounded-full ring-2 ring-offset-2 ring-offset-[#0A2025] ring-transparent hover:ring-green-500 transition-all duration-300" 
             src="{{ (Auth::user()->detail && Auth::user()->detail->profile_photo) ? asset('storage/' . Auth::user()->detail->profile_photo) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=0D8ABC&color=fff' }}" 
             alt="{{ Auth::user()->name }}">
                        </button>
                        <div id="user-menu-dropdown" class="absolute hidden right-0 mt-3 w-48 bg-[#1e343b] border border-gray-700 rounded-lg shadow-xl py-2 z-50">
                            <div class="px-4 py-2 border-b border-gray-700">
                                <p class="text-sm text-white font-semibold">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-gray-400 truncate">{{ Auth::user()->email }}</p>
                            </div>
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-white">Profil Saya</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left block px-4 py-2 text-red-500 hover:bg-red-900/40 hover:text-red-400">
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                @endauth
            </div>
        </div>

        <div class="md:hidden">
            <button id="open-mobile-menu" class="p-2 rounded-md text-gray-300 hover:bg-white/10 hover:text-white transition-colors duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m4 6H4" /></svg>
            </button>
        </div>
    </div>
</nav>

<div id="mobile-menu-container" class="fixed inset-0 z-50 hidden">
    <div id="mobile-menu-backdrop" class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity duration-300 ease-in-out opacity-0"></div>
    <div id="mobile-menu-panel" class="fixed top-0 right-0 h-full w-80 bg-[#0A2025] shadow-2xl p-6 transform translate-x-full transition-transform duration-300 ease-in-out">
        <div class="flex items-center justify-between pb-4 border-b border-gray-700">
            <a href="{{ url('/') }}" class="text-xl font-extrabold text-gray-100">Klangon<span class="text-green-500">Adventure</span></a>
            <button id="close-mobile-menu" class="p-2 rounded-md text-gray-400 hover:bg-white/10 hover:text-white"><svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg></button>
        </div>
        <div class="mt-6 flex flex-col h-full">
            @auth
                {{-- TAMPILAN MOBILE JIKA SUDAH LOGIN --}}
                <div class="flex items-center gap-4 mb-6">
                    <img class="h-12 w-12 rounded-full" 
         src="{{ (Auth::user()->detail && Auth::user()->detail->profile_photo) ? asset('storage/' . Auth::user()->detail->profile_photo) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=0D8ABC&color=fff' }}" 
         alt="{{ Auth::user()->name }}">
                    <div>
                        <p class="font-semibold text-white">{{ Auth::user()->name }}</p>
                        <a href="{{ route('profile.edit') }}" class="text-sm text-green-500 hover:underline">Lihat Profil</a>
                    </div>
                </div>
                <a href="/booking" class="w-full text-center mb-6 px-5 py-3 bg-green-600 text-white font-semibold rounded-lg shadow-sm hover:bg-green-500 transition-colors duration-300">Booking Now</a>
            @endauth

            <ul class="flex flex-col space-y-1 text-gray-300">
                <li><a href="#hero" class="block py-3 px-3 rounded-md hover:bg-gray-700 hover:text-white transition-colors duration-300">Beranda</a></li>
                <li><a href="#about" class="block py-3 px-3 rounded-md hover:bg-gray-700 hover:text-white transition-colors duration-300">Tentang</a></li>
                <li>
                    <p class="px-3 pt-3 pb-1 text-xs uppercase text-gray-500 font-bold">Produk</p>
                    <ul class="pl-4">
                        <li><a href="{{ route('packages.index') }}" class="block py-2 px-3 rounded-md hover:bg-gray-700 hover:text-white transition-colors duration-300">Paket Paralayang</a></li>
                        <li><a href="{{ route('packages.index') }}" class="block py-2 px-3 rounded-md hover:bg-gray-700 hover:text-white transition-colors duration-300">Paket Alat Camping</a></li>
                    </ul>
                </li>
                <li><a href="#contact" class="block py-3 px-3 rounded-md hover:bg-gray-700 hover:text-white transition-colors duration-300">Kontak</a></li>
            </ul>

            <div class="mt-auto">
                @guest
                    {{-- TAMPILAN MOBILE JIKA BELUM LOGIN --}}
                    <div class="grid grid-cols-2 gap-4">
                        <a href="{{ route('login') }}" class="w-full text-center py-3 px-3 rounded-md text-white bg-gray-700 hover:bg-gray-600 transition-colors duration-300">Login</a>
                        <a href="{{ route('register') }}" class="w-full text-center py-3 px-3 rounded-md text-white bg-green-600 hover:bg-green-500 transition-colors duration-300">Register</a>
                    </div>
                @endguest
                @auth
                    {{-- TAMPILAN MOBILE JIKA SUDAH LOGIN (LOGOUT BUTTON) --}}
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block w-full text-center py-3 px-3 rounded-md text-red-500 bg-red-900/40 hover:bg-red-900/60 hover:text-red-400 transition-colors duration-300">Logout</button>
                    </form>
                @endauth
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Elemen untuk Sidebar Mobile
    const openButton = document.getElementById('open-mobile-menu');
    const closeButton = document.getElementById('close-mobile-menu');
    const menuContainer = document.getElementById('mobile-menu-container');
    const menuBackdrop = document.getElementById('mobile-menu-backdrop');
    const menuPanel = document.getElementById('mobile-menu-panel');

    // Elemen untuk Dropdown Produk
    const productMenuButton = document.getElementById('product-menu-button');
    const productMenuDropdown = document.getElementById('product-menu-dropdown');

    // [BARU] Elemen untuk Dropdown Profil Pengguna (jika pengguna login)
    const userMenuButton = document.getElementById('user-menu-button');
    const userMenuDropdown = document.getElementById('user-menu-dropdown');

    // --- Fungsi untuk Buka/Tutup Menu Mobile ---
    const openMenu = () => {
        menuContainer.classList.remove('hidden');
        requestAnimationFrame(() => {
            menuBackdrop.classList.remove('opacity-0');
            menuPanel.classList.remove('translate-x-full');
        });
    };

    const closeMenu = () => {
        menuBackdrop.classList.add('opacity-0');
        menuPanel.classList.add('translate-x-full');
        setTimeout(() => {
            menuContainer.classList.add('hidden');
        }, 300);
    };
    
    // Event listener untuk menu mobile
    openButton.addEventListener('click', openMenu);
    closeButton.addEventListener('click', closeMenu);
    menuBackdrop.addEventListener('click', closeMenu);

    // --- Fungsi untuk Dropdown ---
    function setupDropdown(button, dropdown) {
        if (!button || !dropdown) return; // Jangan jalankan jika elemen tidak ada
        
        button.addEventListener('click', function (event) {
            event.stopPropagation();
            dropdown.classList.toggle('hidden');
        });
    }

    // Terapkan fungsi dropdown
    setupDropdown(productMenuButton, productMenuDropdown);
    setupDropdown(userMenuButton, userMenuDropdown); // Terapkan juga untuk dropdown user

    // Menutup dropdown jika diklik di luar area
    window.addEventListener('click', function (event) {
        if (productMenuDropdown && !productMenuButton.contains(event.target) && !productMenuDropdown.contains(event.target)) {
            productMenuDropdown.classList.add('hidden');
        }
        if (userMenuDropdown && !userMenuButton.contains(event.target) && !userMenuDropdown.contains(event.target)) {
            userMenuDropdown.classList.add('hidden');
        }
    });
});
</script>