<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('layanan_intro_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('layanan_intro_id')->constrained('layanan_intros')->cascadeOnDelete();
            $table->string('path')->comment('Path/nama file gambar');
            $table->string('keterangan')->nullable()->comment('Alt text atau keterangan gambar');
            $table->boolean('is_default')->default(false)->comment('Apakah ini gambar utama (hanya boleh 1)');
            $table->integer('urutan')->default(0)->comment('Urutan gambar pendukung');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('layanan_intro_images');
    }
};
