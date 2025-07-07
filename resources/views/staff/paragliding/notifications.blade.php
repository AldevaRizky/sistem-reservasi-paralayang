@extends('layouts.dashboard')

@section('title', 'Notifikasi Reservasi Paralayang')

@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <div class="flex flex-col md:flex-row md:justify-between md:items-center w-full gap-4">
                <div class="flex-1">
                    <h4 class="text-lg font-semibold mb-1">Notifikasi Reservasi Paralayang</h4>
                    <p class="text-sm text-muted">Daftar reservasi yang perlu ditindaklanjuti</p>
                </div>
            </div>
        </div>

        <div class="card-body">
            @if(session('success'))
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: '{{ session('success') }}',
                        showConfirmButton: false,
                        timer: 2000
                    });
                </script>
            @endif

            <div class="table-responsive">
                <table class="table table-striped align-middle">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Paket</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reservations as $res)
                            <tr>
                                <td>{{ $res->customer_name }}</td>
                                <td>{{ $res->schedule->package->package_name ?? '-' }}</td>
                                <td>{{ \Carbon\Carbon::parse($res->reservation_date)->format('d M Y') }}</td>
                                <td>
                                    <span class="px-2 py-1 text-xs font-semibold rounded
                                        {{ $res->reservation_status == 'confirmed' ? 'bg-blue-500 text-white' :
                                           ($res->reservation_status == 'completed' ? 'bg-green-500 text-white' :
                                           ($res->reservation_status == 'cancelled' ? 'bg-red-500 text-white' :
                                           'bg-yellow-500 text-white')) }}">
                                        {{ ucfirst($res->reservation_status) }}
                                    </span>
                                </td>
                                <td class="flex flex-col md:flex-row gap-2">
                                    <!-- Tombol Selesai -->
                                    <form action="{{ route('staff.reservations.updateStatus', $res->id) }}" method="POST" class="inline selesai-form">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="completed">
                                        <button type="button" class="btn btn-success btn-sm btn-konfirmasi" data-status="completed">Selesai</button>
                                    </form>

                                    <!-- Tombol Batal -->
                                    <form action="{{ route('staff.reservations.updateStatus', $res->id) }}" method="POST" class="inline batal-form">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="cancelled">
                                        <button type="button" class="btn btn-danger btn-sm btn-konfirmasi" data-status="cancelled">Batal</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">Tidak ada reservasi ditemukan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.querySelectorAll('.btn-konfirmasi').forEach(button => {
        button.addEventListener('click', function (e) {
            const status = this.dataset.status;
            const form = this.closest('form');
            let message = status === 'completed' ? 'menandai reservasi sebagai selesai' : 'membatalkan reservasi';

            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: `Anda akan ${message}. Tindakan ini tidak dapat dibatalkan.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: status === 'completed' ? '#28a745' : '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, lanjutkan!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });

    @if(session('success'))
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: '{{ session('success') }}',
        showConfirmButton: false,
        timer: 2000
    });
    @endif
</script>
@endpush
