@extends('layouts.dashboard')

@section('title', 'Tambah Admin')

@section('content')
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h4>Tambah Admin</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.users.admin.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3 text-center">
                        <div class="d-flex justify-content-center mb-2">
                            <img id="preview-image" src="https://placehold.co/600x400" alt="Preview" class="rounded border" style="width: 120px; height: 120px; object-fit: cover;">
                        </div>
                        <input type="file" name="profile_photo" class="form-control" accept="image/*" onchange="previewImage(event)">
                        @error('profile_photo') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        <label>Nama Pengguna</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}">
                        @error('name') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        <label>Nama Lengkap</label>
                        <input type="text" name="full_name" class="form-control" value="{{ old('full_name') }}">
                        @error('full_name') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                        @error('email') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control">
                        @error('password') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        <label>Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label>No. HP</label>
                        <input type="text" name="phone_number" class="form-control" value="{{ old('phone_number') }}">
                        @error('phone_number') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        <label>Alamat</label>
                        <textarea name="address" class="form-control" rows="3">{{ old('address') }}</textarea>
                        @error('address') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        <label>Status</label>
                        <select name="is_active" class="form-select">
                            <option value="active" {{ old('is_active') === 'active' ? 'selected' : '' }}>Aktif</option>
                            <option value="inactive" {{ old('is_active') === 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                        </select>
                        @error('is_active') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('admin.users.admin.index') }}" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </div>
    </div>

    <script>
        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function() {
                const output = document.getElementById('preview-image');
                output.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
@endsection
