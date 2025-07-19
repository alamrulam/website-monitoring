<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proyek;
use App\Models\Pelaksana;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = $request->user();

        if ($user->role === 'admin') {
            // --- LOGIKA BARU UNTUK DASHBOARD ADMIN ---
            $totalProyek = Proyek::count();
            $totalPelaksana = Pelaksana::count();
            $totalAnggaran = Proyek::sum('anggaran');

            // Query untuk mendapatkan data grafik
            $statusCounts = Proyek::query()
                ->select('status', DB::raw('count(*) as total'))
                ->groupBy('status')
                ->pluck('total', 'status');

            // Siapkan data untuk Chart.js
            $chartLabels = $statusCounts->keys();
            $chartData = $statusCounts->values();

            return view('dashboard-admin', compact(
                'totalProyek',
                'totalPelaksana',
                'totalAnggaran',
                'chartLabels',
                'chartData'
            ));
            // ------------------------------------------
        }

        if ($user->role === 'pelaksana') {
            return redirect()->route('pelaksana.dashboard');
        }

        // Fallback jika tidak ada role
        return view('dashboard');
    }
}
