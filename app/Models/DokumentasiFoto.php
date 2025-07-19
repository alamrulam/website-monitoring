<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DokumentasiFoto extends Model
{
    use HasFactory;
    protected $table = 'dokumentasi_fotos';
    protected $fillable = ['proyek_id', 'foto_url', 'keterangan'];

    public function proyek(): BelongsTo
    {
        return $this->belongsTo(Proyek::class);
    }
}
