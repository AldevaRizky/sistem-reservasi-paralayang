@extends('layouts.dashboard')
@section('title', 'Manajemen Peralatan Camping')

@section('content')
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <div class="flex flex-col md:flex-row md:justify-between md:items-center w-full gap-2">
                    {{-- Judul dan Deskripsi --}}
                    <div class="flex-1">
                        <h4 class="text-lg font-semibold mb-1">Manajemen Peralatan Camping</h4>
                        <p class="text-sm text-muted">Kelola data peralatan untuk disewakan</p>
                    </div>

                    {{-- Tombol Tambah Paket --}}
                    <div class="shrink-0">
                        <a href="{{ route('admin.camping-equipment.create') }}"
                            class="btn btn-primary inline-flex items-center gap-2 whitespace-nowrap">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Tambah Paket
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
                                <th>Nama</th>
                                <th>Kategori</th>
                                <th>Harga / Hari</th>
                                <th>Total</th>
                                <th>Tersedia</th>
                                <th>Status</th>
                                <th>Gambar</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($equipments as $item)
                                <tr>
                                    <td>{{ $loop->iteration + ($equipments->currentPage() - 1) * $equipments->perPage() }}
                                    </td>
                                    <td>{{ $item->equipment_name }}</td>
                                    <td>{{ $item->category }}</td>
                                    <td>Rp{{ number_format($item->daily_rental_price, 0, ',', '.') }}</td>
                                    <td>{{ $item->total_quantity }}</td>
                                    <td>{{ $item->available_quantity }}</td>
                                    @php
                                        $statusLabels = [
                                            'available' => 'Tersedia',
                                            'unavailable' => 'Tidak Tersedia',
                                            'damaged' => 'Rusak',
                                            'maintenance' => 'Perawatan',
                                        ];

                                        $statusColors = [
                                            'available' => 'bg-green-500 text-white',
                                            'unavailable' => 'bg-red-500 text-white',
                                            'damaged' => 'bg-red-500 text-white',
                                            'maintenance' => 'bg-yellow-500 text-black',
                                        ];
                                    @endphp

                                    <td>
                                        <span
                                            class="px-2 py-1 text-xs font-semibold rounded {{ $statusColors[$item->equipment_status] ?? 'bg-gray-300' }}">
                                            {{ $statusLabels[$item->equipment_status] ?? ucfirst($item->equipment_status) }}
                                        </span>
                                    </td>

                                    <td>
                                        @if ($item->image)
                                            <img src="{{ asset('storage/' . $item->image) }}" width="80">
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.camping-equipment.edit', $item->id) }}"
                                            class="btn btn-warning btn-sm">Edit</a>
                                        <form action="{{ route('admin.camping-equipment.destroy', $item->id) }}"
                                            method="POST" class="d-inline delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-danger btn-sm btn-delete">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">{{ $equipments->links() }}</div>
            </div>
        </div>
    </div>

    <script>
        document.querySelectorAll('.btn-delete').forEach(button => {
            button.addEventListener('click', function() {
                const form = this.closest('form');
                Swal.fire({
                    title: 'Yakin ingin menghapus?',
                    text: 'Data ini tidak dapat dikembalikan!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#aaa',
                    confirmButtonText: 'Ya, hapus!'
                }).then(result => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>
@endsection
