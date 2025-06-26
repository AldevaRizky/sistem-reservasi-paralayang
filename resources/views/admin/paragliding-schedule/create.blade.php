@extends('layouts.dashboard')
@section('title', 'Tambah Jadwal Paralayang')

@section('content')
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h4>Tambah Jadwal</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.paragliding-schedules.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label>Paket</label>
                        <select name="package_id" class="form-select" required>
                            <option value="">-- Pilih Paket --</option>
                            @foreach ($packages as $pkg)
                                <option value="{{ $pkg->id }}">{{ $pkg->package_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Tanggal</label>
                        <input type="date" name="date" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Jam Mulai</label>
                        <input type="time" name="start_time" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Jam Selesai</label>
                        <input type="time" name="end_time" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Slot Tersedia</label>
                        <input type="number" name="available_slots" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Status</label>
                        <select name="status" class="form-select" required>
                            <option value="available">Tersedia</option>
                            <option value="unavailable">Tidak Tersedia</option>
                            <option value="full">Penuh</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Catatan</label>
                        <textarea name="notes" class="form-control" rows="3"></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('admin.paragliding-schedules.index') }}" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </div>
    </div>
@endsection
