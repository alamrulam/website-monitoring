<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tenaga_kerjas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proyek_id')->constrained()->onDelete('cascade');
            $table->string('nama_pekerja');

            // --- KOLOM BARU SESUAI PERMINTAAN ---
            $table->string('tempat_lahir');
            $table->string('pendidikan');
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            // ------------------------------------

            $table->string('posisi'); // Contoh: Kepala Tukang, Pekerja, Mandor
            $table->string('telepon')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('tenaga_kerjas');
    }
};
