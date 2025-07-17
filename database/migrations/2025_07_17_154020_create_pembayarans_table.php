<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proyek_id')->constrained()->onDelete('cascade');
            $table->date('tanggal_transaksi');
            $table->text('uraian');
            $table->enum('jenis', ['Pemasukan', 'Pengeluaran']);
            $table->enum('kategori', ['Dana Masuk', 'Upah Tenaga Kerja', 'Belanja Material', 'Sewa Alat', 'Biaya Operasional', 'Lain-lain']);
            $table->decimal('jumlah', 15, 2);
            $table->string('bukti_url')->nullable(); // Path untuk menyimpan foto bukti
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pembayarans');
    }
};
