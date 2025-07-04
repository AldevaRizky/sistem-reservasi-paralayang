{{-- KODE INI ADALAH SALINAN PERSIS DARI TAMPILAN ANDA, TIDAK DIUBAH SAMA SEKALI --}}
<div class="row">
    {{-- Update Profile Card --}}
    <div class="col-md-6 mb-4">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Update Profil</h5>
            </div>
            <div class="card-body">
                <form id="updateProfileForm" enctype="multipart/form-data">
                    @csrf
                    {{-- Foto Profil --}}
                    <div class="text-center mb-3">
                        <div id="preview-container" class="mb-2 border rounded d-inline-block overflow-hidden" style="width: 150px; height: 150px;">
                            <img id="profile-preview" src="{{ optional($user->detail)->profile_photo ? asset('storage/' . $user->detail->profile_photo) : 'https://placehold.co/400' }}" alt="Foto Profil" class="img-fluid w-100 h-100" style="object-fit: cover;">
                        </div>
                        <input type="file" name="profile_photo" class="form-control mt-2" accept="image/*" onchange="previewImage(event)">
                    </div>
                    <div class="form-group mb-3">
                        <label>Nama Pengguna</label>
                        <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
                    </div>
                    <div class="form-group mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
                    </div>
                    <div class="form-group mb-3">
                        <label>Nama Lengkap</label>
                        <input type="text" name="full_name" class="form-control" value="{{ optional($user->detail)->full_name }}" required>
                    </div>
                    <div class="form-group mb-3">
                        <label>Nomor Telepon</label>
                        <input type="text" name="phone_number" class="form-control" value="{{ optional($user->detail)->phone_number }}" required>
                    </div>
                    <div class="form-group mb-3">
                        <label>Alamat</label>
                        <textarea name="address" class="form-control" required>{{ optional($user->detail)->address }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-success w-100">Simpan Perubahan</button>
                </form>
            </div>
        </div>
    </div>
    {{-- Delete Account Card --}}
    <div class="col-md-6 mb-4">
        <div class="card shadow-sm border-danger bg-light-danger">
            <div class="card-header bg-danger text-white">
                <h5 class="mb-0">Hapus Akun</h5>
            </div>
            <div class="card-body">
                <p class="text-danger fw-bold fs-6">
                    ⚠️ Akun Anda akan dihapus <strong>secara permanen</strong>. Tindakan ini <u>tidak dapat dibatalkan</u>.
                </p>
                <form id="deleteAccountForm">
                    @csrf
                    <div class="form-group mb-3">
                        <label>Konfirmasi Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-danger w-100">Hapus Akun</button>
                </form>
            </div>
        </div>
    </div>
</div>

