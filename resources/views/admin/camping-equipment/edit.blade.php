@extends('layouts.dashboard')

@section('title', 'Edit Peralatan Camping')

@section('content')
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h4>Edit Peralatan</h4>
            </div>
            <div class="card-body">

                <form action="{{ route('admin.camping-equipment.update', ['camping_equipment' => $equipment->id]) }}"
                    method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label>Nama Peralatan</label>
                        <input type="text" name="equipment_name" class="form-control"
                            value="{{ old('equipment_name', $equipment->equipment_name) }}" required>
                    </div>

                    <div class="mb-3">
                        <label>Kategori</label>
                        <input type="text" name="category" class="form-control"
                            value="{{ old('category', $equipment->category) }}" required>
                    </div>

                    <div class="mb-3">
                        <label>Deskripsi</label>
                        <textarea name="description" class="form-control" rows="4">{{ old('description', $equipment->description) }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label>Harga Sewa / Hari</label>
                        <input type="number" name="daily_rental_price" class="form-control"
                            value="{{ old('daily_rental_price', $equipment->daily_rental_price) }}" required>
                    </div>

                    <div class="mb-3">
                        <label>Total Jumlah</label>
                        <input type="number" name="total_quantity" class="form-control"
                            value="{{ old('total_quantity', $equipment->total_quantity) }}" required>
                    </div>

                    <div class="mb-3">
                        <label>Jumlah Tersedia</label>
                        <input type="number" name="available_quantity" class="form-control"
                            value="{{ old('available_quantity', $equipment->available_quantity) }}" required>
                    </div>

                    <div class="mb-3">
                        <label>Gambar</label>
                        <input type="file" name="image" class="form-control">
                        @if ($equipment->image)
                            <div class="mt-2">
                                <img src="{{ asset('storage/' . $equipment->image) }}" width="120"
                                    alt="Gambar peralatan">
                            </div>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label>Status</label>
                        @php
                            $statusLabels = [
                                'available' => 'Tersedia',
                                'unavailable' => 'Tidak Tersedia',
                                'damaged' => 'Rusak',
                                'maintenance' => 'Perawatan',
                            ];
                        @endphp

                        <select name="equipment_status" class="form-select" required>
                            @foreach (['available', 'unavailable', 'damaged', 'maintenance'] as $status)
                                <option value="{{ $status }}"
                                    {{ old('equipment_status', $equipment->equipment_status) === $status ? 'selected' : '' }}>
                                    {{ $statusLabels[$status] }}
                                </option>
                            @endforeach
                        </select>

                    </div>

                    <button type="submit" class="btn btn-warning">Perbarui</button>
                    <a href="{{ route('admin.camping-equipment.index') }}" class="btn btn-secondary">Kembali</a>
                </form>

            </div>
        </div>
    </div>
@endsection
