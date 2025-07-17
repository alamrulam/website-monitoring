<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = $request->user();

        if ($user->role === 'admin') {
            // Arahkan ke route dashboard admin (misal: daftar proyek)
            return redirect()->route('admin.proyek.index');
        }

        if ($user->role === 'pelaksana') {
            // Arahkan ke route dashboard pelaksana
            return redirect()->route('pelaksana.dashboard');
        }

        // Fallback jika tidak ada role
        return view('dashboard');
    }
}
