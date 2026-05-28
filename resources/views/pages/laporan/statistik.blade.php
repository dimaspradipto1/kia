@extends('layouts.dashboard.template')

@section('content')
@php
    $bulanIndo = [
        1 => 'Januari',
        2 => 'Februari',
        3 => 'Maret',
        4 => 'April',
        5 => 'Mei',
        6 => 'Juni',
        7 => 'Juli',
        8 => 'Agustus',
        9 => 'September',
        10 => 'Oktober',
        11 => 'November',
        12 => 'Desember'
    ];
@endphp
<div class="pagetitle">
    <h1 class="fw-bold text-dark">Statistik Kesehatan Ibu & Anak</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item">Laporan & Monitoring</li>
            <li class="breadcrumb-item active">Statistik Wilayah</li>
        </ol>
    </nav>
</div>

<!-- Custom Page Styling -->
@push('styles')
<style>
    .report-card {
        border: none;
        border-radius: 16px;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.04);
        transition: transform 0.2s ease;
        background: #ffffff;
    }
    .report-card:hover {
        transform: translateY(-3px);
    }
    .card-header-custom {
        background: transparent;
        border-bottom: 1px solid #f1f5f9;
        padding: 1.25rem;
    }
    .icon-box-small {
        width: 42px;
        height: 42px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }
    .kematian-number {
        font-size: 2.2rem;
        font-weight: 800;
        line-height: 1;
    }
</style>
@endpush

