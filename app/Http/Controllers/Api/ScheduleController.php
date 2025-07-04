<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ParaglidingSchedule;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ScheduleController extends Controller
{
    /**
     * Mengambil jadwal yang tersedia berdasarkan package_id dan tanggal.
     */
    public function getSchedules(Request $request)
    {
        // 1. Validasi input
        $request->validate([
            'package_id' => 'required|integer|exists:paragliding_packages,id',
            'date' => 'required|date_format:Y-m-d',
        ]);

        // 2. Query yang sudah diperbaiki dan disesuaikan dengan migrasi terbaru
        $schedules = ParaglidingSchedule::where('paragliding_package_id', $request->package_id)
            ->where('schedule_date', $request->date)
            ->whereRaw('quota > booked_slots') // Logika yang benar: cari jika kuota masih lebih besar dari yang dipesan
            ->orderBy('time_slot') // Menggunakan kolom 'time_slot'
            ->get();

        // 3. Format data untuk ditampilkan di frontend
        $formattedSchedules = $schedules->map(function ($schedule) {
            $remainingSlots = $schedule->quota - $schedule->booked_slots;
            return [
                'time' => Carbon::parse($schedule->time_slot)->format('H:i'),
                'slots' => $remainingSlots,
            ];
        });

        // 4. Kembalikan sebagai JSON
        return response()->json($formattedSchedules);
    }
}