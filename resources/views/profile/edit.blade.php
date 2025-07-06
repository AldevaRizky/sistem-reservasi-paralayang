@extends($layout)

@section('title', 'Edit Profil')

@section('content')
    @include($partialView)

    {{-- Script SweetAlert & jQuery --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <script>
        // Preview Foto Profil
        function previewImage(event) {
            const input = event.target;
            const preview = document.getElementById('profile-preview');
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    preview.src = e.target.result;
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        // Submit Form Update Profile
        $(document).on('submit', '#updateProfileForm', function (e) {
            e.preventDefault();
            let formData = new FormData(this);

            Swal.fire({
                title: 'Simpan perubahan?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, Simpan',
                cancelButtonText: 'Batal',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'swal2-confirm',
                    cancelButton: 'swal2-cancel'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ route('profile.update') }}',
                        method: 'POST',
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function (response) {
                            Swal.fire({
                                title: 'Berhasil!',
                                text: response.message,
                                icon: 'success',
                                confirmButtonText: 'Oke',
                                buttonsStyling: false,
                                customClass: {
                                    confirmButton: 'swal-confirm-btn'
                                }
                            });
                        },
                        error: function (err) {
                            Swal.fire({
                                title: 'Gagal!',
                                text: err.responseJSON?.message || 'Periksa kembali isian Anda.',
                                icon: 'error',
                                confirmButtonText: 'Oke',
                                buttonsStyling: false,
                                customClass: {
                                    confirmButton: 'swal-error-btn'
                                }
                            });
                        }
                    });
                }
            });
        });

        // Submit Form Hapus Akun
        $(document).on('submit', '#deleteAccountForm', function (e) {
            e.preventDefault();
            const password = $(this).find('input[name="password"]').val();

            Swal.fire({
                title: 'Hapus akun ini?',
                text: 'Tindakan ini tidak bisa dibatalkan!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'swal-delete-btn',
                    cancelButton: 'swal-cancel-btn'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ route("profile.destroy") }}',
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            _method: 'DELETE',
                            password: password
                        },
                        success: function (response) {
                            Swal.fire({
                                title: 'Dihapus!',
                                text: response.message,
                                icon: 'success',
                                confirmButtonText: 'Oke',
                                buttonsStyling: false,
                                customClass: {
                                    confirmButton: 'swal-confirm-btn'
                                }
                            }).then(() => {
                                window.location.href = '/';
                            });
                        },
                        error: function (xhr) {
                            Swal.fire({
                                title: 'Gagal!',
                                text: xhr.responseJSON?.message || 'Password salah.',
                                icon: 'error',
                                confirmButtonText: 'Oke',
                                buttonsStyling: false,
                                customClass: {
                                    confirmButton: 'swal-error-btn'
                                }
                            });
                        }
                    });
                }
            });
        });

        // Submit Form Ganti Password
$(document).on('submit', '#changePasswordForm', function (e) {
    e.preventDefault();
    let formData = new FormData(this);

    Swal.fire({
        title: 'Simpan Password Baru?',
        text: 'Pastikan Anda mengingat password baru Anda.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, Simpan',
        cancelButtonText: 'Batal',
        buttonsStyling: false,
        customClass: {
            confirmButton: 'swal2-confirm',
            cancelButton: 'swal2-cancel'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '{{ route("profile.password.update") }}',
                method: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    Swal.fire({
                        title: 'Berhasil!',
                        text: response.message,
                        icon: 'success',
                        confirmButtonText: 'Oke',
                        buttonsStyling: false,
                        customClass: {
                            confirmButton: 'swal-confirm-btn'
                        }
                    }).then(() => {
                        $('#changePasswordModal').addClass('hidden'); // Tutup modal jika pakai modal Tailwind
                        $('#changePasswordForm')[0].reset(); // Reset form
                    });
                },
                error: function (xhr) {
                    Swal.fire({
                        title: 'Gagal!',
                        text: xhr.responseJSON?.message || 'Terjadi kesalahan. Coba lagi.',
                        icon: 'error',
                        confirmButtonText: 'Oke',
                        buttonsStyling: false,
                        customClass: {
                            confirmButton: 'swal-error-btn'
                        }
                    });
                }
            });
        }
    });
});

    </script>

    {{-- SweetAlert Button Style --}}
    <style>
    .swal2-confirm,
    .swal-confirm-btn {
        background-color: #16a34a !important;
        color: white !important;
        font-weight: 600;
        padding: 0.5rem 1rem;
        border-radius: 0.375rem;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
    }

    .swal2-cancel,
    .swal-cancel-btn {
        background-color: #6b7280 !important;
        color: white !important;
        font-weight: 600;
        padding: 0.5rem 1rem;
        border-radius: 0.375rem;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
    }

    .swal2-confirm:hover {
        background-color: #15803d !important;
    }

    .swal2-cancel:hover {
        background-color: #4b5563 !important;
    }

    .swal-error-btn {
        background-color: #dc2626 !important;
        color: white !important;
        font-weight: 600;
    }

    .swal-delete-btn {
        background-color: #ef4444 !important;
        color: white !important;
        font-weight: 600;
    }

    .swal-delete-btn:hover {
        background-color: #dc2626 !important;
    }

    /* Tambahkan jarak antar tombol */
    .swal2-actions {
        display: flex !important;
        gap: 0.75rem !important;
        justify-content: center;
    }
</style>

@endsection
