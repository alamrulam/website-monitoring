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
        'progres_fisik',
    ];

    public function pelaksana(): BelongsTo
    {
        return $this->belongsTo(Pelaksana::class);
    }

    public function kegiatans(): HasMany
    {
        return $this->hasMany(Kegiatan::class);
    }

    // Pastikan fungsi ini ada
    public function tenagaKerja(): HasMany
    {
        return $this->hasMany(TenagaKerja::class);
    }

    // Pastikan fungsi ini ada
    public function pembayaran(): HasMany
    {
        return $this->hasMany(Pembayaran::class);
    }

    // Pastikan fungsi ini ada
    public function dokumentasiFotos(): HasMany
    {
        return $this->hasMany(DokumentasiFoto::class);
    }
}
