@extends('layouts.dashboard')
@section('title', 'Tambah Paket Paralayang')

@section('content')
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h4>Tambah Paket</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.paragliding-packages.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label>Nama Paket</label>
                        <input type="text" name="package_name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Deskripsi</label>
                        <textarea name="description" class="form-control" rows="4"></textarea>
                    </div>
                    <div class="mb-3">
                        <label>Durasi</label>
                        <input type="text" name="duration" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Harga</label>
                        <input type="number" name="price" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Kapasitas per Slot</label>
                        <input type="number" name="capacity_per_slot" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Syarat</label>
                        <textarea name="requirements" class="form-control"></textarea>
                    </div>
                    <div class="mb-3">
                        <label>Gambar</label>
                        <input type="file" name="image" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>Status</label>
                        <select name="is_active" class="form-select" required>
                            <option value="active"
                                {{ old('is_active', $equipment->is_active ?? '') === 'active' ? 'selected' : '' }}>
                                Aktif
                            </option>
                            <option value="inactive"
                                {{ old('is_active', $equipment->is_active ?? '') === 'inactive' ? 'selected' : '' }}>
                                Tidak Aktif
                            </option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('admin.paragliding-packages.index') }}" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </div>
    </div>
@endsection
