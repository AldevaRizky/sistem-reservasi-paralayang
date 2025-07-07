{{-- filepath: resources/views/profile/partials/user-form.blade.php --}}
<main class="bg-gray-100 dark:bg-gray-900 py-10 md:py-16">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <h2 class="text-center text-3xl md:text-4xl font-bold text-gray-800 dark:text-white mb-8">
                Pengaturan Akun
            </h2>
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                {{-- Kolom Kiri: Update Profil --}}
                <div class="lg:col-span-2">
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
                        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Update Profil</h3>
                        </div>
                        <form id="updateProfileForm" enctype="multipart/form-data" class="p-6 space-y-6">
                            @csrf
                            {{-- Foto Profil --}}
                            <div class="flex flex-col items-center mb-4">
                                <div class="mb-2">
                                    <img id="profile-preview"
                                        class="h-24 w-24 rounded-full object-cover ring-4 ring-white dark:ring-gray-700"
                                        src="{{ optional($user->detail)->profile_photo ? asset('storage/' . $user->detail->profile_photo) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=3b82f6&color=fff&size=128' }}"
                                        alt="Foto Profil">
                                </div>
                                <label for="profile_photo_input"
                                    class="inline-block px-3 py-1.5 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 text-xs font-medium rounded-md cursor-pointer hover:bg-gray-200 dark:hover:bg-gray-600 transition">
                                    Ubah Foto
                                </label>
                                <input type="file" name="profile_photo" id="profile_photo_input" class="hidden"
                                    accept="image/*" onchange="previewImage(event)">
                            </div>
                            <div>
                                <label for="name"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama
                                    Pengguna</label>
                                <input type="text" name="name" id="name"
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm text-gray-900 dark:text-white dark:placeholder-gray-400"
                                    value="{{ $user->name }}" required>
                            </div>
                            <div>
                                <label for="email"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                                <input type="email" name="email" id="email"
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm text-gray-900 dark:text-white dark:placeholder-gray-400"
                                    value="{{ $user->email }}" required>
                            </div>
                            <div>
                                <label for="full_name"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama
                                    Lengkap</label>
                                <input type="text" name="full_name" id="full_name"
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm text-gray-900 dark:text-white dark:placeholder-gray-400"
                                    value="{{ optional($user->detail)->full_name }}" required>
                            </div>
                            <div>
                                <label for="phone_number"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nomor
                                    Telepon</label>
                                <input type="text" name="phone_number" id="phone_number"
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm text-gray-900 dark:text-white dark:placeholder-gray-400"
                                    value="{{ optional($user->detail)->phone_number }}" required>
                            </div>
                            <div>
                                <label for="address"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Alamat</label>
                                <textarea name="address" id="address" rows="3"
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm text-gray-900 dark:text-white dark:placeholder-gray-400"
                                    required>{{ optional($user->detail)->address }}</textarea>
                            </div>
                            <div class="flex justify-end">
                                <button type="submit"
                                    class="inline-flex justify-center rounded-md border border-transparent bg-blue-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                                    Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                {{-- Kolom Kanan: Aksi --}}
                <div class="lg:col-span-1 space-y-8">
                    {{-- Ganti Password --}}
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
                        <div class="p-6">
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Ganti Password</h3>
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Pastikan akun Anda menggunakan
                                password yang panjang dan acak agar tetap aman.</p>
                            <button type="button"
                                onclick="document.getElementById('changePasswordModal').classList.remove('hidden')"
                                class="mt-4 inline-flex w-full justify-center rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                                Ganti Password
                            </button>

                        </div>
                    </div>
                    {{-- Hapus Akun --}}
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
                        <div class="p-6">
                            <h3 class="text-xl font-semibold text-red-600 dark:text-red-500">Hapus Akun</h3>
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Setelah akun dihapus, semua data
                                akan hilang permanen. Harap berhati-hati.</p>
                            <button type="button"
                                onclick="document.getElementById('deleteAccountModal').classList.remove('hidden')"
                                class="mt-4 inline-flex w-full justify-center rounded-md border border-transparent bg-red-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                                Hapus Akun Saya
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Modal Konfirmasi Hapus Akun (Tailwind CSS) -->
<div id="deleteAccountModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title"
    role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        {{-- Backdrop --}}
        <div onclick="document.getElementById('deleteAccountModal').classList.add('hidden')"
            class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
        {{-- Centering Trick --}}
        <span class="hidden sm:inline-block sm:h-screen sm:align-middle" aria-hidden="true">&#8203;</span>
        {{-- Modal Panel --}}
        <div
            class="inline-block transform overflow-hidden rounded-lg bg-white dark:bg-gray-800 text-left align-bottom shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:align-middle">
            <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div
                        class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 dark:bg-red-900/50 sm:mx-0 sm:h-10 sm:w-10">
                        <svg class="h-6 w-6 text-red-600 dark:text-red-400" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126z" />
                        </svg>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-white" id="modal-title">Hapus
                            Akun</h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500 dark:text-gray-400">Anda yakin ingin menghapus akun Anda?
                                Semua data Anda akan dihapus secara permanen. Tindakan ini tidak dapat dibatalkan.</p>
                        </div>
                    </div>
                </div>
                <form id="deleteAccountForm" class="mt-4">
                    @csrf
                    <div>
                        <label for="password_delete"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Konfirmasi
                            Password</label>
                        <input type="password" name="password" id="password_delete"
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm text-gray-900 dark:text-white dark:placeholder-gray-400"
                            required placeholder="Password Anda...">
                    </div>
                </form>

            </div>
            <div class="bg-gray-50 dark:bg-gray-800/50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                <button type="submit" form="deleteAccountForm"
                    class="inline-flex w-full justify-center rounded-md border border-transparent bg-red-600 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 sm:ml-3 sm:w-auto sm:text-sm">
                    Ya, Hapus Akun
                </button>
                <button type="button" onclick="document.getElementById('deleteAccountModal').classList.add('hidden')"
                    class="mt-3 inline-flex w-full justify-center rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 px-4 py-2 text-base font-medium text-gray-700 dark:text-gray-200 shadow-sm hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 sm:mt-0 sm:w-auto sm:text-sm">
                    Batal
                </button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Ganti Password -->
