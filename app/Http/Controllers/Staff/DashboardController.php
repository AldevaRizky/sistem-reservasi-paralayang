<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ParaglidingReservation;
use App\Models\Transaction;

class DashboardController extends Controller
{
    public function index()
    {
        $staffId = Auth::id();

        // Jumlah reservasi yang ditangani oleh staff ini
        $reservationsHandled = ParaglidingReservation::where('staff_id', $staffId)->count();

        // Total pendapatan dari reservasi yang ditangani
        $revenueHandled = Transaction::whereHas('reservation', function ($q) use ($staffId) {
            $q->where('staff_id', $staffId);
        })->where('payment_status', 'paid')->sum('total_payment');

        // Grafik pendapatan 6 bulan terakhir
        $monthlyRevenue = [];
        $monthlyLabels = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $monthlyLabels[] = $month->format('F');
            $monthlyRevenue[] = Transaction::whereHas('reservation', function ($q) use ($staffId) {
                $q->where('staff_id', $staffId);
            })->whereMonth('payment_date', $month->month)
              ->whereYear('payment_date', $month->year)
              ->where('payment_status', 'paid')
              ->sum('total_payment');
        }

        // Transaksi terbaru yang ditangani
        $recentTransactions = Transaction::whereHas('reservation', function ($q) use ($staffId) {
            $q->where('staff_id', $staffId);
        })->latest()->take(5)->get();

        return view('staff.dashboard', compact(
            'reservationsHandled',
            'revenueHandled',
            'monthlyRevenue',
            'monthlyLabels',
            'recentTransactions'
        ));
    }
}
