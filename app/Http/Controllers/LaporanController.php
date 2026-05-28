<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FasilitasKesehatan;
use App\Models\RekapCakupanKia;
use App\Models\RekapImunisasi;
use App\Models\RekapGiziBalita;
use App\Models\RekapTtd;
use App\Models\IndikatorKematian;
use App\Models\KbPascaSalin;
use App\Exports\LaporanKiaExport;
use App\Exports\SigaExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    private function recalculateRealData(int $tahun, int $bulan): void
    {
        $faskesList = FasilitasKesehatan::all();

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
                    'kb_pasca_salin' => KbPascaSalin::where('fasilitas_kesehatan_id', $fid)->whereYear('tanggal_mulai', $tahun)->whereMonth('tanggal_mulai', $bulan)->count(),
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
                    'penyebab_utama'  => 'Belum teridentifikasi',
                ]
            );
        }
    }

    public function statistik(Request $request)
    {
        $tahun = $request->input('tahun', now()->year);
        $bulan = $request->input('bulan', now()->month);

        $this->recalculateRealData($tahun, $bulan);

        $ancK1 = RekapCakupanKia::where('tahun', $tahun)->where('bulan', $bulan)->sum('k1_total');
        $ancK4 = RekapCakupanKia::where('tahun', $tahun)->where('bulan', $bulan)->sum('k4_total');
        $ancK6 = RekapCakupanKia::where('tahun', $tahun)->where('bulan', $bulan)->sum('k6_total');

        $persalinanFaskes    = RekapCakupanKia::where('tahun', $tahun)->where('bulan', $bulan)->sum('persalinan_faskes');
        $persalinanNonFaskes = RekapCakupanKia::where('tahun', $tahun)->where('bulan', $bulan)->sum('persalinan_non_faskes');

        $imunisasiData = RekapImunisasi::select('jenis_imunisasi', DB::raw('SUM(jumlah_diberikan) as total'))
            ->where('tahun', $tahun)->where('bulan', $bulan)->groupBy('jenis_imunisasi')->get();
        $imunisasiLabels = $imunisasiData->pluck('jenis_imunisasi')->toArray() ?: ['BCG', 'Polio 1', 'DPT-HB-Hib 1', 'Campak-Rubela'];
        $imunisasiValues = $imunisasiData->pluck('total')->toArray() ?: [0, 0, 0, 0];

        $stuntingCount      = RekapGiziBalita::where('tahun', $tahun)->where('bulan', $bulan)->sum('stunting');
        $totalBalita        = RekapGiziBalita::where('tahun', $tahun)->where('bulan', $bulan)->sum('total_balita_ditimbang');
        $normalStuntingCount = max(0, $totalBalita - $stuntingCount);
        $giziBaik   = RekapGiziBalita::where('tahun', $tahun)->where('bulan', $bulan)->sum('gizi_baik');
        $giziKurang = RekapGiziBalita::where('tahun', $tahun)->where('bulan', $bulan)->sum('gizi_kurang');
        $giziBuruk  = RekapGiziBalita::where('tahun', $tahun)->where('bulan', $bulan)->sum('gizi_buruk');
        $overweight = RekapGiziBalita::where('tahun', $tahun)->where('bulan', $bulan)->sum('overweight');

        $ttdTarget     = RekapTtd::where('tahun', $tahun)->where('bulan', $bulan)->sum('target_ibu_hamil');
        $ttdPatuh      = RekapTtd::where('tahun', $tahun)->where('bulan', $bulan)->sum('patuh_konsumsi');
        $ttdTidakPatuh = max(0, $ttdTarget - $ttdPatuh);

        $kematianIbu    = IndikatorKematian::where('tahun', $tahun)->where('bulan', $bulan)->sum('kematian_ibu');
        $kematianBayi   = IndikatorKematian::where('tahun', $tahun)->where('bulan', $bulan)->sum('kematian_bayi');
        $kematianBalita = IndikatorKematian::where('tahun', $tahun)->where('bulan', $bulan)->sum('kematian_balita');

        // KB Pasca Salin per metode
        $kbData = KbPascaSalin::select('metode_kb', DB::raw('COUNT(*) as total'))
            ->whereYear('tanggal_mulai', $tahun)->whereMonth('tanggal_mulai', $bulan)
            ->groupBy('metode_kb')->orderByDesc('total')->get();
        $kbLabels = $kbData->pluck('metode_kb')->toArray() ?: ['Belum ada data'];
        $kbValues = $kbData->pluck('total')->toArray() ?: [0];

        return view('pages.laporan.statistik', compact(
            'ancK1', 'ancK4', 'ancK6',
            'persalinanFaskes', 'persalinanNonFaskes',
            'imunisasiLabels', 'imunisasiValues',
            'stuntingCount', 'normalStuntingCount',
            'giziBaik', 'giziKurang', 'giziBuruk', 'overweight',
            'ttdPatuh', 'ttdTidakPatuh',
            'kematianIbu', 'kematianBayi', 'kematianBalita',
            'kbLabels', 'kbValues',
            'tahun', 'bulan'
        ));
    }

    public function monitoringFaskes(Request $request)
    {
        $tahun = $request->input('tahun', now()->year);
        $bulan = $request->input('bulan', now()->month);

        $this->recalculateRealData($tahun, $bulan);

        $faskesList = FasilitasKesehatan::all();

        foreach ($faskesList as $faskes) {
            $faskes->cakupan  = RekapCakupanKia::where('faskes_id', $faskes->id)->where('tahun', $tahun)->where('bulan', $bulan)->first();
            $faskes->gizi     = RekapGiziBalita::where('faskes_id', $faskes->id)->where('tahun', $tahun)->where('bulan', $bulan)->first();
            $faskes->ttd      = RekapTtd::where('faskes_id', $faskes->id)->where('tahun', $tahun)->where('bulan', $bulan)->first();
            $faskes->kematian = IndikatorKematian::where('faskes_id', $faskes->id)->where('tahun', $tahun)->where('bulan', $bulan)->first();
        }

        return view('pages.laporan.monitoring_faskes', compact('faskesList', 'tahun', 'bulan'));
    }

    public function monitoringKbPascaSalin(Request $request)
    {
        $tahun    = $request->input('tahun', now()->year);
        $bulan    = $request->input('bulan', now()->month);
        $faskesId = $request->input('faskes_id');

        $query = KbPascaSalin::with(['bukuKia.profilIbu', 'fasilitasKesehatan', 'nakes'])
            ->whereYear('tanggal_mulai', $tahun)
            ->whereMonth('tanggal_mulai', $bulan);

        if ($faskesId) {
            $query->where('fasilitas_kesehatan_id', $faskesId);
        }

        $kbList = $query->orderBy('tanggal_mulai', 'desc')->paginate(15)->withQueryString();

        $perMetode = KbPascaSalin::select('metode_kb', DB::raw('COUNT(*) as total'))
            ->whereYear('tanggal_mulai', $tahun)
            ->whereMonth('tanggal_mulai', $bulan)
            ->when($faskesId, fn($q) => $q->where('fasilitas_kesehatan_id', $faskesId))
            ->groupBy('metode_kb')->orderByDesc('total')->get();

        $totalKb   = $perMetode->sum('total');
        $faskesList = FasilitasKesehatan::all();

        return view('pages.laporan.kb_pasca_salin', compact(
            'kbList', 'perMetode', 'totalKb', 'faskesList', 'tahun', 'bulan', 'faskesId'
        ));
    }

    public function petaSebaran(Request $request)
    {
        $tahun = $request->input('tahun', now()->year);
        $bulan = $request->input('bulan', now()->month);

        $this->recalculateRealData($tahun, $bulan);

        $faskesList = FasilitasKesehatan::all()->map(function ($faskes) use ($tahun, $bulan) {
            $faskes->kematian = IndikatorKematian::where('faskes_id', $faskes->id)->where('tahun', $tahun)->where('bulan', $bulan)->first();
            $faskes->gizi     = RekapGiziBalita::where('faskes_id', $faskes->id)->where('tahun', $tahun)->where('bulan', $bulan)->first();
            $faskes->cakupan  = RekapCakupanKia::where('faskes_id', $faskes->id)->where('tahun', $tahun)->where('bulan', $bulan)->first();

            // Hitung level risiko
            $risikoScore = 0;
            if ($faskes->kematian) {
                $risikoScore += ($faskes->kematian->kematian_ibu * 3) + ($faskes->kematian->kematian_bayi * 2);
            }
            if ($faskes->gizi) {
                $risikoScore += $faskes->gizi->stunting + $faskes->gizi->gizi_buruk;
            }
            $faskes->risiko_score = $risikoScore;
            $faskes->risiko_level = $risikoScore >= 5 ? 'tinggi' : ($risikoScore >= 2 ? 'sedang' : 'rendah');

            return $faskes;
        });

        return view('pages.laporan.peta_sebaran', compact('faskesList', 'tahun', 'bulan'));
    }

    public function exportExcel(Request $request)
    {
        $tahun = $request->input('tahun', now()->year);
        $bulan = $request->input('bulan', now()->month);

        $this->recalculateRealData($tahun, $bulan);

        return Excel::download(new LaporanKiaExport($tahun, $bulan), "Laporan_KIA_{$tahun}_{$bulan}.xlsx");
    }

    public function exportPdf(Request $request)
    {
        $tahun = $request->input('tahun', now()->year);
        $bulan = $request->input('bulan', now()->month);

        $this->recalculateRealData($tahun, $bulan);

        $bulanIndo = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

        $data = [
            'tahun'  => $tahun,
            'bulan'  => $bulan,
            'bulanNama' => $bulanIndo[$bulan],
            'ancK1'  => RekapCakupanKia::where('tahun', $tahun)->where('bulan', $bulan)->sum('k1_total'),
            'ancK4'  => RekapCakupanKia::where('tahun', $tahun)->where('bulan', $bulan)->sum('k4_total'),
            'ancK6'  => RekapCakupanKia::where('tahun', $tahun)->where('bulan', $bulan)->sum('k6_total'),
            'persalinanFaskes'    => RekapCakupanKia::where('tahun', $tahun)->where('bulan', $bulan)->sum('persalinan_faskes'),
            'persalinanNonFaskes' => RekapCakupanKia::where('tahun', $tahun)->where('bulan', $bulan)->sum('persalinan_non_faskes'),
            'kbPascaSalin'        => RekapCakupanKia::where('tahun', $tahun)->where('bulan', $bulan)->sum('kb_pasca_salin'),
            'kbPerMetode'         => KbPascaSalin::select('metode_kb', DB::raw('COUNT(*) as total'))->whereYear('tanggal_mulai', $tahun)->whereMonth('tanggal_mulai', $bulan)->groupBy('metode_kb')->get(),
            'ttdTarget'   => RekapTtd::where('tahun', $tahun)->where('bulan', $bulan)->sum('target_ibu_hamil'),
            'ttdPatuh'    => RekapTtd::where('tahun', $tahun)->where('bulan', $bulan)->sum('patuh_konsumsi'),
            'stunting'    => RekapGiziBalita::where('tahun', $tahun)->where('bulan', $bulan)->sum('stunting'),
            'giziBuruk'   => RekapGiziBalita::where('tahun', $tahun)->where('bulan', $bulan)->sum('gizi_buruk'),
            'totalBalita' => RekapGiziBalita::where('tahun', $tahun)->where('bulan', $bulan)->sum('total_balita_ditimbang'),
            'kematianIbu'    => IndikatorKematian::where('tahun', $tahun)->where('bulan', $bulan)->sum('kematian_ibu'),
            'kematianBayi'   => IndikatorKematian::where('tahun', $tahun)->where('bulan', $bulan)->sum('kematian_bayi'),
            'kematianBalita' => IndikatorKematian::where('tahun', $tahun)->where('bulan', $bulan)->sum('kematian_balita'),
            'imunisasi'   => RekapImunisasi::select('jenis_imunisasi', DB::raw('SUM(jumlah_diberikan) as total'))->where('tahun', $tahun)->where('bulan', $bulan)->groupBy('jenis_imunisasi')->get(),
            'faskesList'  => FasilitasKesehatan::all()->map(function ($f) use ($tahun, $bulan) {
                $f->cakupan  = RekapCakupanKia::where('faskes_id', $f->id)->where('tahun', $tahun)->where('bulan', $bulan)->first();
                $f->kematian = IndikatorKematian::where('faskes_id', $f->id)->where('tahun', $tahun)->where('bulan', $bulan)->first();
                return $f;
            }),
        ];

        $pdf = Pdf::loadView('exports.laporan_pdf', $data)
            ->setPaper('a4', 'portrait')
            ->setOptions(['defaultFont' => 'sans-serif', 'isHtml5ParserEnabled' => true]);

        return $pdf->download("Laporan_KIA_{$tahun}_{$bulan}.pdf");
    }

    public function exportSiga(Request $request)
    {
        $tahun = $request->input('tahun', now()->year);
        $bulan = $request->input('bulan', now()->month);

        $this->recalculateRealData($tahun, $bulan);

        return Excel::download(new SigaExport($tahun, $bulan), "SIGA_KIA_{$tahun}_{$bulan}.xlsx");
    }

    public function monitoringBukuKia(Request $request)
    {
        $faskesId = $request->input('faskes_id');
        $status   = $request->input('status');
        $search   = $request->input('search');
        $tahun    = $request->input('tahun', now()->year);
        $bulan    = $request->input('bulan', now()->month);

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
            $query->where(function ($q) use ($search) {
                $q->where('no_reg_kohort_ibu', 'like', "%{$search}%")
                  ->orWhereHas('profilIbu', fn($qi) => $qi->where('nama_lengkap', 'like', "%{$search}%")->orWhere('nik', 'like', "%{$search}%"));
            });
        }

        $bukuKiaList  = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();
        $totalBuku    = \App\Models\BukuKia::count();
        $totalAktif   = \App\Models\BukuKia::where('status', 'Aktif')->count();
        $totalSelesai = \App\Models\BukuKia::where('status', 'Selesai')->count();
        $totalAnc     = \App\Models\KunjunganAnc::count();
        $faskesList   = FasilitasKesehatan::all();

        return view('pages.laporan.monitoring_buku_kia', compact(
            'bukuKiaList', 'totalBuku', 'totalAktif', 'totalSelesai', 'totalAnc',
            'faskesList', 'faskesId', 'status', 'search', 'tahun', 'bulan'
        ));
    }

    public function monitoringImunisasi(Request $request)
    {
        $faskesId = $request->input('faskes_id');
        $search   = $request->input('search');
        $tahun    = $request->input('tahun', now()->year);
        $bulan    = $request->input('bulan', now()->month);

        $this->recalculateRealData($tahun, $bulan);

        $query = \App\Models\ImunisasiAnak::with(['profilAnak.bukuKia', 'fasilitasKesehatan', 'nakes'])
            ->whereYear('tanggal_pemberian', $tahun)->whereMonth('tanggal_pemberian', $bulan);

        if ($faskesId) $query->where('fasilitas_kesehatan_id', $faskesId);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('jenis_imunisasi', 'like', "%{$search}%")
                  ->orWhereHas('profilAnak', fn($qp) => $qp->where('nama_lengkap', 'like', "%{$search}%"));
            });
        }

        $imunisasiList = $query->orderBy('tanggal_pemberian', 'desc')->paginate(10)->withQueryString();
        $base = \App\Models\ImunisasiAnak::whereYear('tanggal_pemberian', $tahun)->whereMonth('tanggal_pemberian', $bulan);
        $totalVaksin = (clone $base)->count();
        $totalBcg    = (clone $base)->where('jenis_imunisasi', 'like', '%BCG%')->count();
        $totalDpt    = (clone $base)->where('jenis_imunisasi', 'like', '%DPT%')->count();
        $totalPolio  = (clone $base)->where('jenis_imunisasi', 'like', '%Polio%')->count();
        $faskesList  = FasilitasKesehatan::all();

        return view('pages.laporan.monitoring_imunisasi', compact(
            'imunisasiList', 'totalVaksin', 'totalBcg', 'totalDpt', 'totalPolio',
            'faskesList', 'faskesId', 'search', 'tahun', 'bulan'
        ));
    }

    public function monitoringGiziBalita(Request $request)
    {
        $faskesId = $request->input('faskes_id');
        $search   = $request->input('search');
        $tahun    = $request->input('tahun', now()->year);
        $bulan    = $request->input('bulan', now()->month);

        $this->recalculateRealData($tahun, $bulan);

        $query = \App\Models\TumbuhKembang::with(['profilAnak.bukuKia', 'fasilitasKesehatan', 'nakes'])
            ->whereYear('tanggal_ukur', $tahun)->whereMonth('tanggal_ukur', $bulan);

        if ($faskesId) $query->where('fasilitas_kesehatan_id', $faskesId);

        if ($search) {
            $query->whereHas('profilAnak', fn($qp) => $qp->where('nama_lengkap', 'like', "%{$search}%"));
        }

        $giziList = $query->orderBy('tanggal_ukur', 'desc')->paginate(10)->withQueryString();
        $base = \App\Models\TumbuhKembang::whereYear('tanggal_ukur', $tahun)->whereMonth('tanggal_ukur', $bulan);
        $totalDitimbang  = (clone $base)->count();
        $totalGiziBaik   = (clone $base)->where('status_gizi_bb_u', 'gizi baik')->count();
        $totalGiziKurang = (clone $base)->whereIn('status_gizi_bb_u', ['gizi kurang', 'gizi buruk'])->count();
        $totalStunting   = (clone $base)->where('status_stunting', 'stunting')->count();
        $faskesList = FasilitasKesehatan::all();

        return view('pages.laporan.monitoring_gizi_balita', compact(
            'giziList', 'totalDitimbang', 'totalGiziBaik', 'totalGiziKurang', 'totalStunting',
            'faskesList', 'faskesId', 'search', 'tahun', 'bulan'
        ));
    }
}
