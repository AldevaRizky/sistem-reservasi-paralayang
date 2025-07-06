<?php

namespace App\Http\Controllers\Landing;

use App\Http\Controllers\Controller;
use App\Models\ParaglidingPackage;
use App\Models\CampingEquipment;
use Illuminate\Support\Facades\DB;

class BerandaController extends Controller
{
    public function index()
    {
        // Ambil semua paket paralayang aktif + hitung jumlah booking
        $packages = ParaglidingPackage::withCount(['reservations' => function ($query) {
            $query->where('reservation_status', '!=', 'canceled');
        }])
        ->where('is_active', 'active')
        ->orderBy('price', 'asc')
        ->get();

        // Ambil ID paket dengan booking terbanyak
        $mostBookedId = $packages->sortByDesc('reservations_count')->first()?->id;

        // Ambil semua alat camping dengan status "available"
        $equipments = CampingEquipment::where('equipment_status', 'available')->get();

        // Format data agar siap digunakan oleh Alpine.js
        $campingGears = $equipments->map(function ($item) {
            return [
                'name' => $item->equipment_name,
                'category' => $item->category,
                'image' => asset('storage/' . $item->image),
                'features' => explode('|', $item->description),
                'price' => $item->daily_rental_price,
            ];
        });

        return view('landing.beranda', compact('packages', 'mostBookedId', 'campingGears'));
    }
}
