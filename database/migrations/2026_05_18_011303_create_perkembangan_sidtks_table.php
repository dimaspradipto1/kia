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
        Schema::create('perkembangan_sidtks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profil_anak_id')->constrained('profil_anaks')->cascadeOnDelete();
            $table->foreignId('nakes_id')->constrained('users')->cascadeOnDelete();
            $table->date('tanggal_skrining');
            $table->integer('usia_bulan');
            $table->string('domain');
            $table->string('hasil');
            $table->string('tindak_lanjut');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perkembangan_sidtks');
    }
};