<section class="section">
    <div class="row">
        
        <!-- Filter Form & Actions -->
        <div class="col-12 mb-4">
            <div class="card report-card p-4 border-start border-4 border-primary">
                <form action="{{ route('laporan.statistik') }}" method="GET">
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-secondary small">Pilih Tahun</label>
                            <select name="tahun" class="form-select rounded-pill">
                                <option value="2025" {{ $tahun == 2025 ? 'selected' : '' }}>2025</option>
                                <option value="2026" {{ $tahun == 2026 ? 'selected' : '' }}>2026</option>
                                <option value="2027" {{ $tahun == 2027 ? 'selected' : '' }}>2027</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-secondary small">Pilih Bulan</label>
                            <select name="bulan" class="form-select rounded-pill">
                                @foreach(range(1, 12) as $m)
                                    <option value="{{ $m }}" {{ $bulan == $m ? 'selected' : '' }}>
                                        {{ $bulanIndo[$m] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-2 w-100">
                        <button type="submit" class="btn btn-primary rounded-pill fw-bold flex-grow-1">
                            <i class="bi bi-filter me-1"></i> Filter
                        </button>
                        <a href="{{ route('laporan.export-excel', ['tahun' => $tahun, 'bulan' => $bulan]) }}" class="btn btn-success rounded-pill fw-bold flex-grow-1">
                            <i class="bi bi-file-earmark-excel me-1"></i> Excel
                        </a>
                        <a href="{{ route('laporan.export-pdf', ['tahun' => $tahun, 'bulan' => $bulan]) }}" class="btn btn-danger rounded-pill fw-bold flex-grow-1">
                            <i class="bi bi-file-earmark-pdf me-1"></i> PDF
                        </a>
                        <a href="{{ route('laporan.export-siga', ['tahun' => $tahun, 'bulan' => $bulan]) }}" class="btn btn-warning rounded-pill fw-bold text-dark flex-grow-1">
                            <i class="bi bi-file-earmark-spreadsheet me-1"></i> SIGA
                        </a>
                        <button type="button" onclick="window.print()" class="btn btn-outline-secondary rounded-pill fw-bold flex-grow-1">
                            <i class="bi bi-printer me-1"></i> Cetak
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Row: Mortality Indicators (Indikator Kematian) -->
        <div class="col-12 mb-4">
            <div class="card report-card p-4">
                <h5 class="fw-bold text-dark mb-3"><i class="bi bi-exclamation-triangle text-danger me-2"></i> Indikator Kematian Ibu & Anak (Periode: {{ $bulanIndo[$bulan] }} {{ $tahun }})</h5>
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="p-3 bg-danger-subtle text-danger rounded-4 d-flex align-items-center justify-content-between">
                            <div>
                                <span class="small fw-semibold d-block text-uppercase">Kematian Ibu</span>
                                <h3 class="kematian-number mt-1">{{ $kematianIbu }}</h3>
                            </div>
                            <i class="bi bi-person-exclamation fs-1 opacity-75"></i>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 bg-warning-subtle text-warning-emphasis rounded-4 d-flex align-items-center justify-content-between" style="background-color: #fef3c7 !important; color: #92400e !important;">
                            <div>
                                <span class="small fw-semibold d-block text-uppercase">Kematian Bayi</span>
                                <h3 class="kematian-number mt-1">{{ $kematianBayi }}</h3>
                            </div>
                            <i class="bi bi-heartbreak fs-1 opacity-75"></i>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 bg-info-subtle text-info-emphasis rounded-4 d-flex align-items-center justify-content-between" style="background-color: #e0f2fe !important; color: #075985 !important;">
                            <div>
                                <span class="small fw-semibold d-block text-uppercase">Kematian Balita</span>
                                <h3 class="kematian-number mt-1">{{ $kematianBalita }}</h3>
                            </div>
                            <i class="bi bi-emoji-frown fs-1 opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Row 1: ANC Coverage & TTD Adherence -->
        <div class="col-lg-7 mb-4">
            <div class="card report-card h-100">
                <div class="card-header card-header-custom d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <div class="icon-box-small bg-primary-subtle text-primary me-3">
                            <i class="bi bi-clipboard2-pulse"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold text-dark mb-0">Cakupan Kunjungan ANC (K1, K4, K6)</h5>
                            <span class="text-muted small">Cakupan kunjungan berkala pelayanan antenatal</span>
                        </div>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div id="ancChart" style="min-height: 350px;"></div>
                </div>
            </div>
        </div>

        <div class="col-lg-5 mb-4">
            <div class="card report-card h-100">
                <div class="card-header card-header-custom d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <div class="icon-box-small bg-danger-subtle text-danger me-3">
                            <i class="bi bi-capsule"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold text-dark mb-0">Kepatuhan Tablet Tambah Darah (TTD)</h5>
                            <span class="text-muted small">Tingkat kepatuhan konsumsi tablet zat besi</span>
                        </div>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div id="ttdChart" style="min-height: 350px;"></div>
                </div>
            </div>
        </div>

        <!-- Row 2: Persalinan Faskes vs Non-Faskes & KB Pasca Salin per Metode -->
        <div class="col-lg-6 mb-4">
            <div class="card report-card h-100">
                <div class="card-header card-header-custom d-flex align-items-center">
                    <div class="icon-box-small bg-purple-subtle me-3" style="background:#f3e8ff;">
                        <i class="bi bi-hospital" style="color:#7c3aed;"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold text-dark mb-0">Persalinan: Faskes vs Non-Faskes</h5>
                        <span class="text-muted small">Distribusi tempat persalinan ibu</span>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div id="persalinanChart" style="min-height:320px;"></div>
                </div>
            </div>
        </div>

        <div class="col-lg-6 mb-4">
            <div class="card report-card h-100">
                <div class="card-header card-header-custom d-flex align-items-center">
                    <div class="icon-box-small bg-pink-subtle me-3" style="background:#fce7f3;">
                        <i class="bi bi-heart-pulse" style="color:#db2777;"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold text-dark mb-0">KB Pasca Salin per Metode</h5>
                        <span class="text-muted small">Distribusi metode KB yang digunakan ibu</span>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div id="kbChart" style="min-height:320px;"></div>
                </div>
            </div>
        </div>

        <!-- Row 3: Child Immunization & Nutrition Metrics -->
        <div class="col-lg-6 mb-4">
            <div class="card report-card h-100">
                <div class="card-header card-header-custom d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <div class="icon-box-small bg-success-subtle text-success me-3">
                            <i class="bi bi-shield-check"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold text-dark mb-0">Distribusi Imunisasi Anak</h5>
                            <span class="text-muted small">Jumlah pemberian antigen dasar lengkap</span>
                        </div>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div id="imunisasiChart" style="min-height: 350px;"></div>
                </div>
            </div>
        </div>

        <div class="col-lg-6 mb-4">
            <div class="card report-card h-100">
                <div class="card-header card-header-custom d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <div class="icon-box-small bg-warning-subtle text-warning me-3">
                            <i class="bi bi-heart-pulse"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold text-dark mb-0">Status Gizi Balita & Risiko Stunting</h5>
                            <span class="text-muted small">Pemantauan berat badan dan tinggi badan balita</span>
                        </div>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="row">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <h6 class="fw-bold text-center text-secondary mb-3">Status Gizi (BB/U)</h6>
                            <div id="giziChart"></div>
                        </div>
                        <div class="col-md-6">
                            <h6 class="fw-bold text-center text-secondary mb-3">Indikator Stunting</h6>
                            <div id="stuntingChart"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

<!-- ApexCharts Script Logic -->
@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", () => {
        
        // 1. ANC Coverage Column Chart
        new ApexCharts(document.querySelector("#ancChart"), {
            series: [{
                name: 'Total Rekap KIA',
                data: [{{ $ancK1 }}, {{ $ancK4 }}, {{ $ancK6 }}]
            }],
            chart: {
                type: 'bar',
                height: 350,
                toolbar: { show: false },
                background: 'transparent'
            },
            plotOptions: {
                bar: {
                    borderRadius: 8,
                    horizontal: false,
                    columnWidth: '45%',
                    distributed: true
                }
            },
            colors: ['#3b82f6', '#f59e0b', '#10b981'],
            dataLabels: { enabled: true },
            xaxis: {
                categories: ['Kunjungan K1', 'Kunjungan K4', 'Kunjungan K6'],
                labels: { style: { colors: '#64748b', fontWeight: 600 } }
            },
            yaxis: {
                title: { text: 'Ibu Hamil (Jiwa)', style: { color: '#64748b' } }
            },
            legend: { show: false },
            grid: { borderColor: '#f1f5f9' }
        }).render();

        // 2. TTD Adherence Donut Chart
        new ApexCharts(document.querySelector("#ttdChart"), {
            series: [{{ $ttdPatuh }}, {{ $ttdTidakPatuh }}],
            chart: {
                type: 'donut',
                height: 350,
                background: 'transparent'
            },
            labels: ['Patuh Konsumsi', 'Tidak Patuh'],
            colors: ['#10b981', '#ef4444'],
            legend: { position: 'bottom', horizontalAlign: 'center' },
            dataLabels: { enabled: true },
            plotOptions: {
                pie: {
                    donut: {
                        size: '65%',
                        labels: {
                            show: true,
                            total: {
                                show: true,
                                label: 'Target Ibu',
                                formatter: () => {{ $ttdPatuh + $ttdTidakPatuh }}
                            }
                        }
                    }
                }
            }
        }).render();

        // 3. Imunisasi Bar Chart
        new ApexCharts(document.querySelector("#imunisasiChart"), {
            series: [{
                name: 'Jumlah Balita',
                data: @json($imunisasiValues)
            }],
            chart: {
                type: 'bar',
                height: 350,
                toolbar: { show: false }
            },
            plotOptions: {
                bar: {
                    borderRadius: 4,
                    horizontal: true,
                }
            },
            colors: ['#0d9488'],
            xaxis: {
                categories: @json($imunisasiLabels)
            },
            grid: { borderColor: '#f1f5f9' }
        }).render();

        // 4. Persalinan Faskes vs Non-Faskes
        new ApexCharts(document.querySelector("#persalinanChart"), {
            series: [{{ $persalinanFaskes }}, {{ $persalinanNonFaskes }}],
            chart: { type: 'donut', height: 320, background: 'transparent' },
            labels: ['Di Faskes', 'Non-Faskes (Rumah/Dukun)'],
            colors: ['#7c3aed', '#f59e0b'],
            legend: { position: 'bottom' },
            dataLabels: { enabled: true },
            plotOptions: { pie: { donut: { size: '65%', labels: { show: true, total: { show: true, label: 'Total', formatter: () => {{ $persalinanFaskes + $persalinanNonFaskes }} } } } } }
        }).render();

        // 5. KB Pasca Salin per Metode
        new ApexCharts(document.querySelector("#kbChart"), {
            series: @json($kbValues),
            chart: { type: 'bar', height: 320, toolbar: { show: false } },
            plotOptions: { bar: { borderRadius: 6, horizontal: true, distributed: true } },
            colors: ['#db2777','#9333ea','#2563eb','#059669','#d97706','#dc2626'],
            dataLabels: { enabled: true },
            xaxis: { categories: @json($kbLabels), labels: { style: { colors: '#64748b' } } },
            legend: { show: false },
            grid: { borderColor: '#f1f5f9' }
        }).render();

        // 6. Gizi BB/U Pie Chart
        new ApexCharts(document.querySelector("#giziChart"), {
            series: [{{ $giziBaik }}, {{ $giziKurang }}, {{ $giziBuruk }}, {{ $overweight }}],
            chart: {
                type: 'pie',
                height: 280
            },
            labels: ['Gizi Baik', 'Gizi Kurang', 'Gizi Buruk', 'Overweight'],
            colors: ['#10b981', '#f59e0b', '#ef4444', '#6366f1'],
            legend: { position: 'bottom' }
        }).render();

        // 5. Stunting Radial Chart
        new ApexCharts(document.querySelector("#stuntingChart"), {
            series: [{{ $stuntingCount }}, {{ $normalStuntingCount }}],
            chart: {
                type: 'donut',
                height: 280
            },
            labels: ['Stunting', 'Normal'],
            colors: ['#ec4899', '#3b82f6'],
            legend: { position: 'bottom' },
            plotOptions: {
                pie: {
                    donut: {
                        size: '60%'
                    }
                }
            }
        }).render();

    });
</script>
@endpush
@endsection
