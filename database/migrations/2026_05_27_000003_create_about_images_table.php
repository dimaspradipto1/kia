<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('about_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('about_id')->constrained('abouts')->cascadeOnDelete();
            $table->string('path')->comment('Relative path di storage public, e.g. abouts/xxx.jpg');
            $table->string('keterangan')->nullable()->comment('Alt text / caption gambar');
            $table->boolean('is_default')->default(false)->comment('Gambar utama yang ditampilkan');
            $table->unsignedSmallInteger('urutan')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('about_images');
    }
};
