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
    <h1 class="fw-bold text-dark">Monitoring Buku KIA</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item">Laporan & Monitoring</li>
            <li class="breadcrumb-item active">Monitoring Buku KIA</li>
        </ol>
    </nav>
</div>

<!-- Custom Page Styling -->
@push('styles')
<style>
    .kpi-card {
        border: none;
        border-radius: 16px;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.02);
        background: #ffffff;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .kpi-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 35px rgba(0, 0, 0, 0.05);
    }
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
    .badge-custom {
        font-size: 11px;
        padding: 5px 12px;
        border-radius: 20px;
        font-weight: 600;
    }
    .avatar-icon {
        width: 44px;
        height: 44px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        border-radius: 12px;
    }
</style>
@endpush

<section class="section">
    <div class="row">
        
        <!-- KPI Cards -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card kpi-card p-3 border-start border-4 border-primary">
                <div class="d-flex align-items-center">
                    <div class="avatar-icon bg-primary-subtle text-primary me-3">
                        <i class="bi bi-book"></i>
                    </div>
                    <div>
                        <h6 class="text-secondary small fw-bold mb-1">TOTAL BUKU KIA</h6>
                        <h3 class="fw-bold text-dark mb-0">{{ $totalBuku }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card kpi-card p-3 border-start border-4 border-success">
                <div class="d-flex align-items-center">
                    <div class="avatar-icon bg-success-subtle text-success me-3">
                        <i class="bi bi-journal-check"></i>
                    </div>
                    <div>
                        <h6 class="text-secondary small fw-bold mb-1">BUKU KIA AKTIF</h6>
                        <h3 class="fw-bold text-dark mb-0">{{ $totalAktif }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card kpi-card p-3 border-start border-4 border-info">
                <div class="d-flex align-items-center">
                    <div class="avatar-icon bg-info-subtle text-info me-3">
                        <i class="bi bi-award"></i>
                    </div>
                    <div>
                        <h6 class="text-secondary small fw-bold mb-1">BUKU KIA SELESAI</h6>
                        <h3 class="fw-bold text-dark mb-0">{{ $totalSelesai }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card kpi-card p-3 border-start border-4 border-warning">
                <div class="d-flex align-items-center">
                    <div class="avatar-icon bg-warning-subtle text-warning me-3">
                        <i class="bi bi-clipboard2-pulse"></i>
                    </div>
                    <div>
                        <h6 class="text-secondary small fw-bold mb-1">TOTAL KUNJUNGAN ANC</h6>
                        <h3 class="fw-bold text-dark mb-0">{{ $totalAnc }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Form & Actions -->
        <div class="col-12 mb-4">
            <div class="card faskes-card p-4 border-start border-4 border-info">
                <form action="{{ route('laporan.monitoring-buku-kia') }}" method="GET" class="row g-3">
                    <div class="col-md-2">
                        <label class="form-label fw-bold text-secondary small">Pilih Tahun</label>
                        <select name="tahun" class="form-select rounded-pill">
                            <option value="2025" {{ $tahun == 2025 ? 'selected' : '' }}>2025</option>
                            <option value="2026" {{ $tahun == 2026 ? 'selected' : '' }}>2026</option>
                            <option value="2027" {{ $tahun == 2027 ? 'selected' : '' }}>2027</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label fw-bold text-secondary small">Pilih Bulan</label>
                        <select name="bulan" class="form-select rounded-pill">
                            @foreach(range(1, 12) as $m)
                                <option value="{{ $m }}" {{ $bulan == $m ? 'selected' : '' }}>
                                    {{ $bulanIndo[$m] }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold text-secondary small">Filter Fasilitas Kesehatan</label>
                        <select name="faskes_id" class="form-select rounded-pill">
                            <option value="">-- Semua Faskes --</option>
                            @foreach($faskesList as $fk)
                                <option value="{{ $fk->id }}" {{ $faskesId == $fk->id ? 'selected' : '' }}>
                                    {{ $fk->nama_faskes }} ({{ $fk->jenis }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold text-secondary small">Filter Status Buku</label>
                        <select name="status" class="form-select rounded-pill">
                            <option value="Semua" {{ $status == 'Semua' ? 'selected' : '' }}>-- Semua Status --</option>
                            <option value="Aktif" {{ $status == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="Selesai" {{ $status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                            <option value="Non-Aktif" {{ $status == 'Non-Aktif' ? 'selected' : '' }}>Non-Aktif</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label fw-bold text-secondary small">Pencarian Cepat</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0 rounded-start-pill" style="border-radius: 50px 0 0 50px;"><i class="bi bi-search text-muted"></i></span>
                            <input type="text" name="search" class="form-control border-start-0 rounded-end-pill" placeholder="Nama, NIK..." value="{{ $search }}" style="border-radius: 0 50px 50px 0;">
                        </div>
                    </div>
                    <div class="col-12 d-flex justify-content-between align-items-center mt-3 pt-3 border-top">
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-info text-dark border-0 rounded-pill px-4 fw-bold" style="background-color: #0ea5e9;"><i class="bi bi-filter me-1"></i> Filter</button>
                            <a href="{{ route('laporan.monitoring-buku-kia') }}" class="btn btn-outline-secondary rounded-pill px-4 fw-bold bg-white text-secondary border-light-subtle"><i class="bi bi-arrow-counterclockwise me-1"></i> Reset</a>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="{{ route('laporan.export-excel', ['tahun' => $tahun, 'bulan' => $bulan]) }}" class="btn btn-success rounded-pill px-4 fw-bold"><i class="bi bi-file-earmark-excel me-1"></i> Ekspor Rekap Buku KIA</a>
                            <button type="button" onclick="window.print()" class="btn btn-outline-info rounded-pill px-4 fw-bold text-dark border-light-subtle bg-white"><i class="bi bi-printer me-1"></i> Cetak Halaman</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Buku KIA Monitoring Table Card -->
        <div class="col-12">
            <div class="card faskes-card p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-bold text-dark mb-0">Daftar Buku KIA Terbit (Periode: {{ $bulanIndo[$bulan] }} {{ $tahun }})</h5>
                    <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-2 fw-bold">Ditemukan: {{ $bukuKiaList->total() }} Buku</span>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle custom-table mb-0">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 5%;" class="text-center">No</th>
                                <th style="width: 25%;">Identitas Ibu & Faskes</th>
                                <th style="width: 20%;">Nomor Registrasi Kohort</th>
                                <th style="width: 15%;">Penerbitan</th>
                                <th style="width: 15%;" class="text-center">Aktivitas Medis</th>
                                <th style="width: 10%;" class="text-center">Status</th>
                                <th style="width: 10%;" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($bukuKiaList as $buku)
                                <tr>
                                    <td class="text-center fw-semibold text-secondary">
                                        {{ ($bukuKiaList->currentPage() - 1) * $bukuKiaList->perPage() + $loop->iteration }}
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-icon bg-info-subtle text-info me-3" style="width: 38px; height: 38px; font-size: 16px;">
                                                <i class="bi bi-person-fill"></i>
                                            </div>
                                            <div>
                                                <span class="fw-bold text-dark d-block">{{ optional($buku->profilIbu)->nama_lengkap ?? '-' }}</span>
                                                <span class="text-muted small d-block"><i class="bi bi-card-text me-1"></i> NIK: {{ optional($buku->profilIbu)->nik ?? '-' }}</span>
                                                <span class="badge bg-secondary-subtle text-secondary small mt-1" style="font-size: 10px;">
                                                    <i class="bi bi-hospital me-1"></i>{{ optional($buku->fasilitasKesehatan)->nama_faskes ?? '-' }}
                                                </span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="small d-block"><strong>Ibu:</strong> {{ $buku->no_reg_kohort_ibu ?? '-' }}</span>
                                        <span class="small d-block"><strong>Bayi:</strong> {{ $buku->no_reg_kohort_bayi ?? '-' }}</span>
                                        <span class="small d-block"><strong>Balita:</strong> {{ $buku->no_reg_kohort_balita ?? '-' }}</span>
                                    </td>
                                    <td>
                                        <span class="fw-semibold text-dark small d-block">
                                            {{ $buku->diterbitkan_pada ? \Carbon\Carbon::parse($buku->diterbitkan_pada)->translatedFormat('d F Y') : '-' }}
                                        </span>
                                        <span class="text-muted small d-block"><i class="bi bi-person-check me-1"></i> {{ $buku->diterbitkan_oleh ?? '-' }}</span>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-inline-flex flex-column gap-1">
                                            <span class="badge bg-primary-subtle text-primary fw-bold" style="font-size: 10px; padding: 4px 8px;">
                                                <i class="bi bi-clipboard2-pulse me-1"></i>{{ $buku->kunjunganAncs->count() }} ANC
                                            </span>
                                            <span class="badge bg-info-subtle text-info fw-bold" style="font-size: 10px; padding: 4px 8px;">
                                                <i class="bi bi-shield-heart me-1"></i>{{ $buku->pemantauanNifas->count() }} KF Nifas
                                            </span>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        @if($buku->status === 'Aktif')
                                            <span class="badge bg-success text-white badge-custom"><i class="bi bi-check-circle me-1"></i>Aktif</span>
                                        @elseif($buku->status === 'Selesai')
                                            <span class="badge bg-primary text-white badge-custom"><i class="bi bi-award-fill me-1"></i>Selesai</span>
                                        @else
                                            <span class="badge bg-secondary text-white badge-custom"><i class="bi bi-x-circle me-1"></i>Non-Aktif</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('buku-kia.show', $buku->id) }}" class="btn btn-sm btn-info text-white rounded-pill px-3 fw-bold">
                                            <i class="bi bi-eye me-1"></i> Detail
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5 text-muted">
                                        <i class="bi bi-journals fs-1 mb-2"></i>
                                        <p class="mb-0 fw-semibold">Tidak ditemukan buku KIA yang sesuai.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Custom Pagination Links -->
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div class="text-secondary small">
                        Showing {{ $bukuKiaList->firstItem() ?? 0 }} to {{ $bukuKiaList->lastItem() ?? 0 }} of {{ $bukuKiaList->total() }} entries
                    </div>
                    <div>
                        <nav aria-label="Page navigation">
                            <ul class="pagination pagination-sm mb-0">
                                {{-- Previous Page Link --}}
                                @if ($bukuKiaList->onFirstPage())
                                    <li class="page-item disabled"><span class="page-link">&laquo;</span></li>
                                    <li class="page-item disabled"><span class="page-link">&lsaquo;</span></li>
                                @else
                                    <li class="page-item"><a class="page-link text-primary" href="{{ $bukuKiaList->url(1) }}" aria-label="First">&laquo;</a></li>
                                    <li class="page-item"><a class="page-link text-primary" href="{{ $bukuKiaList->previousPageUrl() }}" aria-label="Previous">&lsaquo;</a></li>
                                @endif

                                {{-- Pagination Elements --}}
                                @foreach ($bukuKiaList->getUrlRange(max(1, $bukuKiaList->currentPage() - 2), min($bukuKiaList->lastPage(), $bukuKiaList->currentPage() + 2)) as $page => $url)
                                    @if ($page == $bukuKiaList->currentPage())
                                        <li class="page-item active" aria-current="page"><span class="page-link bg-primary border-primary text-white">{{ $page }}</span></li>
                                    @else
                                        <li class="page-item"><a class="page-link text-primary" href="{{ $url }}">{{ $page }}</a></li>
                                    @endif
                                @endforeach

                                {{-- Next Page Link --}}
                                @if ($bukuKiaList->hasMorePages())
                                    <li class="page-item"><a class="page-link text-primary" href="{{ $bukuKiaList->nextPageUrl() }}" aria-label="Next">&rsaquo;</a></li>
                                    <li class="page-item"><a class="page-link text-primary" href="{{ $bukuKiaList->url($bukuKiaList->lastPage()) }}" aria-label="Last">&raquo;</a></li>
                                @else
                                    <li class="page-item disabled"><span class="page-link">&rsaquo;</span></li>
                                    <li class="page-item disabled"><span class="page-link">&raquo;</span></li>
                                @endif
                            </ul>
                        </nav>
                    </div>
                </div>

            </div>
        </div>

    </div>
</section>
@endsection
