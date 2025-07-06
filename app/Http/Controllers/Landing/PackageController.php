<?php

namespace App\Http\Controllers\Landing;

use App\Http\Controllers\Controller;
use App\Models\ParaglidingPackage;
use App\Models\ParaglidingSchedule;
use App\Models\ParaglidingReservation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class PackageController extends Controller
{
    public function index()
    {
        $packages = ParaglidingPackage::where('is_active', 'active')->get();
        return view('landing.packages.index', compact('packages'));
    }

    public function show($id)
    {
        $package = ParaglidingPackage::findOrFail($id);
        return view('landing.packages.show', compact('package'));
    }

    public function confirmation($id)
    {
        $reservation = ParaglidingReservation::with(['package', 'schedule'])
            ->findOrFail($id);

        return view('landing.packages.confirmation', compact('reservation'));
    }

    public function getSchedules(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'package_id' => 'required|exists:paragliding_packages,id',
        ]);

        $date = $request->date;
        $maxDate = now()->addWeeks(2)->format('Y-m-d');

        if ($date > $maxDate) {
            return response()->json(['availableTimes' => []]);
        }

        $schedules = ParaglidingSchedule::where('paragliding_package_id', $request->package_id)->get();

        $availableTimes = [];

        foreach ($schedules as $schedule) {
            $totalBooked = ParaglidingReservation::where('schedule_id', $schedule->id)
                ->whereDate('reservation_date', $date)
                ->sum('participant_count');

            $remainingQuota = $schedule->quota - $totalBooked;

            $usedStaff = ParaglidingReservation::where('schedule_id', $schedule->id)
                ->whereDate('reservation_date', $date)
                ->pluck('staff_id')
                ->toArray();

            $availableStaff = collect($schedule->staff_id)->filter(function ($staffId) use ($usedStaff) {
                return !in_array($staffId, $usedStaff);
            });

            $isAvailable = $remainingQuota > 0 && !$availableStaff->isEmpty();

            $availableTimes[] = [
                'time' => $schedule->time_slot,
                'slots' => $isAvailable ? $remainingQuota : 'Penuh',
                'available' => $isAvailable,
            ];
        }

        return response()->json(['availableTimes' => $availableTimes]);
    }

    public function makeBooking(Request $request)
    {
        $request->validate([
            'package_id' => 'required|exists:paragliding_packages,id',
            'schedule_time' => 'required',
            'reservation_date' => 'required|date|after_or_equal:today|before_or_equal:' . now()->addWeeks(2)->format('Y-m-d'),
            'participant_count' => 'required|integer|min:1',
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_address' => 'required|string|max:255',
        ]);

        $schedule = ParaglidingSchedule::where('paragliding_package_id', $request->package_id)
            ->where('time_slot', $request->schedule_time)
            ->first();

        if (!$schedule) {
            return response()->json(['message' => 'Schedule not found.'], 404);
        }

        $totalBooked = ParaglidingReservation::where('schedule_id', $schedule->id)
            ->whereDate('reservation_date', $request->reservation_date)
            ->sum('participant_count');

        $remainingQuota = $schedule->quota - $totalBooked;

        if ($remainingQuota < $request->participant_count) {
            return response()->json(['message' => 'Not enough slots available.'], 422);
        }

        $assignedStaffs = ParaglidingReservation::where('schedule_id', $schedule->id)
            ->whereDate('reservation_date', $request->reservation_date)
            ->pluck('staff_id')
            ->toArray();

        $availableStaffId = collect($schedule->staff_id)->first(function ($staffId) use ($assignedStaffs) {
            return !in_array($staffId, $assignedStaffs);
        });

        if (!$availableStaffId) {
            return response()->json(['message' => 'No available staff.'], 422);
        }

        $price = ParaglidingPackage::find($request->package_id)->price;

        $reservation = ParaglidingReservation::create([
            'user_id' => auth()->id(),
            'schedule_id' => $schedule->id,
            'package_id' => $request->package_id,
            'reservation_date' => $request->reservation_date,
            'participant_count' => $request->participant_count,
            'total_price' => $price * $request->participant_count,
            'reservation_status' => 'pending',
            'staff_id' => $availableStaffId,
            'customer_name' => $request->customer_name,
            'customer_phone' => $request->customer_phone,
            'customer_address' => $request->customer_address,
        ]);

        return response()->json([
            'message' => 'Booking berhasil! Silakan segera lakukan pembayaran untuk mengamankan slot Anda.',
            'reservation_id' => $reservation->id,
        ]);
    }
}
