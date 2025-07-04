@extends('layouts.landing')

@section('title', 'Paket Paralayang - Klangon Adventure')

@section('content')
<div class="bg-[#0A2025] pt-12 pb-24">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Header Halaman --}}
        <div class="text-center mb-16">
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-white tracking-tight">
                Pilih Paket Petualangan <span class="text-green-500">Terbang Anda</span>
            </h1>
            <p class="mt-4 max-w-2xl mx-auto text-lg text-gray-400">
                Kami menawarkan berbagai pilihan paket paralayang yang dirancang untuk memberikan pengalaman tak terlupakan, baik untuk pemula maupun yang sudah berpengalaman.
            </p>
        </div>

        {{-- Grid untuk Kartu Paket --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            
            {{-- === KARTU DUMMY 1: PAKET FUN FLIGHT === --}}
            <div class="bg-gray-800/50 backdrop-blur-sm border border-gray-700 rounded-xl overflow-hidden flex flex-col group hover:-translate-y-2 transition-transform duration-300 ease-in-out hover:border-green-500/50">
                <div class="relative">
                    <img src="https://images.unsplash.com/photo-1551632811-561732d1e306?q=80&w=870" class="w-full h-56 object-cover transition-transform duration-300 group-hover:scale-105" alt="Paket Fun Flight">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                </div>
                <div class="p-6 flex flex-col flex-grow">
                    <h3 class="text-2xl font-bold text-white">Paket Fun Flight</h3>
                    <p class="mt-2 text-gray-400 flex-grow">Pilihan sempurna bagi Anda yang baru pertama kali mencoba. Nikmati sensasi terbang ringan dengan pemandangan yang menakjubkan.</p>
                    <ul class="space-y-3 mt-6 text-gray-300">
                        <li class="flex items-center gap-3">
                            <svg class="h-5 w-5 text-green-400 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            <span>Durasi Terbang: <span class="font-semibold">15 Menit</span></span>
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="h-5 w-5 text-green-400 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            <span>Termasuk Video GoPro</span>
                        </li>
                         <li class="flex items-center gap-3">
                            <svg class="h-5 w-5 text-green-400 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 18.75h-9a9.75 9.75 0 011.316-5.327l.1-.318a9.75 9.75 0 015.232-4.585l.386-.172a9.75 9.75 0 016.432 0l.386.173a9.75 9.75 0 015.232 4.585l.1.318A9.75 9.75 0 0122.5 12c0 2.975-.89 5.79-2.457 8.25" /></svg>
                            <span>Pilot Berlisensi & Asuransi</span>
                        </li>
                    </ul>
                    <div class="mt-8 pt-6 border-t border-gray-700">
                        <p class="text-3xl font-extrabold text-green-400">Rp 450.000<span class="text-base font-medium text-gray-400">/ orang</span></p>
                        <a href="#" class="block w-full text-center mt-4 px-6 py-3 bg-green-600 text-white font-semibold rounded-lg shadow-md hover:bg-green-500 transition-colors duration-300">
                            Lihat Detail & Pesan
                        </a>
                    </div>
                </div>
            </div>

            {{-- === KARTU DUMMY 2: PAKET ADVENTURE === --}}
            <div class="bg-gray-800/50 backdrop-blur-sm border border-green-500/50 rounded-xl overflow-hidden flex flex-col group hover:-translate-y-2 transition-transform duration-300 ease-in-out ring-2 ring-green-500/50">
                <div class="relative">
                    <img src="https://images.unsplash.com/photo-1621295628622-54109f36b69a?q=80&w=870" class="w-full h-56 object-cover transition-transform duration-300 group-hover:scale-105" alt="Paket Adventure">
                    <div class="absolute top-0 right-0 bg-green-500 text-white text-xs font-bold px-3 py-1 rounded-bl-lg">PALING POPULER</div>
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                </div>
                <div class="p-6 flex flex-col flex-grow">
                    <h3 class="text-2xl font-bold text-white">Paket Adventure</h3>
                    <p class="mt-2 text-gray-400 flex-grow">Untuk para pencari adrenalin! Terbang lebih tinggi, lebih lama, dan rasakan manuver-manuver seru bersama pilot profesional kami.</p>
                    <ul class="space-y-3 mt-6 text-gray-300">
                        <li class="flex items-center gap-3">
                            <svg class="h-5 w-5 text-green-400 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            <span>Durasi Terbang: <span class="font-semibold">25 Menit</span></span>
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="h-5 w-5 text-green-400 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            <span>Termasuk Video GoPro & Foto</span>
                        </li>
                         <li class="flex items-center gap-3">
                            <svg class="h-5 w-5 text-green-400 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 18.75h-9a9.75 9.75 0 011.316-5.327l.1-.318a9.75 9.75 0 015.232-4.585l.386-.172a9.75 9.75 0 016.432 0l.386.173a9.75 9.75 0 015.232 4.585l.1.318A9.75 9.75 0 0122.5 12c0 2.975-.89 5.79-2.457 8.25" /></svg>
                            <span>Pilot Berlisensi & Asuransi</span>
                        </li>
                    </ul>
                    <div class="mt-8 pt-6 border-t border-gray-700">
                        <p class="text-3xl font-extrabold text-green-400">Rp 650.000<span class="text-base font-medium text-gray-400">/ orang</span></p>
                        <a href="#" class="block w-full text-center mt-4 px-6 py-3 bg-green-600 text-white font-semibold rounded-lg shadow-md hover:bg-green-500 transition-colors duration-300">
                            Lihat Detail & Pesan
                        </a>
                    </div>
                </div>
            </div>

            {{-- === KARTU DUMMY 3: PAKET SUNSET VIEW === --}}
            <div class="bg-gray-800/50 backdrop-blur-sm border border-gray-700 rounded-xl overflow-hidden flex flex-col group hover:-translate-y-2 transition-transform duration-300 ease-in-out hover:border-green-500/50">
                <div class="relative">
                    <img src="https://images.unsplash.com/photo-1591815349225-7addc034c431?q=80&w=870" class="w-full h-56 object-cover transition-transform duration-300 group-hover:scale-105" alt="Paket Sunset View">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                </div>
                <div class="p-6 flex flex-col flex-grow">
                    <h3 class="text-2xl font-bold text-white">Paket Sunset View</h3>
                    <p class="mt-2 text-gray-400 flex-grow">Saksikan keindahan matahari terbenam dari sudut pandang terbaik. Pengalaman romantis dan magis yang tak akan terlupakan.</p>
                    <ul class="space-y-3 mt-6 text-gray-300">
                        <li class="flex items-center gap-3">
                            <svg class="h-5 w-5 text-green-400 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            <span>Durasi Terbang: <span class="font-semibold">20 Menit</span></span>
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="h-5 w-5 text-green-400 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            <span>Termasuk Video GoPro</span>
                        </li>
                         <li class="flex items-center gap-3">
                            <svg class="h-5 w-5 text-green-400 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 18.75h-9a9.75 9.75 0 011.316-5.327l.1-.318a9.75 9.75 0 015.232-4.585l.386-.172a9.75 9.75 0 016.432 0l.386.173a9.75 9.75 0 015.232 4.585l.1.318A9.75 9.75 0 0122.5 12c0 2.975-.89 5.79-2.457 8.25" /></svg>
                            <span>Pilot Berlisensi & Asuransi</span>
                        </li>
                    </ul>
                    <div class="mt-8 pt-6 border-t border-gray-700">
                        <p class="text-3xl font-extrabold text-green-400">Rp 550.000<span class="text-base font-medium text-gray-400">/ orang</span></p>
                        <a href="#" class="block w-full text-center mt-4 px-6 py-3 bg-green-600 text-white font-semibold rounded-lg shadow-md hover:bg-green-500 transition-colors duration-300">
                            Lihat Detail & Pesan
                        </a>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>
@endsection