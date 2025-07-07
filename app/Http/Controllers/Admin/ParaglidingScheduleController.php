<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ParaglidingSchedule;
use App\Models\ParaglidingPackage;
use App\Models\User;

class ParaglidingScheduleController extends Controller
{
    public function index(Request $request)
    {
        $query = ParaglidingSchedule::with('package')->orderBy('time_slot');

        if ($request->filled('q')) {
            $search = $request->q;
            $query->whereHas('package', function ($q) use ($search) {
                $q->where('package_name', 'like', "%{$search}%");
            })->orWhere('time_slot', 'like', "%{$search}%")
              ->orWhere('notes', 'like', "%{$search}%");
        }

        $schedules = $query->paginate(10)->appends(['q' => $request->q]);

        return view('admin.paragliding-schedule.index', compact('schedules'));
    }

    public function create()
    {
        $packages = ParaglidingPackage::all();
        $staffs = User::where('role', 'staff')->get();

        return view('admin.paragliding-schedule.create', compact('packages', 'staffs'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'paragliding_package_id' => 'required|exists:paragliding_packages,id',
            'time_slot' => 'required|date_format:H:i',
            'quota' => 'required|integer|min:1',
            'notes' => 'nullable|string',
            'staff_id' => 'nullable|array',
            'staff_id.*' => 'exists:users,id',
        ]);

        $data['time_slot'] .= ':00'; // Format HH:mm:ss

        // Cegah duplikasi waktu untuk paket yang sama
        $exists = ParaglidingSchedule::where('paragliding_package_id', $data['paragliding_package_id'])
            ->where('time_slot', $data['time_slot'])
            ->exists();

        if ($exists) {
            return back()->withErrors(['time_slot' => 'Paket ini sudah memiliki jadwal pada waktu tersebut.'])->withInput();
        }

        // Validasi quota vs kapasitas paket
        $package = ParaglidingPackage::find($data['paragliding_package_id']);
        if ($data['quota'] > $package->capacity_per_slot) {
            return back()->withErrors(['quota' => 'Kuota melebihi kapasitas paket (' . $package->capacity_per_slot . ').'])->withInput();
        }

        // Simpan data ke database
        $data['staff_id'] = array_map('intval', $data['staff_id'] ?? []);

        ParaglidingSchedule::create($data);

        return redirect()->route('admin.paragliding-schedules.index')->with('success', 'Jadwal berhasil ditambahkan!');
    }

    public function edit(ParaglidingSchedule $paraglidingSchedule)
    {
        $packages = ParaglidingPackage::all();
        $staffs = User::where('role', 'staff')->get();

        // Tidak perlu json_decode karena sudah otomatis dicasting
        return view('admin.paragliding-schedule.edit', [
            'paraglidingSchedule' => $paraglidingSchedule,
            'packages' => $packages,
            'staffs' => $staffs,
        ]);
    }

    public function update(Request $request, ParaglidingSchedule $paraglidingSchedule)
    {
        $data = $request->validate([
            'paragliding_package_id' => 'required|exists:paragliding_packages,id',
            'time_slot' => 'required|date_format:H:i',
            'quota' => 'required|integer|min:1',
            'notes' => 'nullable|string',
            'staff_id' => 'nullable|array',
            'staff_id.*' => 'exists:users,id',
        ]);

        $data['time_slot'] .= ':00';

        $exists = ParaglidingSchedule::where('paragliding_package_id', $data['paragliding_package_id'])
            ->where('time_slot', $data['time_slot'])
            ->where('id', '!=', $paraglidingSchedule->id)
            ->exists();

        if ($exists) {
            return back()->withErrors(['time_slot' => 'Paket ini sudah memiliki jadwal pada waktu tersebut.'])->withInput();
        }

        $package = ParaglidingPackage::find($data['paragliding_package_id']);
        if ($data['quota'] > $package->capacity_per_slot) {
            return back()->withErrors(['quota' => 'Kuota melebihi kapasitas paket (' . $package->capacity_per_slot . ').'])->withInput();
        }

        $data['staff_id'] = array_map('intval', $data['staff_id'] ?? []);

        $paraglidingSchedule->update($data);

        return redirect()->route('admin.paragliding-schedules.index')->with('success', 'Jadwal berhasil diperbarui!');
    }

    public function destroy(ParaglidingSchedule $paraglidingSchedule)
    {
        $paraglidingSchedule->delete();

        return redirect()->route('admin.paragliding-schedules.index')->with('success', 'Jadwal berhasil dihapus!');
    }
}
