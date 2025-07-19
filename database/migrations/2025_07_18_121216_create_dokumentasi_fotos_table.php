<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dokumentasi_fotos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proyek_id')->constrained()->onDelete('cascade');
            $table->string('foto_url');
            $table->string('keterangan'); // Contoh: Kondisi 0%, Pengecoran, Finishing
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dokumentasi_fotos');
    }
};
