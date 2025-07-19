<?php

namespace App\Http\Controllers;

use App\Models\Proyek;
use App\Models\Pelaksana;
use App\Models\MasterKegiatan;
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
        $masterKegiatans = MasterKegiatan::orderBy('nama_kegiatan')->get();
        $satuans = ['m', 'm2', 'm3', 'ls', 'unit', 'titik', 'bh'];

        return view('admin.proyek.create', compact('pelaksanas', 'masterKegiatans', 'satuans'));
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
            // Validasi untuk satu kegiatan
            'nama_kegiatan' => 'required|string|max:255',
            'uraian' => 'nullable|string',
            'volume' => 'required|numeric|min:0',
            'satuan' => 'required|string|max:50',
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

            // Simpan satu detail kegiatan
            $proyek->kegiatans()->create($request->only([
                'nama_kegiatan',
                'uraian',
                'volume',
                'satuan'
            ]));
        });

        return redirect()->route('admin.proyek.index')
            ->with('success', 'Proyek baru berhasil dibuat dan ditugaskan.');
    }

    public function edit(Proyek $proyek)
    {
        // Load relasi kegiatan. Kita ambil yang pertama karena sekarang hanya ada satu.
        $proyek->load('kegiatans');
        $kegiatan = $proyek->kegiatans->first();

        $pelaksanas = Pelaksana::orderBy('nama_perusahaan')->get();
        $masterKegiatans = MasterKegiatan::orderBy('nama_kegiatan')->get();
        $satuans = ['m', 'm2', 'm3', 'ls', 'unit', 'titik', 'bh'];

        return view('admin.proyek.edit', compact('proyek', 'kegiatan', 'pelaksanas', 'masterKegiatans', 'satuans'));
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
            // Validasi untuk satu kegiatan
            'nama_kegiatan' => 'required|string|max:255',
            'uraian' => 'nullable|string',
            'volume' => 'required|numeric|min:0',
            'satuan' => 'required|string|max:50',
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

            // Hapus kegiatan lama dan buat yang baru (cara paling simpel)
            $proyek->kegiatans()->delete();
            $proyek->kegiatans()->create($request->only([
                'nama_kegiatan',
                'uraian',
                'volume',
                'satuan'
            ]));
        });

        return redirect()->route('admin.proyek.index')
            ->with('success', 'Data Proyek berhasil diperbarui.');
    }

    public function destroy(Proyek $proyek)
    {
        $proyek->delete();
        return redirect()->route('admin.proyek.index')->with('success', 'Proyek berhasil dihapus.');
    }
    public function show(Proyek $proyek)
    {
        // Load semua relasi yang dibutuhkan untuk ditampilkan di halaman detail
        $proyek->load(['pelaksana', 'kegiatans', 'tenagaKerja', 'pembayaran' => function ($query) {
            $query->orderBy('tanggal_transaksi', 'desc');
        }]);

        // Hitung total pengeluaran yang sudah dicatat oleh Pelaksana
        $totalPengeluaran = $proyek->pembayaran()->where('jenis', 'Pengeluaran')->sum('jumlah');

        // Hitung sisa anggaran
        $sisaAnggaran = $proyek->anggaran - $totalPengeluaran;

        // Kirim semua data ke view
        return view('admin.proyek.show', compact('proyek', 'totalPengeluaran', 'sisaAnggaran'));
    }
    
    public function cetakPdf(Proyek $proyek)
    {
        // Load semua data yang dibutuhkan untuk laporan
        $proyek->load(['pelaksana', 'pembayaran' => function ($query) {
            $query->orderBy('tanggal_transaksi', 'asc');
        }]);

        $totalPengeluaran = $proyek->pembayaran()->where('jenis', 'Pengeluaran')->sum('jumlah');
        $sisaAnggaran = $proyek->anggaran - $totalPengeluaran;

        // Buat PDF
        $pdf = PDF::loadView('laporan.proyek-pdf', compact('proyek', 'totalPengeluaran', 'sisaAnggaran'));

        // Tampilkan atau download PDF
        // return $pdf->download('laporan-proyek-'.$proyek->id.'.pdf'); // Untuk langsung download
        return $pdf->stream(); // Untuk menampilkan di browser
    }
}
