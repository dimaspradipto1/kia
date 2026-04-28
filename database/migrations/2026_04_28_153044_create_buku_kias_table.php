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
        Schema::create('buku_kias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profil_ibu_id')->constrained()->cascadeOnDelete();
            $table->foreignId('fasilitas_kesehatan_id')->constrained()->cascadeOnDelete();
            $table->string('no_reg_kohort_ibu');
            $table->string('no_reg_kohort_bayi');
            $table->string('no_reg_kohort_balita');
            $table->string('kehamilan_ke');
            $table->string('jumlah_anak_hidup');
            $table->string('riwayat_keguguran');
            $table->string('riwayat_penyakit');
            $table->string('no_catatan_medik_rs');
            $table->string('qr_code');
            $table->string('status');
            $table->string('diterbitkan_pada');
            $table->string('diterbitkan_oleh');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buku_kias');
    }
};
