@extends('layouts.dashboard')
@section('title', 'Tambah Jadwal Paralayang')

@section('content')
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h4>Tambah Jadwal Baru</h4>
            </div>
            <div class="card-body">
                {{-- Menampilkan pesan error jika staf tidak ditemukan --}}
                @if ($errors->has('staff_error'))
                    <div class="alert alert-danger">
                        {{ $errors->first('staff_error') }}
                    </div>
                @endif

                <form action="{{ route('admin.paragliding-schedules.store') }}" method="POST">
                    @csrf
                    
                    {{-- Dropdown Paket --}}
                    <div class="mb-3">
                        <label for="paragliding_package_id" class="form-label">Paket</label>
                        <select name="paragliding_package_id" id="paragliding_package_id" class="form-select @error('paragliding_package_id') is-invalid @enderror" required>
                            <option value="">-- Pilih Paket --</option>
                            @foreach ($packages as $pkg)
                                <option value="{{ $pkg->id }}" {{ old('paragliding_package_id') == $pkg->id ? 'selected' : '' }}>
                                    {{ $pkg->package_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('paragliding_package_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    {{-- Input Tanggal --}}
                    <div class="mb-3">
                        <label for="schedule_date" class="form-label">Tanggal</label>
                        <input type="date" name="schedule_date" id="schedule_date" class="form-control @error('schedule_date') is-invalid @enderror" value="{{ old('schedule_date') }}" required>
                        @error('schedule_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    {{-- Input Waktu Slot --}}
                    <div class="mb-3">
                        <label for="time_slot" class="form-label">Waktu Slot</label>
                        <input type="time" name="time_slot" id="time_slot" class="form-control @error('time_slot') is-invalid @enderror" value="{{ old('time_slot') }}" required>
                        @error('time_slot')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Input Kuota --}}
                    <div class="mb-3">
                        <label for="quota" class="form-label">Total Kuota</label>
                        <input type="number" name="quota" id="quota" class="form-control @error('quota') is-invalid @enderror" value="{{ old('quota') }}" required min="1">
                        @error('quota')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    {{-- Input Catatan --}}
                    <div class="mb-3">
                        <label for="notes" class="form-label">Catatan (Opsional)</label>
                        <textarea name="notes" id="notes" class="form-control @error('notes') is-invalid @enderror" rows="3">{{ old('notes') }}</textarea>
                        @error('notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan Jadwal</button>
                    <a href="{{ route('admin.paragliding-schedules.index') }}" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </div>
    </div>
@endsection
