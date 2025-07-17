<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Proyek extends Model
{
    use HasFactory;

    protected $fillable = [
        'pelaksana_id',
        'nama_proyek',
        'lokasi',
        'anggaran',
        'tanggal_mulai',
        'tanggal_selesai',
        'status',
    ];

    /**
     * Proyek ini dimiliki oleh satu Pelaksana.
     */
    public function pelaksana(): BelongsTo
    {
        return $this->belongsTo(Pelaksana::class);
    }

    // --- TAMBAHKAN RELASI INI ---
    public function tenagaKerja(): HasMany
    {
        return $this->hasMany(TenagaKerja::class);
    }

    public function pembayaran(): HasMany
    {
        return $this->hasMany(Pembayaran::class);
    }
}
