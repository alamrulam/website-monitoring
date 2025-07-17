<?php

namespace App\Http\Controllers\Pelaksana;

use App\Http\Controllers\Controller;
use App\Models\Proyek;
use Illuminate\Http\Request;

class ProyekSayaController extends Controller
{
    public function show(Proyek $proyek, Request $request)
    {
        // Otorisasi: Pastikan proyek ini milik pelaksana yang sedang login
        if ($proyek->pelaksana_id !== $request->user()->pelaksana->id) {
            abort(403);
        }

        // Load relasi
        $proyek->load(['tenagaKerja', 'kegiatans', 'pembayaran' => function ($query) {
            $query->orderBy('tanggal_transaksi', 'desc');
        }]);

        // Hitung total pemasukan dan pengeluaran
        $totalPemasukan = $proyek->pembayaran()->where('jenis', 'Pemasukan')->sum('jumlah');
        $totalPengeluaran = $proyek->pembayaran()->where('jenis', 'Pengeluaran')->sum('jumlah');
        $sisaAnggaran = $proyek->anggaran - $totalPengeluaran;


        return view('pelaksana.proyek.show', compact('proyek', 'totalPemasukan', 'totalPengeluaran', 'sisaAnggaran'));
    }
}
