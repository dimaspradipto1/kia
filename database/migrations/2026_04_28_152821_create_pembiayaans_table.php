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
        Schema::create('pembiayaans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profil_ibu_id')->constrained()->cascadeOnDelete();
            $table->string('jenis_pembiayaan');
            $table->string('nama_asuransi')->nullable();
            $table->string('nomor_polis')->nullable();
            $table->date('tanggal_berlaku')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembiayaans');
    }
};
