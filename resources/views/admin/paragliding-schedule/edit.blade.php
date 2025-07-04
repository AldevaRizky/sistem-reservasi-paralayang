@extends('layouts.dashboard')
@section('title', 'Edit Jadwal Paralayang')

@section('content')
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h4>Edit Jadwal</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.paragliding-schedules.update', $schedule->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- Dropdown Paket --}}
                    <div class="mb-3">
                        <label for="paragliding_package_id" class="form-label">Paket</label>
                        <select name="paragliding_package_id" id="paragliding_package_id" class="form-select @error('paragliding_package_id') is-invalid @enderror" required>
                            @foreach ($packages as $pkg)
                                <option value="{{ $pkg->id }}" 
                                    {{ old('paragliding_package_id', $schedule->paragliding_package_id) == $pkg->id ? 'selected' : '' }}>
                                    {{ $pkg->package_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('paragliding_package_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    {{-- PENYESUAIAN UTAMA: Input untuk memilih banyak staf --}}
                    <div class="mb-3">
                        <label for="staff_ids" class="form-label">Pilot Bertugas</label>
                        <select name="staff_ids[]" id="staff_ids" class="form-select @error('staff_ids') is-invalid @enderror" multiple required>
                            @foreach($staffs as $staff)
                                {{-- Cek apakah ID staf ada di dalam array $assignedStaffIds yang dikirim dari controller --}}
                                <option value="{{ $staff->id }}" {{ in_array($staff->id, old('staff_ids', $assignedStaffIds ?? [])) ? 'selected' : '' }}>
                                    {{ $staff->name }}
                                </option>
                            @endforeach
                        </select>
                        <small class="form-text text-muted">Tahan Ctrl (atau Cmd di Mac) untuk memilih lebih dari satu.</small>
                        @error('staff_ids')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Input Tanggal --}}
                    <div class="mb-3">
                        <label for="schedule_date" class="form-label">Tanggal</label>
                        <input type="date" name="schedule_date" id="schedule_date" class="form-control @error('schedule_date') is-invalid @enderror" 
                               value="{{ old('schedule_date', $schedule->schedule_date) }}" required>
                        @error('schedule_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Input Waktu Slot --}}
                    <div class="mb-3">
                        <label for="time_slot" class="form-label">Waktu Slot</label>
                        <input type="time" name="time_slot" id="time_slot" class="form-control @error('time_slot') is-invalid @enderror" 
                               value="{{ old('time_slot', $schedule->time_slot) }}" required>
                        @error('time_slot')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Input Kuota --}}
                    <div class="mb-3">
                        <label for="quota" class="form-label">Total Kuota (Slot)</label>
                        <input type="number" name="quota" id="quota" class="form-control @error('quota') is-invalid @enderror" 
                               value="{{ old('quota', $schedule->quota) }}" required min="0">
                        @error('quota')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Input Slot Dipesan --}}
                    <div class="mb-3">
                        <label for="booked_slots" class="form-label">Slot Dipesan</label>
                        <input type="number" name="booked_slots" id="booked_slots" class="form-control @error('booked_slots') is-invalid @enderror" 
                               value="{{ old('booked_slots', $schedule->booked_slots) }}" required min="0">
                        @error('booked_slots')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Input Catatan --}}
                    <div class="mb-3">
                        <label for="notes" class="form-label">Catatan (Opsional)</label>
                        <textarea name="notes" id="notes" class="form-control @error('notes') is-invalid @enderror" rows="3">{{ old('notes', $schedule->notes) }}</textarea>
                        @error('notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-warning">Perbarui Jadwal</button>
                    <a href="{{ route('admin.paragliding-schedules.index') }}" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </div>
    </div>
@endsection
