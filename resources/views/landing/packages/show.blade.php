@extends('layouts.landing')

@section('title', $package->package_name)

@section('content')
    <div class="bg-[#0A2025] pt-12 pb-24 text-white">
        <div id="booking-component" data-package='@json($package)' x-data="bookingFormData()" x-init="$watch('selectedDate', value => fetchAvailableTimes())"
            class="container mx-auto px-4 sm:px-6 lg:px-8">

            <div class="grid grid-cols-1 lg:grid-cols-5 gap-x-12">
                <!-- Left: Package Details -->
                <div class="lg:col-span-3">
                    <div class="aspect-w-16 aspect-h-9 rounded-lg overflow-hidden bg-gray-800 mb-4">
                        <img :src="mainImageUrl" alt="Main package image" class="w-full h-full object-cover">
                    </div>

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

                <!-- Right: Booking Form -->
                <div class="lg:col-span-2 mt-10 lg:mt-0">
                    <div
                        class="lg:sticky top-28 h-fit bg-gray-800/50 backdrop-blur-sm border border-gray-700 rounded-xl p-6">
                        <div class="pb-6 border-b border-gray-700">
                            <h3 class="text-2xl font-bold mb-4">Mulai Pemesanan Anda</h3>
                            <div>
                                <label class="font-semibold">Langkah 1: Pilih Tanggal</label>
                                <input type="date" x-model="selectedDate" :min="getTodayDate()" :max="getMaxDate()"
                                    class="mt-2 block w-full rounded-lg bg-gray-700 border-gray-600 text-white p-2.5 focus:ring-green-500 focus:border-green-500"
                                    style="color-scheme: dark;">
                            </div>
                            <div class="mt-6">
                                <label class="font-semibold">Langkah 2: Pilih Jam Terbang</label>
                                <div x-show="isLoadingTimes" class="mt-2 text-gray-400 animate-pulse">Mencari jadwal...
                                </div>
                                <div x-show="!isLoadingTimes && selectedDate && availableTimesSorted.length === 0"
                                    class="mt-2 text-yellow-400 text-sm">
                                    Tidak ada jadwal tersedia pada tanggal ini.
                                </div>
                                <div x-show="!isLoadingTimes && availableTimesSorted.length > 0"
                                    class="grid grid-cols-2 sm:grid-cols-3 gap-3 mt-2">
                                    <template x-for="slot in availableTimesSorted" :key="slot.time">
                                        <button @click="selectTime(slot.time)" :disabled="!isTimeSelectable(slot.time)"
                                            :class="{
                                                'bg-green-600 text-white': selectedTime === slot.time &&
                                                    isTimeSelectable(slot.time),
                                                'bg-gray-700 hover:bg-gray-600': selectedTime !== slot.time &&
                                                    isTimeSelectable(slot.time),
                                                'bg-gray-800 text-gray-500 cursor-not-allowed': !isTimeSelectable(slot
                                                    .time)
                                            }"
                                            class="p-3 rounded-lg text-center transition-colors duration-200">
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
                                <div class="flex justify-between"><span class="text-gray-400">Paket:</span><strong
                                        x-text="package.package_name"></strong></div>
                                <div class="flex justify-between"><span class="text-gray-400">Tanggal:</span><strong
                                        x-text="selectedDate ? new Date(selectedDate).toLocaleDateString('id-ID', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' }) : '-'"
                                        class="text-right"></strong></div>
                                <div class="flex justify-between"><span class="text-gray-400">Waktu:</span><strong
                                        x-text="selectedTime || '-'" class="text-right"></strong></div>
                                <div class="flex justify-between items-center"><span class="text-gray-400">Jumlah
                                        Orang:</span>
                                    <div class="flex items-center gap-3 bg-gray-700 rounded-full">
                                        <button @click="decreaseQuantity()"
                                            class="w-8 h-8 rounded-full hover:bg-gray-600 text-lg font-bold">-</button>
                                        <span x-text="quantity" class="font-bold text-lg"></span>
                                        <button @click="increaseQuantity()"
                                            class="w-8 h-8 rounded-full hover:bg-gray-600 text-lg font-bold">+</button>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-6 pt-6 border-t border-gray-700">
                                <div class="flex justify-between items-center">
                                    <span class="text-lg text-gray-300">Total Harga:</span>
                                    <span class="text-3xl font-extrabold text-green-400"
                                        x-text="formatPrice(totalPrice)"></span>
                                </div>
                                <button @click="bookNow" :disabled="!isFormComplete"
                                    class="w-full mt-6 py-3 bg-green-600 text-white font-semibold rounded-lg shadow-md hover:bg-green-500 transition-all duration-300 disabled:bg-gray-600 disabled:cursor-not-allowed">
                                    Booking
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const isLoggedIn = @json(auth()->check() && auth()->user()->role === 'user');

        function bookingFormData() {
            return {
                package: @json($package),
                selectedDate: '',
                selectedTime: '',
                quantity: 1,
                availableTimes: [],
                isLoadingTimes: false,

                get mainImageUrl() {
                    return this.package.image.startsWith('http') ? this.package.image :
                    `/storage/${this.package.image}`;
                },

                get totalPrice() {
                    return this.package.price * this.quantity;
                },

                get isFormComplete() {
                    return this.selectedDate && this.selectedTime && this.quantity > 0;
                },

                getTodayDate() {
                    return new Date().toLocaleDateString("en-CA", {
                        timeZone: "Asia/Jakarta"
                    });
                },

                getMaxDate() {
                    const maxDate = new Date();
                    maxDate.setDate(maxDate.getDate() + 14);
                    return maxDate.toISOString().split("T")[0];
                },

                formatPrice(amount) {
                    return new Intl.NumberFormat('id-ID', {
                        style: 'currency',
                        currency: 'IDR'
                    }).format(amount);
                },

                fetchAvailableTimes() {
                    if (!this.selectedDate) return;
                    this.isLoadingTimes = true;

                    fetch(`/packages/get-schedules`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify({
                                date: this.selectedDate,
                                package_id: this.package.id
                            })
                        })
                        .then(res => res.json())
                        .then(data => {
                            this.availableTimes = data.availableTimes || [];
                        })
                        .finally(() => {
                            this.isLoadingTimes = false;
                        });
                },

                increaseQuantity() {
                    const selected = this.availableTimes.find(t => t.time === this.selectedTime);
                    if (selected && this.quantity < selected.slots) {
                        this.quantity++;
                    }
                },

                decreaseQuantity() {
                    if (this.quantity > 1) this.quantity--;
                },

                selectTime(time) {
                    if (this.isTimeSelectable(time)) {
                        this.selectedTime = time;
                    }
                },

                isTimeSelectable(slotTime) {
                    if (!this.selectedDate) return false;

                    const slot = this.availableTimes.find(t => t.time === slotTime);
                    if (!slot || !slot.available) return false;

                    const today = new Date().toLocaleDateString("en-CA", {
                        timeZone: "Asia/Jakarta"
                    });
                    if (this.selectedDate !== today) return true;

                    const [hours, minutes] = slotTime.split(":");
                    const now = new Date().toLocaleString("en-US", {
                        timeZone: "Asia/Jakarta"
                    });
                    const nowDate = new Date(now);
                    const scheduleDate = new Date(`${this.selectedDate}T${hours}:${minutes}:00+07:00`);

                    return scheduleDate > nowDate;
                },

                get availableTimesSorted() {
                    return this.availableTimes.slice().sort((a, b) => a.time.localeCompare(b.time));
                },

                bookNow() {
                    if (!this.isFormComplete) return;

                    if (!isLoggedIn) {
                        window.location.href = '/login';
                        return;
                    }

                    const selectedSchedule = this.availableTimes.find(t => t.time === this.selectedTime);
                    if (!selectedSchedule) {
                        Swal.fire('Gagal!', 'Jadwal tidak ditemukan.', 'error');
                        return;
                    }

                    fetch(`/packages/booking`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify({
                                package_id: this.package.id,
                                reservation_date: this.selectedDate,
                                schedule_time: this.selectedTime,
                                participant_count: this.quantity,
                            })
                        })
                        .then(res => {
                            if (!res.ok) throw new Error('Server error');
                            return res.json();
                        })
                        .then(data => {
                            Swal.fire('Berhasil!', data.message, 'success').then(() => {
                                if (data.reservation_id) {
                                    window.location.href = `/booking/confirmation/${data.reservation_id}`;
                                }
                            });
                        })
                        .catch(() => {
                            Swal.fire('Gagal!', 'Terjadi kesalahan saat memproses booking.', 'error');
                        });
                }
            };
        }
    </script>
@endsection
