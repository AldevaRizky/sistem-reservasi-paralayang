<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();

        // Pastikan user punya detail jika belum
        if (!$user->detail) {
            $user->detail()->create([
                'full_name' => $user->name,
                'phone_number' => '',
                'address' => '',
                'profile_photo' => null,
                'is_active' => 'active'
            ]);
        }

        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'full_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'address' => 'required|string',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        $detailData = $request->only(['full_name', 'phone_number', 'address']);

        if ($request->hasFile('profile_photo')) {
            if ($user->detail && $user->detail->profile_photo) {
                Storage::disk('public')->delete($user->detail->profile_photo);
            }

            $detailData['profile_photo'] = $request->file('profile_photo')->store('profiles', 'public');
        }

        // Buat atau update user detail berdasarkan user_id
        $user->detail()->updateOrCreate(
            ['user_id' => $user->id],
            $detailData
        );

        return response()->json(['success' => true, 'message' => 'Profil berhasil diperbarui.']);
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'password' => 'required',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->password, $user->password)) {
            return response()->json(['success' => false, 'message' => 'Password tidak sesuai.'], 422);
        }

        if ($user->detail && $user->detail->profile_photo) {
            Storage::disk('public')->delete($user->detail->profile_photo);
        }

        $user->detail()->delete();
        $user->delete();
        Auth::logout();

        return response()->json(['success' => true, 'message' => 'Akun berhasil dihapus.']);
    }

    public function editPassword()
    {
        return view('profile.password');
    }

    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed'
        ]);

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json(['success' => false, 'message' => 'Password saat ini salah.'], 422);
        }

        $user->update([
            'password' => Hash::make($request->new_password)
        ]);

        return response()->json(['success' => true, 'message' => 'Password berhasil diperbarui.']);
    }
}
