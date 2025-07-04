<div x-data="campingGear()" id="camping-gear-packages">
    <div class="bg-[#0A2025] pt-12 pb-24">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- Header Halaman --}}
            <div class="text-center mb-12">
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-white tracking-tight">
                    Lengkapi Petualangan <span class="text-green-500">Darat Anda</span>
                </h1>
                <p class="mt-4 max-w-2xl mx-auto text-lg text-gray-400">
                    Jelajahi alam dengan nyaman. Kami menyediakan berbagai peralatan camping berkualitas untuk disewa.
                </p>
            </div>

            {{-- Filter Kategori Interaktif --}}
            <div class="flex justify-center flex-wrap gap-3 mb-12">
                <template x-for="category in categories" :key="category">
                    <button
                        @click="activeCategory = category; currentPage = 1"
                        :class="activeCategory === category ? 'bg-green-600 text-white' : 'bg-gray-700 text-gray-300 hover:bg-gray-600'"
                        class="px-5 py-2 text-sm font-medium rounded-full shadow-md transition-colors duration-300"
                        x-text="category">
                    </button>
                </template>
            </div>

            {{-- Grid untuk Kartu Alat Camping (Minimum Height untuk konsistensi) --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 min-h-[550px]">
                <template x-for="(gear, index) in paginatedGears" :key="gear.name + index">
                    <div class="bg-gray-800/50 backdrop-blur-sm border border-gray-700 rounded-xl overflow-hidden flex flex-col group hover:-translate-y-2 transition-transform duration-300 ease-in-out hover:border-green-500/50"
                         x-show="true"
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 transform translate-y-4"
                         x-transition:enter-end="opacity-100 transform translate-y-0"
                         :style="`transition-delay: ${index * 50}ms`">
                        
                        {{-- Konten Kartu (tidak berubah) --}}
                        <div class="relative"><img :src="gear.image" class="w-full h-48 object-cover" :alt="gear.name"><span class="absolute top-3 left-3 bg-green-500/20 text-green-300 text-xs font-bold px-2 py-1 rounded-full" x-text="gear.category"></span></div>
                        <div class="p-5 flex flex-col flex-grow"><h3 class="text-lg font-bold text-white flex-grow" x-text="gear.name"></h3><ul class="space-y-2 my-4 text-sm text-gray-400 border-t border-b border-gray-700 py-3"><template x-for="feature in gear.features" :key="feature"><li class="flex items-center gap-2"><svg class="h-4 w-4 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg><span x-text="feature"></span></li></template></ul><div class="mt-auto"><p class="text-xl font-bold text-green-400"><span x-text="formatPrice(gear.price)"></span><span class="text-sm font-medium text-gray-500">/ malam</span></p><a href="#" class="block w-full text-center mt-3 px-4 py-2 bg-green-600 text-white font-semibold rounded-lg shadow-md hover:bg-green-500 transition-colors duration-300 text-sm">Sewa Sekarang</a></div></div>
                    </div>
                </template>
            </div>

            <div x-show="totalPages > 1" class="flex justify-center items-center gap-4 mt-16 text-white">
                <button @click="currentPage--" :disabled="currentPage === 1" class="p-2 rounded-full hover:bg-gray-700 disabled:opacity-50 disabled:cursor-not-allowed transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                </button>

                <div class="flex items-center gap-2">
                    <template x-for="page in totalPages" :key="page">
                        <button @click="currentPage = page"
                                :class="currentPage === page ? 'bg-green-600 text-white' : 'bg-gray-700 text-gray-300 hover:bg-gray-600'"
                                class="w-10 h-10 rounded-full font-semibold transition-colors duration-300"
                                x-text="page">
                        </button>
                    </template>
                </div>

                <button @click="currentPage++" :disabled="currentPage === totalPages" class="p-2 rounded-full hover:bg-gray-700 disabled:opacity-50 disabled:cursor-not-allowed transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </button>
            </div>

        </div>
    </div>
</div>

<script>
    function campingGear() {
        return {
            activeCategory: 'Semua',
            currentPage: 1, // State untuk halaman saat ini
            itemsPerPage: 4, // Menampilkan 4 item per halaman
            
            categories: ['Semua', 'Tenda', 'Perlengkapan Tidur', 'Perlengkapan Masak', 'Lainnya'],
            gears: [
                { name: 'Tenda Dome Pro (4 Orang)', category: 'Tenda', image: 'https://images.unsplash.com/photo-1504280390367-361c6d9f38f4?q=80&w=870', features: ['Kapasitas: 4 Orang', 'Tipe: Double Layer', 'Berat: 4.5 kg'], price: 65000 },
                { name: 'Sleeping Bag Polar', category: 'Perlengkapan Tidur', image: 'https://images.unsplash.com/photo-1504280390367-361c6d9f38f4?q=80&w=870', features: ['Suhu Nyaman: 15°C', 'Bahan: Polar Fleece', 'Berat: 0.8 kg'], price: 20000 },
                { name: 'Kompor Portable Mini', category: 'Perlengkapan Masak', image: 'https://images.unsplash.com/photo-1504280390367-361c6d9f38f4?q=80&w=870', features: ['Bahan Bakar: Gas', 'Fitur: Windshield', 'Berat: 0.5 kg'], price: 15000 },
                { name: 'Tenda Ultralight (2 Orang)', category: 'Tenda', image: 'https://images.unsplash.com/photo-1504280390367-361c6d9f38f4?q=80&w=870', features: ['Kapasitas: 2 Orang', 'Tipe: Single Layer', 'Berat: 1.8 kg'], price: 45000 },
                { name: 'Kursi Lipat Gunung', category: 'Lainnya', image: 'https://images.unsplash.com/photo-1504280390367-361c6d9f38f4?q=80&w=870', features: ['Beban Maks: 120 kg', 'Rangka: Aluminium', 'Berat: 1.1 kg'], price: 10000 },
                { name: 'Matras Angin Otomatis', category: 'Perlengkapan Tidur', image: 'https://images.unsplash.com/photo-1504280390367-361c6d9f38f4?q=80&w=870', features: ['Ketebalan: 5 cm', 'Fitur: Self-Inflating', 'Berat: 1.5 kg'], price: 25000 },
                { name: 'Nesting Set (Panci & Piring)', category: 'Perlengkapan Masak', image: 'https://images.unsplash.com/photo-1504280390367-361c6d9f38f4?q=80&w=870', features: ['Material: Aluminium', 'Isi: 4 Pcs', 'Berat: 0.7 kg'], price: 20000 },
                { name: 'Headlamp LED Terang', category: 'Lainnya', image: 'https://images.unsplash.com/photo-1504280390367-361c6d9f38f4?q=80&w=870', features: ['Terang: 300 Lumens', 'Baterai: AAA x3', 'Mode: 3 (Terang, Redup, SOS)'], price: 15000 },
            ],
            
            // Fungsi untuk memfilter data
            get filteredGears() {
                if (this.activeCategory === 'Semua') {
                    return this.gears;
                }
                return this.gears.filter(gear => gear.category === this.activeCategory);
            },
            
            // Fungsi untuk menghitung total halaman
            get totalPages() {
                return Math.ceil(this.filteredGears.length / this.itemsPerPage);
            },
            
            // Fungsi untuk mengambil data sesuai halaman saat ini
            get paginatedGears() {
                const start = (this.currentPage - 1) * this.itemsPerPage;
                const end = start + this.itemsPerPage;
                return this.filteredGears.slice(start, end);
            },

            formatPrice(price) {
                return 'Rp ' + new Intl.NumberFormat('id-ID').format(price);
            }
        }
    }
</script>