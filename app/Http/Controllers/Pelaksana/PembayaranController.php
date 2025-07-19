<?php

namespace App\Http\Controllers\Pelaksana;

use App\Http\Controllers\Controller;
use App\Models\Proyek;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PembayaranController extends Controller
{
    /**
     * Menampilkan form untuk mencatat transaksi baru.
     */
    public function create(Proyek $proyek, Request $request)
    {
        // Otorisasi
        if ($proyek->pelaksana_id !== $request->user()->pelaksana->id) {
            abort(403, 'Akses Ditolak');
        }

        $jenis = $request->query('jenis');
        if (!in_array($jenis, ['Pemasukan', 'Pengeluaran'])) {
            abort(400, 'Jenis transaksi tidak valid.');
        }
        return view('pelaksana.pembayaran.create', compact('proyek', 'jenis'));
    }

    /**
     * Menyimpan data transaksi baru ke database.
     */
    public function store(Request $request, Proyek $proyek)
    {
        // Otorisasi
        if ($proyek->pelaksana_id !== $request->user()->pelaksana->id) {
            abort(403, 'Akses Ditolak');
        }

        // Validasi data yang masuk dari form
        $validatedData = $request->validate([
            'tanggal_transaksi' => 'required|date',
            'uraian' => 'required|string',
            'jenis' => 'required|in:Pemasukan,Pengeluaran',
            'kategori' => 'required|string',
            'jumlah' => 'required|numeric|min:0',
            'bukti' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Proses upload file bukti jika ada
        if ($request->hasFile('bukti')) {
            $path = $request->file('bukti')->store('bukti_pembayaran', 'public');
            $validatedData['bukti_url'] = $path;
        }

        // Membuat data baru menggunakan relasi yang sudah ada di Model Proyek.
        $proyek->pembayaran()->create($validatedData);

        // Redirect kembali ke halaman detail proyek di tab "Buku Kas"
        return redirect()->route('pelaksana.proyek.show', ['proyek' => $proyek, 'tab' => 'pembayaran'])
            ->with('success', 'Transaksi berhasil dicatat.');
    }

    /**
     * Menghapus data transaksi.
     */
    public function destroy(Proyek $proyek, Pembayaran $pembayaran, Request $request)
    {
        // Otorisasi
        if ($proyek->pelaksana_id !== $request->user()->pelaksana->id) {
            abort(403, 'Akses Ditolak');
        }

        // Hapus file bukti jika ada
        if ($pembayaran->bukti_url) {
            Storage::disk('public')->delete($pembayaran->bukti_url);
        }

        $pembayaran->delete();

        return redirect()->route('pelaksana.proyek.show', ['proyek' => $proyek, 'tab' => 'pembayaran'])
            ->with('success', 'Transaksi berhasil dihapus.');
    }
    /**
     * Menampilkan form untuk mengedit data transaksi.
     */
    public function edit(Proyek $proyek, Pembayaran $pembayaran, Request $request)
    {
        if ($proyek->pelaksana_id !== $request->user()->pelaksana->id) {
            abort(403, 'Akses Ditolak');
        }

        return view('pelaksana.pembayaran.edit', compact('proyek', 'pembayaran'));
    }

    /**
     * Memperbarui data transaksi di database.
     */
    public function update(Request $request, Proyek $proyek, Pembayaran $pembayaran)
    {
        if ($proyek->pelaksana_id !== $request->user()->pelaksana->id) {
            abort(403, 'Akses Ditolak');
        }

        $validatedData = $request->validate([
            'tanggal_transaksi' => 'required|date',
            'uraian' => 'required|string',
            'kategori' => 'required|string',
            'jumlah' => 'required|numeric|min:0',
            'bukti' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Proses update file bukti jika ada file baru yang diunggah
        if ($request->hasFile('bukti')) {
            // Hapus file lama jika ada
            if ($pembayaran->bukti_url) {
                Storage::disk('public')->delete($pembayaran->bukti_url);
            }
            // Simpan file baru
            $path = $request->file('bukti')->store('bukti_pembayaran', 'public');
            $validatedData['bukti_url'] = $path;
        }

        $pembayaran->update($validatedData);

        return redirect()->route('pelaksana.proyek.show', ['proyek' => $proyek, 'tab' => 'pembayaran'])
            ->with('success', 'Transaksi berhasil diperbarui.');
    }
}
