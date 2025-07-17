<?php

namespace App\Http\Controllers;

use App\Models\Proyek;
use App\Models\Pelaksana;
use App\Models\MasterKegiatan; // <-- Pastikan ini ada
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // <-- Pastikan ini ada

class ProyekController extends Controller
{
    /**
     * Menampilkan daftar semua proyek.
     */
    public function index()
    {
        $proyeks = Proyek::with('pelaksana')->latest()->paginate(10);
        return view('admin.proyek.index', compact('proyeks'));
    }

    /**
     * Menampilkan form untuk membuat proyek baru.
     */
    public function create()
    {
        $pelaksanas = Pelaksana::orderBy('nama_perusahaan')->get();
        // Mengambil data untuk dropdown
        $masterKegiatans = MasterKegiatan::orderBy('nama_kegiatan')->get();
        $satuans = ['m', 'm2', 'm3', 'ls', 'unit', 'titik', 'bh'];

        return view('admin.proyek.create', compact('pelaksanas', 'masterKegiatans', 'satuans'));
    }

    /**
     * Menyimpan proyek baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_proyek' => 'required|string|max:255',
            'pelaksana_id' => 'required|exists:pelaksanas,id',
            'lokasi' => 'required|string',
            'anggaran' => 'required|numeric|min:0',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'kegiatan' => 'required|array|min:1',
            'kegiatan.*.nama_kegiatan' => 'required|string|max:255',
            'kegiatan.*.uraian' => 'nullable|string',
            'kegiatan.*.volume' => 'required|numeric|min:0',
            'kegiatan.*.satuan' => 'required|string|max:50',
        ]);

        // Menggunakan transaction untuk memastikan semua data tersimpan atau tidak sama sekali
        DB::transaction(function () use ($request) {
            // 1. Buat Proyek utama
            $proyek = Proyek::create($request->except('kegiatan'));

            // 2. Simpan setiap detail kegiatan yang berelasi dengan proyek
            foreach ($request->kegiatan as $kegiatanData) {
                $proyek->kegiatans()->create($kegiatanData);
            }
        });

        return redirect()->route('admin.proyek.index')
            ->with('success', 'Proyek baru berhasil dibuat dan ditugaskan.');
    }

    /**
     * Menampilkan form untuk mengedit proyek.
     */
    public function edit(Proyek $proyek)
    {
        $proyek->load('kegiatans'); // Load data kegiatan yang sudah ada
        $pelaksanas = Pelaksana::orderBy('nama_perusahaan')->get();
        // Mengambil data untuk dropdown
        $masterKegiatans = MasterKegiatan::orderBy('nama_kegiatan')->get();
        $satuans = ['m', 'm2', 'm3', 'ls', 'unit', 'titik', 'bh'];

        return view('admin.proyek.edit', compact('proyek', 'pelaksanas', 'masterKegiatans', 'satuans'));
    }

    /**
     * Memperbarui data proyek di database.
     */
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
            'kegiatan' => 'required|array|min:1',
            'kegiatan.*.nama_kegiatan' => 'required|string|max:255',
            'kegiatan.*.uraian' => 'nullable|string',
            'kegiatan.*.volume' => 'required|numeric|min:0',
            'kegiatan.*.satuan' => 'required|string|max:50',
        ]);

        DB::transaction(function () use ($request, $proyek) {
            // 1. Update data proyek utama
            $proyek->update($request->except('kegiatan'));

            // 2. Hapus semua kegiatan lama agar tidak ada data ganda
            $proyek->kegiatans()->delete();

            // 3. Buat ulang semua kegiatan dari data form yang baru
            foreach ($request->kegiatan as $kegiatanData) {
                $proyek->kegiatans()->create($kegiatanData);
            }
        });

        return redirect()->route('admin.proyek.index')
            ->with('success', 'Data Proyek berhasil diperbarui.');
    }

    /**
     * Menghapus proyek dari database.
     */
    public function destroy(Proyek $proyek)
    {
        $proyek->delete();

        return redirect()->route('admin.proyek.index')
            ->with('success', 'Proyek berhasil dihapus.');
    }
}
