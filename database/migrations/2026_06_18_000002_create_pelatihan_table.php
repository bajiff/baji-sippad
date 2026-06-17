<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pelatihan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kategori_id')->constrained('kategori_pelatihan')->cascadeOnDelete();
            $table->string('judul');
            $table->text('deskripsi');
            $table->string('narasumber');
            $table->string('lokasi');
            $table->date('tanggal');
            $table->time('jam');
            $table->integer('kuota')->nullable();
            $table->text('persyaratan')->nullable();
            $table->enum('status', ['draft', 'publish', 'closed', 'selesai'])->default('draft');
            $table->boolean('sertifikat_enabled')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pelatihan');
    }
};
