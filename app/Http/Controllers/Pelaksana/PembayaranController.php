<?php

namespace App\Http\Controllers\Pelaksana;

use App\Http\Controllers\Controller;
use App\Models\Proyek;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    public function create(Proyek $proyek, Request $request)
    {
        // Otorisasi
        if ($proyek->pelaksana_id !== $request->user()->pelaksana->id) {
            abort(403);
        }

        $jenis = $request->query('jenis');
        if (!in_array($jenis, ['Pemasukan', 'Pengeluaran'])) {
            abort(400, 'Jenis transaksi tidak valid.');
        }
        return view('pelaksana.pembayaran.create', compact('proyek', 'jenis'));
    }

    public function store(Request $request, Proyek $proyek)
    {
        // Otorisasi
        if ($proyek->pelaksana_id !== $request->user()->pelaksana->id) {
            abort(403);
        }

        $request->validate([
            'tanggal_transaksi' => 'required|date',
            'uraian' => 'required|string',
            'jenis' => 'required|in:Pemasukan,Pengeluaran',
            'kategori' => 'required|string',
            'jumlah' => 'required|numeric|min:0',
            'bukti' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $path = null;
        if ($request->hasFile('bukti')) {
            $path = $request->file('bukti')->store('bukti_pembayaran', 'public');
        }

        $proyek->pembayaran()->create([
            'tanggal_transaksi' => $request->tanggal_transaksi,
            'uraian' => $request->uraian,
            'jenis' => $request->jenis,
            'kategori' => $request->kategori,
            'jumlah' => $request->jumlah,
            'bukti_url' => $path,
        ]);

        return redirect()->route('pelaksana.proyek.show', $proyek)->with('success', 'Transaksi berhasil dicatat.');
    }

    public function destroy(Proyek $proyek, \App\Models\Pembayaran $pembayaran)
    {
        // Otorisasi
        if ($proyek->pelaksana_id !== request()->user()->pelaksana->id) {
            abort(403);
        }

        // Hapus file bukti jika ada
        if ($pembayaran->bukti_url) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($pembayaran->bukti_url);
        }

        $pembayaran->delete();
        return redirect()->route('pelaksana.proyek.show', $proyek)->with('success', 'Transaksi berhasil dihapus.');
    }
}
