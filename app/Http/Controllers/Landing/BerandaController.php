<?php

namespace App\Http\Controllers\Landing;

use App\Http\Controllers\Controller;
use App\Models\ParaglidingPackage;

class BerandaController extends Controller
{
    public function index()
    {
        $packages = ParaglidingPackage::where('is_active', 'active')
                                        ->latest()
                                        ->take(3) // Ambil 3 paket terbaru untuk ditampilkan di beranda
                                        ->get();
        return view('landing.beranda', compact('packages'));
    }
}
