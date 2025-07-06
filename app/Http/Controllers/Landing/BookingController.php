<?php

namespace App\Http\Controllers\Landing;

use App\Http\Controllers\Controller;
use App\Models\ParaglidingReservation;
use Illuminate\Http\Request;
use Midtrans\Snap;
use Midtrans\Config;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = ParaglidingReservation::with(['package', 'schedule'])
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('landing.bookings.index', compact('bookings'));
    }

    public function pay($id)
    {
        $reservation = ParaglidingReservation::with('package')
            ->where('user_id', auth()->id())
            ->where('id', $id)
            ->firstOrFail();

        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $params = [
            'transaction_details' => [
                'order_id' => 'RES-' . $reservation->id . '-' . time(),
                'gross_amount' => $reservation->total_price,
            ],
            'customer_details' => [
                'first_name' => $reservation->customer_name,
                'phone' => $reservation->customer_phone,
                'address' => $reservation->customer_address,
            ],
            'item_details' => [[
                'id' => $reservation->package->id,
                'price' => $reservation->package->price,
                'quantity' => $reservation->participant_count,
                'name' => $reservation->package->package_name,
            ]]
        ];

        $snapToken = Snap::getSnapToken($params);

        return response()->json(['snapToken' => $snapToken]);
    }
}
