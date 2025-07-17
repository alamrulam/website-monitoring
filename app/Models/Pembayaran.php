<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pembayaran extends Model
{
    use HasFactory;
    protected $fillable = ['proyek_id', 'tanggal_transaksi', 'uraian', 'jenis', 'kategori', 'jumlah', 'bukti_url'];

    public function proyek(): BelongsTo
    {
        return $this->belongsTo(Proyek::class);
    }
}
