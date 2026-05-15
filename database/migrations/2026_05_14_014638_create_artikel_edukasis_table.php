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
        Schema::create('artikel_edukasis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kategori_artikel_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('judul');
            $table->text('content')->nullable();
            $table->enum('status', ['draft', 'published'])->default('draft');
            $table->string('slug');
            $table->text('isi');
            $table->string('gambar')->nullable();
            $table->string('penulis');
            $table->date('diterbitkan_pada')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('artikel_edukasis');
    }
};
