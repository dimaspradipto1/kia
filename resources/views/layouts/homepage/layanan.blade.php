@extends('layouts.homepage.template')

@section('title', 'Layanan Faskes - KIA Care')

@section('content')
    <!-- Page Hero -->
    <section class="ve-page-hero" style="background-image:url('{{ asset('homepage/img/clinic_bg_1779872776394.png') }}');">
        <div class="ve-page-hero-overlay"></div>
        <div class="container ve-page-hero-content">
            <span class="ve-section-tag">Jejaring Kesehatan</span>
            <h1>Layanan Faskes <span>Dekat Dengan Anda</span></h1>
            <nav aria-label="breadcrumb">
                <ol class="ve-breadcrumb">
                    <li><a href="{{ route('homepage') }}">Beranda</a></li>
                    <li class="active">Layanan Faskes</li>
                </ol>
            </nav>
        </div>
    </section>

    <!-- Hero About Section -->
    <section class="section-gap" style="padding-top: 80px; padding-bottom: 50px;">
        <div class="container-tight">
            <div class="row align-items-center g-5">
                <div class="col-12 col-lg-6">
                    <div style="position: relative; border-radius: 40px; overflow: hidden; box-shadow: 0 30px 60px rgba(15, 23, 42, 0.1);">
                        <img src="{{ asset('homepage/img/doctor_obgyn_1779872831013.png') }}" class="w-100 d-block" alt="KIA Care" style="height: 450px; object-fit: cover;">
                    </div>
                </div>
                <div class="col-12 col-lg-6">
                    <span class="badge-pill">Tentang Layanan</span>
                    <h2 class="hero-title-main" style="font-size: clamp(2rem, 4vw, 3rem);">KIA Care adalah <span style="color: var(--brand-p);">platform kesehatan</span> ibu dan anak</h2>
                    <p class="hero-subtitle">Kami menyediakan layanan kesehatan terpadu yang menghubungkan ibu, anak, dan fasilitas kesehatan profesional.</p>
                    <div style="margin-top: 30px;">
                        <div class="mb-3 d-flex align-items-start gap-3">
                            <i class="fa fa-check-circle" style="color: var(--brand-s); font-size: 1.3rem; margin-top: 2px;"></i>
                            <div>
                                <h5 class="fw-bold mb-1">Jejaring Kesehatan Luas</h5>
                                <p class="text-muted small">Bekerjasama dengan puskesmas dan rumah sakit terpercaya di seluruh Indonesia</p>
                            </div>
                        </div>
                        <div class="mb-3 d-flex align-items-start gap-3">
                            <i class="fa fa-check-circle" style="color: var(--brand-s); font-size: 1.3rem; margin-top: 2px;"></i>
                            <div>
                                <h5 class="fw-bold mb-1">Tenaga Medis Profesional</h5>
                                <p class="text-muted small">Dokter spesialis dan bidan berpengalaman siap melayani 24/7</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-start gap-3">
                            <i class="fa fa-check-circle" style="color: var(--brand-s); font-size: 1.3rem; margin-top: 2px;"></i>
                            <div>
                                <h5 class="fw-bold mb-1">Teknologi Digital Terdepan</h5>
                                <p class="text-muted small">Integrasi teknologi untuk kemudahan akses dan monitoring kesehatan</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Layanan Unggulan Section -->
    <section class="section-gap" style="background: #F8FAFC; padding-top: 80px; padding-bottom: 50px;">
        <div class="container-tight">
            <div class="text-center mb-5">
                <span class="badge-pill">Layanan Kami</span>
                <h2 class="hero-title-main" style="font-size: clamp(2rem, 4vw, 3.5rem);">Layanan Unggulan<br><span style="color: var(--brand-p);">KIA Care</span></h2>
                <p class="hero-subtitle mx-auto">Berikut adalah layanan-layanan utama yang kami sediakan melalui jaringan mitra kesehatan profesional.</p>
            </div>

            <div class="row g-3 g-lg-4 justify-content-center">
                <div class="col-6 col-md-4 col-lg-4 mb-4">
                    <div class="service-mini-card">
                        <div class="icon-box"><i class="fa fa-female"></i></div>
                        <h4 class="sora fw-bold mb-2" style="font-size: 1rem;">Pemeriksaan Kehamilan</h4>
                        <p class="text-muted small">Konsultasi rutin dan USG dengan standar medis internasional.</p>
                    </div>
                </div>
                <div class="col-6 col-md-4 col-lg-4 mb-4">
                    <div class="service-mini-card">
                        <div class="icon-box"><i class="fa fa-child"></i></div>
                        <h4 class="sora fw-bold mb-2" style="font-size: 1rem;">Imunisasi Anak</h4>
                        <p class="text-muted small">Program imunisasi lengkap sesuai jadwal pemerintah.</p>
                    </div>
                </div>
                <div class="col-6 col-md-4 col-lg-4 mb-4">
                    <div class="service-mini-card">
                        <div class="icon-box"><i class="fa fa-stethoscope"></i></div>
                        <h4 class="sora fw-bold mb-2" style="font-size: 1rem;">Konsultasi Medis</h4>
                        <p class="text-muted small">Dokter spesialis anak dan obgyn berpengalaman.</p>
                    </div>
                </div>
                <div class="col-6 col-md-4 col-lg-4 mb-4">
                    <div class="service-mini-card">
                        <div class="icon-box"><i class="fa fa-line-chart"></i></div>
                        <h4 class="sora fw-bold mb-2" style="font-size: 1rem;">Tumbuh Kembang</h4>
                        <p class="text-muted small">Pantau perkembangan anak melalui aplikasi digital.</p>
                    </div>
                </div>
                <div class="col-6 col-md-4 col-lg-4 mb-4">
                    <div class="service-mini-card">
                        <div class="icon-box"><i class="fa fa-cutlery"></i></div>
                        <h4 class="sora fw-bold mb-2" style="font-size: 1rem;">Konsultasi Gizi</h4>
                        <p class="text-muted small">Program gizi seimbang untuk ibu dan anak.</p>
                    </div>
                </div>
                <div class="col-6 col-md-4 col-lg-4 mb-4">
                    <div class="service-mini-card">
                        <div class="icon-box"><i class="fa fa-heart"></i></div>
                        <h4 class="sora fw-bold mb-2" style="font-size: 1rem;">Kesehatan Mental</h4>
                        <p class="text-muted small">Konseling untuk mengatasi stress dan kecemasan.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Tim Profesional Section -->
    <section class="section-gap" style="background: linear-gradient(135deg, #4A1E5C 0%, #2D1B3D 100%); padding-top: 80px; padding-bottom: 80px;">
        <div class="container-tight">
            <div class="text-center mb-5">
                <span class="badge-pill" style="background: rgba(255,255,255,0.15); color: #fff; border-color: rgba(255,255,255,0.2);">Tim KIA Care</span>
                <h2 class="hero-title-main" style="font-size: clamp(2rem, 4vw, 3rem); color: #fff;">Profesional<span style="color: var(--brand-p);"> di Balik Layar</span></h2>
                <p class="hero-subtitle mx-auto" style="color: rgba(255,255,255,0.7);">Tim kami terdiri dari tenaga kesehatan dan pengembang yang berfokus pada pengalaman ibu dan anak.</p>
            </div>

            <div class="row g-4 g-md-5 justify-content-center">
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="ve-team-card" style="background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.1); border-radius: 30px; padding: 0; overflow: hidden; transition: all 0.3s;">
                        <div class="ve-team-img bg-img" style="background-image:url('{{ asset('homepage/img/nurse_doctor1_1779872814462.png') }}'); height: 200px;"></div>
                        <div class="ve-team-info" style="padding: 25px; text-align: center; color: #fff; background: transparent !important;">
                            <h5 style="margin: 0 0 5px 0; font-weight: 700; color: #fff;">Dr. Sari Wati</h5>
                            <span style="font-size: 0.9rem; opacity: 0.8; display: block; color: rgba(255,255,255,0.85);">Chief Medical Officer</span>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="ve-team-card" style="background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.1); border-radius: 30px; padding: 0; overflow: hidden; transition: all 0.3s;">
                        <div class="ve-team-img bg-img" style="background-image:url('{{ asset('homepage/img/anton_prasetyo_1779875068396.png') }}'); height: 200px;"></div>
                        <div class="ve-team-info" style="padding: 25px; text-align: center; color: #fff; background: transparent !important;">
                            <h5 style="margin: 0 0 5px 0; font-weight: 700; color: #fff;">Anton Prasetyo</h5>
                            <span style="font-size: 0.9rem; opacity: 0.8; display: block; color: rgba(255,255,255,0.85);">Head of Product</span>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="ve-team-card" style="background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.1); border-radius: 30px; padding: 0; overflow: hidden; transition: all 0.3s;">
                        <div class="ve-team-img bg-img" style="background-image:url('{{ asset('homepage/img/rina_mulyani_1779875089014.png') }}'); height: 200px;"></div>
                        <div class="ve-team-info" style="padding: 25px; text-align: center; color: #fff; background: transparent !important;">
                            <h5 style="margin: 0 0 5px 0; font-weight: 700; color: #fff;">Rina Mulyani</h5>
                            <span style="font-size: 0.9rem; opacity: 0.8; display: block; color: rgba(255,255,255,0.85);">Head of Customer Care</span>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="ve-team-card" style="background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.1); border-radius: 30px; padding: 0; overflow: hidden; transition: all 0.3s;">
                        <div class="ve-team-img bg-img" style="background-image:url('{{ asset('homepage/img/budi_santoso_1779875109468.png') }}'); height: 200px;"></div>
                        <div class="ve-team-info" style="padding: 25px; text-align: center; color: #fff; background: transparent !important;">
                            <h5 style="margin: 0 0 5px 0; font-weight: 700; color: #fff;">Budi Santoso</h5>
                            <span style="font-size: 0.9rem; opacity: 0.8; display: block; color: rgba(255,255,255,0.85);">Head of Development</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Counters Section -->
    <section class="ve-counter-section" style="background: #F8FAFC;">
        <div class="container-tight">
            <div class="ve-counter-grid">
                <div class="ve-counter-item">
                    <i class="fa fa-users"></i>
                    <strong class="counter" data-count="15000">0</strong><span>+</span>
                    <p>Ibu Terbantu</p>
                </div>
                <div class="ve-counter-item">
                    <i class="fa fa-book"></i>
                    <strong class="counter" data-count="120">0</strong><span>+</span>
                    <p>Materi Edukasi</p>
                </div>
                <div class="ve-counter-item">
                    <i class="fa fa-hospital-o"></i>
                    <strong class="counter" data-count="34">0</strong><span>+</span>
                    <p>Faskes Mitra</p>
                </div>
                <div class="ve-counter-item">
                    <i class="fa fa-heart"></i>
                    <strong class="counter" data-count="98">0</strong><span>%</span>
                    <p>Tingkat Kepuasan</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Newsletter Section -->
    <section class="section-gap" style="padding-top: 60px; padding-bottom: 30px;">
        <div class="container-tight">
            <div class="ve-newsletter-wrap">
                <div class="ve-nl-left">
                    <i class="fa fa-envelope-o"></i>
                    <div>
                        <h3>Terhubung dengan KIA Care</h3>
                        <p>Dapatkan update edukasi kesehatan ibu dan anak langsung ke email Anda.</p>
                    </div>
                </div>
                <div class="ve-nl-right">
                    <form class="ve-nl-form" action="#" method="post">
                        <input type="email" placeholder="Masukkan email Anda" required>
                        <button type="submit">Berlangganan</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="section-gap" style="padding-top: 30px; padding-bottom: 60px;">
        <div class="container-tight">
            <div class="konsultasi-online p-4 p-md-5 shadow-2xl overflow-hidden position-relative" style="background: linear-gradient(135deg, #0F172A 0%, #1E293B 100%); border-radius: 40px;">
                <div class="row align-items-center py-3 py-md-5">
                    <div class="col-12 col-lg-8 px-2 px-lg-4" style="z-index: 2;">
                        <h2 class="sora fw-bold text-white mb-3 mb-md-4" style="font-size: clamp(1.8rem, 5vw, 3.5rem); line-height: 1.1;">Butuh Konsultasi<span style="color: var(--brand-p);"> Kesehatan?</span></h2>
                        <p class="text-white opacity-75 mb-4" style="font-size: clamp(0.9rem, 2vw, 1.1rem);">Hubungi langsung fasilitas kesehatan mitra kami atau konsultasi melalui aplikasi KIA Care.</p>
                        <div class="d-flex flex-column flex-md-row">
                            <a href="{{ route('konsultasi-publik.form') }}" class="btn-p mr-md-3 mb-3 mb-md-0" style="width: fit-content;">Chat Dokter</a>
                            <button type="button" class="btn-s-white" data-toggle="modal" data-target="#jadwalTemuModal" style="width: fit-content;">Jadwalkan Temu</button>
                        </div>
                    </div>
                    <div class="col-12 col-lg-4 text-center position-relative d-none d-lg-block" style="z-index: 2;">
                        <div style="font-size: 10rem; opacity: 0.08;">
                            <i class="fa fa-stethoscope"></i>
                        </div>
                    </div>
                </div>
                <div style="position: absolute; top: -100px; right: -100px; width: 400px; height: 400px; background: radial-gradient(circle, rgba(236, 30, 136, 0.2) 0%, transparent 70%);"></div>
            </div>
        </div>
    </section>
@endsection
