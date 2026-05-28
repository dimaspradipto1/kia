@extends('layouts.dashboard.template')

@section('content')
@php
$bulanIndo = [1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',5=>'Mei',6=>'Juni',7=>'Juli',8=>'Agustus',9=>'September',10=>'Oktober',11=>'November',12=>'Desember'];
@endphp
<div class="pagetitle">
    <h1 class="fw-bold text-dark">Laporan KB Pasca Salin per Metode</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item">Laporan & Monitoring</li>
            <li class="breadcrumb-item active">KB Pasca Salin</li>
        </ol>
    </nav>
</div>

<section class="section">
    <div class="row">

        {{-- Filter --}}
        <div class="col-12 mb-4">
            <div class="card border-0 shadow-sm rounded-4 p-4 border-start border-4 border-pink">
                <form action="{{ route('laporan.kb-pasca-salin') }}" method="GET" class="row align-items-end g-3">
                    <div class="col-md-3">
                        <label class="form-label fw-bold text-secondary small">Tahun</label>
                        <select name="tahun" class="form-select rounded-pill">
                            @foreach([2024,2025,2026,2027] as $y)
                                <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>{{ $y }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold text-secondary small">Bulan</label>
                        <select name="bulan" class="form-select rounded-pill">
                            @foreach(range(1,12) as $m)
                                <option value="{{ $m }}" {{ $bulan == $m ? 'selected' : '' }}>{{ $bulanIndo[$m] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold text-secondary small">Fasilitas Kesehatan</label>
                        <select name="faskes_id" class="form-select rounded-pill">
                            <option value="">Semua Faskes</option>
                            @foreach($faskesList as $f)
                                <option value="{{ $f->id }}" {{ $faskesId == $f->id ? 'selected' : '' }}>{{ $f->nama_faskes }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn fw-bold rounded-pill w-100 text-white" style="background:#db2777;"><i class="bi bi-filter me-1"></i> Filter</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Ringkasan per Metode --}}
        <div class="col-lg-5 mb-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white border-bottom py-3 px-4">
                    <h5 class="fw-bold mb-0">Distribusi Metode KB — <span class="text-muted small">{{ $bulanIndo[$bulan] }} {{ $tahun }}</span></h5>
                </div>
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="fw-bold fs-5">Total KB Pasca Salin:</span>
                        <span class="badge fs-6 px-3 py-2 text-white rounded-pill" style="background:#db2777;">{{ $totalKb }}</span>
                    </div>
                    @forelse($perMetode as $item)
                        @php $pct = $totalKb > 0 ? round(($item->total / $totalKb) * 100) : 0; @endphp
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-1">
                                <span class="fw-semibold small">{{ $item->metode_kb }}</span>
                                <span class="fw-bold small text-pink">{{ $item->total }} ({{ $pct }}%)</span>
                            </div>
                            <div class="progress" style="height:10px; border-radius:8px;">
                                <div class="progress-bar" role="progressbar" style="width:{{ $pct }}%; background:linear-gradient(90deg,#db2777,#9333ea);" aria-valuenow="{{ $pct }}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-muted py-5">
                            <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                            Tidak ada data KB untuk periode ini.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Chart --}}
        <div class="col-lg-7 mb-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white border-bottom py-3 px-4">
                    <h5 class="fw-bold mb-0">Grafik per Metode KB</h5>
                </div>
                <div class="card-body p-4">
                    <div id="kbMetodeChart" style="min-height:340px;"></div>
                </div>
            </div>
        </div>

        {{-- Tabel Detail --}}
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-bottom py-3 px-4 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0">Detail Data KB Pasca Salin</h5>
                    <span class="badge rounded-pill px-3 py-2 text-white fw-bold" style="background:#db2777;">{{ $kbList->total() }} data</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead style="background:#fce7f3;">
                                <tr>
                                    <th class="px-4 py-3" style="color:#db2777; font-size:0.78rem; text-transform:uppercase;">No</th>
                                    <th class="py-3" style="color:#db2777; font-size:0.78rem; text-transform:uppercase;">Nama Ibu</th>
                                    <th class="py-3" style="color:#db2777; font-size:0.78rem; text-transform:uppercase;">Fasilitas Kesehatan</th>
                                    <th class="py-3" style="color:#db2777; font-size:0.78rem; text-transform:uppercase;">Metode KB</th>
                                    <th class="py-3" style="color:#db2777; font-size:0.78rem; text-transform:uppercase;">Tanggal Mulai</th>
                                    <th class="py-3" style="color:#db2777; font-size:0.78rem; text-transform:uppercase;">Nakes</th>
                                    <th class="py-3" style="color:#db2777; font-size:0.78rem; text-transform:uppercase;">Catatan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($kbList as $i => $kb)
                                    <tr>
                                        <td class="px-4">{{ $kbList->firstItem() + $i }}</td>
                                        <td class="fw-semibold">{{ $kb->bukuKia->profilIbu->nama_lengkap ?? '-' }}</td>
                                        <td>{{ $kb->fasilitasKesehatan->nama_faskes ?? '-' }}</td>
                                        <td>
                                            <span class="badge rounded-pill px-3 py-1 text-white fw-semibold" style="background:#9333ea; font-size:0.8rem;">
                                                {{ $kb->metode_kb }}
                                            </span>
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($kb->tanggal_mulai)->translatedFormat('d F Y') }}</td>
                                        <td>{{ $kb->nakes->name ?? '-' }}</td>
                                        <td class="text-muted small">{{ $kb->catatan ?? '-' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-5 text-muted">
                                            <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                            Tidak ada data KB untuk periode ini.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if($kbList->hasPages())
                    <div class="card-footer bg-white border-top py-3 px-4">
                        {{ $kbList->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const labels = @json($perMetode->pluck('metode_kb'));
    const values = @json($perMetode->pluck('total'));

    if (labels.length > 0 && values.some(v => v > 0)) {
        new ApexCharts(document.querySelector("#kbMetodeChart"), {
            series: [{ name: 'Jumlah', data: values }],
            chart: { type: 'bar', height: 340, toolbar: { show: false } },
            plotOptions: { bar: { borderRadius: 8, horizontal: true, distributed: true } },
            colors: ['#db2777','#9333ea','#2563eb','#059669','#d97706','#dc2626','#0891b2','#65a30d'],
            dataLabels: { enabled: true },
            xaxis: { categories: labels, labels: { style: { colors: '#64748b', fontWeight: 600 } } },
            legend: { show: false },
            grid: { borderColor: '#f9f0ff' }
        }).render();
    } else {
        document.querySelector("#kbMetodeChart").innerHTML = '<div class="text-center text-muted py-5"><i class="bi bi-bar-chart fs-1 d-block mb-2"></i>Belum ada data KB untuk periode ini.</div>';
    }
});
</script>
@endpush
@endsection
