<?php

namespace App\Http\Controllers\Landing;

use App\Http\Controllers\Controller;
use App\Models\ParaglidingPackage;

class PackageController extends Controller
{
    public function index()
    {
        $packages = ParaglidingPackage::where('is_active', 'active')->get();
        return view('landing.packages.index', compact('packages'));
    }

    public function show($id)
    {
        $package = ParaglidingPackage::findOrFail($id);
        return view('landing.packages.show', compact('package'));
    }
}