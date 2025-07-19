<?php

namespace App\Http\Controllers;

use App\Models\Proyek;
use App\Models\Pelaksana;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
}
