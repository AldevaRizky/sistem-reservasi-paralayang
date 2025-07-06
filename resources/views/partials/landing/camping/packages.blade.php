<script>
    function campingGear() {
        return {
            activeCategory: 'Semua',
            currentPage: 1,
            itemsPerPage: 4,
            categories: ['Semua', 'Tenda', 'Perlengkapan Tidur', 'Perlengkapan Masak', 'Lainnya'],
            gears: @json($campingGears),

            get filteredGears() {
                if (this.activeCategory === 'Semua') return this.gears;
                return this.gears.filter(gear => gear.category === this.activeCategory);
            },

            get totalPages() {
                return Math.ceil(this.filteredGears.length / this.itemsPerPage);
            },

            get paginatedGears() {
                const start = (this.currentPage - 1) * this.itemsPerPage;
                return this.filteredGears.slice(start, start + this.itemsPerPage);
            },

            formatPrice(price) {
                return 'Rp ' + new Intl.NumberFormat('id-ID').format(price);
            }
        }
    }
</script>


<div x-data="campingGear()" id="camping-gear-packages">
    <div class="bg-[#0A2025] pt-12 pb-24">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Header --}}
            <div class="text-center mb-12">
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-white tracking-tight">
                    Lengkapi Petualangan <span class="text-green-500">Darat Anda</span>
                </h1>
                <p class="mt-4 max-w-2xl mx-auto text-lg text-gray-400">
                    Jelajahi alam dengan nyaman. Kami menyediakan berbagai peralatan camping berkualitas untuk disewa.
                </p>
            </div>

            {{-- Filter Kategori --}}
            <div class="flex justify-center flex-wrap gap-3 mb-10">
                <template x-for="category in categories" :key="category">
                    <button @click="activeCategory = category; currentPage = 1"
                        :class="activeCategory === category ? 'bg-green-600 text-white' :
                            'bg-gray-700 text-gray-300 hover:bg-gray-600'"
                        class="px-5 py-2 text-sm font-medium rounded-full shadow-md transition-colors duration-300"
                        x-text="category">
                    </button>
                </template>
            </div>

            {{-- Horizontal Scroll List --}}
            <div class="flex gap-6 overflow-x-auto pb-4 items-stretch scrollbar-thin scrollbar-thumb-green-500"
                style="scroll-snap-type: x mandatory;">
                <template x-for="(gear, index) in filteredGears" :key="gear.name + index">
                    <div class="w-[300px] flex-shrink-0 scroll-snap-align-start bg-gray-800/50 backdrop-blur-sm border border-gray-700 rounded-xl overflow-hidden flex flex-col group hover:-translate-y-2 transition-transform duration-300 hover:border-green-500/50"
                        x-show="true" x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 translate-y-4"
                        x-transition:enter-end="opacity-100 translate-y-0" :style="`transition-delay: ${index * 50}ms`">

                        {{-- Gambar --}}
                        <div class="relative h-44 overflow-hidden">
                            <img :src="gear.image"
                                class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105"
                                :alt="gear.name">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent"></div>
                            <span
                                class="absolute top-3 left-3 bg-green-500/20 text-green-300 text-xs font-bold px-2 py-1 rounded-full"
                                x-text="gear.category"></span>
                        </div>

                        {{-- Konten --}}
                        <div class="p-5 flex flex-col flex-grow">
                            <h3 class="text-lg font-bold text-white flex-grow" x-text="gear.name"></h3>
                            <ul class="space-y-2 my-4 text-sm text-gray-400 border-t border-b border-gray-700 py-3">
                                <template x-for="feature in gear.features" :key="feature">
                                    <li class="flex items-center gap-2">
                                        <svg class="h-4 w-4 text-green-500" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7" />
                                        </svg>
                                        <span x-text="feature"></span>
                                    </li>
                                </template>
                            </ul>

                            <div class="mt-auto">
                                <p class="text-xl font-bold text-green-400">
                                    <span x-text="formatPrice(gear.price)"></span>
                                    <span class="text-sm font-medium text-gray-500">/ malam</span>
                                </p>
                                <button
                                    @click="Swal.fire({
                                        title: 'Masih Dalam Pengembangan',
                                        text: 'Fitur booking alat camping sedang kami siapkan.',
                                        icon: 'info',
                                        confirmButtonText: 'Oke!',
                                        confirmButtonColor: '#22c55e'
                                    })"
                                    class="w-full mt-3 px-4 py-2 bg-green-600 text-white font-semibold rounded-lg shadow-md hover:bg-green-500 transition-colors duration-300 text-sm">
                                    Sewa Sekarang
                                </button>

                            </div>
                        </div>
                    </div>
                </template>
            </div>

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
{{-- SweetAlert2 CDN --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    .swal2-confirm {
        background-color: #16a34a !important;
        color: white !important;
        border: none !important;
        box-shadow: none !important;
    }

    .swal2-cancel {
        background-color: #d33 !important;
        color: white !important;
        border: none !important;
        box-shadow: none !important;
    }
</style>
