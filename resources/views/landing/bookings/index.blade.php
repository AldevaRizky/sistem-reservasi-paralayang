@extends('layouts.landing')

@section('title', 'Booking Saya')

@section('content')
<div class="bg-[#0A2025] pt-12 pb-24 text-white">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold mb-6">Daftar Booking Saya</h1>

        @if($bookings->isEmpty())
            <p class="text-gray-300">Anda belum memiliki booking.</p>
        @else
            <div class="space-y-6">
                @foreach($bookings as $booking)
                    <div class="bg-gray-800 p-6 rounded-lg shadow-md">
                        <h2 class="text-xl font-bold mb-2">{{ $booking->package->package_name }}</h2>
                        <p class="text-gray-300">Tanggal: <strong>{{ \Carbon\Carbon::parse($booking->reservation_date)->translatedFormat('l, d F Y') }}</strong></p>
                        <p class="text-gray-300">Jam: <strong>{{ $booking->schedule->time_slot }}</strong></p>
                        <p class="text-gray-300">Jumlah Peserta: <strong>{{ $booking->participant_count }}</strong></p>
                        <p class="text-gray-300">Total: <strong class="text-green-400">Rp{{ number_format($booking->total_price, 0, ',', '.') }}</strong></p>
                        <p class="text-gray-300">Status:
                            <span class="font-semibold {{ $booking->reservation_status === 'pending' ? 'text-yellow-400' : 'text-green-500' }}">
                                {{ ucfirst($booking->reservation_status) }}
                            </span>
                        </p>

                        @if($booking->reservation_status === 'pending')
                            <button onclick="payNow({{ $booking->id }})"
                                class="mt-4 inline-block px-4 py-2 bg-green-600 hover:bg-green-500 text-white rounded-lg shadow">
                                Bayar Sekarang
                            </button>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
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
                alert('Pembayaran berhasil!');
                window.location.reload();
            },
            onPending: function(result) {
                alert('Pembayaran sedang diproses.');
                window.location.reload();
            },
            onError: function(result) {
                alert('Pembayaran gagal!');
            },
            onClose: function() {
                alert('Anda menutup pembayaran tanpa menyelesaikannya.');
            }
        });
    });
}
</script>
@endsection
