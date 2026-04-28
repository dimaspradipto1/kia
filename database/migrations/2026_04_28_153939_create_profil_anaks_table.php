<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('profil_anaks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('buku_kia_id')->constrained()->cascadeOnDelete();
            $table->string('nama_lengkap');
            $table->string('jenis_kelamin');
            $table->string('anak_ke');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->string('golongan_darah')->nullable();
            $table->string('nomor_akta_kelahiran')->nullable();
            $table->string('berat_lahir_kg')->nullable();
            $table->string('panjang_lahir_cm')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profil_anaks');
    }
};
