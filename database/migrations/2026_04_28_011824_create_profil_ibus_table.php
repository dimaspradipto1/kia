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
        Schema::create('profil_ibus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('fasilitas_kesehatan_id')->constrained()->cascadeOnDelete();
            $table->string('nik');
            $table->string('nama_lengkap');
            $table->string('nama_ibu_kandung')->nullable();
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->string('jenis_fasilitas_kesehatan')->nullable();
            $table->string('golongan_darah')->nullable();
            $table->string('pendidikan')->nullable();
            $table->string('pekerjaan')->nullable();
            $table->string('agama')->nullable();
            $table->text('alamat')->nullable();
            $table->string('nomor_wa')->nullable();
            $table->string('nomor_jkn')->nullable();
            $table->string('nama_puskesmas')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profil_ibus');
    }
};
