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
    <h1 class="fw-bold text-dark">Monitoring Fasilitas Kesehatan</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item">Laporan & Monitoring</li>
            <li class="breadcrumb-item active">Monitoring Faskes</li>
        </ol>
    </nav>
</div>

<!-- Custom Page Styling -->
@push('styles')
<style>
    .faskes-card {
        border: none;
        border-radius: 16px;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.04);
        background: #ffffff;
    }
    .custom-table th {
        font-weight: 700;
        color: #475569;
        text-transform: uppercase;
        font-size: 11px;
        letter-spacing: 0.5px;
    }
    .badge-faskes {
        font-size: 11px;
        padding: 5px 12px;
        border-radius: 20px;
        font-weight: 600;
    }
</style>
@endpush

<section class="section">
    <div class="row">
        
        <!-- Filter Form & Actions -->
        <div class="col-12 mb-4">
            <div class="card faskes-card p-4 border-start border-4 border-info">
                <form action="{{ route('laporan.monitoring-faskes') }}" method="GET" class="row align-items-end g-3">
                    <div class="col-md-3">
                        <label class="form-label fw-bold text-secondary small">Pilih Tahun</label>
                        <select name="tahun" class="form-select rounded-pill">
                            <option value="2025" {{ $tahun == 2025 ? 'selected' : '' }}>2025</option>
                            <option value="2026" {{ $tahun == 2026 ? 'selected' : '' }}>2026</option>
                            <option value="2027" {{ $tahun == 2027 ? 'selected' : '' }}>2027</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold text-secondary small">Pilih Bulan</label>
                        <select name="bulan" class="form-select rounded-pill">
                            @foreach(range(1, 12) as $m)
                                <option value="{{ $m }}" {{ $bulan == $m ? 'selected' : '' }}>
                                    {{ $bulanIndo[$m] }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-info text-dark border-0 rounded-pill w-100 fw-bold" style="background-color: #0ea5e9;"><i class="bi bi-filter me-2"></i> Filter</button>
                    </div>
                    <div class="col-md-4 text-md-end">
                        <a href="{{ route('laporan.export-excel', ['tahun' => $tahun, 'bulan' => $bulan]) }}" class="btn btn-success rounded-pill px-3 fw-bold me-2"><i class="bi bi-file-earmark-excel me-2"></i> Ekspor Excel</a>
                        <button type="button" onclick="window.print()" class="btn btn-outline-info rounded-pill px-3 fw-bold text-dark border-light-subtle bg-white"><i class="bi bi-printer me-2"></i> Cetak</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Faskes Comparative Table Card -->
        <div class="col-12">
            <div class="card faskes-card p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-bold text-dark mb-0">Daftar Hasil Rekap Capaian Faskes (Periode: {{ $bulanIndo[$bulan] }} {{ $tahun }})</h5>
                    <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-2 fw-bold">Total: {{ count($faskesList) }} Faskes</span>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle custom-table mb-0">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 25%;">Nama Faskes</th>
                                <th style="width: 12%;">Jenis</th>
                                <th class="text-center">Cakupan KIA (K1/K4/K6)</th>
                                <th class="text-center">Gizi Balita (Stunting)</th>
                                <th class="text-center">TTD Bumil (Target/Patuh)</th>
                                <th class="text-center">Indikator Kematian (Ibu/Bayi/Balita)</th>
                                <th class="text-center" style="width: 10%;">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($faskesList as $faskes)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm bg-info-subtle text-info rounded-3 p-2 me-3 text-center" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; font-size: 20px;">
                                                <i class="bi bi-hospital"></i>
                                            </div>
                                            <div>
                                                <span class="fw-bold text-dark d-block">{{ $faskes->nama_faskes }}</span>
                                                <span class="text-muted small"><i class="bi bi-geo-alt me-1"></i> Kec. {{ $faskes->kecamatan }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary-subtle text-secondary badge-faskes">
                                            {{ strtoupper($faskes->jenis) }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        @if($faskes->cakupan)
                                            <span class="fw-semibold text-primary d-block">K1: {{ $faskes->cakupan->k1_total }} | K4: {{ $faskes->cakupan->k4_total }} | K6: {{ $faskes->cakupan->k6_total }}</span>
                                            <span class="text-muted small">Persalinan Faskes: {{ $faskes->cakupan->persalinan_faskes }}</span>
                                        @else
                                            <span class="text-muted small">Belum ada rekap data</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if($faskes->gizi)
                                            <span class="fw-semibold text-danger d-block">Stunting: {{ $faskes->gizi->stunting }} Anak</span>
                                            <span class="text-muted small">Total Ditimbang: {{ $faskes->gizi->total_balita_ditimbang }}</span>
                                        @else
                                            <span class="text-muted small">Belum ada rekap data</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if($faskes->ttd)
                                            <span class="fw-semibold text-success d-block">Patuh: {{ $faskes->ttd->patuh_konsumsi }} Bumil</span>
                                            <span class="text-muted small">Target: {{ $faskes->ttd->target_ibu_hamil }}</span>
                                        @else
                                            <span class="text-muted small">Belum ada rekap data</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if($faskes->kematian)
                                            <span class="badge bg-danger-subtle text-danger badge-faskes d-block mb-1">Kematian Ibu: {{ $faskes->kematian->kematian_ibu }}</span>
                                            <span class="text-muted small">Bayi: {{ $faskes->kematian->kematian_bayi }} | Balita: {{ $faskes->kematian->kematian_balita }}</span>
                                        @else
                                            <span class="text-muted small">Belum ada rekap data</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if($faskes->is_active)
                                            <span class="badge bg-success text-white badge-faskes"><i class="bi bi-check-circle me-1"></i>Aktif</span>
                                        @else
                                            <span class="badge bg-danger text-white badge-faskes"><i class="bi bi-x-circle me-1"></i>Nonaktif</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5 text-muted">
                                        <i class="bi bi-building-exclamation fs-1 mb-2"></i>
                                        <p class="mb-0 fw-semibold">Tidak ada data rekap untuk periode ini.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

    </div>
</section>
@endsection
