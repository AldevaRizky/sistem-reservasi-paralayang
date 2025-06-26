<?php

namespace App\Http\Controllers\Landing;

use App\Http\Controllers\Controller;

class BerandaController extends Controller
{
    public function index()
    {
        return view('landing.beranda');
    }
}
