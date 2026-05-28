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
            <div class="col-xl-3">
                <div class="card shadow-sm border-0" style="border-radius: 12px; border-top: 5px solid #EC1E88 !important;">
                    <div class="card-body profile-card pt-3 d-flex flex-column align-items-center">
                        <div class="d-flex align-items-center justify-content-center mb-2" style="width:72px;height:72px;border-radius:50%;background:#fce4f1;">
                            <i class="bi bi-person-hearts" style="font-size:2rem;color:#EC1E88;"></i>
                        </div>
                        <h5 class="fw-bold text-center mb-0">{{ $profilAnak->nama_lengkap }}</h5>
                        <p class="text-muted small mb-1">Anak Ke-{{ $profilAnak->anak_ke }}</p>
                        <span class="badge small" style="background-color:#EC1E88;">{{ $profilAnak->jenis_kelamin }}</span>

                        <hr class="w-100 my-3">

                        {{-- Status Bayi Baru Lahir --}}
                        @if ($profilAnak->bayiBaruLahir)
                            <div class="w-100 text-center">
                                <span class="badge px-3 py-2 fw-semibold" style="background:linear-gradient(135deg,#0d6efd,#0a58ca); border-radius:20px; font-size:0.8rem;">
                                    <i class="bi bi-emoji-smile me-1"></i> Data BBL Tercatat
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
            <div class="col-xl-9">
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
                                    <i class="bi bi-emoji-smile me-1"></i> Bayi Baru Lahir
                                    @if ($profilAnak->bayiBaruLahir)
                                        <span class="badge bg-primary ms-1" style="font-size:0.65rem;">✓</span>
                                    @else
                                        <span class="badge bg-secondary ms-1" style="font-size:0.65rem;">-</span>
                                    @endif
                                </button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link fw-bold" data-bs-toggle="tab" data-bs-target="#tab-imunisasi">
                                    <i class="bi bi-shield-plus me-1"></i> Imunisasi
                                    @if ($profilAnak->imunisasiAnaks->count() > 0)
                                        <span class="badge ms-1 text-white" style="background:#16a34a; font-size:0.65rem;">{{ $profilAnak->imunisasiAnaks->count() }}</span>
                                    @else
                                        <span class="badge bg-secondary ms-1" style="font-size:0.65rem;">0</span>
                                    @endif
                                </button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link fw-bold" data-bs-toggle="tab" data-bs-target="#tab-tumbuh-kembang">
                                    <i class="bi bi-bar-chart-line me-1"></i> Tumbuh Kembang
                                    @if ($profilAnak->tumbuhKembangs->count() > 0)
                                        <span class="badge ms-1 text-white" style="background:#ea580c; font-size:0.65rem;">{{ $profilAnak->tumbuhKembangs->count() }}</span>
                                    @else
                                        <span class="badge bg-secondary ms-1" style="font-size:0.65rem;">0</span>
                                    @endif
                                </button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link fw-bold" data-bs-toggle="tab" data-bs-target="#tab-sidtk">
                                    <i class="bi bi-puzzle-fill me-1"></i> SIDTK
                                    @if ($profilAnak->perkembanganSidtks->count() > 0)
                                        <span class="badge ms-1 text-white" style="background:#7c3aed; font-size:0.65rem;">{{ $profilAnak->perkembanganSidtks->count() }}</span>
                                    @else
                                        <span class="badge bg-secondary ms-1" style="font-size:0.65rem;">0</span>
                                    @endif
                                </button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link fw-bold" data-bs-toggle="tab" data-bs-target="#tab-mpasi">
                                    <i class="bi bi-egg-fried me-1"></i> MPASI
                                    @if ($profilAnak->mpasis->count() > 0)
                                        <span class="badge ms-1 text-white" style="background:#16a34a; font-size:0.65rem;">{{ $profilAnak->mpasis->count() }}</span>
                                    @else
                                        <span class="badge bg-secondary ms-1" style="font-size:0.65rem;">0</span>
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
                                            <i class="bi bi-emoji-smile-fill text-primary me-1"></i> Rekam Medis Bayi Baru Lahir
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
                                            <i class="bi bi-emoji-smile-fill" style="font-size:2.2rem;color:#0d6efd;"></i>
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
                            {{-- Tab 3: Imunisasi Anak --}}
                            <div class="tab-pane fade" id="tab-imunisasi">
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <h5 class="card-title fw-bold mb-0">
                                        <i class="bi bi-shield-plus text-success me-1"></i> Riwayat Imunisasi
                                    </h5>
                                    <a href="{{ route('imunisasi-anak.create', ['profil_anak_id' => $profilAnak->id]) }}"
                                       class="btn btn-sm text-white fw-semibold"
                                       style="background:linear-gradient(135deg,#16a34a,#15803d); border-radius:20px;">
                                        <i class="bi bi-plus-circle me-1"></i> Tambah Imunisasi
                                    </a>
                                </div>

                                @if ($profilAnak->imunisasiAnaks->count() > 0)
                                    @php
                                        $vaccineColors = [
                                            'BCG'=>'#8B5CF6','Hepatitis B'=>'#0d6efd','Polio'=>'#16B3AC',
                                            'DPT-HB-HIB'=>'#EC1E88','Campak'=>'#F59E0B','MMR'=>'#10B981',
                                            'HIB'=>'#EF4444','PCV'=>'#6366F1','Rotavirus'=>'#F97316',
                                            'Varisela'=>'#84CC16',
                                        ];
                                    @endphp
                                    <div class="table-responsive">
                                        <table class="table table-hover align-middle" style="font-size:0.88rem;">
                                            <thead style="background:#F0FFF4;">
                                                <tr>
                                                    <th style="color:#16a34a; font-weight:700; border-bottom:2px solid #16a34a; padding:10px 12px;">No</th>
                                                    <th style="color:#16a34a; font-weight:700; border-bottom:2px solid #16a34a; padding:10px 12px;">Jenis & Dosis</th>
                                                    <th style="color:#16a34a; font-weight:700; border-bottom:2px solid #16a34a; padding:10px 12px;">Tanggal</th>
                                                    <th style="color:#16a34a; font-weight:700; border-bottom:2px solid #16a34a; padding:10px 12px;">Faskes</th>
                                                    <th style="color:#16a34a; font-weight:700; border-bottom:2px solid #16a34a; padding:10px 12px;">Efek Samping</th>
                                                    <th style="color:#16a34a; font-weight:700; border-bottom:2px solid #16a34a; padding:10px 12px; text-align:center;">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($profilAnak->imunisasiAnaks->sortBy('tanggal_pemberian') as $i => $imun)
                                                    @php
                                                        $warna = $vaccineColors[$imun->jenis_imunisasi] ?? '#6c757d';
                                                        $es = $imun->efek_samping;
                                                        $esBadge = ($es === 'Tidak Ada' || !$es)
                                                            ? '<span class="badge bg-success-subtle text-success">Tidak Ada</span>'
                                                            : '<span class="badge bg-warning-subtle text-warning">' . e($es) . '</span>';
                                                    @endphp
                                                    <tr style="border-bottom:1px solid #DCFCE7;">
                                                        <td class="fw-semibold text-muted">{{ $i + 1 }}</td>
                                                        <td>
                                                            <span class="badge px-2 py-1 text-white fw-semibold" style="border-radius:12px; background:{{ $warna }};">
                                                                {{ $imun->jenis_imunisasi }}
                                                            </span>
                                                            <div class="text-muted small mt-1">Dosis ke-{{ $imun->dosis_ke }}</div>
                                                        </td>
                                                        <td class="text-dark">{{ $imun->tanggal_pemberian->translatedFormat('d M Y') }}</td>
                                                        <td class="text-muted small">{{ $imun->fasilitasKesehatan->nama_faskes ?? '-' }}</td>
                                                        <td>{!! $esBadge !!}</td>
                                                        <td class="text-center">
                                                            <a href="{{ route('imunisasi-anak.edit', $imun->id) }}" class="btn btn-warning btn-sm text-white" title="Edit">
                                                                <i class="bi bi-pencil-square"></i>
                                                            </a>
                                                            <button type="button" class="btn btn-danger btn-sm btn-delete-imun" data-id="{{ $imun->id }}" title="Hapus">
                                                                <i class="bi bi-trash"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <div class="text-center py-5">
                                        <div class="d-flex align-items-center justify-content-center mb-3 mx-auto"
                                             style="width:80px;height:80px;border-radius:50%;background:#F0FFF4;">
                                            <i class="bi bi-shield-plus" style="font-size:2.2rem;color:#16a34a;"></i>
                                        </div>
                                        <h5 class="fw-bold text-dark mb-1">Belum Ada Riwayat Imunisasi</h5>
                                        <p class="text-muted mb-4">Belum ada data imunisasi yang dicatat untuk <strong>{{ $profilAnak->nama_lengkap }}</strong>.</p>
                                        <a href="{{ route('imunisasi-anak.create', ['profil_anak_id' => $profilAnak->id]) }}"
                                           class="btn text-white px-4" style="background:linear-gradient(135deg,#16a34a,#15803d); border-radius:30px; font-weight:600;">
                                            <i class="bi bi-plus-circle me-1"></i> Catat Imunisasi Pertama
                                        </a>
                                    </div>
                                @endif
                            </div>

                            {{-- Tab 4: Tumbuh Kembang --}}
                            <div class="tab-pane fade" id="tab-tumbuh-kembang">
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <h5 class="card-title fw-bold mb-0">
                                        <i class="bi bi-bar-chart-line me-1" style="color:#ea580c;"></i> Riwayat Tumbuh Kembang
                                    </h5>
                                    <a href="{{ route('tumbuh-kembang.create', ['profil_anak_id' => $profilAnak->id]) }}"
                                       class="btn btn-sm text-white fw-semibold"
                                       style="background:linear-gradient(135deg,#ea580c,#c2410c); border-radius:20px;">
                                        <i class="bi bi-plus-circle me-1"></i> Tambah Pengukuran
                                    </a>
                                </div>

                                @if ($profilAnak->tumbuhKembangs->count() > 0)
                                    @php
                                        $tks = $profilAnak->tumbuhKembangs->sortBy('tanggal_ukur');
                                        $colorMap = [
                                            'Gizi Baik'   => ['bg'=>'success','lbl'=>'Baik'],
                                            'Normal'      => ['bg'=>'success','lbl'=>'Normal'],
                                            'Gizi Kurang' => ['bg'=>'warning','lbl'=>'Kurang'],
                                            'Pendek'      => ['bg'=>'warning','lbl'=>'Pendek'],
                                            'Gizi Buruk'  => ['bg'=>'danger', 'lbl'=>'Buruk'],
                                            'Sangat Pendek'=>['bg'=>'danger', 'lbl'=>'Sangat Pendek'],
                                            'Gizi Lebih'  => ['bg'=>'info',   'lbl'=>'Lebih'],
                                            'Tinggi'      => ['bg'=>'info',   'lbl'=>'Tinggi'],
                                            'Obesitas'    => ['bg'=>'danger', 'lbl'=>'Obesitas'],
                                        ];
                                    @endphp

                                    {{-- Ringkasan Pengukuran Terbaru --}}
                                    @php $latest = $tks->last(); @endphp
                                    <div class="row g-3 mb-4">
                                        <div class="col-6 col-md-3">
                                            <div class="card border-0 shadow-sm text-center p-3" style="border-radius:10px; background:linear-gradient(135deg,#FFF7ED,#FED7AA);">
                                                <div class="fw-bold fs-4" style="color:#ea580c;">{{ $latest->berat_badan }} kg</div>
                                                <div class="text-muted small">Berat Badan</div>
                                            </div>
                                        </div>
                                        <div class="col-6 col-md-3">
                                            <div class="card border-0 shadow-sm text-center p-3" style="border-radius:10px; background:linear-gradient(135deg,#EFF6FF,#DBEAFE);">
                                                <div class="fw-bold fs-4 text-primary">{{ $latest->tinggi_badan }} cm</div>
                                                <div class="text-muted small">Tinggi Badan</div>
                                            </div>
                                        </div>
                                        <div class="col-6 col-md-3">
                                            <div class="card border-0 shadow-sm text-center p-3" style="border-radius:10px; background:linear-gradient(135deg,#F0FFF4,#DCFCE7);">
                                                <div class="fw-bold fs-4 text-success">{{ $latest->usia_bulan }} bln</div>
                                                <div class="text-muted small">Usia Saat Ukur</div>
                                            </div>
                                        </div>
                                        <div class="col-6 col-md-3">
                                            @php
                                                $st = $latest->status_stunting;
                                                $stc = $st && str_contains(strtolower($st), 'stunting') ? 'danger' : 'success';
                                            @endphp
                                            <div class="card border-0 shadow-sm text-center p-3" style="border-radius:10px; background:linear-gradient(135deg,#FFF1F2,#FFE4E6);">
                                                <div class="fw-bold fs-6 text-{{ $stc }} mt-1">{{ $st ?? 'Tidak Dicatat' }}</div>
                                                <div class="text-muted small">Status Stunting</div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Tabel Riwayat --}}
                                    <div class="table-responsive">
                                        <table class="table table-hover align-middle" style="font-size:0.87rem;">
                                            <thead style="background:#FFF7ED;">
                                                <tr>
                                                    <th style="color:#ea580c; font-weight:700; border-bottom:2px solid #ea580c; padding:10px 12px;">No</th>
                                                    <th style="color:#ea580c; font-weight:700; border-bottom:2px solid #ea580c; padding:10px 12px;">Tanggal & Usia</th>
                                                    <th style="color:#ea580c; font-weight:700; border-bottom:2px solid #ea580c; padding:10px 12px;">BB / TB</th>
                                                    <th style="color:#ea580c; font-weight:700; border-bottom:2px solid #ea580c; padding:10px 12px;">LK / LiLA</th>
                                                    <th style="color:#ea580c; font-weight:700; border-bottom:2px solid #ea580c; padding:10px 12px;">Status Gizi</th>
                                                    <th style="color:#ea580c; font-weight:700; border-bottom:2px solid #ea580c; padding:10px 12px;">Stunting</th>
                                                    <th style="color:#ea580c; font-weight:700; border-bottom:2px solid #ea580c; padding:10px 12px; text-align:center;">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($tks as $i => $tk)
                                                    @php
                                                        $bbU = $colorMap[$tk->status_gizi_bb_u] ?? ['bg'=>'secondary','lbl'=>$tk->status_gizi_bb_u];
                                                        $tbU = $colorMap[$tk->status_gizi_tb_u] ?? ['bg'=>'secondary','lbl'=>$tk->status_gizi_tb_u];
                                                        $bbTb = $colorMap[$tk->status_gizi_bb_tb] ?? ['bg'=>'secondary','lbl'=>$tk->status_gizi_bb_tb];
                                                        $stc2 = $tk->status_stunting && str_contains(strtolower($tk->status_stunting), 'stunting') ? 'danger' : 'success';
                                                    @endphp
                                                    <tr style="border-bottom:1px solid #FED7AA;">
                                                        <td class="fw-semibold text-muted">{{ $i + 1 }}</td>
                                                        <td>
                                                            <div class="fw-semibold">{{ $tk->tanggal_ukur->translatedFormat('d M Y') }}</div>
                                                            <div class="text-muted small"><i class="bi bi-clock me-1"></i>{{ $tk->usia_bulan }} bulan</div>
                                                        </td>
                                                        <td>
                                                            <div class="fw-bold" style="color:#ea580c;">{{ $tk->berat_badan }} kg</div>
                                                            <div class="text-muted small">{{ $tk->tinggi_badan }} cm</div>
                                                        </td>
                                                        <td class="text-muted small">
                                                            {{ $tk->lingkar_kepala ? $tk->lingkar_kepala . ' cm' : '-' }}<br>
                                                            {{ $tk->lila_cm ? $tk->lila_cm . ' cm' : '-' }}
                                                        </td>
                                                        <td>
                                                            <div class="d-flex flex-column gap-1">
                                                                <span class="badge bg-{{ $bbU['bg'] }}-subtle text-{{ $bbU['bg'] }} px-1" style="font-size:0.7rem;">BB/U: {{ $bbU['lbl'] }}</span>
                                                                <span class="badge bg-{{ $tbU['bg'] }}-subtle text-{{ $tbU['bg'] }} px-1" style="font-size:0.7rem;">TB/U: {{ $tbU['lbl'] }}</span>
                                                                <span class="badge bg-{{ $bbTb['bg'] }}-subtle text-{{ $bbTb['bg'] }} px-1" style="font-size:0.7rem;">BB/TB: {{ $bbTb['lbl'] }}</span>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            @if ($tk->status_stunting)
                                                                <span class="badge bg-{{ $stc2 }}-subtle text-{{ $stc2 }}" style="font-size:0.75rem;">{{ $tk->status_stunting }}</span>
                                                            @else
                                                                <span class="text-muted small">-</span>
                                                            @endif
                                                        </td>
                                                        <td class="text-center">
                                                            <a href="{{ route('tumbuh-kembang.edit', $tk->id) }}" class="btn btn-warning btn-sm text-white" title="Edit">
                                                                <i class="bi bi-pencil-square"></i>
                                                            </a>
                                                            <button type="button" class="btn btn-danger btn-sm btn-delete-tk" data-id="{{ $tk->id }}" title="Hapus">
                                                                <i class="bi bi-trash"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <div class="text-center py-5">
                                        <div class="d-flex align-items-center justify-content-center mb-3 mx-auto"
                                             style="width:80px;height:80px;border-radius:50%;background:#FFF7ED;">
                                            <i class="bi bi-bar-chart-line" style="font-size:2.2rem;color:#ea580c;"></i>
                                        </div>
                                        <h5 class="fw-bold text-dark mb-1">Belum Ada Data Tumbuh Kembang</h5>
                                        <p class="text-muted mb-4">Belum ada pengukuran tumbuh kembang untuk <strong>{{ $profilAnak->nama_lengkap }}</strong>.</p>
                                        <a href="{{ route('tumbuh-kembang.create', ['profil_anak_id' => $profilAnak->id]) }}"
                                           class="btn text-white px-4" style="background:linear-gradient(135deg,#ea580c,#c2410c); border-radius:30px; font-weight:600;">
                                            <i class="bi bi-plus-circle me-1"></i> Catat Pengukuran Pertama
                                        </a>
                                    </div>
                                @endif
                            </div>

                            {{-- Tab 5: SIDTK --}}
                            <div class="tab-pane fade" id="tab-sidtk">
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <h5 class="card-title fw-bold mb-0">
                                        <i class="bi bi-puzzle-fill me-1" style="color:#7c3aed;"></i> Riwayat Perkembangan SIDTK
                                    </h5>
                                    <a href="{{ route('perkembangan-sidtk.create', ['profil_anak_id' => $profilAnak->id]) }}"
                                       class="btn btn-sm text-white fw-semibold"
                                       style="background:linear-gradient(135deg,#7c3aed,#6d28d9); border-radius:20px;">
                                        <i class="bi bi-plus-circle me-1"></i> Tambah Skrining
                                    </a>
                                </div>

                                @if ($profilAnak->perkembanganSidtks->count() > 0)
                                    @php
                                        $sidtks = $profilAnak->perkembanganSidtks->sortBy('tanggal_skrining');
                                        $domainColors = [
                                            'Gerak Kasar'              => '#0d6efd',
                                            'Gerak Halus'              => '#16B3AC',
                                            'Bicara & Bahasa'          => '#8B5CF6',
                                            'Sosialisasi & Kemandirian'=> '#EC1E88',
                                            'Kognitif'                 => '#F59E0B',
                                        ];
                                        $sesuai   = $sidtks->where('hasil','Sesuai')->count();
                                        $meragukan= $sidtks->where('hasil','Meragukan')->count();
                                        $menyimpang= $sidtks->where('hasil','Penyimpangan')->count();
                                    @endphp

                                    {{-- Ringkasan --}}
                                    <div class="row g-3 mb-4">
                                        <div class="col-4">
                                            <div class="card border-0 shadow-sm text-center p-3" style="border-radius:10px; background:linear-gradient(135deg,#F0FFF4,#DCFCE7);">
                                                <div class="fw-bold fs-4 text-success">{{ $sesuai }}</div>
                                                <div class="text-muted small"><i class="bi bi-check-circle me-1"></i>Sesuai</div>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="card border-0 shadow-sm text-center p-3" style="border-radius:10px; background:linear-gradient(135deg,#FFFBEB,#FEF3C7);">
                                                <div class="fw-bold fs-4 text-warning">{{ $meragukan }}</div>
                                                <div class="text-muted small"><i class="bi bi-exclamation-circle me-1"></i>Meragukan</div>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="card border-0 shadow-sm text-center p-3" style="border-radius:10px; background:linear-gradient(135deg,#FFF1F2,#FFE4E6);">
                                                <div class="fw-bold fs-4 text-danger">{{ $menyimpang }}</div>
                                                <div class="text-muted small"><i class="bi bi-x-circle me-1"></i>Penyimpangan</div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="table-responsive">
                                        <table class="table table-hover align-middle" style="font-size:0.87rem;">
                                            <thead style="background:#F5F3FF;">
                                                <tr>
                                                    <th style="color:#7c3aed; font-weight:700; border-bottom:2px solid #7c3aed; padding:10px 12px;">No</th>
                                                    <th style="color:#7c3aed; font-weight:700; border-bottom:2px solid #7c3aed; padding:10px 12px;">Tanggal & Usia</th>
                                                    <th style="color:#7c3aed; font-weight:700; border-bottom:2px solid #7c3aed; padding:10px 12px;">Domain</th>
                                                    <th style="color:#7c3aed; font-weight:700; border-bottom:2px solid #7c3aed; padding:10px 12px;">Hasil</th>
                                                    <th style="color:#7c3aed; font-weight:700; border-bottom:2px solid #7c3aed; padding:10px 12px;">Tindak Lanjut</th>
                                                    <th style="color:#7c3aed; font-weight:700; border-bottom:2px solid #7c3aed; padding:10px 12px;">Nakes</th>
                                                    <th style="color:#7c3aed; font-weight:700; border-bottom:2px solid #7c3aed; padding:10px 12px; text-align:center;">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($sidtks as $i => $sk)
                                                    @php
                                                        $dc = $domainColors[$sk->domain] ?? '#6c757d';
                                                        $hasilCls = match($sk->hasil) {
                                                            'Sesuai'       => 'success',
                                                            'Meragukan'    => 'warning',
                                                            'Penyimpangan' => 'danger',
                                                            default        => 'secondary',
                                                        };
                                                        $tlDarurat = str_contains($sk->tindak_lanjut, 'Rujuk');
                                                    @endphp
                                                    <tr style="border-bottom:1px solid #EDE9FE;">
                                                        <td class="fw-semibold text-muted">{{ $i + 1 }}</td>
                                                        <td>
                                                            <div class="fw-semibold">{{ $sk->tanggal_skrining->translatedFormat('d M Y') }}</div>
                                                            <div class="text-muted small"><i class="bi bi-clock me-1"></i>{{ $sk->usia_bulan }} bulan</div>
                                                        </td>
                                                        <td>
                                                            <span class="badge px-2 py-1 text-white fw-semibold" style="border-radius:12px; background:{{ $dc }}; font-size:0.78rem;">
                                                                {{ $sk->domain }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span class="badge bg-{{ $hasilCls }}-subtle text-{{ $hasilCls }} px-2 py-1 fw-semibold" style="font-size:0.78rem;">
                                                                {{ $sk->hasil }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span class="badge {{ $tlDarurat ? 'bg-danger-subtle text-danger' : 'bg-primary-subtle text-primary' }} px-2 py-1" style="font-size:0.78rem;">
                                                                {{ $sk->tindak_lanjut }}
                                                            </span>
                                                        </td>
                                                        <td class="text-muted small">{{ $sk->nakes->name ?? '-' }}</td>
                                                        <td class="text-center">
                                                            <a href="{{ route('perkembangan-sidtk.edit', $sk->id) }}" class="btn btn-warning btn-sm text-white" title="Edit">
                                                                <i class="bi bi-pencil-square"></i>
                                                            </a>
                                                            <button type="button" class="btn btn-danger btn-sm btn-delete-sidtk" data-id="{{ $sk->id }}" title="Hapus">
                                                                <i class="bi bi-trash"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <div class="text-center py-5">
                                        <div class="d-flex align-items-center justify-content-center mb-3 mx-auto"
                                             style="width:80px;height:80px;border-radius:50%;background:#F5F3FF;">
                                            <i class="bi bi-puzzle-fill" style="font-size:2.2rem;color:#7c3aed;"></i>
                                        </div>
                                        <h5 class="fw-bold text-dark mb-1">Belum Ada Data SIDTK</h5>
                                        <p class="text-muted mb-4">Belum ada data skrining perkembangan untuk <strong>{{ $profilAnak->nama_lengkap }}</strong>.</p>
                                        <a href="{{ route('perkembangan-sidtk.create', ['profil_anak_id' => $profilAnak->id]) }}"
                                           class="btn text-white px-4" style="background:linear-gradient(135deg,#7c3aed,#6d28d9); border-radius:30px; font-weight:600;">
                                            <i class="bi bi-plus-circle me-1"></i> Catat Skrining Pertama
                                        </a>
                                    </div>
                                @endif
                            </div>

                            {{-- Tab 6: MPASI --}}
                            <div class="tab-pane fade" id="tab-mpasi">
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <h5 class="card-title fw-bold mb-0">
                                        <i class="bi bi-egg-fried me-1 text-success"></i> Riwayat MPASI
                                    </h5>
                                    <a href="{{ route('mpasi.create', ['profil_anak_id' => $profilAnak->id]) }}"
                                       class="btn btn-sm text-white fw-semibold"
                                       style="background:linear-gradient(135deg,#16a34a,#15803d); border-radius:20px;">
                                        <i class="bi bi-plus-circle me-1"></i> Tambah MPASI
                                    </a>
                                </div>

                                @if ($profilAnak->mpasis->count() > 0)
                                    @php
                                        $mpasiList = $profilAnak->mpasis->sortBy('tanggal_mulai_mpasi');
                                        $jenisBadgeColors = [
                                            'Bubur Susu'       => '#0d6efd',
                                            'Bubur Saring'     => '#16B3AC',
                                            'Pure Sayuran'     => '#16a34a',
                                            'Pure Buah'        => '#F59E0B',
                                            'Bubur Nasi Tim'   => '#8B5CF6',
                                            'Nasi Tim'         => '#EC1E88',
                                            'Finger Food'      => '#ea580c',
                                            'Makanan Keluarga' => '#6366F1',
                                            'Makanan Selingan' => '#14b8a6',
                                        ];
                                        $teksturMap = [
                                            'Cair / Encer'             => 'info',
                                            'Semipadat / Lembek'       => 'primary',
                                            'Cincang Kasar'            => 'warning',
                                            'Dipotong Kecil'           => 'secondary',
                                            'Seperti Makanan Keluarga' => 'success',
                                        ];
                                    @endphp

                                    <div class="table-responsive">
                                        <table class="table table-hover align-middle" style="font-size:0.87rem;">
                                            <thead style="background:#F0FFF4;">
                                                <tr>
                                                    <th style="color:#16a34a; font-weight:700; border-bottom:2px solid #16a34a; padding:10px 12px;">No</th>
                                                    <th style="color:#16a34a; font-weight:700; border-bottom:2px solid #16a34a; padding:10px 12px;">Jenis MPASI</th>
                                                    <th style="color:#16a34a; font-weight:700; border-bottom:2px solid #16a34a; padding:10px 12px;">Mulai</th>
                                                    <th style="color:#16a34a; font-weight:700; border-bottom:2px solid #16a34a; padding:10px 12px;">Frekuensi</th>
                                                    <th style="color:#16a34a; font-weight:700; border-bottom:2px solid #16a34a; padding:10px 12px;">Tekstur</th>
                                                    <th style="color:#16a34a; font-weight:700; border-bottom:2px solid #16a34a; padding:10px 12px;">Catatan Gizi</th>
                                                    <th style="color:#16a34a; font-weight:700; border-bottom:2px solid #16a34a; padding:10px 12px; text-align:center;">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($mpasiList as $i => $mp)
                                                    @php
                                                        $jc  = $jenisBadgeColors[$mp->jenis_mpasi] ?? '#6c757d';
                                                        $tkCls = $teksturMap[$mp->tekstur] ?? 'secondary';
                                                    @endphp
                                                    <tr style="border-bottom:1px solid #DCFCE7;">
                                                        <td class="fw-semibold text-muted">{{ $i + 1 }}</td>
                                                        <td>
                                                            <span class="badge px-2 py-1 text-white fw-semibold"
                                                                  style="border-radius:12px; background:{{ $jc }}; font-size:0.78rem;">
                                                                {{ $mp->jenis_mpasi }}
                                                            </span>
                                                        </td>
                                                        <td class="text-dark fw-semibold small">
                                                            {{ $mp->tanggal_mulai_mpasi->translatedFormat('d M Y') }}
                                                        </td>
                                                        <td>
                                                            <span class="badge bg-success-subtle text-success px-2 py-1" style="font-size:0.75rem;">
                                                                <i class="bi bi-clock me-1"></i>{{ $mp->frekuensi }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span class="badge bg-{{ $tkCls }}-subtle text-{{ $tkCls }} px-2 py-1" style="font-size:0.75rem;">
                                                                {{ $mp->tekstur }}
                                                            </span>
                                                        </td>
                                                        <td class="text-muted small" style="max-width:180px;">
                                                            {{ Str::limit($mp->catatan_gizi, 60) }}
                                                        </td>
                                                        <td class="text-center">
                                                            <a href="{{ route('mpasi.edit', $mp->id) }}" class="btn btn-warning btn-sm text-white" title="Edit">
                                                                <i class="bi bi-pencil-square"></i>
                                                            </a>
                                                            <button type="button" class="btn btn-danger btn-sm btn-delete-mpasi" data-id="{{ $mp->id }}" title="Hapus">
                                                                <i class="bi bi-trash"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <div class="text-center py-5">
                                        <div class="d-flex align-items-center justify-content-center mb-3 mx-auto"
                                             style="width:80px;height:80px;border-radius:50%;background:#F0FFF4;">
                                            <i class="bi bi-egg-fried" style="font-size:2.2rem;color:#16a34a;"></i>
                                        </div>
                                        <h5 class="fw-bold text-dark mb-1">Belum Ada Data MPASI</h5>
                                        <p class="text-muted mb-4">Belum ada catatan MPASI untuk <strong>{{ $profilAnak->nama_lengkap }}</strong>.</p>
                                        <a href="{{ route('mpasi.create', ['profil_anak_id' => $profilAnak->id]) }}"
                                           class="btn text-white px-4" style="background:linear-gradient(135deg,#16a34a,#15803d); border-radius:30px; font-weight:600;">
                                            <i class="bi bi-plus-circle me-1"></i> Catat MPASI Pertama
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

    @push('scripts')
        <script>
            $(document).on('click', '.btn-delete-imun', function () {
                var id = $(this).data('id');
                var row = $(this).closest('tr');
                Swal.fire({
                    title: 'Hapus Imunisasi?',
                    text: "Catatan imunisasi ini akan terhapus permanen!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ url('imunisasi-anak') }}/" + id,
                            type: 'POST',
                            data: { _method: 'DELETE', _token: "{{ csrf_token() }}" },
                            success: function (response) {
                                if (response.status === 'success') {
                                    Swal.fire({
                                        title: 'Terhapus!',
                                        text: response.message,
                                        icon: 'success',
                                        confirmButtonColor: '#16a34a'
                                    }).then(() => { location.reload(); });
                                }
                            },
                            error: function () {
                                Swal.fire('Gagal!', 'Terjadi kesalahan saat menghapus data.', 'error');
                            }
                        });
                    }
                });
            });

            // Delete Tumbuh Kembang
            $(document).on('click', '.btn-delete-tk', function () {
                var id = $(this).data('id');
                Swal.fire({
                    title: 'Hapus Data Tumbuh Kembang?',
                    text: "Catatan pengukuran ini akan terhapus permanen!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ url('tumbuh-kembang') }}/" + id,
                            type: 'POST',
                            data: { _method: 'DELETE', _token: "{{ csrf_token() }}" },
                            success: function (response) {
                                if (response.status === 'success') {
                                    Swal.fire({
                                        title: 'Terhapus!',
                                        text: response.message,
                                        icon: 'success',
                                        confirmButtonColor: '#ea580c'
                                    }).then(() => { location.reload(); });
                                }
                            },
                            error: function () {
                                Swal.fire('Gagal!', 'Terjadi kesalahan saat menghapus data.', 'error');
                            }
                        });
                    }
                });
            });

            // Delete Perkembangan SIDTK
            $(document).on('click', '.btn-delete-sidtk', function () {
                var id = $(this).data('id');
                Swal.fire({
                    title: 'Hapus Data SIDTK?',
                    text: "Catatan skrining perkembangan ini akan terhapus permanen!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ url('perkembangan-sidtk') }}/" + id,
                            type: 'POST',
                            data: { _method: 'DELETE', _token: "{{ csrf_token() }}" },
                            success: function (response) {
                                if (response.status === 'success') {
                                    Swal.fire({
                                        title: 'Terhapus!',
                                        text: response.message,
                                        icon: 'success',
                                        confirmButtonColor: '#7c3aed'
                                    }).then(() => { location.reload(); });
                                }
                            },
                            error: function () {
                                Swal.fire('Gagal!', 'Terjadi kesalahan saat menghapus data.', 'error');
                            }
                        });
                    }
                });
            });

            // Delete MPASI
            $(document).on('click', '.btn-delete-mpasi', function () {
                var id = $(this).data('id');
                Swal.fire({
                    title: 'Hapus Data MPASI?',
                    text: "Catatan MPASI ini akan terhapus permanen!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ url('mpasi') }}/" + id,
                            type: 'POST',
                            data: { _method: 'DELETE', _token: "{{ csrf_token() }}" },
                            success: function (response) {
                                if (response.status === 'success') {
                                    Swal.fire({
                                        title: 'Terhapus!',
                                        text: response.message,
                                        icon: 'success',
                                        confirmButtonColor: '#16a34a'
                                    }).then(() => { location.reload(); });
                                }
                            },
                            error: function () {
                                Swal.fire('Gagal!', 'Terjadi kesalahan saat menghapus data.', 'error');
                            }
                        });
                    }
                });
            });
        </script>
    @endpush
@endsection
