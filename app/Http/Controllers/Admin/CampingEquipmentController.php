<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CampingEquipment;
use Illuminate\Support\Facades\Storage;

class CampingEquipmentController extends Controller
{
    /**
     * Menampilkan daftar semua peralatan camping
     */
    public function index(Request $request)
    {
        $query = CampingEquipment::query();

        if ($request->has('q') && $request->q !== '') {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('equipment_name', 'like', "%{$search}%")
                    ->orWhere('category', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $equipments = $query->paginate(10)->appends(['q' => $request->q]);

        return view('admin.camping-equipment.index', compact('equipments'));
    }

    /**
     * Form untuk menambah data baru
     */
    public function create()
    {
        return view('admin.camping-equipment.create');
    }

    /**
     * Simpan data baru ke database
     */
    public function store(Request $request)
    {
        $data = $this->validateData($request);

        // Upload gambar jika ada
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('equipment', 'public');
        }

        CampingEquipment::create($data);

        return redirect()->route('admin.camping-equipment.index')
            ->with('success', 'Peralatan berhasil ditambahkan!');
    }

    /**
     * Form edit data
     */
    public function edit(CampingEquipment $camping_equipment)
    {
        return view('admin.camping-equipment.edit', [
            'equipment' => $camping_equipment
        ]);
    }

    public function update(Request $request, CampingEquipment $camping_equipment)
    {
        $data = $this->validateData($request);

        // Update gambar jika ada file baru
        if ($request->hasFile('image')) {
            if ($camping_equipment->image) {
                Storage::disk('public')->delete($camping_equipment->image);
            }

            $data['image'] = $request->file('image')->store('equipment', 'public');
        }

        $camping_equipment->update($data);

        return redirect()->route('admin.camping-equipment.index')
            ->with('success', 'Peralatan berhasil diperbarui!');
    }

    /**
     * Hapus data
     */
    public function destroy(CampingEquipment $camping_equipment)
    {
        if ($camping_equipment->image) {
            Storage::disk('public')->delete($camping_equipment->image);
        }

        $camping_equipment->delete();

        return redirect()->route('admin.camping-equipment.index')
            ->with('success', 'Peralatan berhasil dihapus!');
    }

    /**
     * Validasi data form
     */
    private function validateData(Request $request)
    {
        return $request->validate([
            'equipment_name'      => 'required|string|max:255',
            'category'            => 'required|string|max:255',
            'description'         => 'nullable|string',
            'daily_rental_price'  => 'required|numeric|min:0',
            'total_quantity'      => 'required|integer|min:0',
            'available_quantity'  => 'required|integer|min:0',
            'image'               => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'equipment_status'    => 'required|in:available,unavailable,damaged,maintenance',
        ]);
    }
}
