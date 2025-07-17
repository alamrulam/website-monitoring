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
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('nama_perusahaan');
            $table->string('nama_kontak');
            $table->string('telepon');
            $table->text('alamat');

            // --- KOLOM TAMBAHAN DENGAN NAMA BARU ---
            $table->string('nomor_kontrak')->nullable();
            $table->date('tanggal_kontrak')->nullable();
            $table->string('nama_bank')->nullable();
            $table->string('nomor_rekening')->nullable();
            $table->string('atas_nama_rekening')->nullable();
            // $table->string('nomor_pajak')->nullable(); // <-- DIHAPUS
            // ------------------------------------

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pelaksanas');
    }
};
