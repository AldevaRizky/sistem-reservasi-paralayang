@extends('layouts.dashboard')
@section('title', 'Manajemen Jadwal Paralayang')

@section('content')
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <div class="flex flex-col md:flex-row md:justify-between md:items-center w-full gap-2">
                    <div class="flex-1">
                        <h4 class="text-lg font-semibold mb-1">Manajemen Jadwal Paralayang</h4>
                        <p class="text-sm text-muted">Atur jadwal terbang berdasarkan paket yang tersedia.</p>
                    </div>
                    <div class="shrink-0">
                        <a href="{{ route('admin.paragliding-schedules.create') }}"
                            class="btn btn-primary inline-flex items-center gap-2 whitespace-nowrap">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Tambah Jadwal
                        </a>
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

                <div class="table-responsive">
                    <table class="table table-striped align-middle">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Paket</th>
                                <th>Tanggal</th>
                                <th>Jam Mulai</th>
                                <th>Jam Selesai</th>
                                <th>Slot Tersedia</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($schedules as $schedule)
                                <tr>
                                    <td>{{ $loop->iteration + ($schedules->currentPage() - 1) * $schedules->perPage() }}
                                    </td>
                                    <td>{{ $schedule->package->package_name ?? '-' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($schedule->date)->format('d M Y') }}</td>
                                    <td>{{ $schedule->start_time }}</td>
                                    <td>{{ $schedule->end_time }}</td>
                                    <td>{{ $schedule->available_slots }}</td>
                                    @php
                                        switch ($schedule->status) {
                                            case 'available':
                                                $statusText = 'Tersedia';
                                                $statusColor = 'bg-green-500 text-white';
                                                break;
                                            case 'unavailable':
                                                $statusText = 'Tidak Tersedia';
                                                $statusColor = 'bg-yellow-500 text-black';
                                                break;
                                            case 'full':
                                                $statusText = 'Penuh';
                                                $statusColor = 'bg-red-500 text-white';
                                                break;
                                            default:
                                                $statusText = 'Tidak Diketahui';
                                                $statusColor = 'bg-red-500 text-black';
                                        }
                                    @endphp

                                    <td>
                                        <span class="px-2 py-1 text-sm font-semibold rounded {{ $statusColor }}">
                                            {{ $statusText }}
                                        </span>
                                    </td>

                                    <td>
                                        <a href="{{ route('admin.paragliding-schedules.edit', $schedule->id) }}"
                                            class="btn btn-warning btn-sm">Edit</a>
                                        <form action="{{ route('admin.paragliding-schedules.destroy', $schedule->id) }}"
                                            method="POST" class="d-inline delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-danger btn-sm btn-delete"
                                                data-id="{{ $schedule->id }}">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    {{ $schedules->links() }}
                </div>
            </div>
        </div>
    </div>

    <script>
        document.querySelectorAll('.btn-delete').forEach(button => {
            button.addEventListener('click', function() {
                const form = this.closest('form');
                Swal.fire({
                    title: 'Yakin ingin menghapus?',
                    text: "Data tidak dapat dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>
@endsection
