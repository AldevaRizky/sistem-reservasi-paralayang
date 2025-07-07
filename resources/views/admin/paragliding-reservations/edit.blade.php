@extends('layouts.dashboard')
@section('title', 'Ubah Status Booking')

@section('content')
<div class="container mt-5">
    <div class="card max-w-2xl mx-auto">
        <div class="card-header">
            <h4 class="text-lg font-semibold mb-1">Ubah Status Booking</h4>
            <p class="text-sm text-muted">Untuk: <strong>{{ $reservation->customer_name }}</strong></p>
        </div>

        <div class="card-body">
            @if (session('success'))
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Sukses',
                        text: "{{ session('success') }}",
                    });
                </script>
            @endif

            @if ($errors->any())
                <script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Terjadi Kesalahan',
                        html: `{!! implode('<br>', $errors->all()) !!}`,
                    });
                </script>
            @endif

            <form action="{{ route('admin.paragliding-reservations.update', $reservation->id) }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label for="reservation_status" class="mt-3 form-label">Status Reservasi</label>
                    <select name="reservation_status" id="reservation_status" class="form-control" required>
                        @php
                            $statusOptions = [
                                'pending' => 'Menunggu',
                                'confirmed' => 'Dikonfirmasi',
                                'cancelled' => 'Dibatalkan',
                                'completed' => 'Selesai'
                            ];
                        @endphp
                        @foreach ($statusOptions as $value => $label)
                            <option value="{{ $value }}" {{ $reservation->reservation_status === $value ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="payment_status" class="mt-3 form-label">Status Pembayaran</label>
                    <select name="payment_status" id="payment_status" class="form-control" required>
                        @php
                            $paymentOptions = [
                                'pending' => 'Menunggu Pembayaran',
                                'paid' => 'Lunas',
                                'failed' => 'Gagal',
                                'refunded' => 'Dikembalikan'
                            ];
                        @endphp
                        @foreach ($paymentOptions as $value => $label)
                            <option value="{{ $value }}" {{ optional($reservation->transaction)->payment_status === $value ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mt-6 flex justify-end gap-2">
                    <a href="{{ route('admin.paragliding-reservations.index') }}" class="btn btn-secondary">Kembali</a>
                    <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
