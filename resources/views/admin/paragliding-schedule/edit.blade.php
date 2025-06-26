@extends('layouts.dashboard')
@section('title', 'Edit Jadwal Paralayang')

@section('content')
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h4>Edit Jadwal</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.paragliding-schedules.update', $paraglidingSchedule->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label>Paket</label>
                        <select name="package_id" class="form-select" required>
                            @foreach ($packages as $pkg)
                                <option value="{{ $pkg->id }}"
                                    {{ $pkg->id == $paraglidingSchedule->package_id ? 'selected' : '' }}>
                                    {{ $pkg->package_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Tanggal</label>
                        <input type="date" name="date" class="form-control" value="{{ $paraglidingSchedule->date }}"
                            required>
                    </div>
                    <div class="mb-3">
                        <label>Jam Mulai</label>
                        <input type="time" name="start_time" class="form-control"
                            value="{{ $paraglidingSchedule->start_time }}" required>
                    </div>
                    <div class="mb-3">
                        <label>Jam Selesai</label>
                        <input type="time" name="end_time" class="form-control"
                            value="{{ $paraglidingSchedule->end_time }}" required>
                    </div>
                    <div class="mb-3">
                        <label>Slot Tersedia</label>
                        <input type="number" name="available_slots" class="form-control"
                            value="{{ $paraglidingSchedule->available_slots }}" required>
                    </div>
                    <div class="mb-3">
                        <label>Status</label>
                        <select name="status" class="form-select" required>
                            <option value="available" {{ $paraglidingSchedule->status === 'available' ? 'selected' : '' }}>
                                Tersedia</option>
                            <option value="unavailable"
                                {{ $paraglidingSchedule->status === 'unavailable' ? 'selected' : '' }}>Tidak Tersedia
                            </option>
                            <option value="full" {{ $paraglidingSchedule->status === 'full' ? 'selected' : '' }}>Penuh
                            </option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Catatan</label>
                        <textarea name="notes" class="form-control" rows="3">{{ $paraglidingSchedule->notes }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-warning">Perbarui</button>
                    <a href="{{ route('admin.paragliding-schedules.index') }}" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </div>
    </div>
@endsection
