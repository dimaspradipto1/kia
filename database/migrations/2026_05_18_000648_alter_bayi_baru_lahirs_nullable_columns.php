<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Make persalinan_id, hb0_waktu, shk_waktu, shk_hasil, pjb_hasil nullable
     * since they are optional in the newborn recording workflow.
     */
    public function up(): void
    {
        Schema::table('bayi_baru_lahirs', function (Blueprint $table) {
            $table->foreignId('persalinan_id')->nullable()->change();
            $table->time('hb0_waktu')->nullable()->change();
            $table->time('shk_waktu')->nullable()->change();
            $table->string('shk_hasil')->nullable()->change();
            $table->string('pjb_hasil')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bayi_baru_lahirs', function (Blueprint $table) {
            $table->foreignId('persalinan_id')->nullable(false)->change();
            $table->time('hb0_waktu')->nullable(false)->change();
            $table->time('shk_waktu')->nullable(false)->change();
            $table->string('shk_hasil')->nullable(false)->change();
            $table->string('pjb_hasil')->nullable(false)->change();
        });
    }
};
