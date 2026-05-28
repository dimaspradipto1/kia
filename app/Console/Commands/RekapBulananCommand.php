<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\FasilitasKesehatan;
use App\Models\RekapCakupanKia;
use App\Models\RekapImunisasi;
use App\Models\RekapGiziBalita;
use App\Models\RekapTtd;
use App\Models\IndikatorKematian;
use Carbon\Carbon;

class RekapBulananCommand extends Command
{
    protected $signature = 'rekap:bulanan {--tahun= : Tahun rekap} {--bulan= : Bulan rekap}';
    protected $description = 'Generate rekap bulanan otomatis data KIA ke tabel rekap untuk dilaporkan ke Dinkes';

    public function handle(): int
    {
        $prev = Carbon::now()->subMonth();
        $tahun = (int) ($this->option('tahun') ?? $prev->year);
        $bulan = (int) ($this->option('bulan') ?? $prev->month);

        $this->info("Memproses rekap bulan {$bulan}/{$tahun}...");

        $faskesList = FasilitasKesehatan::all();
        $bar = $this->output->createProgressBar($faskesList->count());
        $bar->start();

        foreach ($faskesList as $faskes) {
            $fid = $faskes->id;
            $wid = $faskes->wilayah_id ?? \App\Models\WilayaDinkes::first()?->id ?? 1;

            // 1. Rekap Cakupan KIA
            RekapCakupanKia::updateOrCreate(
                ['faskes_id' => $fid, 'wilayah_id' => $wid, 'tahun' => $tahun, 'bulan' => $bulan],
                [
                    'k1_total' => \App\Models\KunjunganAnc::where('fasilitas_kesehatan_id', $fid)->whereYear('tanggal_kunjungan', $tahun)->whereMonth('tanggal_kunjungan', $bulan)->where('kunjungan_ke', 1)->count(),
                    'k4_total' => \App\Models\KunjunganAnc::where('fasilitas_kesehatan_id', $fid)->whereYear('tanggal_kunjungan', $tahun)->whereMonth('tanggal_kunjungan', $bulan)->where('kunjungan_ke', 4)->count(),
                    'k6_total' => \App\Models\KunjunganAnc::where('fasilitas_kesehatan_id', $fid)->whereYear('tanggal_kunjungan', $tahun)->whereMonth('tanggal_kunjungan', $bulan)->where('kunjungan_ke', 6)->count(),
                    'persalinan_faskes'     => \App\Models\Persalinan::where('fasilitas_kesehatan_id', $fid)->whereYear('tanggal_lahir', $tahun)->whereMonth('tanggal_lahir', $bulan)->whereNotIn('jenis_persalinan', ['Dukun', 'Rumah', 'Non-Faskes'])->count(),
                    'persalinan_non_faskes' => \App\Models\Persalinan::where('fasilitas_kesehatan_id', $fid)->whereYear('tanggal_lahir', $tahun)->whereMonth('tanggal_lahir', $bulan)->whereIn('jenis_persalinan', ['Dukun', 'Rumah', 'Non-Faskes'])->count(),
                    'nifas_kf1' => \App\Models\PemantauanNifas::whereHas('bukuKia', fn($q) => $q->where('fasilitas_kesehatan_id', $fid))->whereYear('tanggal', $tahun)->whereMonth('tanggal', $bulan)->where('hari_ke', 'like', '%KF 1%')->count(),
                    'nifas_kf2' => \App\Models\PemantauanNifas::whereHas('bukuKia', fn($q) => $q->where('fasilitas_kesehatan_id', $fid))->whereYear('tanggal', $tahun)->whereMonth('tanggal', $bulan)->where('hari_ke', 'like', '%KF 2%')->count(),
                    'nifas_kf3' => \App\Models\PemantauanNifas::whereHas('bukuKia', fn($q) => $q->where('fasilitas_kesehatan_id', $fid))->whereYear('tanggal', $tahun)->whereMonth('tanggal', $bulan)->where('hari_ke', 'like', '%KF 3%')->count(),
                    'kb_pasca_salin' => \App\Models\KbPascaSalin::where('fasilitas_kesehatan_id', $fid)->whereYear('tanggal_mulai', $tahun)->whereMonth('tanggal_mulai', $bulan)->count(),
                ]
            );

            // 2. Rekap Imunisasi
            foreach (['BCG', 'Polio 1', 'DPT-HB-Hib 1', 'Campak-Rubela'] as $jenis) {
                $jumlah = \App\Models\ImunisasiAnak::where('fasilitas_kesehatan_id', $fid)->where('jenis_imunisasi', $jenis)->whereYear('tanggal_pemberian', $tahun)->whereMonth('tanggal_pemberian', $bulan)->count();
                RekapImunisasi::updateOrCreate(
                    ['faskes_id' => $fid, 'wilayah_id' => $wid, 'tahun' => $tahun, 'bulan' => $bulan, 'jenis_imunisasi' => $jenis],
                    ['jumlah_diberikan' => $jumlah, 'target_sasaran' => 50, 'persentase_cakupan' => $jumlah > 0 ? round(($jumlah / 50) * 100, 2) : 0]
                );
            }

            // 3. Rekap Gizi Balita
            $gb = fn() => \App\Models\TumbuhKembang::where('fasilitas_kesehatan_id', $fid)->whereYear('tanggal_ukur', $tahun)->whereMonth('tanggal_ukur', $bulan);
            RekapGiziBalita::updateOrCreate(
                ['faskes_id' => $fid, 'wilayah_id' => $wid, 'tahun' => $tahun, 'bulan' => $bulan],
                [
                    'total_balita_ditimbang' => $gb()->count(),
                    'gizi_baik'   => $gb()->where('status_gizi_bb_u', 'gizi baik')->count(),
                    'gizi_kurang' => $gb()->where('status_gizi_bb_u', 'gizi kurang')->count(),
                    'gizi_buruk'  => $gb()->where('status_gizi_bb_u', 'gizi buruk')->count(),
                    'stunting'    => $gb()->where('status_stunting', 'stunting')->count(),
                    'wasting'     => $gb()->where('status_gizi_bb_tb', 'wasting')->count(),
                    'overweight'  => $gb()->where('status_gizi_bb_u', 'overweight')->count(),
                ]
            );

            // 4. Rekap TTD
            $ttd = fn() => \App\Models\PencatatanTtd::whereHas('bukuKia', fn($q) => $q->where('fasilitas_kesehatan_id', $fid))->whereYear('tanggal', $tahun)->whereMonth('tanggal', $bulan);
            $totalTtd = $ttd()->count();
            RekapTtd::updateOrCreate(
                ['faskes_id' => $fid, 'wilayah_id' => $wid, 'tahun' => $tahun, 'bulan' => $bulan],
                ['target_ibu_hamil' => max(50, $totalTtd), 'mendapat_ttd' => $totalTtd, 'patuh_konsumsi' => $ttd()->whereIn('diminum', ['Ya', '1', 'yes', 'Ya (Diminum)'])->count()]
            );

            // 5. Indikator Kematian
            $ps = fn() => \App\Models\Persalinan::where('fasilitas_kesehatan_id', $fid)->whereYear('tanggal_lahir', $tahun)->whereMonth('tanggal_lahir', $bulan);
            IndikatorKematian::updateOrCreate(
                ['faskes_id' => $fid, 'wilayah_id' => $wid, 'tahun' => $tahun, 'bulan' => $bulan],
                [
                    'kematian_ibu'    => $ps()->where('kondisi_ibu', 'Meninggal Dunia')->count(),
                    'kematian_bayi'   => $ps()->whereIn('kondisi_bayi', ['Meninggal Dunia (IUFD)', 'Meninggal'])->count(),
                    'kematian_balita' => 0,
                    'penyebab_utama'  => 'Rekap Otomatis',
                ]
            );

            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info("✅ Rekap bulan {$bulan}/{$tahun} selesai — {$faskesList->count()} faskes diproses.");

        return Command::SUCCESS;
    }
}
