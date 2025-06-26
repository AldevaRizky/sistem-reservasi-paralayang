<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ParaglidingPackage;
use Illuminate\Support\Facades\Storage;

class ParaglidingPackageController extends Controller
{
    public function index(Request $request)
    {
        $query = ParaglidingPackage::query();

        if ($request->has('q') && $request->q != '') {
            $search = $request->q;
            $query->where('package_name', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%")
                ->orWhere('duration', 'like', "%{$search}%");
        }

        $packages = $query->paginate(10)->appends(['q' => $request->q]);

        return view('admin.paragliding-package.index', compact('packages'));
    }

    public function create()
    {
        return view('admin.paragliding-package.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'package_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'duration' => 'required|string',
            'price' => 'required|numeric',
            'requirements' => 'nullable|string',
            'capacity_per_slot' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg',
            'is_active' => 'required|in:active,inactive',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('packages', 'public');
        }

        ParaglidingPackage::create($data);

        return redirect()->route('admin.paragliding-packages.index')->with('success', 'Paket berhasil ditambahkan!');
    }

    public function edit(ParaglidingPackage $paraglidingPackage)
    {
        return view('admin.paragliding-package.edit', compact('paraglidingPackage'));
    }

    public function update(Request $request, ParaglidingPackage $paraglidingPackage)
    {
        $data = $request->validate([
            'package_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'duration' => 'required|string',
            'price' => 'required|numeric',
            'requirements' => 'nullable|string',
            'capacity_per_slot' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg',
            'is_active' => 'required|in:active,inactive',
        ]);

        if ($request->hasFile('image')) {
            if ($paraglidingPackage->image) {
                Storage::disk('public')->delete($paraglidingPackage->image);
            }
            $data['image'] = $request->file('image')->store('packages', 'public');
        }

        $paraglidingPackage->update($data);

        return redirect()->route('admin.paragliding-packages.index')->with('success', 'Paket berhasil diperbarui!');
    }

    public function destroy(ParaglidingPackage $paraglidingPackage)
    {
        if ($paraglidingPackage->image) {
            Storage::disk('public')->delete($paraglidingPackage->image);
        }

        $paraglidingPackage->delete();

        return redirect()->route('admin.paragliding-packages.index')->with('success', 'Paket berhasil dihapus!');
    }
}
