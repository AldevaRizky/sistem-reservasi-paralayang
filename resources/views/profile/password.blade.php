@extends('layouts.dashboard')

@section('title', 'Ganti Password')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Ganti Password</h5>
                </div>
                <div class="card-body">
                    <form id="passwordForm">
                        @csrf

                        <div class="form-group mb-3">
                            <label>Password Saat Ini</label>
                            <input type="password" name="current_password" class="form-control" required>
                        </div>

                        <div class="form-group mb-3">
                            <label>Password Baru</label>
                            <input type="password" name="new_password" class="form-control" required>
                        </div>

                        <div class="form-group mb-3">
                            <label>Konfirmasi Password Baru</label>
                            <input type="password" name="new_password_confirmation" class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-success w-100">Simpan Password Baru</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {{-- jQuery & SweetAlert --}}
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $('#passwordForm').on('submit', function (e) {
            e.preventDefault();
            let formData = $(this).serialize();

            Swal.fire({
                title: 'Ganti password?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, Ganti',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ route('profile.password.update') }}',
                        method: 'POST',
                        data: formData,
                        success: function (response) {
                            Swal.fire('Berhasil!', response.message, 'success');
                            $('#passwordForm')[0].reset();
                        },
                        error: function (xhr) {
                            let message = xhr.responseJSON?.message || 'Terjadi kesalahan';
                            Swal.fire('Gagal!', message, 'error');
                        }
                    });
                }
            });
        });
    </script>
@endpush
