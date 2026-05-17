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
        Schema::create('wilaya_dinkes', function (Blueprint $table) {
            $table->id();
            $table->string('kode_dinkes')->unique();
            $table->text('nama_dinkes');
            $table->string('tipe_dinkes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wilaya_dinkes');
    }
};
