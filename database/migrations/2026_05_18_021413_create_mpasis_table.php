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
        Schema::create('mpasis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profil_anak_id')->constrained()->cascadeOnDelete();
            $table->foreignId('nakes_id')->constrained('users')->cascadeOnDelete();
            $table->date('tanggal_mulai_mpasi');
            $table->string('jenis_mpasi');
            $table->string('frekuensi');
            $table->string('tekstur');
            $table->string('catatan_gizi');
            $table->date('dibuat_pada');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mpasis');
    }
};
