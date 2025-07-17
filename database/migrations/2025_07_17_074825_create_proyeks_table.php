<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('proyeks', function (Blueprint $table) {
            $table->id();
            // Relasi ke tabel pelaksanas. Jika pelaksana dihapus, proyeknya juga terhapus.
            $table->foreignId('pelaksana_id')->constrained()->onDelete('cascade');
            $table->string('nama_proyek');
            $table->text('lokasi');
            $table->decimal('anggaran', 15, 2); // Angka besar dengan 2 desimal
            $table->date('tanggal_mulai')->nullable();
            $table->date('tanggal_selesai')->nullable();
            $table->enum('status', ['Perencanaan', 'Berjalan', 'Selesai', 'Dibatalkan'])->default('Perencanaan');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('proyeks');
    }
};
