<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ParaglidingReservation;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Midtrans\Notification;
use Midtrans\Config;

class MidtransCallbackController extends Controller
{
    public function handle(Request $request)
    {
        // Konfigurasi Midtrans
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;

        // Buat objek notifikasi dari Midtrans
        $notification = new Notification();

        $transaction = $notification->transaction_status; // settlement, pending, cancel, etc.
        $type = $notification->payment_type;              // bank_transfer, gopay, etc.
        $orderId = $notification->order_id;               // RES-<id>-<timestamp>
        $fraud = $notification->fraud_status ?? null;

        // Ambil reservation ID dari format order_id (contoh: RES-4-1751778014)
        $orderParts = explode('-', $orderId);
        $reservationId = $orderParts[1] ?? null;

        // Validasi reservasi
        $reservation = ParaglidingReservation::find($reservationId);

        if (!$reservation) {
            Log::warning('Reservasi tidak ditemukan untuk Midtrans order_id: ' . $orderId);
            return response()->json(['status' => 'not found'], 404);
        }

        // Tentukan nilai payment_status yang cocok dengan enum di database
        $statusToStore = match ($transaction) {
            'settlement', 'capture' => 'paid',
            'pending' => 'pending',
            'deny', 'cancel', 'expire' => 'failed',
            default => 'pending',
        };

        // Simpan data transaksi ke tabel Transaction
        Transaction::updateOrCreate(
            ['reservation_id' => $reservation->id],
            [
                'transaction_type' => 'paragliding',
                'total_payment' => $reservation->total_price,
                'payment_method' => $type,
                'payment_status' => $statusToStore,
                'payment_date' => now(),
            ]
        );

        // Update status reservasi sesuai status pembayaran
        if (in_array($transaction, ['settlement', 'capture']) && $fraud === 'accept') {
            $reservation->reservation_status = 'confirmed';
        } elseif ($transaction === 'pending') {
            $reservation->reservation_status = 'pending';
        } elseif (in_array($transaction, ['deny', 'cancel', 'expire'])) {
            $reservation->reservation_status = 'cancelled';
        }

        $reservation->save();

        Log::info('Callback Midtrans diproses untuk reservation ID: ' . $reservation->id);

        return response()->json(['status' => 'ok']);
    }
}
