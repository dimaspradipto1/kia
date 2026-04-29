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
        Schema::create('kb_pasca_salins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('buku_kia_id')->constrained()->cascadeOnDelete();
            $table->foreignId('nakes_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('fasilitas_kesehatan_id')->constrained()->cascadeOnDelete();
            $table->string('metode_kb');
            $table->date('tanggal_mulai');
            $table->text('catatan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kb_pasca_salins');
    }
};
