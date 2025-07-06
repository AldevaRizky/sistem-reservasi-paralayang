@extends('layouts.dashboard')
@section('title', 'Manajemen Jadwal Paralayang')

@section('content')
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <div class="flex flex-col md:flex-row md:justify-between md:items-center w-full gap-2">
                    {{-- Judul dan Deskripsi --}}
                    <div class="flex-1">
                        <h4 class="text-lg font-semibold mb-1">Manajemen Jadwal Paralayang</h4>
                        <p class="text-sm text-muted">Daftar jadwal berdasarkan paket dan waktu.</p>
                    </div>

                    {{-- Tombol Tambah Jadwal --}}
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

                @if ($errors->any())
                    <script>
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            html: `{!! implode('<br>', $errors->all()) !!}`,
                        });
                    </script>
                @endif

                <div class="table-responsive">
                    <table class="table table-striped align-middle">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Paket</th>
                                <th>Waktu</th>
                                <th>Kuota</th>
                                <th>Staff</th>
                                <th>Catatan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($schedules as $schedule)
                                <tr>
                                    <td>{{ $loop->iteration + ($schedules->currentPage() - 1) * $schedules->perPage() }}</td>
                                    <td>{{ $schedule->package->package_name ?? '-' }}</td>
                                    <td>{{ $schedule->time_slot }}</td>
                                    <td>{{ $schedule->quota }}</td>
                                    <td>
                                        @php
                                            $staffNames = $schedule->staffs()->pluck('name')->toArray();
                                        @endphp
                                        {{ implode(', ', $staffNames) ?: '-' }}
                                    </td>
                                    <td>{{ $schedule->notes }}</td>
                                    <td>
                                        <a href="{{ route('admin.paragliding-schedules.edit', $schedule->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                        <form action="{{ route('admin.paragliding-schedules.destroy', $schedule->id) }}" method="POST" class="d-inline delete-form">
                                            @csrf @method('DELETE')
                                            <button type="button" class="btn btn-danger btn-sm btn-delete">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">{{ $schedules->links() }}</div>
            </div>
        </div>
    </div>

    <script>
        document.querySelectorAll('.btn-delete').forEach(button => {
            button.addEventListener('click', function () {
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
                    if (result.isConfirmed) form.submit();
                });
            });
        });
    </script>
@endsection
