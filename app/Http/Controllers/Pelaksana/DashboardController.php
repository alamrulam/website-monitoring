<?php

namespace App\Http\Controllers\Pelaksana;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Ambil user yang sedang login dan relasi pelaksananya
        $pelaksana = $request->user()->pelaksana;

        // Ambil semua proyek yang dimiliki oleh pelaksana tersebut
        $proyeks = $pelaksana->proyeks()->latest()->paginate(10);

        return view('pelaksana.dashboard', compact('proyeks'));
    }
}
