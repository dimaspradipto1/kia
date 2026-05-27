<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('teams', function (Blueprint $table) {
            // Hapus kolom twitter
            $table->dropColumn('twitter');

            // Tambah kolom sosial media baru setelah linkedin
            $table->string('tiktok')->nullable()->after('linkedin');
            $table->string('instagram')->nullable()->after('tiktok');
            $table->string('facebook')->nullable()->after('instagram');
        });
    }

    public function down(): void
    {
        Schema::table('teams', function (Blueprint $table) {
            $table->dropColumn(['tiktok', 'instagram', 'facebook']);
            $table->string('twitter')->nullable()->after('linkedin');
        });
    }
};
