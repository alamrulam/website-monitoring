<?php

namespace App\Http\Controllers\Pelaksana;

use App\Http\Controllers\Controller;
use App\Models\Proyek;
use App\Models\TenagaKerja;
use Illuminate\Http\Request;

class TenagaKerjaController extends Controller
{
    public function create(Proyek $proyek, Request $request)
    {
        if ($proyek->pelaksana_id !== $request->user()->pelaksana->id) {
            abort(403, 'Akses Ditolak');
        }
        // Siapkan data untuk dropdown posisi
        $posisiOptions = ['Kepala Tukang', 'Tukang', 'Mandor', 'Pekerja'];

        return view('pelaksana.tenaga_kerja.create', compact('proyek', 'posisiOptions'));
    }

    public function store(Request $request, Proyek $proyek)
    {
        if ($proyek->pelaksana_id !== $request->user()->pelaksana->id) {
            abort(403, 'Akses Ditolak');
        }

        // Validasi data baru
        $validatedData = $request->validate([
            'nama_pekerja' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'pendidikan' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'posisi' => 'required|string|in:Kepala Tukang,Tukang,Mandor,Pekerja',
            'telepon' => 'nullable|string|max:15',
        ]);

        $proyek->tenagaKerja()->create($validatedData);

        return redirect()->route('pelaksana.proyek.show', ['proyek' => $proyek, 'tab' => 'tenaga-kerja'])
            ->with('success', 'Tenaga kerja berhasil ditambahkan.');
    }

    public function destroy(Proyek $proyek, TenagaKerja $tenagaKerja, Request $request)
    {
        if ($proyek->pelaksana_id !== $request->user()->pelaksana->id) {
            abort(403, 'Akses Ditolak');
        }

        $tenagaKerja->delete();

        return redirect()->route('pelaksana.proyek.show', ['proyek' => $proyek, 'tab' => 'tenaga-kerja'])
            ->with('success', 'Tenaga kerja berhasil dihapus.');
    }


    /**
     * Menampilkan form untuk mengedit data tenaga kerja.
     */
    public function edit(Proyek $proyek, TenagaKerja $tenagaKerja, Request $request)
    {
        if ($proyek->pelaksana_id !== $request->user()->pelaksana->id) {
            abort(403, 'Akses Ditolak');
        }
        $posisiOptions = ['Kepala Tukang', 'Tukang', 'Mandor', 'Pekerja'];

        return view('pelaksana.tenaga_kerja.edit', compact('proyek', 'tenagaKerja', 'posisiOptions'));
    }

    /**
     * Memperbarui data tenaga kerja di database.
     */
    public function update(Request $request, Proyek $proyek, TenagaKerja $tenagaKerja)
    {
        if ($proyek->pelaksana_id !== $request->user()->pelaksana->id) {
            abort(403, 'Akses Ditolak');
        }

        $validatedData = $request->validate([
            'nama_pekerja' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'pendidikan' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'posisi' => 'required|string|in:Kepala Tukang,Tukang,Mandor,Pekerja',
            'telepon' => 'nullable|string|max:15',
        ]);

        $tenagaKerja->update($validatedData);

        return redirect()->route('pelaksana.proyek.show', ['proyek' => $proyek, 'tab' => 'tenaga-kerja'])
            ->with('success', 'Data tenaga kerja berhasil diperbarui.');
    }
}
