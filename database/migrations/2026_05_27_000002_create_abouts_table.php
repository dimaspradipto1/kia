<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('abouts', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('sub_judul')->nullable();
            $table->text('deskripsi_pendek')->nullable()->comment('Paragraf singkat / lead text');
            $table->text('deskripsi_panjang')->nullable()->comment('Paragraf lengkap');
            $table->json('fitur')->nullable()->comment('Array fitur/keunggulan');
            $table->unsignedSmallInteger('tahun_mengabdi')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('abouts');
    }
};
