<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class StaffUserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'staff')->with('detail');

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

        $staffs = $query->paginate(10)->appends(['q' => $request->q]);

        return view('admin.users.staff.index', compact('staffs'));
    }

    public function create()
    {
        return view('admin.users.staff.create');
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

        $staff = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'staff',
        ]);

        $detailData = $request->only(['full_name', 'phone_number', 'address', 'is_active']);
        if ($request->hasFile('profile_photo')) {
            $detailData['profile_photo'] = $request->file('profile_photo')->store('profiles', 'public');
        }
        $staff->detail()->create($detailData);

        return redirect()->route('admin.users.staff.index')->with('success', 'Staff berhasil ditambahkan.');
    }

    public function edit(User $staff)
    {
        return view('admin.users.staff.edit', compact('staff'));
    }

    public function update(Request $request, User $staff)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $staff->id,
            'password' => 'nullable|min:6|confirmed',
            'full_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'address' => 'required|string',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg',
            'is_active' => 'required|in:active,inactive'
        ]);

        $staff->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password ? Hash::make($request->password) : $staff->password,
        ]);

        $detailData = $request->only(['full_name', 'phone_number', 'address', 'is_active']);

        if ($request->hasFile('profile_photo')) {
            // Hapus foto lama jika ada
            if ($staff->detail && $staff->detail->profile_photo) {
                Storage::disk('public')->delete($staff->detail->profile_photo);
            }
            $detailData['profile_photo'] = $request->file('profile_photo')->store('profiles', 'public');
        }

        // Cek apakah detail sudah ada
        if ($staff->detail) {
            $staff->detail()->update($detailData);
        } else {
            $staff->detail()->create($detailData);
        }

        return redirect()->route('admin.users.staff.index')->with('success', 'Staff berhasil diperbarui.');
    }

    public function destroy(User $staff)
    {
        if ($staff->detail && $staff->detail->profile_photo) {
            Storage::disk('public')->delete($staff->detail->profile_photo);
        }

        $staff->detail()->delete();
        $staff->delete();

        return redirect()->route('admin.users.staff.index')->with('success', 'Staff berhasil dihapus.');
    }
}