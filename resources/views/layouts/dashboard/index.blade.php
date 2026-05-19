@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1 class="fw-bold text-dark">Dashboard Pelayanan KIA</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active">Dashboard</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<!-- Premium Global Styles for WOW factor -->
@push('styles')
<style>
    .welcome-banner {
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        position: relative;
        overflow: hidden;
        border: none;
    }
    .welcome-banner::before {
        content: "";
        position: absolute;
        width: 300px;
        height: 300px;
        background: rgba(255, 255, 255, 0.15);
        border-radius: 50%;
        top: -100px;
        right: -100px;
    }
    .welcome-banner::after {
        content: "";
        position: absolute;
        width: 150px;
        height: 150px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        bottom: -50px;
        right: 150px;
    }
    .glass-card {
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.25);
        border-radius: 16px;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.04);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .glass-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.08);
    }
    .stats-icon-wrapper {
        width: 60px;
        height: 60px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 26px;
    }
    .btn-action-panel {
        border-radius: 12px;
        transition: all 0.2s ease;
        font-weight: 600;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
    }
    .btn-action-panel:hover {
        transform: scale(1.03);
    }
    .maternal-gradient {
        background: linear-gradient(135deg, #ec4899 0%, #f43f5e 100%);
        color: white;
    }
    .admin-gradient {
        background: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%);
        color: white;
    }
    .nakes-gradient {
        background: linear-gradient(135deg, #0d9488 0%, #14b8a6 100%);
        color: white;
    }
    .dinkes-gradient {
        background: linear-gradient(135deg, #0284c7 0%, #0ea5e9 100%);
        color: white;
    }
    .pengguna-gradient {
        background: linear-gradient(135deg, #d97706 0%, #f59e0b 100%);
        color: white;
    }
    .custom-badge {
        font-size: 11px;
        padding: 6px 12px;
        border-radius: 20px;
        font-weight: 600;
    }
    .pulse-animation {
        animation: pulse 2s infinite;
    }
    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.05); }
        100% { transform: scale(1); }
    }
</style>
@endpush

