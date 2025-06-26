<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AdminUserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'admin')->with('detail');

        if ($request->has('q') && $request->q !== '') {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhereHas('detail', function ($queryDetail) use ($search) {
                        $queryDetail->where('full_name', 'like', "%{$search}%")
                            ->orWhere('phone_number', 'like', "%{$search}%")
                            ->orWhere('address', 'like', "%{$search}%");
                    });
            });
        }

        $admins = $query->paginate(10)->appends(['q' => $request->q]);

        return view('admin.users.admin.index', compact('admins'));
    }

    public function create()
    {
        return view('admin.users.admin.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'full_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'address' => 'required|string',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg',
            'is_active' => 'required|in:active,inactive'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin',
        ]);

        $detailData = $request->only(['full_name', 'phone_number', 'address', 'is_active']);
        if ($request->hasFile('profile_photo')) {
            $detailData['profile_photo'] = $request->file('profile_photo')->store('profiles', 'public');
        }
        $user->detail()->create($detailData);

        return redirect()->route('admin.users.admin.index')->with('success', 'Admin berhasil ditambahkan.');
    }

    public function edit(User $admin)
    {
        return view('admin.users.admin.edit', compact('admin'));
    }

    public function update(Request $request, User $admin)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $admin->id,
            'password' => 'nullable|min:6|confirmed',
            'full_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'address' => 'required|string',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg',
            'is_active' => 'required|in:active,inactive'
        ]);

        $admin->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password ? Hash::make($request->password) : $admin->password,
        ]);

        $detailData = $request->only(['full_name', 'phone_number', 'address', 'is_active']);

        if ($request->hasFile('profile_photo')) {
            // Hapus foto lama jika ada
            if ($admin->detail && $admin->detail->profile_photo) {
                Storage::disk('public')->delete($admin->detail->profile_photo);
            }
            $detailData['profile_photo'] = $request->file('profile_photo')->store('profiles', 'public');
        }

        // Cek apakah detail sudah ada
        if ($admin->detail) {
            $admin->detail()->update($detailData);
        } else {
            $admin->detail()->create($detailData);
        }

        return redirect()->route('admin.users.admin.index')->with('success', 'Admin berhasil diperbarui.');
    }

    public function destroy(User $admin)
    {
        if ($admin->detail && $admin->detail->profile_photo) {
            Storage::disk('public')->delete($admin->detail->profile_photo);
        }

        $admin->detail()->delete();
        $admin->delete();

        return redirect()->route('admin.users.admin.index')->with('success', 'Admin berhasil dihapus.');
    }
}