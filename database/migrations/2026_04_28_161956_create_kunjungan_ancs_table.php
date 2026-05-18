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
        Schema::create('kunjungan_ancs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('buku_kia_id')->constrained()->cascadeOnDelete();
            $table->foreignId('fasilitas_kesehatan_id')->constrained()->cascadeOnDelete();
            $table->integer('trimester');
            $table->integer('kunjungan_ke');
            $table->date('tanggal_kunjungan');
            $table->float('berat_badan');
            $table->decimal('tekanan_darah_sistolik');
            $table->decimal('tekanan_darah_diastolik');
            $table->decimal('tinggi_fundus_cm')->nullable();
            $table->decimal('lila_cm');
            $table->string('denyut_jantung_janin')->nullable();
            $table->string('letak_janin')->nullable();
            $table->string('status_tt')->nullable();
            $table->string('usg_dilakukan');
            $table->string('hasil_usg')->nullable();
            $table->string('skrining_jiwa')->nullable();
            $table->text('catatan')->nullable();
            $table->foreignId('nakes_id')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kunjungan_ancs');
    }
};
