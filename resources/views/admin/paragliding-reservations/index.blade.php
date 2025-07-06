@extends('layouts.dashboard')
@section('title', 'Daftar Booking Paralayang')

@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <div class="flex flex-col md:flex-row md:justify-between md:items-center w-full gap-4">
                <div class="flex-1">
                    <h4 class="text-lg font-semibold mb-1">Daftar Booking Paralayang</h4>
                    <p class="text-sm text-muted">Kelola data reservasi paralayang pengguna</p>
                </div>

                <div class="flex-shrink-0">
                    <form method="GET" class="flex items-center gap-2">
                        <input type="date" name="date" value="{{ $parsedDate }}" class="form-control w-auto" />
                        <button type="submit" class="btn btn-primary">Filter</button>
                    </form>
                </div>
            </div>
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

            <div class="table-responsive">
                <table class="table table-striped align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Alamat</th>
                            <th>No. HP</th>
                            <th>Paket</th>
                            <th>Jadwal</th>
                            <th>Status Reservasi</th>
                            <th>Status Pembayaran</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($reservations as $reservation)
                            @php
                                $statusReservasi = [
                                    'pending' => 'Menunggu',
                                    'confirmed' => 'Dikonfirmasi',
                                    'cancelled' => 'Dibatalkan',
                                    'completed' => 'Selesai',
                                ];

                                $statusPembayaran = [
                                    'pending' => 'Menunggu Pembayaran',
                                    'paid' => 'Lunas',
                                    'failed' => 'Gagal',
                                    'refunded' => 'Dikembalikan',
                                ];

                                $statusReservasiColor = [
                                    'pending' => 'bg-yellow-500 text-white',
                                    'confirmed' => 'bg-blue-500 text-white',
                                    'cancelled' => 'bg-red-500 text-white',
                                    'completed' => 'bg-green-500 text-white',
                                ];

                                $statusPembayaranColor = [
                                    'pending' => 'bg-yellow-500 text-white',
                                    'paid' => 'bg-green-500 text-white',
                                    'failed' => 'bg-red-500 text-white',
                                    'refunded' => 'bg-yellow-500 text-white',
                                ];
                            @endphp
                            <tr>
                                <td>{{ $loop->iteration + ($reservations->currentPage() - 1) * $reservations->perPage() }}</td>
                                <td>{{ $reservation->customer_name ?? '-' }}</td>
                                <td>{{ $reservation->user->email ?? '-' }}</td>
                                <td>{{ $reservation->customer_address ?? '-' }}</td>
                                <td>{{ $reservation->customer_phone ?? '-' }}</td>
                                <td>{{ $reservation->package->package_name ?? '-' }}</td>
                                <td>{{ optional($reservation->schedule)->time_slot ? \Carbon\Carbon::parse($reservation->schedule->time_slot)->format('H:i') : '-' }}</td>
                                <td>
                                    <span class="px-2 py-1 text-xs font-semibold rounded {{ $statusReservasiColor[$reservation->reservation_status] ?? 'bg-gray-300 text-black' }}">
                                        {{ $statusReservasi[$reservation->reservation_status] ?? '-' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="px-2 py-1 text-xs font-semibold rounded {{ $statusPembayaranColor[$reservation->transaction->payment_status ?? ''] ?? 'bg-gray-300 text-black' }}">
                                        {{ $statusPembayaran[$reservation->transaction->payment_status ?? ''] ?? 'Belum Ada' }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.paragliding-reservations.edit', $reservation->id) }}"
                                        class="btn btn-warning btn-sm">Ubah Status</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $reservations->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
