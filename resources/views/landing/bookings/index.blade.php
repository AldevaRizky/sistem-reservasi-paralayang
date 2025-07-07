@extends('layouts.landing')

@section('title', 'Booking Saya')

@section('content')
    <div class="bg-[#0A2025] pt-16 pb-24 min-h-screen text-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl font-extrabold mb-10 text-center">📋 Booking Saya</h1>

            @if ($bookings->isEmpty())
                <div class="text-center text-gray-300 text-lg">Anda belum memiliki booking.</div>
            @else
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($bookings as $booking)
                        @php
                            $status = optional($booking->transaction)->payment_status;

                            if (empty($status)) {
                                $status = 'pending';
                            }

                            $statusLabel = match ($status) {
                                'settlement', 'capture', 'paid' => 'Lunas',
                                'pending' => 'Menunggu Pembayaran',
                                'deny', 'cancel', 'expire' => 'Gagal',
                                'refund', 'chargeback' => 'Dikembalikan',
                                default => ucfirst($status),
                            };

                            $statusColor = match ($status) {
                                'settlement', 'capture', 'paid' => 'bg-green-500 text-white',
                                'pending' => 'bg-yellow-400 text-black',
                                'deny', 'cancel', 'expire' => 'bg-red-500 text-white',
                                'refund', 'chargeback' => 'bg-blue-400 text-white',
                                default => 'bg-gray-500 text-white',
                            };
                        @endphp
                        <div class="bg-gray-800 rounded-xl shadow-lg p-6 space-y-4 hover:shadow-2xl transition">
                            <div class="flex justify-between items-center">
                                <h2 class="text-2xl font-bold">{{ $booking->package->package_name }}</h2>
                                <span
                                    class="px-3 py-1 rounded-full text-sm font-semibold
                                {{ $booking->reservation_status === 'pending' ? 'bg-yellow-500 text-black' : 'bg-green-600 text-white' }}">
                                    {{ ucfirst($booking->reservation_status) }}
                                </span>
                            </div>

                            <div class="text-sm text-gray-300 space-y-1">
                                <p><span class="font-semibold">📅 Tanggal:</span>
                                    {{ \Carbon\Carbon::parse($booking->reservation_date)->translatedFormat('l, d F Y') }}
                                </p>
                                <p><span class="font-semibold">🕐 Waktu:</span> {{ $booking->schedule->time_slot }}</p>
                                <p><span class="font-semibold">👥 Peserta:</span> {{ $booking->participant_count }} orang
                                </p>
                                <p><span class="font-semibold">💰 Total:</span> <span
                                        class="text-green-400 font-bold">Rp{{ number_format($booking->total_price, 0, ',', '.') }}</span>
                                </p>
                                <p><span class="font-semibold">💳 Status Pembayaran:</span>
                                    <span
                                        class="inline-block rounded px-2 py-1 text-xs font-semibold {{ $statusColor }}">{{ $statusLabel }}</span>
                                </p>
                            </div>

                            @if ($booking->reservation_status === 'pending')
                                <button onclick="payNow({{ $booking->id }})"
                                    class="w-full mt-4 py-2 bg-green-600 hover:bg-green-500 text-white rounded-lg font-semibold transition duration-200 ease-in-out">
                                    💳 Bayar Sekarang
                                </button>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    {{-- Midtrans & SweetAlert --}}
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function payNow(bookingId) {
            fetch(`/my-bookings/pay/${bookingId}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    window.snap.pay(data.snapToken, {
                        onSuccess: function(result) {
                            Swal.fire({
                                title: 'Berhasil!',
                                text: 'Pembayaran berhasil diproses.',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then(() => window.location.reload());
                        },
                        onPending: function(result) {
                            Swal.fire({
                                title: 'Menunggu Pembayaran',
                                text: 'Silakan selesaikan pembayaran Anda.',
                                icon: 'info',
                                confirmButtonText: 'OK'
                            }).then(() => window.location.reload());
                        },
                        onError: function(result) {
                            Swal.fire({
                                title: 'Gagal!',
                                text: 'Terjadi kesalahan saat pembayaran.',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        },
                        onClose: function() {
                            Swal.fire({
                                title: 'Dibatalkan',
                                text: 'Anda menutup pembayaran tanpa menyelesaikannya.',
                                icon: 'warning',
                                confirmButtonText: 'OK'
                            });
                        }
                    });
                });
        }
    </script>
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
@endsection
