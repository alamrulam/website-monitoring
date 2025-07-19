<?php

namespace App\Http\Controllers\Pelaksana;

use App\Http\Controllers\Controller;
use App\Models\Proyek;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ProyekSayaController extends Controller
{
    public function show(Proyek $proyek, Request $request, $tab = 'detail')
    {
        // Otorisasi: Pastikan proyek ini milik pelaksana yang sedang login
        if ($proyek->pelaksana_id !== $request->user()->pelaksana->id) {
            abort(403);
        }

        // Daftar tab yang valid
        $validTabs = ['detail', 'progres', 'tenaga-kerja', 'pembayaran'];
        if (!in_array($tab, $validTabs)) {
            $tab = 'detail'; // Default ke tab detail jika tidak valid
        }

        // ======================================================
        // PERBAIKAN LOGIKA DI SINI
        // Kita muat semua relasi yang mungkin dibutuhkan secara langsung.
        // Ini memastikan data selalu tersedia di setiap tab.
        // ======================================================
        $proyek->load([
            'pelaksana',
            'kegiatans',
            'dokumentasiFotos',
            'tenagaKerja', // <-- Memuat data tenaga kerja
            'pembayaran' => function ($query) {
                $query->orderBy('tanggal_transaksi', 'desc');
            } // <-- Memuat data pembayaran
        ]);

        // Hitung ringkasan keuangan (selalu dibutuhkan)
        $totalPengeluaran = $proyek->pembayaran()->where('jenis', 'Pengeluaran')->sum('jumlah');
        $sisaAnggaran = $proyek->anggaran - $totalPengeluaran;

        return view('pelaksana.proyek.show', compact('proyek', 'tab', 'totalPengeluaran', 'sisaAnggaran'));
    }

    public function cetakPdf(Proyek $proyek, Request $request)
    {
        // Otorisasi
        if ($proyek->pelaksana_id !== $request->user()->pelaksana->id) {
            abort(403);
        }

        // Load data yang dibutuhkan untuk PDF
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
