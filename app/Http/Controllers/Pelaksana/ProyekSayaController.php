<?php

namespace App\Http\Controllers\Pelaksana;

use App\Http\Controllers\Controller;
use App\Models\Proyek;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf; // <-- PASTIKAN BARIS INI ADA, INI KUNCINYA!

class ProyekSayaController extends Controller
{
    public function show(Proyek $proyek, Request $request, $tab = 'detail')
    {
        if ($proyek->pelaksana_id !== $request->user()->pelaksana->id) {
            abort(403);
        }
        $validTabs = ['detail', 'progres', 'tenaga-kerja', 'pembayaran'];
        if (!in_array($tab, $validTabs)) {
            $tab = 'detail';
        }
        $proyek->load(['pelaksana', 'kegiatans', 'dokumentasiFotos', 'tenagaKerja', 'pembayaran' => function ($query) {
            $query->orderBy('tanggal_transaksi', 'desc');
        }]);
        $totalPengeluaran = $proyek->pembayaran()->where('jenis', 'Pengeluaran')->sum('jumlah');
        $sisaAnggaran = $proyek->anggaran - $totalPengeluaran;
        return view('pelaksana.proyek.show', compact('proyek', 'tab', 'totalPengeluaran', 'sisaAnggaran'));
    }

    public function cetakPdf(Proyek $proyek, Request $request)
    {
        // Otorisasi untuk memastikan pelaksana hanya bisa mencetak laporannya sendiri
        if ($proyek->pelaksana_id !== $request->user()->pelaksana->id) {
            abort(403);
        }

        // Memuat data yang dibutuhkan untuk ditampilkan di PDF
        $proyek->load(['pelaksana', 'pembayaran' => function ($query) {
            $query->orderBy('tanggal_transaksi', 'asc');
        }]);

        // Menghitung ulang data keuangan untuk akurasi
        $totalPengeluaran = $proyek->pembayaran()->where('jenis', 'Pengeluaran')->sum('jumlah');
        $sisaAnggaran = $proyek->anggaran - $totalPengeluaran;

        // Membuat objek PDF dari file view 'laporan.proyek-pdf'
        $pdf = PDF::loadView('laporan.proyek-pdf', compact('proyek', 'totalPengeluaran', 'sisaAnggaran'));

        // Menampilkan PDF di browser
        return $pdf->stream('laporan-' . $proyek->nama_proyek . '.pdf');
    }
}
