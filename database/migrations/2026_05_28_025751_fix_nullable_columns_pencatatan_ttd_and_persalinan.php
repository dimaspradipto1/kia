<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pencatatan_ttds', function (Blueprint $table) {
            $table->text('catatan')->nullable()->change();
        });

        Schema::table('persalinans', function (Blueprint $table) {
            $table->string('komplikasi')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('pencatatan_ttds', function (Blueprint $table) {
            $table->text('catatan')->nullable(false)->change();
        });

        Schema::table('persalinans', function (Blueprint $table) {
            $table->string('komplikasi')->nullable(false)->change();
        });
    }
};
