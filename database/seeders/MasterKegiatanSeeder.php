<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MasterKegiatan; // <-- Jangan lupa import

class MasterKegiatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MasterKegiatan::create(['nama_kegiatan' => 'Pekerjaan Persiapan', 'default_satuan' => 'ls']);
        MasterKegiatan::create(['nama_kegiatan' => 'Galian Tanah', 'default_satuan' => 'm3']);
        MasterKegiatan::create(['nama_kegiatan' => 'Urugan Pasir', 'default_satuan' => 'm3']);
        MasterKegiatan::create(['nama_kegiatan' => 'Pemasangan Paving Block', 'default_satuan' => 'm2']);
        MasterKegiatan::create(['nama_kegiatan' => 'Pengecoran Rabat Beton', 'default_satuan' => 'm3']);
        MasterKegiatan::create(['nama_kegiatan' => 'Pekerjaan Finishing', 'default_satuan' => 'ls']);
    }
}
