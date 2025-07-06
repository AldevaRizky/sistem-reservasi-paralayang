<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ParaglidingReservation;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class ParaglidingReservationController extends Controller
{
    /**
     * Menampilkan daftar booking paralayang dengan filter berdasarkan reservation_date.
     */
    public function index(Request $request)
    {
        // Ambil filter tanggal dari query string, default ke hari ini
        $date = $request->input('date');

        // Validasi dan parsing tanggal
        try {
            $parsedDate = $date ? Carbon::parse($date)->toDateString() : Carbon::today()->toDateString();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['Tanggal tidak valid.']);
        }

        $reservations = ParaglidingReservation::with(['user', 'schedule', 'package', 'transaction'])
            ->whereDate('reservation_date', $parsedDate)
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('admin.paragliding-reservations.index', compact('reservations', 'parsedDate'));
    }

    /**
     * Menampilkan form ubah status booking.
     */
    public function edit($id)
    {
        $reservation = ParaglidingReservation::with(['user', 'schedule', 'package', 'transaction'])->findOrFail($id);
        return view('admin.paragliding-reservations.edit', compact('reservation'));
    }

    /**
     * Memperbarui status reservasi dan pembayaran.
     */
    public function update(Request $request, $id)
    {
        $reservation = ParaglidingReservation::findOrFail($id);

        $data = $request->validate([
            'reservation_status' => 'required|in:pending,confirmed,cancelled,completed',
            'payment_status' => 'required|in:pending,paid,failed,refunded',
        ]);

        // Update status reservasi
        $reservation->update([
            'reservation_status' => $data['reservation_status']
        ]);

        // Update atau buat transaksi
        if ($reservation->transaction) {
            $reservation->transaction->update([
                'payment_status' => $data['payment_status'],
                'verified_by_id' => Auth::id(),
                'payment_date' => now(),
            ]);
        } else {
            Transaction::create([
                'reservation_id' => $reservation->id,
                'user_id' => $reservation->user_id,
                'amount' => $reservation->total_price,
                'payment_status' => $data['payment_status'],
                'payment_method' => 'manual',
                'payment_date' => now(),
                'verified_by_id' => Auth::id(),
            ]);
        }

        return redirect()->route('admin.paragliding-reservations.index')
            ->with('success', 'Status reservasi dan pembayaran berhasil diperbarui.');
    }
}
