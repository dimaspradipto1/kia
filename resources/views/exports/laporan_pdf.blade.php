<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan KIA {{ $bulanNama }} {{ $tahun }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 11px; color: #1e293b; line-height: 1.5; }
        .page { padding: 30px; }

        /* Header */
        .header { text-align: center; border-bottom: 3px solid #1e40af; padding-bottom: 14px; margin-bottom: 20px; }
        .header h1 { font-size: 16px; font-weight: 700; color: #1e40af; text-transform: uppercase; letter-spacing: 1px; }
        .header h2 { font-size: 13px; font-weight: 600; color: #334155; margin-top: 3px; }
        .header p  { font-size: 10px; color: #64748b; margin-top: 2px; }

        /* Section */
        .section-title { background: #1e40af; color: white; padding: 6px 12px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px; border-radius: 4px; }

        /* KPI Cards */
        .kpi-grid { display: table; width: 100%; margin-bottom: 18px; border-collapse: separate; border-spacing: 6px; }
        .kpi-cell { display: table-cell; width: 25%; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 6px; padding: 10px; text-align: center; vertical-align: middle; }
        .kpi-num  { font-size: 22px; font-weight: 800; }
        .kpi-label{ font-size: 9px; color: #64748b; font-weight: 600; text-transform: uppercase; margin-top: 2px; }

        /* Tables */
        table { width: 100%; border-collapse: collapse; margin-bottom: 18px; font-size: 10px; }
        thead th { background: #1e40af; color: white; padding: 7px 8px; text-align: left; font-size: 9.5px; text-transform: uppercase; }
        tbody tr:nth-child(even) { background: #f8fafc; }
        tbody td { padding: 6px 8px; border-bottom: 1px solid #e2e8f0; }
        .text-center { text-align: center; }
        .text-right  { text-align: right; }

        /* Risk Badges */
        .badge-danger  { background: #fef2f2; color: #dc2626; padding: 2px 8px; border-radius: 10px; font-weight: 700; font-size: 9px; }
        .badge-warning { background: #fffbeb; color: #d97706; padding: 2px 8px; border-radius: 10px; font-weight: 700; font-size: 9px; }
        .badge-success { background: #f0fdf4; color: #16a34a; padding: 2px 8px; border-radius: 10px; font-weight: 700; font-size: 9px; }

        .page-break { page-break-after: always; }
        .footer { text-align: center; font-size: 9px; color: #94a3b8; margin-top: 20px; border-top: 1px solid #e2e8f0; padding-top: 10px; }
    </style>
</head>
<body>
<div class="page">

    {{-- Header --}}
    <div class="header">
        <h1>Laporan Kesehatan Ibu dan Anak (KIA)</h1>
        <h2>Periode: {{ $bulanNama }} {{ $tahun }}</h2>
        <p>Dicetak pada: {{ now()->translatedFormat('d F Y, H:i') }} WIB &nbsp;|&nbsp; Sistem Informasi KIA</p>
    </div>

    {{-- 1. Ringkasan Indikator Kematian --}}
    <div class="section-title">⚠ Indikator Kematian Ibu & Anak (AKI/AKB)</div>
    <div class="kpi-grid">
        <div class="kpi-cell">
            <div class="kpi-num" style="color:#dc2626;">{{ $kematianIbu }}</div>
            <div class="kpi-label">Kematian Ibu (AKI)</div>
        </div>
        <div class="kpi-cell">
            <div class="kpi-num" style="color:#ea580c;">{{ $kematianBayi }}</div>
            <div class="kpi-label">Kematian Bayi (AKB)</div>
        </div>
        <div class="kpi-cell">
            <div class="kpi-num" style="color:#0284c7;">{{ $kematianBalita }}</div>
            <div class="kpi-label">Kematian Balita</div>
        </div>
        <div class="kpi-cell">
            <div class="kpi-num" style="color:#7c3aed;">{{ $kematianIbu + $kematianBayi + $kematianBalita }}</div>
            <div class="kpi-label">Total Kematian</div>
        </div>
    </div>

    {{-- 2. Cakupan KIA --}}
    <div class="section-title">📋 Cakupan Kunjungan ANC & Persalinan</div>
    <div class="kpi-grid">
        <div class="kpi-cell">
            <div class="kpi-num" style="color:#1d4ed8;">{{ $ancK1 }}</div>
            <div class="kpi-label">Kunjungan K1</div>
        </div>
        <div class="kpi-cell">
            <div class="kpi-num" style="color:#047857;">{{ $ancK4 }}</div>
            <div class="kpi-label">Kunjungan K4</div>
        </div>
        <div class="kpi-cell">
            <div class="kpi-num" style="color:#b45309;">{{ $ancK6 }}</div>
            <div class="kpi-label">Kunjungan K6</div>
        </div>
        <div class="kpi-cell">
            <div class="kpi-num" style="color:#be185d;">{{ $kbPascaSalin }}</div>
            <div class="kpi-label">KB Pasca Salin</div>
        </div>
    </div>

    <table>
        <thead><tr><th>Indikator</th><th class="text-center">Di Faskes</th><th class="text-center">Non-Faskes</th><th class="text-center">Total</th></tr></thead>
        <tbody>
            <tr>
                <td><strong>Persalinan</strong></td>
                <td class="text-center"><span class="badge-success">{{ $persalinanFaskes }}</span></td>
                <td class="text-center"><span class="badge-warning">{{ $persalinanNonFaskes }}</span></td>
                <td class="text-center"><strong>{{ $persalinanFaskes + $persalinanNonFaskes }}</strong></td>
            </tr>
        </tbody>
    </table>

    {{-- 3. TTD --}}
    <div class="section-title">💊 Tablet Tambah Darah (TTD)</div>
    <div class="kpi-grid">
        <div class="kpi-cell">
            <div class="kpi-num" style="color:#1d4ed8;">{{ $ttdTarget }}</div>
            <div class="kpi-label">Target Ibu Hamil</div>
        </div>
        <div class="kpi-cell">
            <div class="kpi-num" style="color:#047857;">{{ $ttdPatuh }}</div>
            <div class="kpi-label">Patuh Konsumsi</div>
        </div>
        <div class="kpi-cell">
            <div class="kpi-num" style="color:#dc2626;">{{ max(0,$ttdTarget-$ttdPatuh) }}</div>
            <div class="kpi-label">Tidak Patuh</div>
        </div>
        <div class="kpi-cell">
            <div class="kpi-num" style="color:#7c3aed;">{{ $ttdTarget > 0 ? round(($ttdPatuh/$ttdTarget)*100) : 0 }}%</div>
            <div class="kpi-label">Cakupan Kepatuhan</div>
        </div>
    </div>

    {{-- 4. Gizi & Stunting --}}
    <div class="section-title">📊 Status Gizi & Stunting Balita</div>
    <div class="kpi-grid">
        <div class="kpi-cell">
            <div class="kpi-num" style="color:#0891b2;">{{ $totalBalita }}</div>
            <div class="kpi-label">Balita Ditimbang</div>
        </div>
        <div class="kpi-cell">
            <div class="kpi-num" style="color:#dc2626;">{{ $stunting }}</div>
            <div class="kpi-label">Stunting</div>
        </div>
        <div class="kpi-cell">
            <div class="kpi-num" style="color:#ea580c;">{{ $giziBuruk }}</div>
            <div class="kpi-label">Gizi Buruk</div>
        </div>
        <div class="kpi-cell">
            <div class="kpi-num" style="color:#047857;">{{ $totalBalita > 0 ? round((($totalBalita-$stunting-$giziBuruk)/$totalBalita)*100) : 0 }}%</div>
            <div class="kpi-label">Balita Normal</div>
        </div>
    </div>

    {{-- 5. Imunisasi --}}
    <div class="section-title">🛡 Cakupan Imunisasi Dasar Lengkap</div>
    <table>
        <thead><tr><th>Jenis Imunisasi</th><th class="text-center">Jumlah Diberikan</th></tr></thead>
        <tbody>
            @foreach($imunisasi as $imun)
                <tr><td>{{ $imun->jenis_imunisasi }}</td><td class="text-center"><strong>{{ $imun->total }}</strong></td></tr>
            @endforeach
            @if($imunisasi->isEmpty())
                <tr><td colspan="2" class="text-center" style="color:#94a3b8;">Belum ada data imunisasi</td></tr>
            @endif
        </tbody>
    </table>

    {{-- 6. KB Pasca Salin per Metode --}}
    <div class="section-title">💗 KB Pasca Salin per Metode</div>
    <table>
        <thead><tr><th>Metode KB</th><th class="text-center">Jumlah</th><th class="text-center">%</th></tr></thead>
        <tbody>
            @php $totalKbPdf = $kbPerMetode->sum('total'); @endphp
            @foreach($kbPerMetode as $kb)
                <tr>
                    <td>{{ $kb->metode_kb }}</td>
                    <td class="text-center">{{ $kb->total }}</td>
                    <td class="text-center">{{ $totalKbPdf > 0 ? round(($kb->total/$totalKbPdf)*100) : 0 }}%</td>
                </tr>
            @endforeach
            @if($kbPerMetode->isEmpty())
                <tr><td colspan="3" class="text-center" style="color:#94a3b8;">Belum ada data KB</td></tr>
            @endif
        </tbody>
    </table>

    <div class="page-break"></div>

    {{-- 7. Tabel Rekap per Faskes --}}
    <div class="header" style="margin-bottom:16px;">
        <h2>Rekap Per Fasilitas Kesehatan — {{ $bulanNama }} {{ $tahun }}</h2>
    </div>

    <div class="section-title">🏥 Kinerja Fasilitas Kesehatan</div>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Faskes</th>
                <th>Kecamatan</th>
                <th class="text-center">K1</th>
                <th class="text-center">K4</th>
                <th class="text-center">K6</th>
                <th class="text-center">Pers. Faskes</th>
                <th class="text-center">AKI</th>
                <th class="text-center">AKB</th>
            </tr>
        </thead>
        <tbody>
            @foreach($faskesList as $i => $f)
                <tr>
                    <td class="text-center">{{ $i + 1 }}</td>
                    <td><strong>{{ $f->nama_faskes }}</strong></td>
                    <td>{{ $f->kecamatan }}</td>
                    <td class="text-center">{{ $f->cakupan->k1_total ?? 0 }}</td>
                    <td class="text-center">{{ $f->cakupan->k4_total ?? 0 }}</td>
                    <td class="text-center">{{ $f->cakupan->k6_total ?? 0 }}</td>
                    <td class="text-center">{{ $f->cakupan->persalinan_faskes ?? 0 }}</td>
                    <td class="text-center">
                        @if(($f->kematian->kematian_ibu ?? 0) > 0)
                            <span class="badge-danger">{{ $f->kematian->kematian_ibu }}</span>
                        @else
                            <span class="badge-success">0</span>
                        @endif
                    </td>
                    <td class="text-center">
                        @if(($f->kematian->kematian_bayi ?? 0) > 0)
                            <span class="badge-danger">{{ $f->kematian->kematian_bayi }}</span>
                        @else
                            <span class="badge-success">0</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Laporan ini digenerate otomatis oleh Sistem Informasi KIA &bull; {{ now()->translatedFormat('d F Y') }} &bull; Data bersumber dari rekap transaksional real-time
    </div>

</div>
</body>
</html>
