<?php


namespace App\Http\Controllers\Pelaksana;

use App\Http\Controllers\Controller;
use App\Models\Proyek;
use App\Models\DokumentasiFoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProgresController extends Controller
{
    // Method untuk update progres fisik
    public function updateProgres(Request $request, Proyek $proyek)
    {
        // Otorisasi
        if ($proyek->pelaksana_id !== $request->user()->pelaksana->id) {
            abort(403);
        }

        $request->validate([
            'progres_fisik' => 'required|integer|min:0|max:100',
        ]);

        $proyek->update(['progres_fisik' => $request->progres_fisik]);

        return redirect()->route('pelaksana.proyek.show', $proyek)->with('success', 'Progres fisik berhasil diperbarui.');
    }

    // Method untuk upload foto
    public function uploadFoto(Request $request, Proyek $proyek)
    {
        // Otorisasi
        if ($proyek->pelaksana_id !== $request->user()->pelaksana->id) {
            abort(403);
        }

        $request->validate([
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'keterangan' => 'required|string|max:255',
        ]);

        $path = $request->file('foto')->store('dokumentasi_proyek', 'public');

        $proyek->dokumentasiFotos()->create([
            'foto_url' => $path,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('pelaksana.proyek.show', $proyek)->with('success', 'Foto dokumentasi berhasil diunggah.');
    }

    // Method untuk hapus foto
    public function hapusFoto(Request $request, Proyek $proyek, DokumentasiFoto $foto)
    {
        // Otorisasi
        if ($proyek->pelaksana_id !== $request->user()->pelaksana->id) {
            abort(403);
        }

        // Hapus file dari storage
        Storage::disk('public')->delete($foto->foto_url);
        // Hapus record dari database
        $foto->delete();

        return redirect()->route('pelaksana.proyek.show', $proyek)->with('success', 'Foto dokumentasi berhasil dihapus.');
    }
}
