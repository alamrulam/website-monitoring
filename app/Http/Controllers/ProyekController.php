<?php

namespace App\Http\Controllers;

use App\Models\Proyek;
use App\Models\Pelaksana;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
class ProyekController extends Controller
{
    public function index()
    {
        $proyeks = Proyek::with('pelaksana')->latest()->paginate(10);
        return view('admin.proyek.index', compact('proyeks'));
    }

    public function create()
    {
        $pelaksanas = Pelaksana::orderBy('nama_perusahaan')->get();
        // Siapkan data untuk dropdown Uraian Pekerjaan
        $uraianOptions = ['Jalan Tanah', 'Jalan Kerikil', 'Jalan Rabat Beton', 'Jalan Aspal Tipis'];

        return view('admin.proyek.create', compact('pelaksanas', 'uraianOptions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_proyek' => 'required|string|max:255',
            'pelaksana_id' => 'required|exists:pelaksanas,id',
            'lokasi' => 'required|string',
            'anggaran' => 'required|numeric|min:0',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            // Validasi untuk detail pekerjaan jalan
            'uraian' => 'required|string|in:Jalan Tanah,Jalan Kerikil,Jalan Rabat Beton,Jalan Aspal Tipis',
            'volume' => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($request) {
            // Buat Proyek utama
            $proyek = Proyek::create($request->only([
                'nama_proyek',
                'pelaksana_id',
                'lokasi',
                'anggaran',
                'tanggal_mulai',
                'tanggal_selesai'
            ]));

            // Simpan detail kegiatan dengan data yang sudah ditetapkan
            $proyek->kegiatans()->create([
                'nama_kegiatan' => 'Jalan Desa', // Hardcoded
                'uraian' => $request->uraian,
                'volume' => $request->volume,
                'satuan' => 'meter', // Hardcoded
            ]);
        });

        return redirect()->route('admin.proyek.index')
            ->with('success', 'Proyek baru berhasil dibuat dan ditugaskan.');
    }

    public function edit(Proyek $proyek)
    {
        $proyek->load('kegiatans');
        $kegiatan = $proyek->kegiatans->first();
        $pelaksanas = Pelaksana::orderBy('nama_perusahaan')->get();
        // Siapkan data untuk dropdown Uraian Pekerjaan
        $uraianOptions = ['Jalan Tanah', 'Jalan Kerikil', 'Jalan Rabat Beton', 'Jalan Aspal Tipis'];

        return view('admin.proyek.edit', compact('proyek', 'kegiatan', 'pelaksanas', 'uraianOptions'));
    }

    public function update(Request $request, Proyek $proyek)
    {
        $request->validate([
            'nama_proyek' => 'required|string|max:255',
            'pelaksana_id' => 'required|exists:pelaksanas,id',
            'lokasi' => 'required|string',
            'anggaran' => 'required|numeric|min:0',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'status' => 'required|in:Perencanaan,Berjalan,Selesai,Dibatalkan',
            // Validasi untuk detail pekerjaan jalan
            'uraian' => 'required|string|in:Jalan Tanah,Jalan Kerikil,Jalan Rabat Beton,Jalan Aspal Tipis',
            'volume' => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($request, $proyek) {
            // Update data proyek utama
            $proyek->update($request->only([
                'nama_proyek',
                'pelaksana_id',
                'lokasi',
                'anggaran',
                'tanggal_mulai',
                'tanggal_selesai',
                'status'
            ]));

            // Hapus kegiatan lama dan buat yang baru
            $proyek->kegiatans()->delete();
            $proyek->kegiatans()->create([
                'nama_kegiatan' => 'Jalan Desa', // Hardcoded
                'uraian' => $request->uraian,
                'volume' => $request->volume,
                'satuan' => 'meter', // Hardcoded
            ]);
        });

        return redirect()->route('admin.proyek.index')
            ->with('success', 'Data Proyek berhasil diperbarui.');
    }

    public function destroy(Proyek $proyek)
    {
        $proyek->delete();
        return redirect()->route('admin.proyek.index')->with('success', 'Proyek berhasil dihapus.');
    }
    /**
     * Menampilkan halaman detail proyek untuk monitoring oleh Admin.
     * INI ADALAH METHOD BARU YANG MEMPERBAIKI ERROR.
     */
    public function show(Proyek $proyek)
    {
        // Load semua relasi yang dibutuhkan untuk ditampilkan di halaman detail
        $proyek->load(['pelaksana', 'kegiatans', 'tenagaKerja', 'dokumentasiFotos', 'pembayaran' => function ($query) {
            $query->orderBy('tanggal_transaksi', 'desc');
        }]);

        // Hitung total pengeluaran
        $totalPengeluaran = $proyek->pembayaran()->where('jenis', 'Pengeluaran')->sum('jumlah');

        // Hitung sisa anggaran
        $sisaAnggaran = $proyek->anggaran - $totalPengeluaran;

        // Kirim semua data ke view
        return view('admin.proyek.show', compact('proyek', 'totalPengeluaran', 'sisaAnggaran'));
    }

    /**
     * Membuat laporan PDF untuk proyek dari sisi Admin.
     * INI ADALAH METHOD BARU.
     */
    public function cetakPdf(Proyek $proyek)
    {
        // Load semua data yang dibutuhkan untuk laporan
        $proyek->load(['pelaksana', 'pembayaran' => function ($query) {
            $query->orderBy('tanggal_transaksi', 'asc');
        }]);

        $totalPengeluaran = $proyek->pembayaran()->where('jenis', 'Pengeluaran')->sum('jumlah');
        $sisaAnggaran = $proyek->anggaran - $totalPengeluaran;

        // Buat PDF menggunakan view yang sama dengan Pelaksana
        $pdf = PDF::loadView('laporan.proyek-pdf', compact('proyek', 'totalPengeluaran', 'sisaAnggaran'));

        return $pdf->stream('laporan-' . $proyek->nama_proyek . '.pdf');
    }
}
