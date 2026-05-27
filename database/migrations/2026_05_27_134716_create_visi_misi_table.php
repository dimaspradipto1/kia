<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('visi_misi', function (Blueprint $table) {
            $table->id();
            $table->text('visi')->comment('Pernyataan visi organisasi');
            $table->json('misi')->comment('Array poin-poin misi');
            $table->text('nilai')->nullable()->comment('Ringkasan nilai (paragraf pendek)');
            $table->json('nilai_items')->nullable()->comment('Array item nilai detail: [{judul,deskripsi,ikon,tema}]');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('visi_misi');
    }
};
