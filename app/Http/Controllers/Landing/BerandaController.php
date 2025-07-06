<?php

namespace App\Http\Controllers\Landing;

use App\Http\Controllers\Controller;
use App\Models\ParaglidingPackage;
use Illuminate\Support\Facades\DB;

class BerandaController extends Controller
{
    public function index()
    {
        // Ambil semua paket aktif + hitung jumlah booking
        $packages = ParaglidingPackage::withCount(['reservations' => function ($query) {
            $query->where('reservation_status', '!=', 'canceled'); // Hitung hanya yang bukan dibatalkan
        }])
            ->where('is_active', 'active')
            ->orderBy('price', 'asc')
            ->get();

        // Ambil ID paket dengan booking terbanyak
        $mostBookedId = $packages->sortByDesc('reservations_count')->first()?->id;

        return view('landing.beranda', compact('packages', 'mostBookedId'));
    }
}
