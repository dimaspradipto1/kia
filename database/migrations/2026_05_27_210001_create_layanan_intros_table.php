<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('layanan_intros', function (Blueprint $table) {
            $table->id();
            $table->string('badge_text')->default('Tentang Layanan')->comment('Teks badge kecil di atas judul');
            $table->string('judul')->comment('Judul utama bagian intro, contoh: KIA Care adalah platform kesehatan ibu dan anak');
            $table->text('deskripsi')->nullable()->comment('Paragraf deskripsi di bawah judul');
            $table->json('fitur')->nullable()->comment('Array fitur unggulan [{judul, deskripsi}]');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('layanan_intros');
    }
};
