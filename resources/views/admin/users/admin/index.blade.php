@extends('layouts.dashboard')
@section('title', 'Manajemen Admin')

@section('content')
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <div class="flex flex-col md:flex-row md:justify-between md:items-center w-full gap-2">
                    <div class="flex-1">
                        <h4 class="text-lg font-semibold mb-1">Manajemen Admin</h4>
                        <p class="text-sm text-muted">Kelola akun administrator sistem</p>
                    </div>

                    <div class="shrink-0">
                        <a href="{{ route('admin.users.admin.create') }}"
                            class="btn btn-primary inline-flex items-center gap-2 whitespace-nowrap">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Tambah Admin
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
                                <th>Email</th>
                                <th>No. HP</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($admins as $admin)
                                <tr>
                                    <td>{{ $loop->iteration + ($admins->currentPage() - 1) * $admins->perPage() }}</td>
                                    <td>{{ $admin->detail->full_name ?? $admin->name }}</td>
                                    <td>{{ $admin->email }}</td>
                                    <td>{{ $admin->detail->phone_number ?? '-' }}</td>
                                    @php
                                        $statusLabels = [
                                            'active' => 'Aktif',
                                            'inactive' => 'Tidak Aktif',
                                        ];

                                        $statusColors = [
                                            'active' => 'bg-green-500 text-white',
                                            'inactive' => 'bg-red-500 text-white',
                                        ];

                                        $status = $admin->detail->is_active ?? null;
                                    @endphp

                                    <td>
                                        <span
                                            class="px-2 py-1 text-xs font-semibold rounded {{ $statusColors[$status] ?? 'bg-yellow-500 text-white' }}">
                                            {{ $statusLabels[$status] ?? 'Belum diatur' }}
                                        </span>
                                    </td>

                                    <td>
                                        <a href="{{ route('admin.users.admin.edit', $admin->id) }}"
                                            class="btn btn-warning btn-sm">Edit</a>
                                        <form action="{{ route('admin.users.admin.destroy', $admin->id) }}" method="POST"
                                            class="d-inline delete-form">
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

                <div class="mt-3">
                    {{ $admins->links() }}
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
