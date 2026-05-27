@extends('layouts.homepage.template')

@section('title', 'Visi, Misi & Nilai - KIA Care')

@section('content')
    <section class="ve-page-hero" style="background-image:url('{{ asset('homepage/img/clinic_bg_1779872776394.png') }}');">
        <div class="ve-page-hero-overlay"></div>
        <div class="container ve-page-hero-content">
            <span class="ve-section-tag">Pondasi Kami</span>
            <h1>Visi, Misi & <span>Nilai KIA Care</span></h1>
            <nav aria-label="breadcrumb">
                <ol class="ve-breadcrumb">
                    <li><a href="{{ route('homepage') }}">Beranda</a></li>
                    <li class="active">Visi, Misi & Nilai</li>
                </ol>
            </nav>
        </div>
    </section>

    @if($visiMisi)
    {{-- ===== DATA DINAMIS DARI DB ===== --}}
    @php
        $temaColors = \App\Models\VisiMisi::$temaColors;
    @endphp

    <section class="ve-section" style="background: #FFF5F8;">
        <div class="container">
            <div class="ve-section-header text-center mb-5">
                <span class="ve-section-tag">Prinsip Utama</span>
                <h2>Komitmen Terhadap <span>Ibu & Anak</span></h2>
                <p class="mx-auto" style="max-width: 700px; font-size: 1.1rem; color: var(--ve-text-light);">
                    Kami mendedikasikan teknologi dan empati untuk membangun masa depan kesehatan keluarga Indonesia yang lebih cerah dan terpantau.
                </p>
            </div>

            <div class="ve-mvv-grid">
                {{-- Visi --}}
                <div class="ve-mvv-card">
                    <div class="ve-mvv-icon"><i class="fa fa-eye"></i></div>
                    <h4>Visi Kami</h4>
                    <p style="font-size: 1.05rem; line-height: 1.8; text-align: justify; text-justify: inter-word;">
                        {{ $visiMisi->visi }}
                    </p>
                </div>

                {{-- Misi --}}
                <div class="ve-mvv-card">
                    <div class="ve-mvv-icon"><i class="fa fa-bullseye"></i></div>
                    <h4>Misi Kami</h4>
                    <ul class="text-left" style="list-style: none; padding: 0; margin: 0; text-align: left; width: 100%;">
                        @foreach($visiMisi->misi ?? [] as $poin)
                            <li style="font-size: 0.95rem; line-height: 1.6; margin-bottom: 12px; display: flex; align-items: flex-start;">
                                <i class="fa fa-check" style="color: var(--brand-p); margin-right: 10px; margin-top: 5px; flex-shrink: 0; font-size: 0.85rem;"></i>
                                <span style="flex: 1; text-align: justify; text-justify: inter-word;">{{ $poin }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>

                {{-- Nilai --}}
                <div class="ve-mvv-card">
                    <div class="ve-mvv-icon"><i class="fa fa-heart"></i></div>
                    <h4>Nilai Kami</h4>
                    <p style="font-size: 1.05rem; line-height: 1.8; text-align: justify; text-justify: inter-word;">
                        {{ $visiMisi->nilai }}
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- Detail Nilai Items (jika ada) --}}
    @if(!empty($visiMisi->nilai_items))
    <section class="ve-section" style="background: #fff;">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-12 col-lg-5">
                    <div class="ve-about-text p-0">
                        <span class="ve-section-tag">Nilai Luhur</span>
                        <h2 style="font-size: 2.5rem; line-height: 1.2;">Membimbing <br>Langkah <span>Pelayanan Kami</span></h2>
                        <p class="ve-lead" style="line-height: 1.8;">Setiap baris kode dan setiap interaksi medis didasari oleh empati mendalam untuk mendukung keselamatan ibu dan tumbuh kembang optimal sang anak.</p>
                        <p style="color: var(--ve-text-light);">KIA Care percaya bahwa keluarga yang sehat dimulai dari ibu yang terpantau dengan baik sejak awal kehamilan hingga masa balita emas buah hatinya.</p>
                    </div>
                </div>
                <div class="col-12 col-lg-7">
                    <div class="row g-4" style="margin-top: 20px;">
                        @foreach($visiMisi->nilai_items as $item)
                            @php
                                $colors = $temaColors[$item['tema'] ?? 'blue'] ?? $temaColors['blue'];
                                $ikon   = $item['ikon'] ?? 'fa-star';
                            @endphp
                            <div class="col-12 col-md-6">
                                <div class="p-4 border border-1"
                                     style="background: {{ $colors['bg'] }}; border-color: {{ $colors['border'] }} !important; border-radius: 20px; margin-bottom: 24px;">
                                    <h5 class="fw-bold mb-2" style="color: var(--ve-dark);">
                                        <i class="fa {{ $ikon }} me-2" style="color: {{ $colors['ikon'] }};"></i>
                                        {{ $item['judul'] }}
                                    </h5>
                                    <p class="small text-muted mb-0" style="line-height: 1.6;">{{ $item['deskripsi'] }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif

    @else
    {{-- ===== FALLBACK STATIS jika belum ada data di DB ===== --}}
    <section class="ve-section" style="background: #FFF5F8;">
        <div class="container">
            <div class="ve-section-header text-center mb-5">
                <span class="ve-section-tag">Prinsip Utama</span>
                <h2>Komitmen Terhadap <span>Ibu & Anak</span></h2>
                <p class="mx-auto" style="max-width: 700px; font-size: 1.1rem; color: var(--ve-text-light);">Kami mendedikasikan teknologi dan empati untuk membangun masa depan kesehatan keluarga Indonesia yang lebih cerah dan terpantau.</p>
            </div>
            <div class="ve-mvv-grid">
                <div class="ve-mvv-card">
                    <div class="ve-mvv-icon"><i class="fa fa-eye"></i></div>
                    <h4>Visi Kami</h4>
                    <p style="font-size: 1.05rem; line-height: 1.8; text-align: justify; text-justify: inter-word;">Menjadi platform digital kesehatan ibu dan anak pilihan utama di Indonesia dengan pengalaman pemantauan yang aman, personal, dan terintegrasi.</p>
                </div>
                <div class="ve-mvv-card">
                    <div class="ve-mvv-icon"><i class="fa fa-bullseye"></i></div>
                    <h4>Misi Kami</h4>
                    <ul class="text-left" style="list-style: none; padding: 0; margin: 0; text-align: left; width: 100%;">
                        <li style="font-size: 0.95rem; line-height: 1.6; margin-bottom: 12px; display: flex; align-items: flex-start;">
                            <i class="fa fa-check" style="color: var(--brand-p); margin-right: 10px; margin-top: 5px; flex-shrink: 0; font-size: 0.85rem;"></i>
                            <span style="flex: 1;">Meningkatkan akses informasi kesehatan ibu dan anak di seluruh Indonesia.</span>
                        </li>
                        <li style="font-size: 0.95rem; line-height: 1.6; margin-bottom: 12px; display: flex; align-items: flex-start;">
                            <i class="fa fa-check" style="color: var(--brand-p); margin-right: 10px; margin-top: 5px; flex-shrink: 0; font-size: 0.85rem;"></i>
                            <span style="flex: 1;">Menghadirkan teknologi pemantauan kesehatan digital yang mudah dan ramah pengguna.</span>
                        </li>
                        <li style="font-size: 0.95rem; line-height: 1.6; margin-bottom: 12px; display: flex; align-items: flex-start;">
                            <i class="fa fa-check" style="color: var(--brand-p); margin-right: 10px; margin-top: 5px; flex-shrink: 0; font-size: 0.85rem;"></i>
                            <span style="flex: 1;">Menjadi platform yang dapat diandalkan dan dipercaya oleh setiap keluarga.</span>
                        </li>
                    </ul>
                </div>
                <div class="ve-mvv-card">
                    <div class="ve-mvv-icon"><i class="fa fa-heart"></i></div>
                    <h4>Nilai Kami</h4>
                    <p style="font-size: 1.05rem; line-height: 1.8; text-align: justify; text-justify: inter-word;">Transparansi informasi, empati yang tulus dalam pelayanan, inovasi tanpa henti, serta komitmen penuh terhadap kesejahteraan tumbuh kembang anak.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="ve-section" style="background: #fff;">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-12 col-lg-5">
                    <div class="ve-about-text p-0">
                        <span class="ve-section-tag">Nilai Luhur</span>
                        <h2 style="font-size: 2.5rem; line-height: 1.2;">Membimbing <br>Langkah <span>Pelayanan Kami</span></h2>
                        <p class="ve-lead" style="line-height: 1.8;">Setiap baris kode dan setiap interaksi medis didasari oleh empati mendalam untuk mendukung keselamatan ibu dan tumbuh kembang optimal sang anak.</p>
                        <p style="color: var(--ve-text-light);">KIA Care percaya bahwa keluarga yang sehat dimulai dari ibu yang terpantau dengan baik sejak awal kehamilan hingga masa balita emas buah hatinya.</p>
                    </div>
                </div>
                <div class="col-12 col-lg-7">
                    <div class="row g-4" style="margin-top: 20px;">
                        <div class="col-12 col-md-6">
                            <div class="p-4 border border-1" style="background: #FDF2F8; border-color: #FBCFE8; border-radius: 20px; margin-bottom: 24px;">
                                <h5 class="fw-bold mb-2" style="color: var(--ve-dark);"><i class="fa fa-shield me-2" style="color: var(--brand-p);"></i> Keamanan Data</h5>
                                <p class="small text-muted mb-0" style="line-height: 1.6;">Rekam catatan medis KMS dan riwayat imunisasi anak tersimpan aman di cloud terenkripsi.</p>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="p-4 border border-1" style="background: #F0FDF4; border-color: #BBF7D0; border-radius: 20px; margin-bottom: 24px;">
                                <h5 class="fw-bold mb-2" style="color: var(--ve-dark);"><i class="fa fa-heartbeat me-2 text-success"></i> Respons Cepat</h5>
                                <p class="small text-muted mb-0" style="line-height: 1.6;">Layanan telemedisin menghubungkan ibu hamil dengan bidan atau dokter jaga dalam hitungan menit.</p>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="p-4 border border-1" style="background: #EFF6FF; border-color: #BFDBFE; border-radius: 20px;">
                                <h5 class="fw-bold mb-2" style="color: var(--ve-dark);"><i class="fa fa-users me-2 text-primary"></i> Inklusif</h5>
                                <p class="small text-muted mb-0" style="line-height: 1.6;">Dapat diakses oleh siapa saja, dari perkotaan hingga pelosok daerah dengan jaringan faskes primer terintegrasi.</p>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="p-4 border border-1" style="background: #FFFBEB; border-color: #FDE68A; border-radius: 20px;">
                                <h5 class="fw-bold mb-2" style="color: var(--ve-dark);"><i class="fa fa-graduation-cap me-2 text-warning"></i> Edukatif</h5>
                                <p class="small text-muted mb-0" style="line-height: 1.6;">Menyediakan informasi artikel kesehatan terverifikasi medis untuk menghilangkan mitos dan kecemasan.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif
@endsection
