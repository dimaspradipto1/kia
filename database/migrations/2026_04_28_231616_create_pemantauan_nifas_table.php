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
        Schema::create('pemantauan_nifas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('buku_kia_id')->constrained()->cascadeOnDelete();
            $table->foreignId('nakes_id')->constrained('users')->cascadeOnDelete();
            $table->date('tanggal');
            $table->string('hari_ke');
            $table->string('demam');
            $table->string('pendarahan');
            $table->string('nyeri_ulu_hati');
            $table->string('pandangan_kabur');
            $table->string('keluar_cairan_berbau');
            $table->string('payudara_bengkak');
            $table->string('gangguan_jiwa');
            $table->string('gangguan_bak');
            $table->text('catatan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemantauan_nifas');
    }
};
