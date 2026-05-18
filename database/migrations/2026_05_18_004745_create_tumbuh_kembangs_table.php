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
        Schema::create('tumbuh_kembangs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profil_anak_id')->constrained('profil_anaks')->cascadeOnDelete();
            $table->foreignId('fasilitas_kesehatan_id')->constrained('fasilitas_kesehatans')->cascadeOnDelete();
            $table->foreignId('nakes_id')->constrained('users')->cascadeOnDelete();
            $table->date('tanggal_ukur');
            $table->integer('usia_bulan');
            $table->decimal('berat_badan', 5, 2);
            $table->decimal('tinggi_badan', 5, 2);
            $table->decimal('lingkar_kepala', 5, 2)->nullable();
            $table->decimal('lila_cm', 5, 2)->nullable();
            $table->string('status_gizi_bb_u');
            $table->string('status_gizi_tb_u');
            $table->string('status_gizi_bb_tb');
            $table->string('status_stunting')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tumbuh_kembangs');
    }
};
