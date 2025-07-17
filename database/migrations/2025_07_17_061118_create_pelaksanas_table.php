<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pelaksanas', function (Blueprint $table) {
            $table->id();
            // Relasi ke tabel users. Jika user dihapus, pelaksana juga terhapus.
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('nama_perusahaan');
            $table->string('nama_kontak');
            $table->string('telepon');
            $table->text('alamat');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pelaksanas');
    }
};
