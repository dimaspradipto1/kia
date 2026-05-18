@extends('layouts.dashboard.template')

@section('content')
    <div class="pagetitle">
        <h1>Detail Profil Anak</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('profil-anak.index') }}">Profil Anak</a></li>
                <li class="breadcrumb-item active">Detail</li>
            </ol>
        </nav>
    </div>

    <section class="section profile">
        <div class="row">
            {{-- Kartu Profil Kiri --}}
            <div class="col-xl-4">
                <div class="card shadow-sm border-0" style="border-radius: 12px; border-top: 5px solid #EC1E88 !important;">
                    <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                        <div class="d-flex align-items-center justify-content-center mb-3" style="width:100px;height:100px;border-radius:50%;background:#fce4f1;">
                            <i class="bi bi-person-hearts" style="font-size:3rem;color:#EC1E88;"></i>
                        </div>
                        <h2 class="fw-bold text-center">{{ $profilAnak->nama_lengkap }}</h2>
                        <h3 class="text-muted">Anak Ke-{{ $profilAnak->anak_ke }}</h3>
                        <p class="badge" style="background-color:#EC1E88;">{{ $profilAnak->jenis_kelamin }}</p>

                        <hr class="w-100 my-3">

                        {{-- Status Bayi Baru Lahir --}}
                        @if ($profilAnak->bayiBaruLahir)
                            <div class="w-100 text-center">
                                <span class="badge px-3 py-2 fw-semibold" style="background:linear-gradient(135deg,#0d6efd,#0a58ca); border-radius:20px; font-size:0.8rem;">
                                    <i class="bi bi-baby me-1"></i> Data BBL Tercatat
                                </span>
                                @php
                                    $kondisi = $profilAnak->bayiBaruLahir->kondisi_umum;
                                    $kondisiColor = match(strtolower($kondisi)) {
                                        'baik'   => 'success',
                                        'sedang' => 'warning',
                                        'buruk'  => 'danger',
                                        default  => 'secondary',
                                    };
                                @endphp
                                <div class="mt-2">
                                    <span class="badge bg-{{ $kondisiColor }}-subtle text-{{ $kondisiColor }} px-3 py-2 fw-semibold" style="border-radius:15px;">
                                        Kondisi: {{ $kondisi }}
                                    </span>
                                </div>
                            </div>
                        @else
                            <div class="w-100 text-center">
                                <span class="badge bg-secondary-subtle text-secondary px-3 py-2 fw-semibold" style="border-radius:20px; font-size:0.8rem;">
                                    <i class="bi bi-exclamation-circle me-1"></i> Data BBL Belum Ada
                                </span>
                                <div class="mt-2">
                                    <a href="{{ route('bayi-baru-lahir.create', ['profil_anak_id' => $profilAnak->id]) }}"
                                       class="btn btn-sm text-white" style="background:linear-gradient(135deg,#0d6efd,#0a58ca); border-radius:20px;">
                                        <i class="bi bi-plus-circle me-1"></i> Catat Sekarang
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Konten Kanan --}}
            <div class="col-xl-8">
                <div class="card shadow-sm border-0" style="border-radius: 12px;">
                    <div class="card-body pt-3">
                        <ul class="nav nav-tabs nav-tabs-bordered">
                            <li class="nav-item">
                                <button class="nav-link active fw-bold" data-bs-toggle="tab" data-bs-target="#profile-overview">
                                    <i class="bi bi-person-lines-fill me-1"></i> Informasi Detail
                                </button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link fw-bold" data-bs-toggle="tab" data-bs-target="#tab-bbl">
                                    <i class="bi bi-baby me-1"></i> Bayi Baru Lahir
                                    @if ($profilAnak->bayiBaruLahir)
                                        <span class="badge bg-primary ms-1" style="font-size:0.65rem;">✓</span>
                                    @else
                                        <span class="badge bg-secondary ms-1" style="font-size:0.65rem;">-</span>
                                    @endif
                                </button>
                            </li>
                        </ul>

                        <div class="tab-content pt-3">
                            {{-- Tab 1: Informasi Detail --}}
                            <div class="tab-pane fade show active profile-overview" id="profile-overview">
                                <h5 class="card-title fw-bold">Data Anak</h5>

                                <div class="row mb-3">
                                    <div class="col-lg-3 col-md-4 label fw-bold text-muted">Nama Ibu</div>
                                    <div class="col-lg-9 col-md-8">{{ optional(optional($profilAnak->bukuKia)->profilIbu)->nama_lengkap ?? '-' }}</div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-lg-3 col-md-4 label fw-bold text-muted">Tempat, Tgl Lahir</div>
                                    <div class="col-lg-9 col-md-8">{{ $profilAnak->tempat_lahir }}, {{ \Carbon\Carbon::parse($profilAnak->tanggal_lahir)->translatedFormat('d F Y') }}</div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-lg-3 col-md-4 label fw-bold text-muted">Golongan Darah</div>
                                    <div class="col-lg-9 col-md-8">{{ $profilAnak->golongan_darah ?? '-' }}</div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-lg-3 col-md-4 label fw-bold text-muted">Berat Lahir</div>
                                    <div class="col-lg-9 col-md-8">{{ $profilAnak->berat_lahir_kg ? $profilAnak->berat_lahir_kg . ' kg' : '-' }}</div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-lg-3 col-md-4 label fw-bold text-muted">Panjang Lahir</div>
                                    <div class="col-lg-9 col-md-8">{{ $profilAnak->panjang_lahir_cm ? $profilAnak->panjang_lahir_cm . ' cm' : '-' }}</div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-lg-3 col-md-4 label fw-bold text-muted">No. Akta Kelahiran</div>
                                    <div class="col-lg-9 col-md-8">{{ $profilAnak->nomor_akta_kelahiran ?? '-' }}</div>
                                </div>
                            </div>

                            {{-- Tab 2: Bayi Baru Lahir --}}
                            <div class="tab-pane fade" id="tab-bbl">
                                @if ($profilAnak->bayiBaruLahir)
                                    @php $bbl = $profilAnak->bayiBaruLahir; @endphp

                                    {{-- Header Kondisi --}}
                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                        <h5 class="card-title fw-bold mb-0">
                                            <i class="bi bi-baby text-primary me-1"></i> Rekam Medis Bayi Baru Lahir
                                        </h5>
                                        <div class="d-flex gap-2">
                                            @php
                                                $k = $bbl->kondisi_umum;
                                                $kc = match(strtolower($k)) { 'baik'=>'success','sedang'=>'warning','buruk'=>'danger', default=>'secondary' };
                                            @endphp
                                            <span class="badge bg-{{ $kc }}-subtle text-{{ $kc }} px-3 py-2 fw-semibold" style="border-radius:15px; font-size:0.85rem;">
                                                Kondisi Umum: {{ $k }}
                                            </span>
                                            <a href="{{ route('bayi-baru-lahir.edit', $bbl->id) }}"
                                               class="btn btn-sm btn-warning text-white">
                                                <i class="bi bi-pencil-square me-1"></i> Edit
                                            </a>
                                        </div>
                                    </div>

                                    <div class="row g-3">
                                        {{-- Imunisasi Awal --}}
                                        <div class="col-md-6">
                                            <div class="card border-0 shadow-sm h-100" style="border-radius:10px; border-left:4px solid #16B3AC !important;">
                                                <div class="card-body p-3">
                                                    <h6 class="fw-bold text-dark mb-3">
                                                        <i class="bi bi-shield-plus text-teal me-1"></i> Imunisasi Awal
                                                    </h6>

                                                    {{-- HB0 --}}
                                                    <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom">
                                                        <span class="fw-semibold small text-muted">Imunisasi HB0</span>
                                                        @if ($bbl->hb0_diberikan)
                                                            <div class="text-end">
                                                                <span class="badge bg-success-subtle text-success">✓ Diberikan</span>
                                                                @if ($bbl->hb0_waktu)
                                                                    <div class="text-muted" style="font-size:0.75rem;">{{ \Carbon\Carbon::createFromFormat('H:i:s', $bbl->hb0_waktu)->format('H:i') }} WIB</div>
                                                                @endif
                                                            </div>
                                                        @else
                                                            <span class="badge bg-danger-subtle text-danger">✗ Tidak</span>
                                                        @endif
                                                    </div>

                                                    {{-- Vitamin K1 --}}
                                                    <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom">
                                                        <span class="fw-semibold small text-muted">Vitamin K1</span>
                                                        @if ($bbl->vit_k1_diberikan)
                                                            <span class="badge bg-success-subtle text-success">✓ Diberikan</span>
                                                        @else
                                                            <span class="badge bg-danger-subtle text-danger">✗ Tidak</span>
                                                        @endif
                                                    </div>

                                                    {{-- Salep Mata --}}
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <span class="fw-semibold small text-muted">Salep Mata</span>
                                                        @if ($bbl->salep_mata_diberikan)
                                                            <span class="badge bg-success-subtle text-success">✓ Diberikan</span>
                                                        @else
                                                            <span class="badge bg-danger-subtle text-danger">✗ Tidak</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Skrining --}}
                                        <div class="col-md-6">
                                            <div class="card border-0 shadow-sm h-100" style="border-radius:10px; border-left:4px solid #EC1E88 !important;">
                                                <div class="card-body p-3">
                                                    <h6 class="fw-bold text-dark mb-3">
                                                        <i class="bi bi-activity text-pink me-1"></i> Skrining Bayi
                                                    </h6>

                                                    {{-- SHK --}}
                                                    <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom">
                                                        <span class="fw-semibold small text-muted">Skrining Hipotiroid (SHK)</span>
                                                        @if ($bbl->shk_dilakukan)
                                                            <div class="text-end">
                                                                <span class="badge bg-success-subtle text-success">✓ Dilakukan</span>
                                                                @if ($bbl->shk_waktu)
                                                                    <div class="text-muted" style="font-size:0.75rem;">{{ \Carbon\Carbon::createFromFormat('H:i:s', $bbl->shk_waktu)->format('H:i') }} WIB</div>
                                                                @endif
                                                                @if ($bbl->shk_hasil)
                                                                    <div class="text-dark small fw-semibold">Hasil: {{ $bbl->shk_hasil }}</div>
                                                                @endif
                                                            </div>
                                                        @else
                                                            <span class="badge bg-secondary-subtle text-secondary">— Tidak Dilakukan</span>
                                                        @endif
                                                    </div>

                                                    {{-- PJB --}}
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <span class="fw-semibold small text-muted">Deteksi PJB</span>
                                                        @if ($bbl->pjb_dilakukan)
                                                            <div class="text-end">
                                                                <span class="badge bg-success-subtle text-success">✓ Dilakukan</span>
                                                                @if ($bbl->pjb_hasil)
                                                                    <div class="text-dark small fw-semibold">Hasil: {{ $bbl->pjb_hasil }}</div>
                                                                @endif
                                                            </div>
                                                        @else
                                                            <span class="badge bg-secondary-subtle text-secondary">— Tidak Dilakukan</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Tenaga Kesehatan --}}
                                        <div class="col-12">
                                            <div class="card border-0 shadow-sm" style="border-radius:10px; background:linear-gradient(135deg,#EFF6FF,#DBEAFE);">
                                                <div class="card-body p-3 d-flex align-items-center gap-3">
                                                    <div class="d-flex align-items-center justify-content-center flex-shrink-0"
                                                         style="width:48px;height:48px;border-radius:50%;background:white;">
                                                        <i class="bi bi-person-badge-fill text-primary" style="font-size:1.4rem;"></i>
                                                    </div>
                                                    <div>
                                                        <div class="text-muted small fw-semibold">Dicatat oleh Tenaga Kesehatan</div>
                                                        <div class="fw-bold text-dark">{{ $bbl->nakes->name ?? '-' }}</div>
                                                        <div class="text-muted small">Dicatat: {{ $bbl->created_at->translatedFormat('d F Y, H:i') }} WIB</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    {{-- Kosong --}}
                                    <div class="text-center py-5">
                                        <div class="d-flex align-items-center justify-content-center mb-3 mx-auto"
                                             style="width:80px;height:80px;border-radius:50%;background:#EFF6FF;">
                                            <i class="bi bi-baby" style="font-size:2.2rem;color:#0d6efd;"></i>
                                        </div>
                                        <h5 class="fw-bold text-dark mb-1">Data Bayi Baru Lahir Belum Ada</h5>
                                        <p class="text-muted mb-4">Belum ada data pemeriksaan bayi baru lahir yang dicatat untuk <strong>{{ $profilAnak->nama_lengkap }}</strong>.</p>
                                        <a href="{{ route('bayi-baru-lahir.create', ['profil_anak_id' => $profilAnak->id]) }}"
                                           class="btn text-white px-4" style="background:linear-gradient(135deg,#0d6efd,#0a58ca); border-radius:30px; font-weight:600;">
                                            <i class="bi bi-plus-circle me-1"></i> Catat Sekarang
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="card-footer bg-white border-0 p-4 pt-0">
                        <a href="{{ route('profil-anak.edit', $profilAnak->id) }}" class="btn text-white px-4" style="background-color: #EC1E88; border-radius: 8px;">Edit Data</a>
                        <a href="{{ route('profil-anak.index') }}" class="btn btn-secondary px-4" style="border-radius: 8px;">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
        .text-pink { color: #EC1E88 !important; }
        .text-teal { color: #16B3AC !important; }
    </style>
@endsection
