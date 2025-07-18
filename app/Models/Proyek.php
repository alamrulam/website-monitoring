<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Proyek extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
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
     * Mendefinisikan relasi bahwa Proyek ini dimiliki oleh satu Pelaksana.
     */
    public function pelaksana(): BelongsTo
    {
        return $this->belongsTo(Pelaksana::class);
    }

    /**
     * Mendefinisikan relasi bahwa satu Proyek bisa memiliki banyak Kegiatan.
     * INI ADALAH FUNGSI YANG HILANG DAN MENYEBABKAN ERROR.
     */
    public function kegiatans(): HasMany
    {
        return $this->hasMany(Kegiatan::class);
    }

    /**
     * Mendefinisikan relasi bahwa satu Proyek bisa memiliki banyak Tenaga Kerja.
     */
    public function tenagaKerja(): HasMany
    {
        return $this->hasMany(TenagaKerja::class);
    }

    /**
     * Mendefinisikan relasi bahwa satu Proyek bisa memiliki banyak Pembayaran.
     */
    public function pembayaran(): HasMany
    {
        return $this->hasMany(Pembayaran::class);
    }
}
