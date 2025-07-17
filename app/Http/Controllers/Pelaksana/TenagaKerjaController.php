<?php

namespace App\Http\Controllers\Pelaksana;

use App\Http\Controllers\Controller;
use App\Models\Proyek;
use Illuminate\Http\Request;

class TenagaKerjaController extends Controller
{
    public function create(Proyek $proyek)
    {
        return view('pelaksana.tenaga_kerja.create', compact('proyek'));
    }

    public function store(Request $request, Proyek $proyek)
    {
        // Otorisasi
        if ($proyek->pelaksana_id !== $request->user()->pelaksana->id) {
            abort(403);
        }

        $request->validate([
            'nama_pekerja' => 'required|string|max:255',
            'posisi' => 'required|string|max:255',
            'telepon' => 'nullable|string|max:15',
        ]);

        $proyek->tenagaKerja()->create($request->all());

        return redirect()->route('pelaksana.proyek.show', $proyek)->with('success', 'Tenaga kerja berhasil ditambahkan.');
    }

    public function destroy(Proyek $proyek, \App\Models\TenagaKerja $tenagaKerja)
    {
        // Otorisasi
        if ($proyek->pelaksana_id !== request()->user()->pelaksana->id) {
            abort(403);
        }

        $tenagaKerja->delete();
        return redirect()->route('pelaksana.proyek.show', $proyek)->with('success', 'Tenaga kerja berhasil dihapus.');
    }
}
