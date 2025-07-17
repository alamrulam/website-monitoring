<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('master_kegiatans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kegiatan')->unique();
            $table->string('default_satuan')->default('m2');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('master_kegiatans');
    }
};
