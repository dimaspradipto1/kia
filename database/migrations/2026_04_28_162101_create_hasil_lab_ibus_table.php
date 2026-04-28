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
        Schema::create('hasil_lab_ibus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kunjungan_anc_id')->constrained()->cascadeOnDelete();
            $table->string('jenis_pemeriksaan');
            $table->string('hasil');
            $table->string('satuan');
            $table->string('nilai_normal');
            $table->date('tanggal_periksa');
            $table->foreignId('nakes_id')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hasil_lab_ibus');
    }
};
