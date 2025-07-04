<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ParaglidingSchedule;
use App\Models\ParaglidingPackage;
use App\Models\User;

class ParaglidingScheduleController extends Controller
{
    /**
     * Menampilkan daftar jadwal dengan semua pilot yang bertugas.
     */
    public function index(Request $request)
    {
        // PENYESUAIAN: Eager load relasi 'staffs' (jamak) yang baru.
        $query = ParaglidingSchedule::with(['package', 'staffs'])->latest('schedule_date');

        if ($request->has('q') && $request->q != '') {
            $search = $request->q;
            $query->where(function ($subQuery) use ($search) {
                $subQuery->whereHas('package', function ($q) use ($search) {
                    $q->where('package_name', 'like', "%{$search}%");
                })
                    // PENYESUAIAN: Mencari berdasarkan relasi 'staffs' (jamak).
                    ->orWhereHas('staffs', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    })
                    ->orWhere('schedule_date', 'like', "%{$search}%");
            });
        }

        $schedules = $query->paginate(10)->appends(['q' => $request->q]);
        return view('admin.paragliding-schedule.index', compact('schedules'));
    }

    /**
     * Menampilkan form untuk membuat jadwal baru.
     */
    public function create()
    {
        $packages = ParaglidingPackage::where('is_active', 'active')->get();
        return view('admin.paragliding-schedule.create', compact('packages'));
    }

    /**
     * Menyimpan jadwal baru dan menugaskan beberapa pilot sesuai kuota.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'paragliding_package_id' => 'required|exists:paragliding_packages,id',
            'schedule_date' => 'required|date',
            'time_slot' => 'required',
            'quota' => 'required|integer|min:1', // Kuota sekarang berarti jumlah pilot/slot.
            'notes' => 'nullable|string'
        ]);

        // PENYESUAIAN: Logika untuk mencari beberapa pilot sesuai kuota.
        $requiredPilots = $data['quota'];
        $availablePilots = User::where('role', 'staff')
            ->whereHas('detail', fn($q) => $q->where('is_active', 'active'))
            ->inRandomOrder() // Pilih secara acak
            ->limit($requiredPilots) // Ambil sejumlah pilot yang dibutuhkan.
            ->get();

        // Handle jika pilot yang tersedia tidak mencukupi.
        if ($availablePilots->count() < $requiredPilots) {
            return back()->withInput()->withErrors(['quota' => "Pilot yang tersedia hanya {$availablePilots->count()}, tidak cukup untuk kuota {$requiredPilots}."]);
        }

        $data['booked_slots'] = 0;

        // 1. Buat jadwalnya terlebih dahulu.
        $schedule = ParaglidingSchedule::create($data);

        // 2. PENYESUAIAN: Gunakan attach() untuk menugaskan banyak pilot.
        $schedule->staffs()->attach($availablePilots->pluck('id'));

        return redirect()->route('admin.paragliding-schedules.index')->with('success', 'Jadwal berhasil dibuat dengan ' . $requiredPilots . ' pilot ditugaskan.');
    }

    /**
     * Menampilkan form untuk mengedit jadwal, termasuk memilih beberapa staf.
     */
    public function edit(ParaglidingSchedule $paraglidingSchedule)
    {
        $schedule = $paraglidingSchedule;
        $packages = ParaglidingPackage::where('is_active', 'active')->get();
        $staffs = User::where('role', 'staff')->whereHas('detail', fn($q) => $q->where('is_active', 'active'))->orderBy('name')->get();

        // PENYESUAIAN: Ambil ID semua staf yang saat ini ditugaskan untuk jadwal ini.
        $assignedStaffIds = $schedule->staffs->pluck('id')->toArray();

        return view('admin.paragliding-schedule.edit', compact('schedule', 'packages', 'staffs', 'assignedStaffIds'));
    }

    /**
     * Memperbarui data jadwal yang ada di database.
     */
    public function update(Request $request, ParaglidingSchedule $paraglidingSchedule)
    {
        $data = $request->validate([
            'paragliding_package_id' => 'required|exists:paragliding_packages,id',
            'schedule_date' => 'required|date',
            'time_slot' => 'required',
            'quota' => 'required|integer|min:0',
            'booked_slots' => 'required|integer|min:0|lte:quota',
            'notes' => 'nullable|string',
            'staff_ids' => 'nullable|array', // PENYESUAIAN: Terima array dari multi-select.
            'staff_ids.*' => 'exists:users,id' // Validasi setiap ID di dalam array.
        ]);

        // Update data dasar jadwal.
        $paraglidingSchedule->update($data);

        // PENYESUAIAN: Gunakan sync() untuk memperbarui daftar pilot yang bertugas.
        if ($request->has('staff_ids')) {
            $paraglidingSchedule->staffs()->sync($request->staff_ids);
        } else {
            // Jika tidak ada staf yang dipilih, hapus semua tugas.
            $paraglidingSchedule->staffs()->sync([]);
        }

        return redirect()->route('admin.paragliding-schedules.index')->with('success', 'Jadwal berhasil diperbarui.');
    }

    /**
     * Menghapus jadwal dari database.
     */
    public function destroy(ParaglidingSchedule $paraglidingSchedule)
    {
        $paraglidingSchedule->delete();
        return redirect()->route('admin.paragliding-schedules.index')->with('success', 'Jadwal berhasil dihapus.');
    }
}
