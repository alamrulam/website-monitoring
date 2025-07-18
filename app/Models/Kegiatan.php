<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Kegiatan extends Model
{
    use HasFactory;

    protected $fillable = [
        'proyek_id',
        'nama_kegiatan',
        'uraian',
        'volume',
        'satuan',
    ];

    public function proyek(): BelongsTo
    {
        return $this->belongsTo(Proyek::class);
    }
}
