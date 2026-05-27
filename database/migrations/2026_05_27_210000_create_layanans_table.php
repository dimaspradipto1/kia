<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('layanans', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('ikon')->default('fa-star')->comment('Class ikon Font Awesome, contoh: fa-female');
            $table->string('tema')->default('pink')->comment('Tema warna: pink, green, blue, yellow, purple, orange');
            $table->text('deskripsi')->nullable();
            $table->text('deskripsi_panjang')->nullable()->comment('Deskripsi panjang untuk halaman layanan');
            $table->integer('urutan')->default(0)->comment('Urutan tampil di halaman');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('layanans');
    }
};
