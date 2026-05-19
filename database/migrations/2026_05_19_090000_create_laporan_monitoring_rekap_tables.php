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
        // Alter fasilitas_kesehatans to add wilayah_id
        if (Schema::hasTable('fasilitas_kesehatans')) {
            Schema::table('fasilitas_kesehatans', function (Blueprint $table) {
                if (!Schema::hasColumn('fasilitas_kesehatans', 'wilayah_id')) {
                    $table->foreignId('wilayah_id')->nullable()->after('id')->constrained('wilaya_dinkes')->nullOnDelete();
                }
            });
        }

        // 1. Rekap Cakupan KIA
        Schema::create('rekap_cakupan_kias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('faskes_id')->constrained('fasilitas_kesehatans')->cascadeOnDelete();
            $table->foreignId('wilayah_id')->constrained('wilaya_dinkes')->cascadeOnDelete();
            $table->integer('tahun');
            $table->integer('bulan');
            $table->integer('k1_total')->default(0);
            $table->integer('k4_total')->default(0);
            $table->integer('k6_total')->default(0);
            $table->integer('persalinan_faskes')->default(0);
            $table->integer('persalinan_non_faskes')->default(0);
            $table->integer('nifas_kf1')->default(0);
            $table->integer('nifas_kf2')->default(0);
            $table->integer('nifas_kf3')->default(0);
            $table->integer('kb_pasca_salin')->default(0);
            $table->timestamps();
        });

        // 2. Rekap Imunisasi
        Schema::create('rekap_imunisasis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('faskes_id')->constrained('fasilitas_kesehatans')->cascadeOnDelete();
            $table->foreignId('wilayah_id')->constrained('wilaya_dinkes')->cascadeOnDelete();
            $table->integer('tahun');
            $table->integer('bulan');
            $table->string('jenis_imunisasi');
            $table->integer('jumlah_diberikan')->default(0);
            $table->integer('target_sasaran')->default(0);
            $table->decimal('persentase_cakupan', 5, 2)->default(0.00);
            $table->timestamps();
        });

        // 3. Rekap Gizi Balita
        Schema::create('rekap_gizi_balitas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('faskes_id')->constrained('fasilitas_kesehatans')->cascadeOnDelete();
            $table->foreignId('wilayah_id')->constrained('wilaya_dinkes')->cascadeOnDelete();
            $table->integer('tahun');
            $table->integer('bulan');
            $table->integer('total_balita_ditimbang')->default(0);
            $table->integer('gizi_baik')->default(0);
            $table->integer('gizi_kurang')->default(0);
            $table->integer('gizi_buruk')->default(0);
            $table->integer('stunting')->default(0);
            $table->integer('wasting')->default(0);
            $table->integer('overweight')->default(0);
            $table->timestamps();
        });

        // 4. Rekap TTD
        Schema::create('rekap_ttds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('faskes_id')->constrained('fasilitas_kesehatans')->cascadeOnDelete();
            $table->foreignId('wilayah_id')->constrained('wilaya_dinkes')->cascadeOnDelete();
            $table->integer('tahun');
            $table->integer('bulan');
            $table->integer('target_ibu_hamil')->default(0);
            $table->integer('mendapat_ttd')->default(0);
            $table->integer('patuh_konsumsi')->default(0);
            $table->timestamps();
        });

        // 5. Indikator Kematian
        Schema::create('indikator_kematians', function (Blueprint $table) {
            $table->id();
            $table->foreignId('faskes_id')->constrained('fasilitas_kesehatans')->cascadeOnDelete();
            $table->foreignId('wilayah_id')->constrained('wilaya_dinkes')->cascadeOnDelete();
            $table->integer('tahun');
            $table->integer('bulan');
            $table->integer('kematian_ibu')->default(0);
            $table->integer('kematian_bayi')->default(0);
            $table->integer('kematian_balita')->default(0);
            $table->string('penyebab_utama')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('indikator_kematians');
        Schema::dropIfExists('rekap_ttds');
        Schema::dropIfExists('rekap_gizi_balitas');
        Schema::dropIfExists('rekap_imunisasis');
        Schema::dropIfExists('rekap_cakupan_kias');

        if (Schema::hasTable('fasilitas_kesehatans')) {
            Schema::table('fasilitas_kesehatans', function (Blueprint $table) {
                if (Schema::hasColumn('fasilitas_kesehatans', 'wilayah_id')) {
                    $table->dropForeign(['wilayah_id']);
                    $table->dropColumn('wilayah_id');
                }
            });
        }
    }
};
