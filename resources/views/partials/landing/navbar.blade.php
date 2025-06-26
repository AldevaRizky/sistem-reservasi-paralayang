<nav class="bg-white shadow-md py-4">
    <div class="container mx-auto px-4 flex justify-between items-center">
        <a href="{{ url('/') }}" class="text-xl font-bold text-blue-600">Logo</a>
        <ul class="flex space-x-6">
            <li><a href="#hero" class="hover:text-blue-600">Beranda</a></li>
            <li><a href="#about" class="hover:text-blue-600">Tentang</a></li>
            <li><a href="#contact" class="hover:text-blue-600">Kontak</a></li>
            <li><a href="{{ route('packages.index') }}" class="hover:text-blue-600">Paket Paralayang</a></li>
        </ul>
    </div>
</nav>
