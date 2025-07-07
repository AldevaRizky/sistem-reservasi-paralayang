<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\ParaglidingReservation;
use App\Models\CampingRental;
use App\Models\User;
use App\Models\CampingEquipment;
use App\Models\ParaglidingPackage;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalTransactions = Transaction::count();
        $totalRevenue = Transaction::where('payment_status', 'paid')->sum('total_payment');
        $totalReservations = ParaglidingReservation::count();
        $totalCampingEquipments = CampingEquipment::count();
        $totalParaglidingPackages = ParaglidingPackage::count();
        $totalStaff = User::where('role', 'staff')->count();

        $now = Carbon::now();

        // Grafik Pendapatan 6 Bulan Terakhir
        $monthlyLabels = [];
        $monthlyRevenue = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = $now->copy()->subMonths($i);
            $label = $month->format('F');
            $monthlyLabels[] = $label;
            $total = Transaction::where('payment_status', 'paid')
                ->whereMonth('payment_date', $month->month)
                ->whereYear('payment_date', $month->year)
                ->sum('total_payment');
            $monthlyRevenue[] = $total;
        }

        // Grafik Pendapatan Mingguan (7 hari terakhir)
        $weeklyLabels = [];
        $weeklyRevenue = [];
        for ($i = 6; $i >= 0; $i--) {
            $day = $now->copy()->subDays($i);
            $label = $day->format('D');
            $weeklyLabels[] = $label;
            $total = Transaction::where('payment_status', 'paid')
                ->whereDate('payment_date', $day->format('Y-m-d'))
                ->sum('total_payment');
            $weeklyRevenue[] = $total;
        }

        // Grafik Pendapatan per Bulan (12 bulan untuk perbandingan tahun ini)
        $allMonthsLabels = [];
        $allMonthsRevenue = [];
        for ($i = 1; $i <= 12; $i++) {
            $label = date('F', mktime(0, 0, 0, $i, 1));
            $allMonthsLabels[] = $label;
            $total = Transaction::where('payment_status', 'paid')
                ->whereMonth('payment_date', $i)
                ->whereYear('payment_date', $now->year)
                ->sum('total_payment');
            $allMonthsRevenue[] = $total;
        }

        $recentTransactions = Transaction::with('reservation')
            ->orderByDesc('created_at')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalTransactions',
            'totalRevenue',
            'totalReservations',
            'totalCampingEquipments',
            'totalParaglidingPackages',
            'totalStaff',
            'monthlyLabels',
            'monthlyRevenue',
            'weeklyLabels',
            'weeklyRevenue',
            'allMonthsLabels',
            'allMonthsRevenue',
            'recentTransactions'
        ));
    }
}
