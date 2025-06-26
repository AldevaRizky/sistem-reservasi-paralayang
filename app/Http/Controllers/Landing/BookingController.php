<?php

namespace App\Http\Controllers\Landing;

use App\Http\Controllers\Controller;
use App\Models\ParaglidingPackage;
use App\Models\ParaglidingSchedule;
use App\Models\ParaglidingReservation;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Midtrans\Snap;
use Midtrans\Config;

class BookingController extends Controller
{
    public function selectSchedule(Request $request, $packageId)
    {
        $package = ParaglidingPackage::findOrFail($packageId);

        $schedules = ParaglidingSchedule::where('package_id', $packageId)
            ->whereDate('date', '>=', now()->toDateString())
            ->where('status', 'available')
            ->where('available_slots', '>', 0)
            ->orderBy('date')
            ->get();

        return view('landing.booking.select-schedule', compact('package', 'schedules'));
    }

    public function createReservation(Request $request, $scheduleId)
    {
        $request->validate([
            'participant_count' => 'required|integer|min:1',
            'notes' => 'nullable|string',
        ]);

        $schedule = ParaglidingSchedule::with('package')->findOrFail($scheduleId);

        if ($schedule->available_slots < $request->participant_count) {
            return back()->withErrors(['participant_count' => 'Jumlah peserta melebihi slot tersedia.']);
        }

        $total_price = $schedule->package->price * $request->participant_count;

        DB::beginTransaction();

        $reservation = ParaglidingReservation::create([
            'user_id' => Auth::id(),
            'schedule_id' => $schedule->id,
            'package_id' => $schedule->package_id,
            'reservation_date' => $schedule->date,
            'participant_count' => $request->participant_count,
            'total_price' => $total_price,
            'reservation_status' => 'pending',
            'notes' => $request->notes,
        ]);

        $schedule->decrement('available_slots', $request->participant_count);

        $transaction = Transaction::create([
            'reservation_id' => $reservation->id,
            'transaction_type' => 'paragliding',
            'total_payment' => $total_price,
            'payment_status' => 'pending',
            'payment_token' => null,
        ]);

        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $snapPayload = [
            'transaction_details' => [
                'order_id' => 'ORDER-' . $transaction->id . '-' . Str::random(5),
                'gross_amount' => $total_price,
            ],
            'customer_details' => [
                'first_name' => Auth::user()->name,
                'email' => Auth::user()->email,
            ],
        ];

        $snapToken = Snap::getSnapToken($snapPayload);
        $transaction->update(['payment_token' => $snapToken]);

        DB::commit();

        return redirect()->route('user.booking.payment', $transaction->id);
    }

    public function showPaymentForm($transactionId)
    {
        $transaction = Transaction::with('reservation.package')->findOrFail($transactionId);

        if ($transaction->reservation->user_id !== Auth::id()) {
            abort(403);
        }

        return view('landing.booking.payment', compact('transaction'));
    }
}
