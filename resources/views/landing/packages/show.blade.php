@extends('layouts.landing')

@section('title', $package->package_name)

@section('content')
{{-- 
    PERUBAHAN TAMPILAN GAMBAR:
    1. Galeri thumbnail di bawah gambar utama telah dihapus.
    2. JavaScript disederhanakan untuk hanya memuat satu gambar utama.
    3. Div pembungkus gambar (`aspect-w-16 aspect-h-9` dan `object-cover`) sudah memastikan ukuran gambar konsisten.
--}}
<div class="bg-[#0A2025] pt-12 pb-24 text-white">
    <div id="booking-component"
         data-package='@json($package)'
         x-data="bookingFormData()"
         class="container mx-auto px-4 sm:px-6 lg:px-8">

        <div class="grid grid-cols-1 lg:grid-cols-5 gap-x-12">
            
            <div class="lg:col-span-3">
                {{-- Galeri Gambar (Sekarang hanya satu gambar) --}}
                <div>
                    <div class="aspect-w-16 aspect-h-9 rounded-lg overflow-hidden bg-gray-800 mb-4">
                        {{-- Img ini akan selalu konsisten ukurannya --}}
                        <img :src="mainImage" alt="Main package image" class="w-full h-full object-cover">
                    </div>
                    {{-- Bagian thumbnail gallery sudah dihapus --}}
                </div>

                {{-- Detail Paket --}}
                <div class="mt-10">
                    <h1 class="text-4xl font-extrabold tracking-tight" x-text="package.package_name"></h1>
                    <p class="text-3xl font-bold text-green-400 mt-2">
                        <span x-text="formatPrice(package.price)"></span> / orang
                    </p>
                    <div class="mt-6 text-lg text-gray-300 leading-relaxed prose prose-invert max-w-none">
                        <p x-html="package.description.replace(/\n/g, '<br>')"></p>
                    </div>
                    <h3 class="text-xl font-bold mt-8 border-t border-gray-700 pt-6">Persyaratan:</h3>
                    <p class="mt-2 text-gray-300" x-text="package.requirements"></p>
                </div>
            </div>

            <div class="lg:col-span-2 mt-10 lg:mt-0">
                 <div class="lg:sticky top-28 h-fit bg-gray-800/50 backdrop-blur-sm border border-gray-700 rounded-xl p-6">
                    <div class="pb-6 border-b border-gray-700">
                        <h3 class="text-2xl font-bold mb-4">Mulai Pemesanan Anda</h3>
                        <div>
                            <label class="font-semibold">Langkah 1: Pilih Tanggal</label>
                            <input type="date" x-model="selectedDate" :min="getTodayDate()" class="mt-2 block w-full rounded-lg bg-gray-700 border-gray-600 text-white p-2.5 focus:ring-green-500 focus:border-green-500" style="color-scheme: dark;">
                        </div>
                        <div class="mt-6">
                            <label class="font-semibold">Langkah 2: Pilih Jam Terbang</label>
                            <div x-show="isLoadingTimes" class="mt-2 text-gray-400 animate-pulse">Mencari jadwal...</div>
                            <div x-show="!isLoadingTimes && selectedDate && availableTimes.length === 0" class="mt-2 text-yellow-400 text-sm">
                                Tidak ada jadwal tersedia pada tanggal ini.
                            </div>
                            <div x-show="!isLoadingTimes && availableTimes.length > 0" class="grid grid-cols-2 sm:grid-cols-3 gap-3 mt-2">
                                <template x-for="slot in availableTimes" :key="slot.time">
                                    <button @click="selectedTime = slot.time" :class="{'bg-green-600 text-white': selectedTime === slot.time, 'bg-gray-700 hover:bg-gray-600': selectedTime !== slot.time}" class="p-3 rounded-lg text-center transition-colors duration-200">
                                        <p class="font-bold" x-text="slot.time"></p>
                                        <p class="text-xs" x-text="`${slot.slots} Sisa`"></p>
                                    </button>
                                </template>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6">
                        <h3 class="text-xl font-bold mb-4">Ringkasan Pesanan</h3>
                        <div class="space-y-4">
                            <div class="flex justify-between"><span class="text-gray-400">Paket:</span><strong x-text="package.package_name" class="text-right"></strong></div>
                            <div class="flex justify-between"><span class="text-gray-400">Tanggal:</span><strong x-text="selectedDate ? new Date(selectedDate).toLocaleDateString('id-ID', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' }) : '-'" class="text-right"></strong></div>
                            <div class="flex justify-between"><span class="text-gray-400">Waktu:</span><strong x-text="selectedTime || '-'"></strong></div>
                            <div class="flex justify-between items-center"><span class="text-gray-400">Jumlah Orang:</span>
                                <div class="flex items-center gap-3 bg-gray-700 rounded-full">
                                    <button @click="decreaseQuantity()" class="w-8 h-8 rounded-full hover:bg-gray-600 text-lg font-bold">-</button>
                                    <span x-text="quantity" class="font-bold text-lg"></span>
                                    <button @click="increaseQuantity()" class="w-8 h-8 rounded-full hover:bg-gray-600 text-lg font-bold">+</button>
                                </div>
                            </div>
                        </div>
                        <div class="mt-6 pt-6 border-t border-gray-700">
                            <div class="flex justify-between items-center">
                                <span class="text-lg text-gray-300">Total Harga:</span>
                                <span class="text-3xl font-extrabold text-green-400" x-text="formatPrice(totalPrice)"></span>
                            </div>
                            <button :disabled="!isFormComplete" class="w-full mt-6 py-3 bg-green-600 text-white font-semibold rounded-lg shadow-md hover:bg-green-500 transition-all duration-300 disabled:bg-gray-600 disabled:cursor-not-allowed">
                                Lanjutkan Pembayaran
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Tag script dengan logika gambar yang disederhanakan --}}
<script>
    function bookingFormData() {
        const componentEl = document.getElementById('booking-component');
        const packageData = JSON.parse(componentEl.getAttribute('data-package'));

        return {
            package: packageData,
            mainImage: '', // Dibuat kosong dulu
            selectedDate: '',
            selectedTime: null,
            quantity: 1,
            availableTimes: [],
            isLoadingTimes: false,

            // Fungsi helper untuk memproses URL gambar
            getImageUrl(imagePath) {
                const defaultImageUrl = `{{ asset('storage/packages/default.jpg') }}`;
                if (!imagePath) return defaultImageUrl;
                if (imagePath.includes('/')) return `{{ asset('storage/') }}/${imagePath}`;
                return `{{ asset('storage/packages/') }}/${imagePath}`;
            },

            init() {
                // Atur gambar utama di sini
                this.mainImage = this.getImageUrl(this.package.image);

                // Logika untuk fetch jadwal tidak berubah
                this.$watch('selectedDate', newDate => {
                    this.selectedTime = null;
                    this.fetchAvailableTimes(newDate);
                });
            },

            fetchAvailableTimes(date) {
                if (!date) { this.availableTimes = []; return; }
                this.isLoadingTimes = true;
                fetch(`/api/schedules?package_id=${this.package.id}&date=${date}`)
                    .then(response => response.json())
                    .then(data => {
                        this.availableTimes = data;
                        this.isLoadingTimes = false;
                    }).catch(error => {
                        console.error('Gagal mengambil jadwal:', error);
                        this.isLoadingTimes = false;
                    });
            },
            getTodayDate() { return new Date().toISOString().split('T')[0]; },
            increaseQuantity() { this.quantity++; },
            decreaseQuantity() { if (this.quantity > 1) this.quantity--; },
            formatPrice(price) { return 'Rp ' + new Intl.NumberFormat('id-ID').format(price); },

            get totalPrice() { return this.package.price * this.quantity; },
            get isFormComplete() { return this.selectedDate && this.selectedTime && this.quantity > 0; }
        }
    }
</script>
@endsection