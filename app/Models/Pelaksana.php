<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany; // <-- Tambahkan ini

class Pelaksana extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nama_perusahaan',
        'nama_kontak',
        'telepon',
        'alamat',
        'nomor_kontrak',
        'tanggal_kontrak',
        'nama_bank',
        'nomor_rekening',
        'atas_nama_rekening',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Satu Pelaksana bisa memiliki banyak Proyek.
     */
    public function proyeks(): HasMany
    {
        return $this->hasMany(Proyek::class);
    }
}
