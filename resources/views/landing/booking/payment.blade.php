@extends('layouts.landing')
@section('title', 'Pembayaran')
@section('content')
<div class="container mx-auto py-8">
    <h2 class="text-2xl font-bold mb-4">Pembayaran untuk: {{ $transaction->reservation->package->name }}</h2>
    <p>Total Pembayaran: <strong>Rp{{ number_format($transaction->total_payment, 0, ',', '.') }}</strong></p>

    @if ($transaction->payment_token)
        <div id="payment-button" class="mt-4">
            <button id="pay-button" class="bg-green-600 text-white px-4 py-2 rounded">Bayar Sekarang</button>
        </div>
    @else
        <p class="text-red-500">Token pembayaran tidak tersedia.</p>
    @endif
</div>

<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.client_key') }}"></script>
<script>
    document.getElementById('pay-button')?.addEventListener('click', function () {
        snap.pay('{{ $transaction->payment_token }}', {
            onSuccess: function(result) {
                alert('Pembayaran berhasil!');
                location.reload();
            },
            onPending: function(result) {
                alert('Menunggu pembayaran...');
            },
            onError: function(result) {
                alert('Terjadi kesalahan saat pembayaran.');
            },
            onClose: function() {
                alert('Kamu belum menyelesaikan pembayaran.');
            }
        });
    });
</script>
@endsection
