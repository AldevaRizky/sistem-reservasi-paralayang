// File: resources/js/app.js

// 1. Impor default dari Laravel
import "./bootstrap";

// 2. Impor AlpineJS (sudah ada)
import Alpine from "alpinejs";

// 3. Impor pustaka yang kita butuhkan
import $ from "jquery";
import Swal from "sweetalert2";

// 4. Jadikan variabel global agar mudah diakses (praktik aman untuk kode lama)
window.Alpine = Alpine;
window.$ = $;
window.Swal = Swal;

// 5. Jalankan Alpine
Alpine.start();

// --- LOGIKA APLIKASI ANDA DIMULAI DI SINI ---

// 6. Fungsi untuk menampilkan preview gambar
// Dijadikan fungsi global agar bisa dipanggil dari `onchange` di HTML
window.previewImage = function (event) {
    const input = event.target;
    const preview = document.getElementById("profile-preview");
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function (e) {
            preview.src = e.target.result;
        };
        reader.readAsDataURL(input.files[0]);
    }
};

// 7. Event Listener untuk form #updateProfileForm
$(document).on("submit", "#updateProfileForm", function (e) {
    // Mencegah form dari reload halaman
    e.preventDefault();

    let formData = new FormData(this);
    // Ambil token CSRF dari tag meta di header HTML
    const csrfToken = document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content");

    Swal.fire({
        title: "Simpan perubahan profil?",
        icon: "question",
        showCancelButton: true,
        confirmButtonText: "Ya, Simpan",
        cancelButtonText: "Batal",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "/profile/update", // URL untuk update profil
                method: "POST",
                data: formData,
                contentType: false,
                processData: false,
                headers: {
                    "X-CSRF-TOKEN": csrfToken, // Kirim CSRF token di header
                },
                // ...
                success: function (response) {
                    Swal.fire({
                        title: "Berhasil!",
                        text: response.message,
                        icon: "success",
                        timer: 2000, // Tampilkan notifikasi selama 2 detik
                        showConfirmButton: false, // Sembunyikan tombol "OK"
                    }).then(() => {
                        window.location.reload(); // Muat ulang halaman setelah notifikasi hilang
                    });
                },
                // ...
                error: function (err) {
                    let msg = "Gagal menyimpan. Periksa kembali isian Anda.";
                    if (err.responseJSON && err.responseJSON.message) {
                        msg = err.responseJSON.message;
                    }
                    Swal.fire("Gagal!", msg, "error");
                },
            });
        }
    });
});

// 8. Event Listener untuk form #deleteAccountForm
$(document).on("submit", "#deleteAccountForm", function (e) {
    e.preventDefault();
    const password = $(this).find('input[name="password"]').val();
    const token = $(this).find('input[name="_token"]').val();

    Swal.fire({
        title: "Yakin ingin menghapus akun?",
        text: "Tindakan ini tidak dapat dibatalkan!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#dc3545",
        confirmButtonText: "Ya, Hapus!",
        cancelButtonText: "Batal",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "/profile/destroy", // URL untuk hapus akun
                method: "POST",
                data: {
                    _token: token,
                    _method: "DELETE", // Method-override untuk Laravel
                    password: password,
                },
                success: function (response) {
                    Swal.fire("Dihapus!", response.message, "success").then(
                        () => {
                            window.location.href = "/"; // Arahkan ke halaman utama setelah sukses
                        }
                    );
                },
                error: function (xhr) {
                    Swal.fire(
                        "Gagal!",
                        xhr.responseJSON.message || "Password salah.",
                        "error"
                    );
                },
            });
        }
    });
});
