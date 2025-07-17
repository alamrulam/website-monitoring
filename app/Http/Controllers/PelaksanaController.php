<?php

namespace App\Http\Controllers;

use App\Models\Pelaksana;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PelaksanaController extends Controller
{
    public function index()
    {
        $pelaksanas = Pelaksana::with('user')->latest()->paginate(10);
        return view('admin.pelaksana.index', compact('pelaksanas'));
    }

    public function create()
    {
        return view('admin.pelaksana.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_perusahaan' => 'required|string|max:255',
            'nama_kontak' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'telepon' => 'required|string|max:15',
            'alamat' => 'required|string',
            'nomor_kontrak' => 'nullable|string|max:255',
            'tanggal_kontrak' => 'nullable|date',
            'nama_bank' => 'nullable|string|max:255',
            'nomor_rekening' => 'nullable|string|max:255',
            'atas_nama_rekening' => 'nullable|string|max:255',
        ]);

        $password = Str::random(8);

        $user = User::create([
            'name' => $request->nama_kontak,
            'email' => $request->email,
            'password' => Hash::make($password),
            'role' => 'pelaksana',
        ]);

        $user->pelaksana()->create($request->all());

        return redirect()->route('admin.pelaksana.index')
            ->with('success', 'Pelaksana berhasil dibuat.')
            ->with('password', 'Password untuk ' . $request->email . ' adalah: ' . $password);
    }

    public function show(Pelaksana $pelaksana)
    {
        return redirect()->route('admin.pelaksana.edit', $pelaksana);
    }

    public function edit(Pelaksana $pelaksana)
    {
        return view('admin.pelaksana.edit', compact('pelaksana'));
    }

    public function update(Request $request, Pelaksana $pelaksana)
    {
        $request->validate([
            'nama_perusahaan' => 'required|string|max:255',
            'nama_kontak' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $pelaksana->user_id,
            'telepon' => 'required|string|max:15',
            'alamat' => 'required|string',
            'nomor_kontrak' => 'nullable|string|max:255',
            'tanggal_kontrak' => 'nullable|date',
            'nama_bank' => 'nullable|string|max:255',
            'nomor_rekening' => 'nullable|string|max:255',
            'atas_nama_rekening' => 'nullable|string|max:255',
        ]);

        $pelaksana->user->update([
            'name' => $request->nama_kontak,
            'email' => $request->email,
        ]);

        $pelaksana->update($request->all());

        return redirect()->route('admin.pelaksana.index')
            ->with('success', 'Data Pelaksana berhasil diperbarui.');
    }

    public function destroy(Pelaksana $pelaksana)
    {
        $pelaksana->user->delete();

        return redirect()->route('admin.pelaksana.index')
            ->with('success', 'Pelaksana berhasil dihapus.');
    }
}
