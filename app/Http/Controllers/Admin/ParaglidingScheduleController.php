<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ParaglidingSchedule;
use App\Models\ParaglidingPackage;

class ParaglidingScheduleController extends Controller
{
    public function index(Request $request)
    {
        $query = ParaglidingSchedule::with('package')->latest();

        if ($request->has('q') && $request->q != '') {
            $search = $request->q;
            $query->whereHas('package', function ($q) use ($search) {
                $q->where('package_name', 'like', "%{$search}%");
            })->orWhere('date', 'like', "%{$search}%")
            ->orWhere('status', 'like', "%{$search}%");
        }

        $schedules = $query->paginate(10)->appends(['q' => $request->q]);

        return view('admin.paragliding-schedule.index', compact('schedules'));
    }

    public function create()
    {
        $packages = ParaglidingPackage::where('is_active', 'active')->get();
        return view('admin.paragliding-schedule.create', compact('packages'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'package_id' => 'required|exists:paragliding_packages,id',
            'date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'available_slots' => 'required|integer|min:1',
            'status' => 'required|in:available,unavailable,full',
            'notes' => 'nullable|string'
        ]);

        ParaglidingSchedule::create($data);
        return redirect()->route('admin.paragliding-schedules.index')->with('success', 'Jadwal berhasil ditambahkan.');
    }

    public function edit(ParaglidingSchedule $paraglidingSchedule)
    {
        $packages = ParaglidingPackage::where('is_active', 'active')->get();
        return view('admin.paragliding-schedule.edit', compact('paraglidingSchedule', 'packages'));
    }

    public function update(Request $request, ParaglidingSchedule $paraglidingSchedule)
    {
        $data = $request->validate([
            'package_id' => 'required|exists:paragliding_packages,id',
            'date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'available_slots' => 'required|integer|min:1',
            'status' => 'required|in:available,unavailable,full',
            'notes' => 'nullable|string'
        ]);

        $paraglidingSchedule->update($data);
        return redirect()->route('admin.paragliding-schedules.index')->with('success', 'Jadwal berhasil diperbarui.');
    }

    public function destroy(ParaglidingSchedule $paraglidingSchedule)
    {
        $paraglidingSchedule->delete();
        return redirect()->route('admin.paragliding-schedules.index')->with('success', 'Jadwal berhasil dihapus.');
    }
}
