@extends($layout)

@section('title', 'Edit Profil')

@section('content')
    {{-- Baris ini akan memuat tampilan yang benar (admin/staff atau user) secara dinamis --}}
    @include($partialView)
@endsection

@push('scripts')
    {{-- Dependensi jQuery & SweetAlert2 --}}
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- KODE JAVASCRIPT LENGKAP UNTUK SEMUA FUNGSI --}}
    <script>
        // Fungsi untuk menampilkan preview gambar sebelum diupload
        function previewImage(event) {
            const input = event.target;
            const preview = document.getElementById('profile-preview');
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        // AJAX Handler untuk form #updateProfileForm
        // Bekerja untuk kedua tampilan (admin/staff dan user)
        // Menggunakan event delegation untuk memastikan script bekerja meski form dimuat secara dinamis
        $(document).on('submit', '#updateProfileForm', function(e) {
            e.preventDefault();
            let formData = new FormData(this);

            Swal.fire({
                title: 'Simpan perubahan profil?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, Simpan',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ route('profile.update') }}',
                        method: 'POST',
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            Swal.fire('Berhasil!', response.message, 'success');
                        },
                        error: function(err) {
    let msg = 'Periksa kembali isian Anda.';
    if (err.responseJSON && err.responseJSON.message) {
        msg = err.responseJSON.message;
    }
    Swal.fire('Gagal!', msg, 'error');
}
                    });
                }
            });
        });

        // AJAX Handler untuk form #deleteAccountForm
        // Bekerja untuk kedua tampilan (admin/staff dan user)
        $(document).on('submit', '#deleteAccountForm', function(e) {
            e.preventDefault();
            const password = $(this).find('input[name="password"]').val();

            Swal.fire({
                title: 'Yakin ingin menghapus akun?',
                text: "Tindakan ini tidak dapat dibatalkan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ route('profile.destroy') }}',
                        method: 'POST', // Method HTML tetap POST
                        data: {
                            _token: '{{ csrf_token() }}',
                            _method: 'DELETE', // Method-Override untuk Laravel
                            password: password
                        },
                        success: function(response) {
                            Swal.fire('Dihapus!', response.message, 'success').then(() => {
                                window.location.href = '/';
                            });
                        },
                        error: function(xhr) {
                            Swal.fire('Gagal!', xhr.responseJSON.message || 'Password salah.', 'error');
                        }
                    });
                }
            });
        });
    </script>
@endpush
