@extends('layouts.dashboard')
@section('title', 'Manajemen Users')

@section('content')
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <div class="flex flex-col md:flex-row md:justify-between md:items-center w-full gap-2">
                    <div class="flex-1">
                        <h4 class="text-lg font-semibold mb-1">Manajemen Users</h4>
                        <p class="text-sm text-muted">Mengelola data pengguna, status aktif, serta detail akun dengan mudah.</p>
                    </div>

                    <div class="shrink-0">
                        <a href="{{ route('admin.users.user.create') }}"
                            class="btn btn-primary inline-flex items-center gap-2 whitespace-nowrap">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Tambah Users
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
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}</td>
                                    <td>{{ $user->detail->full_name ?? $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->detail->phone_number ?? '-' }}</td>
                                    @php
                                        $statusLabels = [
                                            'active' => 'Aktif',
                                            'inactive' => 'Tidak Aktif',
                                        ];

                                        $statusColors = [
                                            'active' => 'bg-green-500 text-white',
                                            'inactive' => 'bg-red-500 text-white',
                                        ];

                                        $status = $user->detail->is_active ?? null;
                                    @endphp

                                    <td>
                                        <span
                                            class="px-2 py-1 text-xs font-semibold rounded {{ $statusColors[$status] ?? 'bg-yellow-500 text-white' }}">
                                            {{ $statusLabels[$status] ?? 'Belum diatur' }}
                                        </span>
                                    </td>

                                    <td>
                                        <a href="{{ route('admin.users.user.edit', $user->id) }}"
                                            class="btn btn-warning btn-sm">Edit</a>
                                        <form action="{{ route('admin.users.user.destroy', $user->id) }}" method="POST"
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
                    {{ $users->links() }}
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
