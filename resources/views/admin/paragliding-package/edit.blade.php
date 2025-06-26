@extends('layouts.dashboard')
@section('title', 'Edit Paket Paralayang')

@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h4>Edit Paket</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.paragliding-packages.update', $paraglidingPackage->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label>Nama Paket</label>
                    <input type="text" name="package_name" class="form-control" value="{{ $paraglidingPackage->package_name }}" required>
                </div>
                <div class="mb-3">
                    <label>Deskripsi</label>
                    <textarea name="description" class="form-control" rows="4">{{ $paraglidingPackage->description }}</textarea>
                </div>
                <div class="mb-3">
                    <label>Durasi</label>
                    <input type="text" name="duration" class="form-control" value="{{ $paraglidingPackage->duration }}" required>
                </div>
                <div class="mb-3">
                    <label>Harga</label>
                    <input type="number" name="price" class="form-control" value="{{ $paraglidingPackage->price }}" required>
                </div>
                <div class="mb-3">
                    <label>Kapasitas per Slot</label>
                    <input type="number" name="capacity_per_slot" class="form-control" value="{{ $paraglidingPackage->capacity_per_slot }}" required>
                </div>
                <div class="mb-3">
                    <label>Syarat</label>
                    <textarea name="requirements" class="form-control">{{ $paraglidingPackage->requirements }}</textarea>
                </div>
                <div class="mb-3">
                    <label>Gambar</label>
                    <input type="file" name="image" class="form-control">
                    @if ($paraglidingPackage->image)
                        <div class="mt-2">
                            <img src="{{ asset('storage/' . $paraglidingPackage->image) }}" width="120">
                        </div>
                    @endif
                </div>
                <div class="mb-3">
                    <label>Status</label>
                    <select name="is_active" class="form-select" required>
                        <option value="active" {{ $paraglidingPackage->is_active === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ $paraglidingPackage->is_active === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-warning">Perbarui</button>
                <a href="{{ route('admin.paragliding-packages.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection
