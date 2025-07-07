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
                        <select name="paragliding_package_id" class="form-select" required>
                            <option value="">-- Pilih Paket --</option>
                            @foreach ($packages as $pkg)
                                <option value="{{ $pkg->id }}">{{ $pkg->package_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Waktu Terbang</label>
                        <input type="time" name="time_slot" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Kuota</label>
                        <input type="number" name="quota" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Catatan</label>
                        <textarea name="notes" class="form-control"></textarea>
                    </div>
                    <div class="mb-3">
                        <label>Staff Penanggung Jawab</label>
                        <div id="staff-container">
                            <div class="input-group mb-2">
                                <select name="staff_id[]" class="form-select" required>
                                    <option value="">-- Pilih Staff --</option>
                                    @foreach ($staffs as $staff)
                                        <option value="{{ $staff->id }}">{{ $staff->name }}</option>
                                    @endforeach
                                </select>
                                <button type="button" class="btn btn-danger remove-staff">Hapus</button>
                            </div>
                        </div>
                        <button type="button" class="btn btn-sm btn-secondary" id="add-staff">+ Tambah Staff</button>
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('admin.paragliding-schedules.index') }}" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </div>
    </div>

    <script>
        const staffOptions = @json($staffs->map(fn($s) => ['id' => $s->id, 'name' => $s->name]));
        const staffContainer = document.getElementById('staff-container');

        document.getElementById('add-staff').addEventListener('click', () => {
            const wrapper = document.createElement('div');
            wrapper.classList.add('input-group', 'mb-2');

            const select = document.createElement('select');
            select.name = 'staff_id[]';
            select.classList.add('form-select');
            select.required = true;
            select.innerHTML = `<option value="">-- Pilih Staff --</option>` +
                staffOptions.map(s => `<option value="${s.id}">${s.name}</option>`).join('');

            const btn = document.createElement('button');
            btn.type = 'button';
            btn.classList.add('btn', 'btn-danger', 'remove-staff');
            btn.textContent = 'Hapus';

            wrapper.appendChild(select);
            wrapper.appendChild(btn);
            staffContainer.appendChild(wrapper);
        });

        staffContainer.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-staff')) {
                e.target.closest('.input-group').remove();
            }
        });
    </script>
@endsection
