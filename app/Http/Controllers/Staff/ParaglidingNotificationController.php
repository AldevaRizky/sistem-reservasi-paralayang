<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ParaglidingReservation;
use Illuminate\Support\Facades\Auth;

class ParaglidingNotificationController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $search = $request->q;

        $reservations = ParaglidingReservation::whereIn('reservation_status', ['pending', 'confirmed'])
            ->whereHas('schedule', function ($query) use ($user) {
                $query->whereJsonContains('staff_id', $user->id);
            })
            ->when($search, function ($query) use ($search) {
                $query->where('customer_name', 'like', '%' . $search . '%');
            })
            ->with(['user', 'schedule.package'])
            ->orderBy('reservation_date', 'desc')
            ->get();

        return view('staff.paragliding.notifications', compact('reservations', 'search'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:cancelled,completed',
        ]);

        $reservation = ParaglidingReservation::findOrFail($id);

        // Pastikan staff memiliki hak untuk mengubah status
        $user = Auth::user();
        $isAuthorized = $reservation->schedule && in_array($user->id, $reservation->schedule->staff_id ?? []);

        if (!$isAuthorized) {
            abort(403, 'Anda tidak memiliki akses untuk mengubah status ini.');
        }

        $reservation->reservation_status = $request->status;
        $reservation->save();

        return redirect()->back()->with('success', 'Status reservasi berhasil diperbarui.');
    }
}
