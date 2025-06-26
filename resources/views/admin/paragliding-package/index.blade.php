@extends('layouts.dashboard')
@section('title', 'Manajemen Paket Paralayang')

@section('content')
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <div class="flex flex-col md:flex-row md:justify-between md:items-center w-full gap-2">
                    {{-- Judul dan Deskripsi --}}
                    <div class="flex-1">
                        <h4 class="text-lg font-semibold mb-1">Manajemen Paket Paralayang</h4>
                        <p class="text-sm text-muted">Tambahkan data paket paralayang sesuai kebutuhan.</p>
                    </div>

                    {{-- Tombol Tambah Paket --}}
                    <div class="shrink-0">
                        <a href="{{ route('admin.paragliding-packages.create') }}"
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
                                <th>Nama Paket</th>
                                <th>Durasi</th>
                                <th>Harga</th>
                                <th>Kapasitas</th>
                                <th>Status</th>
                                <th>Gambar</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($packages as $pkg)
                                <tr>
                                    <td>{{ $loop->iteration + ($packages->currentPage() - 1) * $packages->perPage() }}</td>
                                    <td>{{ $pkg->package_name }}</td>
                                    <td>{{ $pkg->duration }}</td>
                                    <td>Rp{{ number_format($pkg->price, 0, ',', '.') }}</td>
                                    <td>{{ $pkg->capacity_per_slot }}</td>
                                    <td>
                                        <span class="badge bg-{{ $pkg->is_active === 'active' ? 'success' : 'secondary' }}">
                                            {{ ucfirst($pkg->is_active) }}
                                        </span>
                                    </td>
                                    <td>
                                        @if ($pkg->image)
                                            <img src="{{ asset('storage/' . $pkg->image) }}"
                                                style="width: 100px; height: 60px; object-fit: cover;">
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.paragliding-packages.edit', $pkg->id) }}"
                                            class="btn btn-warning btn-sm">Edit</a>
                                        <form action="{{ route('admin.paragliding-packages.destroy', $pkg->id) }}"
                                            method="POST" class="d-inline delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-danger btn-sm btn-delete"
                                                data-id="{{ $pkg->id }}">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    {{ $packages->links() }}
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