<div id="changePasswordModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title"
    role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        {{-- Backdrop --}}
        <div onclick="document.getElementById('changePasswordModal').classList.add('hidden')"
            class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
        <span class="hidden sm:inline-block sm:h-screen sm:align-middle" aria-hidden="true">&#8203;</span>
        <div
            class="inline-block transform overflow-hidden rounded-lg bg-white dark:bg-gray-800 text-left align-bottom shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:align-middle">
            <form id="changePasswordForm" class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4"
                method="POST" action="{{ route('user.profile.password.update') }}">
                @csrf
                <div class="sm:flex sm:items-start">
                    <div
                        class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-blue-100 dark:bg-blue-900/50 sm:mx-0 sm:h-10 sm:w-10">
                        <svg class="h-6 w-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor"
                            stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 15v2m0-10a4 4 0 00-4 4v2a4 4 0 008 0v-2a4 4 0 00-4-4zm0 0V5m0 14h.01" />
                        </svg>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                        <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-white" id="modal-title">Ganti
                            Password</h3>
                        <div class="mt-2 space-y-4">
                            <div>
                                <label for="current_password"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Password
                                    Saat Ini</label>
                                <input type="password" name="current_password" id="current_password"
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 shadow-sm sm:text-sm text-gray-900 dark:text-white"
                                    required>
                            </div>
                            <div>
                                <label for="new_password"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Password
                                    Baru</label>
                                <input type="password" name="new_password" id="new_password"
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 shadow-sm sm:text-sm text-gray-900 dark:text-white"
                                    required>
                            </div>
                            <div>
                                <label for="new_password_confirmation"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Konfirmasi
                                    Password</label>
                                <input type="password" name="new_password_confirmation"
                                    id="new_password_confirmation"
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 shadow-sm sm:text-sm text-gray-900 dark:text-white"
                                    required>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 dark:bg-gray-800/50 px-4 py-3 mt-4 sm:flex sm:flex-row-reverse sm:px-6">
                    <button type="submit"
                        class="inline-flex w-full justify-center rounded-md border border-transparent bg-blue-600 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 sm:ml-3 sm:w-auto sm:text-sm">
                        Simpan
                    </button>
                    <button type="button"
                        onclick="document.getElementById('changePasswordModal').classList.add('hidden')"
                        class="mt-3 inline-flex w-full justify-center rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 px-4 py-2 text-base font-medium text-gray-700 dark:text-gray-200 shadow-sm hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 sm:mt-0 sm:w-auto sm:text-sm">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
