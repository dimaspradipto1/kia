<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FasilitasKesehatan;
use App\Models\RekapCakupanKia;
use App\Models\RekapImunisasi;
use App\Models\RekapGiziBalita;
use App\Models\RekapTtd;
use App\Models\IndikatorKematian;
use App\Exports\LaporanKiaExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    /**
     * Helper to dynamically calculate and update the rekap tables based on murni real transactional data
     */
    private function recalculateRealData($tahun, $bulan)
    {
        $faskesList = FasilitasKesehatan::all();

        foreach ($faskesList as $faskes) {
            $faskesId = $faskes->id;
            $wilayahId = $faskes->wilayah_id;
            if (!$wilayahId) {
                $wilayah = \App\Models\WilayaDinkes::first();
                $wilayahId = $wilayah ? $wilayah->id : 1;
            }

            // 1. Rekap Cakupan KIA
            $k1 = \App\Models\KunjunganAnc::where('fasilitas_kesehatan_id', $faskesId)
                ->whereYear('tanggal_kunjungan', $tahun)
                ->whereMonth('tanggal_kunjungan', $bulan)
                ->where('kunjungan_ke', 1)
                ->count();

            $k4 = \App\Models\KunjunganAnc::where('fasilitas_kesehatan_id', $faskesId)
                ->whereYear('tanggal_kunjungan', $tahun)
                ->whereMonth('tanggal_kunjungan', $bulan)
                ->where('kunjungan_ke', 4)
                ->count();

            $k6 = \App\Models\KunjunganAnc::where('fasilitas_kesehatan_id', $faskesId)
                ->whereYear('tanggal_kunjungan', $tahun)
                ->whereMonth('tanggal_kunjungan', $bulan)
                ->where('kunjungan_ke', 6)
                ->count();

            $persalinanFaskes = \App\Models\Persalinan::where('fasilitas_kesehatan_id', $faskesId)
                ->whereYear('tanggal_lahir', $tahun)
                ->whereMonth('tanggal_lahir', $bulan)
                ->whereNotIn('jenis_persalinan', ['Dukun', 'Rumah', 'Non-Faskes'])
                ->count();

            $persalinanNonFaskes = \App\Models\Persalinan::where('fasilitas_kesehatan_id', $faskesId)
                ->whereYear('tanggal_lahir', $tahun)
                ->whereMonth('tanggal_lahir', $bulan)
                ->whereIn('jenis_persalinan', ['Dukun', 'Rumah', 'Non-Faskes'])
                ->count();

            $nifasKF1 = \App\Models\PemantauanNifas::whereHas('bukuKia', function($q) use ($faskesId) {
                    $q->where('fasilitas_kesehatan_id', $faskesId);
                })
                ->whereYear('tanggal', $tahun)
                ->whereMonth('tanggal', $bulan)
                ->where('hari_ke', 'like', '%KF 1%')
                ->count();

            $nifasKF2 = \App\Models\PemantauanNifas::whereHas('bukuKia', function($q) use ($faskesId) {
                    $q->where('fasilitas_kesehatan_id', $faskesId);
                })
                ->whereYear('tanggal', $tahun)
                ->whereMonth('tanggal', $bulan)
                ->where('hari_ke', 'like', '%KF 2%')
                ->count();

            $nifasKF3 = \App\Models\PemantauanNifas::whereHas('bukuKia', function($q) use ($faskesId) {
                    $q->where('fasilitas_kesehatan_id', $faskesId);
                })
                ->whereYear('tanggal', $tahun)
                ->whereMonth('tanggal', $bulan)
                ->where('hari_ke', 'like', '%KF 3%')
                ->count();

            $kbPascaSalin = \App\Models\KbPascaSalin::where('fasilitas_kesehatan_id', $faskesId)
                ->whereYear('tanggal_mulai', $tahun)
                ->whereMonth('tanggal_mulai', $bulan)
                ->count();

            RekapCakupanKia::updateOrCreate(
                [
                    'faskes_id' => $faskesId,
                    'wilayah_id' => $wilayahId,
                    'tahun' => $tahun,
                    'bulan' => $bulan
                ],
                [
                    'k1_total' => $k1,
                    'k4_total' => $k4,
                    'k6_total' => $k6,
                    'persalinan_faskes' => $persalinanFaskes,
                    'persalinan_non_faskes' => $persalinanNonFaskes,
                    'nifas_kf1' => $nifasKF1,
                    'nifas_kf2' => $nifasKF2,
                    'nifas_kf3' => $nifasKF3,
                    'kb_pasca_salin' => $kbPascaSalin,
                ]
            );

            // 2. Rekap Imunisasi
            $imunisasiList = ['BCG', 'Polio 1', 'DPT-HB-Hib 1', 'Campak-Rubela'];
            foreach ($imunisasiList as $jenis) {
                $jumlahDiberikan = \App\Models\ImunisasiAnak::where('fasilitas_kesehatan_id', $faskesId)
                    ->where('jenis_imunisasi', $jenis)
                    ->whereYear('tanggal_pemberian', $tahun)
                    ->whereMonth('tanggal_pemberian', $bulan)
                    ->count();

                $target = 50;
                $persentase = $target > 0 ? ($jumlahDiberikan / $target) * 100 : 0;

                RekapImunisasi::updateOrCreate(
                    [
                        'faskes_id' => $faskesId,
                        'wilayah_id' => $wilayahId,
                        'tahun' => $tahun,
                        'bulan' => $bulan,
                        'jenis_imunisasi' => $jenis
                    ],
                    [
                        'jumlah_diberikan' => $jumlahDiberikan,
                        'target_sasaran' => $target,
                        'persentase_cakupan' => $persentase
                    ]
                );
            }

            // 3. Rekap Gizi Balita
            $totalDitimbang = \App\Models\TumbuhKembang::where('fasilitas_kesehatan_id', $faskesId)
                ->whereYear('tanggal_ukur', $tahun)
                ->whereMonth('tanggal_ukur', $bulan)
                ->count();

            $giziBaik = \App\Models\TumbuhKembang::where('fasilitas_kesehatan_id', $faskesId)
                ->whereYear('tanggal_ukur', $tahun)
                ->whereMonth('tanggal_ukur', $bulan)
                ->where('status_gizi_bb_u', 'gizi baik')
                ->count();

            $giziKurang = \App\Models\TumbuhKembang::where('fasilitas_kesehatan_id', $faskesId)
                ->whereYear('tanggal_ukur', $tahun)
                ->whereMonth('tanggal_ukur', $bulan)
                ->where('status_gizi_bb_u', 'gizi kurang')
                ->count();

            $giziBuruk = \App\Models\TumbuhKembang::where('fasilitas_kesehatan_id', $faskesId)
                ->whereYear('tanggal_ukur', $tahun)
                ->whereMonth('tanggal_ukur', $bulan)
                ->where('status_gizi_bb_u', 'gizi buruk')
                ->count();

            $stunting = \App\Models\TumbuhKembang::where('fasilitas_kesehatan_id', $faskesId)
                ->whereYear('tanggal_ukur', $tahun)
                ->whereMonth('tanggal_ukur', $bulan)
                ->where('status_stunting', 'stunting')
                ->count();

            $wasting = \App\Models\TumbuhKembang::where('fasilitas_kesehatan_id', $faskesId)
                ->whereYear('tanggal_ukur', $tahun)
                ->whereMonth('tanggal_ukur', $bulan)
                ->where('status_gizi_bb_tb', 'wasting')
                ->count();

            $overweight = \App\Models\TumbuhKembang::where('fasilitas_kesehatan_id', $faskesId)
                ->whereYear('tanggal_ukur', $tahun)
                ->whereMonth('tanggal_ukur', $bulan)
                ->where('status_gizi_bb_u', 'overweight')
                ->count();

            RekapGiziBalita::updateOrCreate(
                [
                    'faskes_id' => $faskesId,
                    'wilayah_id' => $wilayahId,
                    'tahun' => $tahun,
                    'bulan' => $bulan
                ],
                [
                    'total_balita_ditimbang' => $totalDitimbang,
                    'gizi_baik' => $giziBaik,
                    'gizi_kurang' => $giziKurang,
                    'gizi_buruk' => $giziBuruk,
                    'stunting' => $stunting,
                    'wasting' => $wasting,
                    'overweight' => $overweight,
                ]
            );

            // 4. Rekap TTD
            $totalTTD = \App\Models\PencatatanTtd::whereHas('bukuKia', function ($q) use ($faskesId) {
                    $q->where('fasilitas_kesehatan_id', $faskesId);
                })
                ->whereYear('tanggal', $tahun)
                ->whereMonth('tanggal', $bulan)
                ->count();

            $patuh = \App\Models\PencatatanTtd::whereHas('bukuKia', function ($q) use ($faskesId) {
                    $q->where('fasilitas_kesehatan_id', $faskesId);
                })
                ->whereYear('tanggal', $tahun)
                ->whereMonth('tanggal', $bulan)
                ->whereIn('diminum', ['Ya', '1', 'yes', 'Ya (Diminum)'])
                ->count();

            $target = max(50, $totalTTD);

            RekapTtd::updateOrCreate(
                [
                    'faskes_id' => $faskesId,
                    'wilayah_id' => $wilayahId,
                    'tahun' => $tahun,
                    'bulan' => $bulan
                ],
                [
                    'target_ibu_hamil' => $target,
                    'mendapat_ttd' => $totalTTD,
                    'patuh_konsumsi' => $patuh
                ]
            );

            // 5. Indikator Kematian
            $kematianIbu = \App\Models\Persalinan::where('fasilitas_kesehatan_id', $faskesId)
                ->whereYear('tanggal_lahir', $tahun)
                ->whereMonth('tanggal_lahir', $bulan)
                ->where('kondisi_ibu', 'Meninggal')
                ->count();

            $kematianBayi = \App\Models\Persalinan::where('fasilitas_kesehatan_id', $faskesId)
                ->whereYear('tanggal_lahir', $tahun)
                ->whereMonth('tanggal_lahir', $bulan)
                ->where('kondisi_bayi', 'Meninggal')
                ->count();

            $kematianBalita = 0;

            IndikatorKematian::updateOrCreate(
                [
                    'faskes_id' => $faskesId,
                    'wilayah_id' => $wilayahId,
                    'tahun' => $tahun,
                    'bulan' => $bulan
                ],
                [
                    'kematian_ibu' => $kematianIbu,
                    'kematian_bayi' => $kematianBayi,
                    'kematian_balita' => $kematianBalita,
                    'penyebab_utama' => 'Belum teridentifikasi',
                ]
            );
        }
    }

    /**
     * Display statistical graphs for Maternal & Child Health indicators (Statistik KIA Wilayah)
     */
    public function statistik(Request $request)
    {
        $tahun = $request->input('tahun', 2026);
        $bulan = $request->input('bulan', 5);

        // Dynamically recalculate based on raw transactional data before querying
        $this->recalculateRealData($tahun, $bulan);

        // 1. Cakupan ANC: K1 vs K4 vs K6 from RekapCakupanKia
        $ancK1 = RekapCakupanKia::where('tahun', $tahun)->where('bulan', $bulan)->sum('k1_total');
        $ancK4 = RekapCakupanKia::where('tahun', $tahun)->where('bulan', $bulan)->sum('k4_total');
        $ancK6 = RekapCakupanKia::where('tahun', $tahun)->where('bulan', $bulan)->sum('k6_total');

        // 2. Cakupan Imunisasi: Grouped by Jenis Imunisasi from RekapImunisasi
        $imunisasiData = RekapImunisasi::select('jenis_imunisasi', DB::raw('SUM(jumlah_diberikan) as total'))
            ->where('tahun', $tahun)
            ->where('bulan', $bulan)
            ->groupBy('jenis_imunisasi')
            ->get();

        $imunisasiLabels = $imunisasiData->pluck('jenis_imunisasi')->toArray();
        $imunisasiValues = $imunisasiData->pluck('total')->toArray();

        if (empty($imunisasiLabels)) {
            $imunisasiLabels = ['BCG', 'Polio 1', 'DPT-HB-Hib 1', 'Campak-Rubela'];
            $imunisasiValues = [0, 0, 0, 0];
        }

        // 3. Status Gizi Anak from RekapGiziBalita
        $stuntingCount = RekapGiziBalita::where('tahun', $tahun)->where('bulan', $bulan)->sum('stunting');
        
        $totalBalita = RekapGiziBalita::where('tahun', $tahun)->where('bulan', $bulan)->sum('total_balita_ditimbang');
        $normalStuntingCount = max(0, $totalBalita - $stuntingCount);

        $giziBaik = RekapGiziBalita::where('tahun', $tahun)->where('bulan', $bulan)->sum('gizi_baik');
        $giziKurang = RekapGiziBalita::where('tahun', $tahun)->where('bulan', $bulan)->sum('gizi_kurang');
        $giziBuruk = RekapGiziBalita::where('tahun', $tahun)->where('bulan', $bulan)->sum('gizi_buruk');
        $overweight = RekapGiziBalita::where('tahun', $tahun)->where('bulan', $bulan)->sum('overweight');

        // 4. Kepatuhan Konsumsi TTD Ibu Hamil from RekapTtd
        $ttdTarget = RekapTtd::where('tahun', $tahun)->where('bulan', $bulan)->sum('target_ibu_hamil');
        $ttdPatuh = RekapTtd::where('tahun', $tahun)->where('bulan', $bulan)->sum('patuh_konsumsi');
        $ttdTidakPatuh = max(0, $ttdTarget - $ttdPatuh);

        // 5. Indikator Kematian
        $kematianIbu = IndikatorKematian::where('tahun', $tahun)->where('bulan', $bulan)->sum('kematian_ibu');
        $kematianBayi = IndikatorKematian::where('tahun', $tahun)->where('bulan', $bulan)->sum('kematian_bayi');
        $kematianBalita = IndikatorKematian::where('tahun', $tahun)->where('bulan', $bulan)->sum('kematian_balita');

        return view('pages.laporan.statistik', [
            'ancK1' => $ancK1,
            'ancK4' => $ancK4,
            'ancK6' => $ancK6,
            'imunisasiLabels' => $imunisasiLabels,
            'imunisasiValues' => $imunisasiValues,
            'stuntingCount' => $stuntingCount,
            'normalStuntingCount' => $normalStuntingCount,
            'giziBaik' => $giziBaik,
            'giziKurang' => $giziKurang,
            'giziBuruk' => $giziBuruk,
            'overweight' => $overweight,
            'ttdPatuh' => $ttdPatuh,
            'ttdTidakPatuh' => $ttdTidakPatuh,
            'kematianIbu' => $kematianIbu,
            'kematianBayi' => $kematianBayi,
            'kematianBalita' => $kematianBalita,
            'tahun' => $tahun,
            'bulan' => $bulan,
        ]);
    }

    /**
     * Display a comparative dashboard monitoring all registered healthcare facilities (Monitoring Faskes)
     */
    public function monitoringFaskes(Request $request)
    {
        $tahun = $request->input('tahun', 2026);
        $bulan = $request->input('bulan', 5);

        // Dynamically recalculate based on raw transactional data before querying
        $this->recalculateRealData($tahun, $bulan);

        // Fetch faskes list with aggregated monthly rekap logs
        $faskesList = FasilitasKesehatan::all();

        foreach ($faskesList as $faskes) {
            $faskes->cakupan = RekapCakupanKia::where('faskes_id', $faskes->id)
                ->where('tahun', $tahun)
                ->where('bulan', $bulan)
                ->first();

            $faskes->gizi = RekapGiziBalita::where('faskes_id', $faskes->id)
                ->where('tahun', $tahun)
                ->where('bulan', $bulan)
                ->first();

            $faskes->ttd = RekapTtd::where('faskes_id', $faskes->id)
                ->where('tahun', $tahun)
                ->where('bulan', $bulan)
                ->first();

            $faskes->kematian = IndikatorKematian::where('faskes_id', $faskes->id)
                ->where('tahun', $tahun)
                ->where('bulan', $bulan)
                ->first();
        }

        return view('pages.laporan.monitoring_faskes', [
            'faskesList' => $faskesList,
            'tahun' => $tahun,
            'bulan' => $bulan,
        ]);
    }

    /**
     * Export dynamic health records compiled into Excel Sheet using Laravel Excel
     */
    public function exportExcel(Request $request)
    {
        $tahun = $request->input('tahun', 2026);
        $bulan = $request->input('bulan', 5);

        // Dynamically recalculate based on raw transactional data before compiling Excel
        $this->recalculateRealData($tahun, $bulan);

        $filename = "Laporan_Monitoring_Faskes_{$tahun}_{$bulan}.xlsx";

        return Excel::download(new LaporanKiaExport($tahun, $bulan), $filename);
    }

    /**
     * Display the Buku KIA monitoring dashboard
     */
    public function monitoringBukuKia(Request $request)
    {
        $faskesId = $request->input('faskes_id');
        $status = $request->input('status');
        $search = $request->input('search');
        $tahun = $request->input('tahun', 2026);
        $bulan = $request->input('bulan', 5);

        $query = \App\Models\BukuKia::with(['profilIbu', 'fasilitasKesehatan', 'profilAnak', 'kunjunganAncs', 'pemantauanNifas'])
            ->whereYear('diterbitkan_pada', $tahun)
            ->whereMonth('diterbitkan_pada', $bulan);

        if ($faskesId) {
            $query->where('fasilitas_kesehatan_id', $faskesId);
        }

        if ($status && $status !== 'Semua') {
            $query->where('status', $status);
        }

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('no_reg_kohort_ibu', 'like', "%{$search}%")
                  ->orWhere('no_reg_kohort_bayi', 'like', "%{$search}%")
                  ->orWhere('no_reg_kohort_balita', 'like', "%{$search}%")
                  ->orWhereHas('profilIbu', function($qi) use ($search) {
                      $qi->where('nama_lengkap', 'like', "%{$search}%")
                         ->orWhere('nik', 'like', "%{$search}%");
                  });
            });
        }

        $bukuKiaList = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

        // Calculate quick total indicators
        $totalBuku = \App\Models\BukuKia::count();
        $totalAktif = \App\Models\BukuKia::where('status', 'Aktif')->count();
        $totalSelesai = \App\Models\BukuKia::where('status', 'Selesai')->count();
        $totalAnc = \App\Models\KunjunganAnc::count();

        $faskesList = FasilitasKesehatan::all();

        return view('pages.laporan.monitoring_buku_kia', [
            'bukuKiaList' => $bukuKiaList,
            'totalBuku' => $totalBuku,
            'totalAktif' => $totalAktif,
            'totalSelesai' => $totalSelesai,
            'totalAnc' => $totalAnc,
            'faskesList' => $faskesList,
            'faskesId' => $faskesId,
            'status' => $status,
            'search' => $search,
            'tahun' => $tahun,
            'bulan' => $bulan,
        ]);
    }

    /**
     * Display the Imunisasi Anak monitoring dashboard
     */
    public function monitoringImunisasi(Request $request)
    {
        $faskesId = $request->input('faskes_id');
        $search = $request->input('search');
        $tahun = $request->input('tahun', 2026);
        $bulan = $request->input('bulan', 5);

        // Dynamic synchronizer to make sure data is real and synchronized before querying
        $this->recalculateRealData($tahun, $bulan);

        $query = \App\Models\ImunisasiAnak::with(['profilAnak.bukuKia', 'fasilitasKesehatan', 'nakes'])
            ->whereYear('tanggal_pemberian', $tahun)
            ->whereMonth('tanggal_pemberian', $bulan);

        if ($faskesId) {
            $query->where('fasilitas_kesehatan_id', $faskesId);
        }

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('jenis_imunisasi', 'like', "%{$search}%")
                  ->orWhereHas('profilAnak', function($qp) use ($search) {
                      $qp->where('nama_lengkap', 'like', "%{$search}%")
                         ->orWhere('nik', 'like', "%{$search}%");
                  });
            });
        }

        $imunisasiList = $query->orderBy('tanggal_pemberian', 'desc')->paginate(10)->withQueryString();

        // Calculate quick KPI totals for the selected period
        $totalVaksin = \App\Models\ImunisasiAnak::whereYear('tanggal_pemberian', $tahun)->whereMonth('tanggal_pemberian', $bulan)->count();
        $totalBcg = \App\Models\ImunisasiAnak::whereYear('tanggal_pemberian', $tahun)->whereMonth('tanggal_pemberian', $bulan)->where('jenis_imunisasi', 'like', '%BCG%')->count();
        $totalDpt = \App\Models\ImunisasiAnak::whereYear('tanggal_pemberian', $tahun)->whereMonth('tanggal_pemberian', $bulan)->where('jenis_imunisasi', 'like', '%DPT%')->count();
        $totalPolio = \App\Models\ImunisasiAnak::whereYear('tanggal_pemberian', $tahun)->whereMonth('tanggal_pemberian', $bulan)->where('jenis_imunisasi', 'like', '%Polio%')->count();

        $faskesList = FasilitasKesehatan::all();

        return view('pages.laporan.monitoring_imunisasi', [
            'imunisasiList' => $imunisasiList,
            'totalVaksin' => $totalVaksin,
            'totalBcg' => $totalBcg,
            'totalDpt' => $totalDpt,
            'totalPolio' => $totalPolio,
            'faskesList' => $faskesList,
            'faskesId' => $faskesId,
            'search' => $search,
            'tahun' => $tahun,
            'bulan' => $bulan,
        ]);
    }

    /**
     * Display the Gizi Balita (Tumbuh Kembang) monitoring dashboard
     */
    public function monitoringGiziBalita(Request $request)
    {
        $faskesId = $request->input('faskes_id');
        $search = $request->input('search');
        $tahun = $request->input('tahun', 2026);
        $bulan = $request->input('bulan', 5);

        // Dynamic synchronizer to make sure data is real and synchronized before querying
        $this->recalculateRealData($tahun, $bulan);

        $query = \App\Models\TumbuhKembang::with(['profilAnak.bukuKia', 'fasilitasKesehatan', 'nakes'])
            ->whereYear('tanggal_ukur', $tahun)
            ->whereMonth('tanggal_ukur', $bulan);

        if ($faskesId) {
            $query->where('fasilitas_kesehatan_id', $faskesId);
        }

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->whereHas('profilAnak', function($qp) use ($search) {
                    $qp->where('nama_lengkap', 'like', "%{$search}%")
                       ->orWhere('nik', 'like', "%{$search}%");
                });
            });
        }

        $giziList = $query->orderBy('tanggal_ukur', 'desc')->paginate(10)->withQueryString();

        // Calculate quick KPI totals for the selected period
        $totalDitimbang = \App\Models\TumbuhKembang::whereYear('tanggal_ukur', $tahun)->whereMonth('tanggal_ukur', $bulan)->count();
        $totalGiziBaik = \App\Models\TumbuhKembang::whereYear('tanggal_ukur', $tahun)->whereMonth('tanggal_ukur', $bulan)->where('status_gizi_bb_u', 'gizi baik')->count();
        $totalGiziKurang = \App\Models\TumbuhKembang::whereYear('tanggal_ukur', $tahun)->whereMonth('tanggal_ukur', $bulan)->whereIn('status_gizi_bb_u', ['gizi kurang', 'gizi buruk'])->count();
        $totalStunting = \App\Models\TumbuhKembang::whereYear('tanggal_ukur', $tahun)->whereMonth('tanggal_ukur', $bulan)->where('status_stunting', 'stunting')->count();

        $faskesList = FasilitasKesehatan::all();

        return view('pages.laporan.monitoring_gizi_balita', [
            'giziList' => $giziList,
            'totalDitimbang' => $totalDitimbang,
            'totalGiziBaik' => $totalGiziBaik,
            'totalGiziKurang' => $totalGiziKurang,
            'totalStunting' => $totalStunting,
            'faskesList' => $faskesList,
            'faskesId' => $faskesId,
            'search' => $search,
            'tahun' => $tahun,
            'bulan' => $bulan,
        ]);
    }
}
