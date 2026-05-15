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
        Schema::create('fasilitas_kesehatans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_faskes');
            $table->string('jenis');
            $table->string('alamat');
            $table->string('kecamatan');
            $table->string('kab_kota');
            $table->string('provinsi');
            $table->string('latitude');
            $table->string('longitude');
            $table->string('telepon');
            $table->string('jam_operasional');
            $table->boolean('is_active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fasilitas_kesehatans');
    }
};