<section class="section dashboard">
    <div class="row">
        
        <!-- Welcome Banner -->
        <div class="col-12 mb-4">
            @if($role === 'administrator' || $role === 'admin')
                <div class="card welcome-banner admin-gradient p-4 text-white">
            @elseif($role === 'dinas kesehatan')
                <div class="card welcome-banner dinkes-gradient p-4 text-white">
            @elseif($role === 'nakes')
                <div class="card welcome-banner nakes-gradient p-4 text-white">
            @elseif($role === 'ibu hamil')
                <div class="card welcome-banner maternal-gradient p-4 text-white">
            @else
                <div class="card welcome-banner pengguna-gradient p-4 text-white">
            @endif
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h2 class="fw-bold mb-2">Selamat Datang, {{ $user->name }}!</h2>
                        <p class="mb-0 opacity-90">
                            @if($role === 'administrator' || $role === 'admin')
                                Anda masuk sebagai <strong>Administrator Sistem</strong>. Kelola data master, monitoring faskes, audit user, dan atur hak akses pelayanan KIA nasional secara terpadu.
                            @elseif($role === 'dinas kesehatan')
                                Anda masuk sebagai <strong>Dinas Kesehatan</strong>. Pantau metrik kesehatan wilayah, agregasi data faskes, serta evaluasi kemajuan pelayanan KIA di kabupaten/kota.
                            @elseif($role === 'nakes')
                                Anda masuk sebagai <strong>Tenaga Kesehatan (Nakes)</strong>. Kelola buku KIA pasien, isi rekam medis ANC, imunisasi anak, dan pantau tumbuh kembang anak secara digital.
                            @elseif($role === 'ibu hamil')
                                Anda masuk sebagai <strong>Ibu Hamil / Ibu Balita</strong>. Pantau kesehatan janin, jadwal ANC, status imunisasi anak, dokumen medis, dan nikmati panduan KIA terpercaya.
                            @else
                                Selamat datang di Portal Kesehatan Ibu dan Anak. Silakan hubungi faskes atau lengkapi data diri Anda untuk mengakses catatan medis KIA Anda secara privat.
                            @endif
                        </p>
                    </div>
                    <div class="col-md-4 text-md-end mt-3 mt-md-0">
                        <span class="badge bg-white text-dark py-2 px-3 fw-bold rounded-pill shadow-sm">
                            <i class="bi bi-shield-check text-success me-1"></i> Role: {{ strtoupper($role) }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- ROLE: ADMINISTRATOR -->
        @if($role === 'administrator' || $role === 'admin')
            <!-- Statistics Cards -->
            <div class="col-xxl-3 col-md-6 mb-4">
                <div class="card glass-card h-100 border-0 p-3">
                    <div class="d-flex align-items-center">
                        <div class="stats-icon-wrapper bg-primary-subtle text-primary">
                            <i class="bi bi-people-fill"></i>
                        </div>
                        <div class="ps-3">
                            <span class="text-muted small fw-semibold">Total Pengguna</span>
                            <h3 class="fw-bold mb-0 text-dark mt-1">{{ $total_users }}</h3>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-xxl-3 col-md-6 mb-4">
                <div class="card glass-card h-100 border-0 p-3">
                    <div class="d-flex align-items-center">
                        <div class="stats-icon-wrapper bg-danger-subtle text-danger">
                            <i class="bi bi-heart-pulse-fill"></i>
                        </div>
                        <div class="ps-3">
                            <span class="text-muted small fw-semibold">Profil Ibu Hamil</span>
                            <h3 class="fw-bold mb-0 text-dark mt-1">{{ $total_ibu }}</h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xxl-3 col-md-6 mb-4">
                <div class="card glass-card h-100 border-0 p-3">
                    <div class="d-flex align-items-center">
                        <div class="stats-icon-wrapper bg-success-subtle text-success">
                            <i class="bi bi-emoji-smile-fill"></i>
                        </div>
                        <div class="ps-3">
                            <span class="text-muted small fw-semibold">Profil Anak</span>
                            <h3 class="fw-bold mb-0 text-dark mt-1">{{ $total_anak }}</h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xxl-3 col-md-6 mb-4">
                <div class="card glass-card h-100 border-0 p-3">
                    <div class="d-flex align-items-center">
                        <div class="stats-icon-wrapper bg-warning-subtle text-warning">
                            <i class="bi bi-journal-medical"></i>
                        </div>
                        <div class="ps-3">
                            <span class="text-muted small fw-semibold">Buku KIA Terbit</span>
                            <h3 class="fw-bold mb-0 text-dark mt-1">{{ $total_buku_kia }}</h3>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Left side columns -->
            <div class="col-lg-8">
                <!-- Recent Registrations -->
                <div class="card glass-card border-0 mb-4">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="fw-bold text-dark mb-0">Pendaftaran Pengguna Terbaru</h5>
                            <a href="{{ route('users.index') }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">Lihat Semua</a>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Status</th>
                                        <th>Tgl Daftar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recent_users as $u)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-sm bg-light rounded-circle p-2 me-2 text-center text-secondary" style="width: 38px; height: 38px;">
                                                        <i class="bi bi-person-fill"></i>
                                                    </div>
                                                    <div>
                                                        <span class="fw-semibold text-dark">{{ $u->name }}</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ $u->email }}</td>
                                            <td>
                                                <span class="badge bg-secondary-subtle text-secondary custom-badge">
                                                    {{ strtoupper($u->role->nama_role ?? 'Pengguna') }}
                                                </span>
                                            </td>
                                            <td>
                                                @if($u->is_active)
                                                    <span class="badge bg-success-subtle text-success custom-badge"><i class="bi bi-check-circle me-1"></i>Aktif</span>
                                                @else
                                                    <span class="badge bg-danger-subtle text-danger custom-badge"><i class="bi bi-x-circle me-1"></i>Nonaktif</span>
                                                @endif
                                            </td>
                                            <td class="text-muted small">{{ $u->created_at->format('d M Y') }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-4 text-muted">Belum ada pengguna terdaftar.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Recent Buku KIA Issued -->
                <div class="card glass-card border-0">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="fw-bold text-dark mb-0">Buku KIA Diterbitkan Baru-baru Ini</h5>
                            <a href="{{ route('buku-kia.index') }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">Lihat Semua</a>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>No. Kohort Ibu</th>
                                        <th>Nama Ibu Hamil</th>
                                        <th>No. Rekam Medik RS</th>
                                        <th>Diterbitkan Oleh</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recent_buku as $b)
                                        <tr>
                                            <td class="fw-semibold text-primary">{{ $b->no_reg_kohort_ibu }}</td>
                                            <td>{{ $b->profilIbu->nama_lengkap ?? '-' }}</td>
                                            <td>{{ $b->no_catatan_medik_rs }}</td>
                                            <td>{{ $b->diterbitkan_oleh }}</td>
                                            <td>
                                                <span class="badge bg-success custom-badge">{{ strtoupper($b->status ?? 'Aktif') }}</span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-4 text-muted">Belum ada Buku KIA terbit.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right side columns -->
            <div class="col-lg-4">
                <!-- System Quick Actions -->
                <div class="card glass-card border-0 mb-4 p-4">
                    <h5 class="fw-bold text-dark mb-3">Pintasan Administrator</h5>
                    <div class="d-grid gap-2">
                        <a href="{{ route('users.create') }}" class="btn btn-primary btn-action-panel text-start p-3">
                            <i class="bi bi-person-plus me-2"></i> Tambah Pengguna Baru
                        </a>
                        <a href="{{ route('fasilitas-kesehatan.create') }}" class="btn btn-outline-secondary btn-action-panel text-start p-3 bg-white text-dark border-light-subtle">
                            <i class="bi bi-building me-2"></i> Tambah Faskes Baru
                        </a>
                        <a href="{{ route('roles.index') }}" class="btn btn-outline-secondary btn-action-panel text-start p-3 bg-white text-dark border-light-subtle">
                            <i class="bi bi-shield-lock me-2"></i> Pengaturan Hak Akses
                        </a>
                    </div>
                </div>

                <!-- Info Card -->
                <div class="card border-0 bg-light p-4 text-center rounded-4">
                    <i class="bi bi-server text-primary mb-2" style="font-size: 40px;"></i>
                    <h6 class="fw-bold text-dark">Informasi Server KIA</h6>
                    <p class="text-muted small mb-0">Semua koneksi dienkripsi dengan SSL tingkat tinggi. Database dimonitor secara real-time demi menjamin kerahasiaan data rekam medis ibu dan anak.</p>
                </div>
            </div>

        <!-- ROLE: DINAS KESEHATAN -->
        @elseif($role === 'dinas kesehatan')
            <!-- Statistics Cards -->
            <div class="col-md-3 mb-4">
                <div class="card glass-card h-100 border-0 p-3">
                    <div class="d-flex align-items-center">
                        <div class="stats-icon-wrapper bg-info-subtle text-info">
                            <i class="bi bi-building-fill"></i>
                        </div>
                        <div class="ps-3">
                            <span class="text-muted small fw-semibold">Fasilitas Kesehatan</span>
                            <h3 class="fw-bold mb-0 text-dark mt-1">{{ $total_faskes }}</h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-4">
                <div class="card glass-card h-100 border-0 p-3">
                    <div class="d-flex align-items-center">
                        <div class="stats-icon-wrapper bg-danger-subtle text-danger">
                            <i class="bi bi-heart-fill"></i>
                        </div>
                        <div class="ps-3">
                            <span class="text-muted small fw-semibold">Ibu Hamil Terdaftar</span>
                            <h3 class="fw-bold mb-0 text-dark mt-1">{{ $total_ibu }}</h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-4">
                <div class="card glass-card h-100 border-0 p-3">
                    <div class="d-flex align-items-center">
                        <div class="stats-icon-wrapper bg-success-subtle text-success">
                            <i class="bi bi-emoji-smile-fill"></i>
                        </div>
                        <div class="ps-3">
                            <span class="text-muted small fw-semibold">Anak Terdaftar</span>
                            <h3 class="fw-bold mb-0 text-dark mt-1">{{ $total_anak }}</h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-4">
                <div class="card glass-card h-100 border-0 p-3">
                    <div class="d-flex align-items-center">
                        <div class="stats-icon-wrapper bg-warning-subtle text-warning">
                            <i class="bi bi-journal-text"></i>
                        </div>
                        <div class="ps-3">
                            <span class="text-muted small fw-semibold">Buku KIA Diterbitkan</span>
                            <h3 class="fw-bold mb-0 text-dark mt-1">{{ $total_buku_kia }}</h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <!-- Faskes Activity -->
                <div class="card glass-card border-0 mb-4">
                    <div class="card-body p-4">
                        <h5 class="fw-bold text-dark mb-3">Distribusi Penerbitan Buku KIA Wilayah</h5>
                        <div class="table-responsive">
                            <table class="table align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>No. Kohort</th>
                                        <th>Ibu Hamil</th>
                                        <th>Fasilitas Kesehatan</th>
                                        <th>Tgl Terbit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recent_activities as $act)
                                        <tr>
                                            <td class="fw-semibold">{{ $act->no_reg_kohort_ibu }}</td>
                                            <td>{{ $act->profilIbu->nama_lengkap ?? '-' }}</td>
                                            <td>
                                                <span class="badge bg-info-subtle text-info rounded-pill px-3">
                                                    {{ $act->fasilitasKesehatan->nama_faskes ?? 'Puskesmas Wilayah' }}
                                                </span>
                                            </td>
                                            <td>{{ $act->created_at->format('d M Y') }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center py-4 text-muted">Belum ada penerbitan data KIA baru di wilayah Anda.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card glass-card border-0 p-4 mb-4">
                    <h5 class="fw-bold text-dark mb-3">Tugas Utama Dinas Kesehatan</h5>
                    <ul class="list-unstyled mb-0">
                        <li class="d-flex mb-3">
                            <i class="bi bi-check2-circle text-success me-2 fs-5"></i>
                            <span>Evaluasi cakupan imunisasi dasar lengkap anak.</span>
                        </li>
                        <li class="d-flex mb-3">
                            <i class="bi bi-check2-circle text-success me-2 fs-5"></i>
                            <span>Monitoring angka kunjungan ANC ibu hamil (K1-K6).</span>
                        </li>
                        <li class="d-flex">
                            <i class="bi bi-check2-circle text-success me-2 fs-5"></i>
                            <span>Pelaporan bulanan program KIA faskes sewilayah.</span>
                        </li>
                    </ul>
                </div>
            </div>

        <!-- ROLE: TENAGA KESEHATAN (NAKES) -->
        @elseif($role === 'nakes')
            <!-- Clinic Metadata Info -->
            @if($my_faskes)
                <div class="col-12 mb-4">
                    <div class="card border-0 bg-info-subtle p-3 rounded-4">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-hospital text-info fs-2 me-3"></i>
                            <div>
                                <h6 class="fw-bold text-dark mb-1">Tempat Tugas: {{ $my_faskes->nama_faskes }}</h6>
                                <p class="text-muted small mb-0"><i class="bi bi-geo-alt me-1"></i> {{ $my_faskes->alamat }}, Kec. {{ $my_faskes->kecamatan }}, {{ $my_faskes->kab_kota }} | <i class="bi bi-clock me-1"></i> Operasional: {{ $my_faskes->jam_operasional }} ({{ $my_faskes->jam_buka }} - {{ $my_faskes->jam_tutup }})</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Stats -->
            <div class="col-md-4 mb-4">
                <div class="card glass-card h-100 border-0 p-3">
                    <div class="d-flex align-items-center">
                        <div class="stats-icon-wrapper bg-pink-subtle text-danger" style="background-color: #ffe4e6 !important;">
                            <i class="bi bi-person-heart"></i>
                        </div>
                        <div class="ps-3">
                            <span class="text-muted small fw-semibold">Pasien Ibu Hamil</span>
                            <h3 class="fw-bold mb-0 text-dark mt-1">{{ $total_ibu }}</h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card glass-card h-100 border-0 p-3">
                    <div class="d-flex align-items-center">
                        <div class="stats-icon-wrapper bg-success-subtle text-success">
                            <i class="bi bi-heart-pulse"></i>
                        </div>
                        <div class="ps-3">
                            <span class="text-muted small fw-semibold">Pasien Anak</span>
                            <h3 class="fw-bold mb-0 text-dark mt-1">{{ $total_anak }}</h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card glass-card h-100 border-0 p-3">
                    <div class="d-flex align-items-center">
                        <div class="stats-icon-wrapper bg-teal-subtle text-teal" style="background-color: #ccfbf1 !important; color: #0f766e !important;">
                            <i class="bi bi-journal-bookmark-fill"></i>
                        </div>
                        <div class="ps-3">
                            <span class="text-muted small fw-semibold">Buku KIA Aktif</span>
                            <h3 class="fw-bold mb-0 text-dark mt-1">{{ $total_buku_kia }}</h3>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Left column -->
            <div class="col-lg-8">
                <!-- Recent ANC Checkups -->
                <div class="card glass-card border-0 mb-4">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="fw-bold text-dark mb-0">Pemeriksaan ANC Terbaru Faskes Anda</h5>
                            <a href="{{ route('kunjungan-anc.index') }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">Lihat Semua</a>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Ibu Hamil</th>
                                        <th>Trimester</th>
                                        <th>Kunjungan Ke</th>
                                        <th>Tgl Kunjungan</th>
                                        <th>Berat Badan</th>
                                        <th>Tekanan Darah</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recent_kunjungan as $k)
                                        <tr>
                                            <td class="fw-semibold">{{ $k->bukuKia->profilIbu->nama_lengkap ?? '-' }}</td>
                                            <td>Trimester {{ $k->trimester }}</td>
                                            <td class="text-center"><span class="badge bg-secondary-subtle text-secondary rounded-pill px-2">Ke-{{ $k->kunjungan_ke }}</span></td>
                                            <td>{{ \Carbon\Carbon::parse($k->tanggal_kunjungan)->format('d M Y') }}</td>
                                            <td>{{ $k->berat_badan }} kg</td>
                                            <td>{{ $k->tekanan_darah_sistolik }}/{{ $k->tekanan_darah_diastolik }} mmHg</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-4 text-muted">Belum ada catatan rekam medis ANC baru.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right column (Clinical Operations Actions) -->
            <div class="col-lg-4">
                <div class="card glass-card border-0 p-4 mb-4">
                    <h5 class="fw-bold text-dark mb-3">Alur Kerja Klinis Nakes</h5>
                    <div class="d-grid gap-2">
                        <a href="{{ route('profil-ibu.create') }}" class="btn btn-danger btn-action-panel text-start p-3 bg-rose text-white border-0" style="background-color: #f43f5e;">
                            <i class="bi bi-person-plus-fill me-2"></i> Registrasi Pasien Ibu Hamil
                        </a>
                        <a href="{{ route('buku-kia.create') }}" class="btn btn-primary btn-action-panel text-start p-3 border-0">
                            <i class="bi bi-journal-plus me-2"></i> Terbitkan Buku KIA Pasien
                        </a>
                        <a href="{{ route('kunjungan-anc.create') }}" class="btn btn-teal btn-action-panel text-start p-3 text-white border-0" style="background-color: #0d9488;">
                            <i class="bi bi-clipboard-pulse me-2"></i> Input Rekam Medis ANC
                        </a>
                        <a href="{{ route('profil-anak.create') }}" class="btn btn-outline-secondary btn-action-panel text-start p-3 bg-white text-dark border-light-subtle">
                            <i class="bi bi-emoji-laughing me-2"></i> Registrasi Profil Anak Pasien
                        </a>
                    </div>
                </div>
            </div>

        <!-- ROLE: IBU HAMIL (Pregnant Mother) -->
        @elseif($role === 'ibu hamil')
            @if(!$profil_ibu)
                <!-- Onboarding banner to fill profile -->
                <div class="col-12 mb-4">
                    <div class="card border-0 bg-danger-subtle p-5 rounded-4 text-center">
                        <i class="bi bi-person-bounding-box text-danger mb-3" style="font-size: 55px;"></i>
                        <h4 class="fw-bold text-dark">Data Profil Ibu Hamil Belum Dilengkapi</h4>
                        <p class="text-muted w-75 mx-auto">Selamat datang! Silakan lengkapi profil Ibu Hamil Anda terlebih dahulu agar Tenaga Kesehatan dapat mendaftarkan rekam medis dan menerbitkan Buku KIA Anda.</p>
                        <div class="mt-3">
                            <a href="{{ route('profil-ibu.create') }}" class="btn btn-danger px-4 py-3 rounded-pill fw-bold shadow-sm pulse-animation"><i class="bi bi-pencil-square me-2"></i> Lengkapi Profil Ibu Sekarang</a>
                        </div>
                    </div>
                </div>
            @else
                <!-- Main Pregnant Mother Passport Cards -->
                <div class="col-lg-6 mb-4">
                    <!-- Mother Profile card -->
                    <div class="card border-0 text-white rounded-4 shadow-sm maternal-gradient p-4 h-100">
                        <h5 class="fw-bold border-bottom border-white border-opacity-25 pb-2"><i class="bi bi-postcard-fill me-2"></i> Kartu Paspor Kesehatan Ibu Hamil</h5>
                        <div class="row mt-3">
                            <div class="col-md-6 mb-3">
                                <span class="small opacity-75 d-block">Nama Lengkap</span>
                                <span class="fw-bold fs-5">{{ $profil_ibu->nama_lengkap }}</span>
                            </div>
                            <div class="col-md-6 mb-3">
                                <span class="small opacity-75 d-block">NIK</span>
                                <span class="fw-bold">{{ $profil_ibu->nik }}</span>
                            </div>
                            <div class="col-md-6 mb-3">
                                <span class="small opacity-75 d-block">Golongan Darah</span>
                                <span class="fw-bold badge bg-white text-danger px-3 fs-6 rounded-pill mt-1">{{ $profil_ibu->golongan_darah ?? '-' }}</span>
                            </div>
                            <div class="col-md-6 mb-3">
                                <span class="small opacity-75 d-block">No. Kartu JKN</span>
                                <span class="fw-bold">{{ $profil_ibu->nomor_jkn ?? '-' }}</span>
                            </div>
                            <div class="col-md-6">
                                <span class="small opacity-75 d-block">Puskesmas Terdaftar</span>
                                <span class="fw-bold">{{ $profil_ibu->nama_puskesmas ?? ($profil_ibu->fasilitasKesehatan->nama_faskes ?? '-') }}</span>
                            </div>
                            <div class="col-md-6">
                                <span class="small opacity-75 d-block">Umur</span>
                                <span class="fw-bold">{{ \Carbon\Carbon::parse($profil_ibu->tanggal_lahir)->age }} Tahun</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 mb-4">
                    <!-- Buku KIA info card -->
                    <div class="card border-0 bg-white shadow-sm p-4 rounded-4 h-100 border-start border-4 border-danger">
                        <h5 class="fw-bold text-dark border-bottom pb-2"><i class="bi bi-book-half text-danger me-2"></i> Informasi Buku KIA Anda</h5>
                        @if(!$buku_kia)
                            <div class="text-center py-4">
                                <i class="bi bi-journal-x text-muted fs-2"></i>
                                <p class="text-muted small mt-2">Buku KIA Anda belum diterbitkan secara digital oleh Tenaga Kesehatan Puskesmas/RS. Silakan hubungi nakes di faskes terdaftar Anda.</p>
                            </div>
                        @else
                            <div class="row mt-3">
                                <div class="col-md-6 mb-3">
                                    <span class="small text-muted d-block">No. Reg Kohort Ibu</span>
                                    <span class="fw-bold text-dark">{{ $buku_kia->no_reg_kohort_ibu }}</span>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <span class="small text-muted d-block">Status Buku KIA</span>
                                    <span class="badge bg-success custom-badge mt-1"><i class="bi bi-check-circle me-1"></i>{{ strtoupper($buku_kia->status) }}</span>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <span class="small text-muted d-block">Kehamilan Ke-</span>
                                    <span class="fw-bold text-dark fs-6">{{ $buku_kia->kehamilan_ke }}</span>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <span class="small text-muted d-block">Anak Hidup / Keguguran</span>
                                    <span class="fw-bold text-dark">{{ $buku_kia->jumlah_anak_hidup }} / {{ $buku_kia->riwayat_keguguran }}</span>
                                </div>
                                <div class="col-md-12">
                                    <span class="small text-muted d-block">Riwayat Penyakit Ibu</span>
                                    <span class="text-secondary small">{{ $buku_kia->riwayat_penyakit ?? 'Tidak ada riwayat penyakit' }}</span>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Latest ANC visit details card -->
                <div class="col-lg-8 mb-4">
                    <div class="card glass-card border-0 p-4 h-100">
                        <h5 class="fw-bold text-dark border-bottom pb-2 mb-3"><i class="bi bi-clipboard2-pulse-fill text-danger me-2"></i> Perkembangan Pemeriksaan Kehamilan Terakhir (ANC)</h5>
                        @if($anc_visits->isEmpty())
                            <div class="text-center py-5">
                                <i class="bi bi-heart-broken text-muted fs-1 mb-2"></i>
                                <h6 class="fw-semibold text-dark">Belum Ada Rekam Kunjungan ANC</h6>
                                <p class="text-muted small w-75 mx-auto">Jadwalkan kunjungan ANC pertama Anda dengan Tenaga Kesehatan di Puskesmas atau Rumah Sakit terdekat untuk memantau kesehatan kandungan Anda.</p>
                            </div>
                        @else
                            @php $latest_anc = $anc_visits->first(); @endphp
                            <div class="row align-items-center">
                                <div class="col-md-6 mb-4 mb-md-0 border-end border-light">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="bg-danger-subtle p-3 rounded-4 me-3 text-danger fs-3">
                                            <i class="bi bi-calendar3"></i>
                                        </div>
                                        <div>
                                            <span class="small text-muted d-block">Kunjungan Terakhir</span>
                                            <span class="fw-bold text-dark">{{ \Carbon\Carbon::parse($latest_anc->tanggal_kunjungan)->format('d F Y') }}</span>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-primary-subtle p-3 rounded-4 me-3 text-primary fs-3" style="background-color: #e0f2fe !important;">
                                            <i class="bi bi-hospital"></i>
                                        </div>
                                        <div>
                                            <span class="small text-muted d-block">Tempat Periksa</span>
                                            <span class="fw-bold text-dark">{{ $latest_anc->fasilitasKesehatan->nama_faskes ?? '-' }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-6 mb-3">
                                            <span class="small text-muted d-block">Trimester / Kunjungan</span>
                                            <span class="fw-bold text-dark">T{{ $latest_anc->trimester }} / Ke-{{ $latest_anc->kunjungan_ke }}</span>
                                        </div>
                                        <div class="col-6 mb-3">
                                            <span class="small text-muted d-block">Berat Badan Ibu</span>
                                            <span class="fw-bold text-dark">{{ $latest_anc->berat_badan }} Kg</span>
                                        </div>
                                        <div class="col-6 mb-3">
                                            <span class="small text-muted d-block">Tekanan Darah</span>
                                            <span class="fw-bold text-dark">{{ $latest_anc->tekanan_darah_sistolik }}/{{ $latest_anc->tekanan_darah_diastolik }} mmHg</span>
                                        </div>
                                        <div class="col-6 mb-3">
                                            <span class="small text-muted d-block">Denyut Jantung Janin</span>
                                            <span class="fw-bold text-success">{{ $latest_anc->denyut_jantung_janin ?? '-' }} dpm</span>
                                        </div>
                                        <div class="col-6">
                                            <span class="small text-muted d-block">Letak Janin</span>
                                            <span class="fw-bold text-dark">{{ $latest_anc->letak_janin ?? '-' }}</span>
                                        </div>
                                        <div class="col-6">
                                            <span class="small text-muted d-block">Catatan Nakes</span>
                                            <span class="text-secondary small">{{ $latest_anc->catatan ?? '-' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Children cards list -->
                <div class="col-lg-4 mb-4">
                    <div class="card glass-card border-0 p-4 h-100">
                        <h5 class="fw-bold text-dark border-bottom pb-2 mb-3"><i class="bi bi-emoji-heart-eyes-fill text-success me-2"></i> Anak Saya</h5>
                        @if($children->isEmpty())
                            <div class="text-center py-5 text-muted">
                                <i class="bi bi-balloon fs-1 text-secondary mb-2"></i>
                                <p class="small mb-0">Belum ada anak terdaftar dalam Buku KIA digital Anda.</p>
                            </div>
                        @else
                            <div class="d-flex flex-column gap-3 overflow-auto" style="max-height: 280px;">
                                @foreach($children as $child)
                                    <div class="p-3 bg-light rounded-4 border-start border-4 border-success d-flex align-items-center">
                                        <div class="fs-2 text-success me-3">
                                            @if($child->jenis_kelamin === 'L' || strtolower($child->jenis_kelamin) === 'laki-laki' || strtolower($child->jenis_kelamin) === 'l')
                                                <i class="bi bi-gender-male"></i>
                                            @else
                                                <i class="bi bi-gender-female"></i>
                                            @endif
                                        </div>
                                        <div>
                                            <h6 class="fw-bold text-dark mb-1">{{ $child->nama_lengkap }}</h6>
                                            <span class="text-muted small d-block"><i class="bi bi-calendar-event me-1"></i> Lahir: {{ \Carbon\Carbon::parse($child->tanggal_lahir)->format('d M Y') }}</span>
                                            <span class="text-muted small"><i class="bi bi-rulers me-1"></i> L: {{ $child->panjang_lahir_cm }} cm | B: {{ $child->berat_lahir_kg }} kg</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Husband card and finance summaries -->
                <div class="col-md-6 mb-4">
                    <div class="card glass-card border-0 p-4 h-100">
                        <h5 class="fw-bold text-dark border-bottom pb-2 mb-3"><i class="bi bi-people-fill text-primary me-2"></i> Profil Suami</h5>
                        @if(!$profil_suami)
                            <div class="text-center py-4">
                                <p class="text-muted small">Profil suami belum ditambahkan. Lengkapi data keluarga Anda di menu keluarga.</p>
                                <a href="{{ route('profil-suami.create') }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">Lengkapi Profil Suami</a>
                            </div>
                        @else
                            <div class="row">
                                <div class="col-6 mb-3">
                                    <span class="small text-muted d-block">Nama Suami</span>
                                    <span class="fw-bold text-dark">{{ $profil_suami->nama_suami }}</span>
                                </div>
                                <div class="col-6 mb-3">
                                    <span class="small text-muted d-block">NIK</span>
                                    <span class="fw-bold text-dark">{{ $profil_suami->nik }}</span>
                                </div>
                                <div class="col-6">
                                    <span class="small text-muted d-block">Golongan Darah</span>
                                    <span class="fw-bold text-dark badge bg-primary-subtle text-primary px-3 rounded-pill">{{ $profil_suami->golongan_darah ?? '-' }}</span>
                                </div>
                                <div class="col-6">
                                    <span class="small text-muted d-block">Pekerjaan</span>
                                    <span class="fw-bold text-dark">{{ $profil_suami->pekerjaan ?? '-' }}</span>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="col-md-6 mb-4">
                    <div class="card glass-card border-0 p-4 h-100">
                        <h5 class="fw-bold text-dark border-bottom pb-2 mb-3"><i class="bi bi-credit-card-fill text-warning me-2"></i> Pembiayaan Kesehatan</h5>
                        @if($pembiayaan_list->isEmpty())
                            <div class="text-center py-4">
                                <p class="text-muted small">Belum ada rekaman pembiayaan / jaminan kesehatan terdaftar.</p>
                                <a href="{{ route('pembiayaan.create') }}" class="btn btn-sm btn-outline-warning rounded-pill px-3">Tambah Pembiayaan</a>
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-sm table-borderless">
                                    <thead>
                                        <tr class="table-light">
                                            <th>Nama Jaminan</th>
                                            <th>No. Jaminan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($pembiayaan_list as $pem)
                                            <tr>
                                                <td class="fw-semibold">{{ $pem->nama_pembiayaan }}</td>
                                                <td>{{ $pem->nomor_pembiayaan }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

        <!-- ROLE: PENGGUNA (General / Onboarding) -->
        @else
            <div class="col-12 mb-4">
                <div class="card border-0 bg-amber-subtle p-5 rounded-4 text-center shadow-sm">
                    <i class="bi bi-shield-lock-fill text-warning mb-3" style="font-size: 55px;"></i>
                    <h3 class="fw-bold text-dark">Menunggu Verifikasi Role atau Profil</h3>
                    <p class="text-muted w-75 mx-auto mb-4">Akun Anda saat ini memiliki akses terdaftar sebagai Pengguna Umum. Untuk memantau rekam medis KIA, silakan hubungi Tenaga Kesehatan di Puskesmas atau RS agar dapat diperbarui menjadi role <strong>Ibu Hamil</strong> atau <strong>Nakes</strong>.</p>
                    <div>
                        <a href="{{ route('logout') }}" class="btn btn-warning px-4 py-3 rounded-pill fw-bold text-dark shadow-sm"><i class="bi bi-box-arrow-left me-2"></i> Keluar Akun</a>
                    </div>
                </div>
            </div>
        @endif

    </div>
</section>
@endsection
