<div class="bg-[#0A2025] pt-12 pb-24" id="paragliding-packages">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Header Halaman --}}
        <div class="text-center mb-16">
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-white tracking-tight">
                Pilih Paket Petualangan <span class="text-green-500">Terbang Anda</span>
            </h1>
            <p class="mt-4 max-w-2xl mx-auto text-lg text-gray-400">
                Kami menawarkan berbagai pilihan paket paralayang yang dirancang untuk memberikan pengalaman tak
                terlupakan.
            </p>
        </div>

        {{-- Horizontal Scroll Card --}}
        <div class="flex gap-6 overflow-x-auto pb-4 items-stretch scrollbar-thin scrollbar-thumb-green-500"
            style="scroll-snap-type: x mandatory;">
            @forelse($packages as $package)
                @php
                    $imageUrl = Str::contains($package->image, '/')
                        ? asset('storage/' . $package->image)
                        : asset('storage/packages/' . $package->image);
                @endphp

                <div
                    class="w-[340px] flex-shrink-0 scroll-snap-align-start bg-gray-800/50 backdrop-blur-sm border
                    {{ $package->id === $mostBookedId ? 'border-green-500 ring-[1.5px] ring-green-500' : 'border-gray-700' }}
                    rounded-xl overflow-hidden flex flex-col group hover:-translate-y-2 transition-transform duration-300 ease-in-out hover:border-green-500/50">

                    {{-- Gambar --}}
                    <div class="relative h-44 overflow-hidden">
                        <div class="absolute inset-0 transition-transform duration-300 group-hover:scale-105">
                            <img src="{{ $imageUrl }}" class="w-full h-full object-cover"
                                alt="{{ $package->package_name }}">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                        </div>

                        @if ($package->id === $mostBookedId)
                            <div
                                class="absolute top-0 right-0 z-10 bg-green-500 text-white text-xs font-bold px-2 py-1 rounded-bl-lg">
                                POPULER</div>
                        @endif
                    </div>

                    {{-- Konten --}}
                    <div class="p-4 flex flex-col flex-grow justify-between">
                        <div class="min-h-[90px]">
                            <h3 class="text-lg font-bold text-white leading-snug">{{ $package->package_name }}</h3>
                            <p class="mt-1 text-gray-400 text-sm">{{ Str::limit($package->description, 90) }}</p>
                        </div>

                        {{-- Fitur --}}
                        <ul class="space-y-2 mt-4 text-gray-300 text-xs">
                            <li class="flex items-center gap-2">
                                <svg class="h-4 w-4 text-green-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>Durasi: <strong>{{ $package->duration }}</strong></span>
                            </li>
                            <li class="flex items-center gap-2">
                                <svg class="h-4 w-4 text-green-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>Video GoPro</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <svg class="h-4 w-4 text-green-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M16.5 18.75h-9a9.75 9.75 0 011.316-5.327l.1-.318a9.75 9.75 0 015.232-4.585l.386-.172a9.75 9.75 0 016.432 0l.386.173a9.75 9.75 0 015.232 4.585l.1.318A9.75 9.75 0 0122.5 12c0 2.975-.89 5.79-2.457 8.25" />
                                </svg>
                                <span>Pilot & Asuransi</span>
                            </li>
                        </ul>

                        {{-- Harga & Tombol --}}
                        <div class="mt-6 pt-4 border-t border-gray-700">
                            <p class="text-xl font-extrabold text-green-400">Rp
                                {{ number_format($package->price, 0, ',', '.') }}
                                <span class="text-xs font-medium text-gray-400">/ orang</span>
                            </p>

                            <a href="{{ route('packages.show', $package->id) }}"
                                class="block w-full text-center mt-3 px-4 py-2 bg-green-600 text-white font-semibold rounded-md shadow-md hover:bg-green-500 transition-colors duration-300 text-sm">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center w-full text-gray-400 text-xl">Saat ini belum ada paket paralayang yang tersedia.
                </div>
            @endforelse
        </div>
    </div>
</div>

{{-- Scrollbar Custom --}}
<style>
    .scrollbar-thin::-webkit-scrollbar {
        height: 6px;
    }

    .scrollbar-thin::-webkit-scrollbar-thumb {
        background-color: #10b981;
        border-radius: 4px;
    }
</style>
