<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TenagaKerja extends Model
{
    use HasFactory;
    protected $table = 'tenaga_kerjas';

    // Sesuaikan dengan kolom baru di database
    protected $fillable = [
        'proyek_id',
        'nama_pekerja',
        'tempat_lahir',
        'pendidikan',
        'jenis_kelamin',
        'posisi',
        'telepon'
    ];

    public function proyek(): BelongsTo
    {
        return $this->belongsTo(Proyek::class);
    }
}
