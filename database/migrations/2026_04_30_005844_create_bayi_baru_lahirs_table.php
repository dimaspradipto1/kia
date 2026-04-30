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
        Schema::create('bayi_baru_lahirs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profil_anak_id')->constrained()->cascadeOnDelete();
            $table->foreignId('persalinan_id')->constrained()->cascadeOnDelete();
            $table->foreignId('nakes_id')->constrained('users')->cascadeOnDelete();
            $table->boolean('hb0_diberikan');
            $table->time('hb0_waktu');
            $table->boolean('vit_k1_diberikan');
            $table->boolean('salep_mata_diberikan');
            $table->boolean('shk_dilakukan');
            $table->time('shk_waktu');
            $table->string('shk_hasil');
            $table->boolean('pjb_dilakukan');
            $table->string('pjb_hasil');
            $table->string('kondisi_umum');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bayi_baru_lahirs');
    }
};
