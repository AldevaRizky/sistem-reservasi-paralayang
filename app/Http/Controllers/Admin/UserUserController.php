<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserUserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'user')->with('detail');

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

        $users = $query->paginate(10)->appends(['q' => $request->q]);

        return view('admin.users.user.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.user.create');
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
            'role' => 'user',
        ]);

        $detailData = $request->only(['full_name', 'phone_number', 'address', 'is_active']);
        if ($request->hasFile('profile_photo')) {
            $detailData['profile_photo'] = $request->file('profile_photo')->store('profiles', 'public');
        }
        $user->detail()->create($detailData);

        return redirect()->route('admin.users.user.index')->with('success', 'User berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        return view('admin.users.user.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6|confirmed',
            'full_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'address' => 'required|string',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg',
            'is_active' => 'required|in:active,inactive'
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
        ]);

        $detailData = $request->only(['full_name', 'phone_number', 'address', 'is_active']);

        if ($request->hasFile('profile_photo')) {
            // Hapus foto lama jika ada
            if ($user->detail && $user->detail->profile_photo) {
                Storage::disk('public')->delete($user->detail->profile_photo);
            }
            $detailData['profile_photo'] = $request->file('profile_photo')->store('profiles', 'public');
        }

        // Cek apakah detail sudah ada
        if ($user->detail) {
            $user->detail()->update($detailData);
        } else {
            $user->detail()->create($detailData);
        }

        return redirect()->route('admin.users.user.index')->with('success', 'User berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if ($user->detail && $user->detail->profile_photo) {
            Storage::disk('public')->delete($user->detail->profile_photo);
        }

        $user->detail()->delete();
        $user->delete();

        return redirect()->route('admin.users.user.index')->with('success', 'User berhasil dihapus.');
    }
}