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
        Schema::create('persalinans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('buku_kia_id')->constrained()->cascadeOnDelete();
            $table->foreignId('fasilitas_kesehatan_id')->constrained()->cascadeOnDelete();
            $table->date('tanggal_lahir');
            $table->string('jam_lahir');
            $table->string('jenis_persalinan');
            $table->string('penolong');
            $table->decimal('berat_bayi_kg');
            $table->decimal('panjang_bayi_cm');
            $table->integer('apgar_score_1');
            $table->integer('apgar_score_5');
            $table->string('kondisi_ibu');
            $table->string('kondisi_bayi');
            $table->string('komplikasi');
            $table->foreignId('nakes_id')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('persalinans');
    }
};
