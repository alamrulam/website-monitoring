<?php

namespace App\Http\Controllers\Pelaksana;

use App\Http\Controllers\Controller;
use App\Models\Proyek;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

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
    /**
     * Membuat laporan PDF untuk proyek dari sisi Pelaksana.
     */
    public function cetakPdf(Proyek $proyek, Request $request)
    {
        // Otorisasi
        if ($proyek->pelaksana_id !== $request->user()->pelaksana->id) {
            abort(403);
        }

        // Load data yang dibutuhkan
        $proyek->load(['pelaksana', 'pembayaran' => function ($query) {
            $query->orderBy('tanggal_transaksi', 'asc');
        }]);

        $totalPengeluaran = $proyek->pembayaran()->where('jenis', 'Pengeluaran')->sum('jumlah');
        $sisaAnggaran = $proyek->anggaran - $totalPengeluaran;

        // Buat PDF
        $pdf = PDF::loadView('laporan.proyek-pdf', compact('proyek', 'totalPengeluaran', 'sisaAnggaran'));

        return $pdf->stream();
    }
}
