<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pimpinans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_desa')->default('Suranenggala Kidul');
            $table->string('nama_kepala_desa')->default('Pemerintah Desa Suranenggala Kidul');
            $table->timestamps();
        });

        DB::table('pimpinans')->insert([
            'nama_desa' => 'Suranenggala Kidul',
            'nama_kepala_desa' => 'Pemerintah Desa Suranenggala Kidul',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pimpinans');
    }
};
