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
                                <th>Nama Paket</th>
                                <th>Tanggal</th>
                                <th>Waktu</th>
                                <th>Slot (Dipesan/Kuota)</th>
                                <th>Sisa Slot</th>
                                <th>Status</th>
                                <th>Staf Bertugas</th>
                                <th>Catatan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($schedules as $schedule)
                                <tr class="{{ \Carbon\Carbon::parse($schedule->schedule_date . ' ' . $schedule->time_slot)->isPast() ? 'bg-secondary bg-opacity-10' : '' }}">
                                    <td>{{ $loop->iteration + ($schedules->currentPage() - 1) * $schedules->perPage() }}
                                    </td>
                                    <td>{{ $schedule->package->package_name ?? '-' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($schedule->schedule_date)->format('d M Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($schedule->time_slot)->format('H:i') }}</td>
                                    <td>{{ $schedule->booked_slots }} / {{ $schedule->quota }}</td>
                                    
                                    @php
                                        $availableSlots = $schedule->quota - $schedule->booked_slots;
                                        
                                        if ($availableSlots <= 0) {
                                            $statusText = 'Penuh';
                                            $statusColor = 'bg-red-500 text-white';
                                        } else {
                                            $statusText = 'Tersedia';
                                            $statusColor = 'bg-green-500 text-white';
                                        }
                                    @endphp
                                    
                                    <td>{{ $availableSlots }}</td>

                                    <td>
                                        <span class="badge {{ $statusColor }}">
                                            {{ $statusText }}
                                        </span>
                                    </td>
                                    
                                    {{-- PENYESUAIAN UTAMA: Menampilkan hanya nama depan staf --}}
                                    <td>
                                        @forelse($schedule->staffs as $staff)
                                            {{-- Ambil bagian pertama dari nama setelah dipecah oleh spasi --}}
                                            <span class="badge bg-primary mb-1">{{ explode(' ', $staff->name)[0] }}</span>
                                        @empty
                                            -
                                        @endforelse
                                    </td>

                                    <td>
                                        @if($schedule->notes)
                                            <span title="{{ $schedule->notes }}">
                                                {{ \Illuminate\Support\Str::limit($schedule->notes, 30, '...') }}
                                            </span>
                                        @else
                                            -
                                        @endif
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
                            @empty
                                <tr>
                                    <td colspan="10" class="text-center">
                                        Belum ada data jadwal. Silakan <a href="{{ route('admin.paragliding-schedules.create') }}">tambah jadwal baru</a>.
                                    </td>
                                </tr>
                            @endforelse
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
                    text: "Data yang dihapus tidak dapat dikembalikan!",
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
