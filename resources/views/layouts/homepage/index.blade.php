@extends('layouts.homepage.template')

@section('title', 'KIA Care - Kesehatan Ibu & Anak')

@section('content')

    <!-- ===== HERO: Split layout — left text, right image panel ===== -->
    <section class="ve-hero">
        <div class="container-tight">
            <div class="ve-hero-inner">
                <!-- Left Panel -->
                <div class="ve-hero-left">
                    <span class="ve-hero-badge">Pendamping Setia Ibu & Anak · Terpercaya di Indonesia</span>
                    <h1>Jaga Kesehatan <span class="ve-highlight">Ibu & Buah Hati</span><br>Dengan Cinta</h1>
                    <p>KIA Care menyediakan panduan kesehatan lengkap, jadwal imunisasi, dan tips kehamilan untuk memastikan tumbuh kembang buah hati yang optimal.</p>
                    <div class="ve-hero-btns">
                        <a href="{{ route('homepage') }}#layanan" class="ve-btn-primary">Layanan Kami</a>
                        <a href="{{ route('homepage.about') }}" class="ve-btn-ghost">Pelajari Selengkapnya</a>
                    </div>
                    <!-- Quick Stats Row -->
                    <div class="ve-hero-stats">
                        <div class="ve-stat">
                            <strong>15rb+</strong>
                            <span>Ibu Terdaftar</span>
                        </div>
                        <div class="ve-stat-divider"></div>
                        <div class="ve-stat">
                            <strong>98%</strong>
                            <span>Kepuasan Ibu</span>
                        </div>
                        <div class="ve-stat-divider"></div>
                        <div class="ve-stat">
                            <strong>250+</strong>
                            <span>Tenaga Medis</span>
                        </div>
                    </div>
                </div>

                <!-- Right Panel: image card -->
                <div class="ve-hero-right">
                    <div class="ve-hero-media">
                        <img src="{{ asset('homepage/img/bg-img/mother_baby_hero.png') }}" alt="Ibu dan bayi" class="ve-hero-img-main">
                        <div class="ve-hero-img-accent" style="background-image:url({{ asset('homepage/img/bg-img/pediatrician_accent.png') }});"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== MARQUEE TRUST BAR ===== -->
    <div class="ve-trust-bar">
        <div class="ve-trust-inner">
            <span><i class="fa fa-heartbeat"></i> Terverifikasi Medis</span>
            <span><i class="fa fa-check-circle"></i> Sesuai Standar Kemenkes</span>
            <span><i class="fa fa-users"></i> 15,000+ Ibu Bergabung</span>
            <span><i class="fa fa-lock"></i> Data Privasi Aman</span>
            <span><i class="fa fa-hospital-o"></i> 500+ Mitra Klinik</span>
            <span><i class="fa fa-stethoscope"></i> 250+ Tenaga Medis</span>
            <span><i class="fa fa-heartbeat"></i> Terverifikasi Medis</span>
            <span><i class="fa fa-check-circle"></i> Sesuai Standar Kemenkes</span>
            <span><i class="fa fa-users"></i> 15,000+ Ibu Bergabung</span>
            <span><i class="fa fa-lock"></i> 256-bit Encryption</span>
        </div>
    </div>

    <!-- ===== INFO KIA 2024 & EDUKASI ===== -->
    <section class="section-gap">
        <div class="container-tight">
            <div class="text-center">
                <span class="badge-pill">Edukasi KIA 2024</span>
                <h2 class="hero-title-main">Pengetahuan Adalah <br><span style="color: var(--brand-p);">Kekuatan Ibu.</span></h2>
                <p class="hero-subtitle mx-auto">Materi kesehatan yang disusun secara ilmiah untuk mendampingi setiap langkah perkembangan buah hati Anda.</p>
            </div>

            <div class="bento-grid">
                <div class="bento-card tall">
                    <div>
                        <div class="icon-circle"><i class="fa fa-child"></i></div>
                        <h4 class="sora fw-bold mb-3">1000 HPK</h4>
                        <p>Fase krusial yang menentukan kualitas hidup anak selamanya. Pastikan nutrisi optimal hari demi hari.</p>
                    </div>
                    <div class="mt-5 d-none d-lg-block">
                        <img src="https://images.unsplash.com/photo-1596464716127-f2a82984de30?auto=format&fit=crop&q=80&w=400" class="w-100 rounded-4" style="height: 150px; object-fit: cover;">
                    </div>
                </div>
                <div class="bento-card wide">
                    <div class="row align-items-center">
                        <div class="col-md-7">
                            <div class="icon-circle" style="background: #E0F2FE; color: #0284C7;"><i class="fa fa-shield"></i></div>
                            <h4 class="sora fw-bold mb-3">Strategi Cegah Stunting</h4>
                            <p>Intervensi dini melalui pola asuh dan sanitasi untuk pertumbuhan fisik yang sempurna.</p>
                        </div>
                        <div class="col-md-5 d-none d-lg-block">
                            <img src="https://images.unsplash.com/photo-1584622650111-993a426fbf0a?auto=format&fit=crop&q=80&w=400" class="w-100 rounded-4" style="height: 200px; object-fit: cover;">
                        </div>
                    </div>
                </div>
                <div class="bento-card normal">
                    <div class="icon-circle" style="background: #FEF3C7; color: #D97706;"><i class="fa fa-tint"></i></div>
                    <h4 class="sora fw-bold mb-3">ASI Eksklusif</h4>
                    <p>Imunitas terbaik langsung dari ibu. Panduan sukses menyusui 6 bulan pertama.</p>
                </div>
                <div class="bento-card normal">
                    <div class="icon-circle" style="background: #F1F5F9; color: var(--brand-p);"><i class="fa fa-book"></i></div>
                    <h4 class="sora fw-bold mb-3">Katalog Digital</h4>
                    <p>Akses ratusan artikel gizi dan tips kesehatan ibu terbaru.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== PANDUAN BUKU KIA DIGITAL ===== -->
    <section class="section-gap" style="background: #F8FAFC;">
        <div class="container-tight">
            <div class="mockup-wrap">
                <div class="row align-items-center g-5">
                    <div class="col-lg-5 order-2 order-lg-1">
                        <span class="badge-pill" style="background: #fff;">Smart Platform</span>
                        <h2 class="sora fw-bold mb-4" style="font-size: 3.5rem; line-height: 1.1;">Buku KIA <br><span style="color: var(--brand-p);">Dalam Smartphone.</span></h2>
                        <p class="mb-5 fs-5">Lupakan buku fisik yang mudah rusak. Sekarang semua catatan kesehatan tersimpan aman di cloud.</p>
                        
                        <div class="d-none d-md-block">
                            <div class="d-flex mb-4">
                                <div class="me-4"><i class="fa fa-check-circle fs-3 text-success"></i></div>
                                <div>
                                    <h6 class="fw-bold m-0">Input Data Instan</h6>
                                    <p class="small text-muted">Catat hasil kontrol bidan dalam hitungan detik.</p>
                                </div>
                            </div>
                            <div class="d-flex mb-5">
                                <div class="me-4"><i class="fa fa-check-circle fs-3 text-success"></i></div>
                                <div>
                                    <h6 class="fw-bold m-0">Grafik Tumbuh Kembang</h6>
                                    <p class="small text-muted">Analisis otomatis KMS (Kartu Menuju Sehat) digital.</p>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex gap-4">
                            <a href="{{ route('login') }}" class="btn-p">Mulai Sekarang</a>
                            <a href="#" class="btn-s">Pelajari Fitur</a>
                        </div>
                    </div>
                    <div class="col-lg-7 order-1 order-lg-2">
                        <div class="mockup-screen" style="background: transparent; border: none; box-shadow: none; display: flex; justify-content: center;">
                            <img src="{{ asset('homepage/img/core-img/buku_kia.png') }}" class="rounded-4 shadow-2xl" style="max-width: 100%; height: auto;">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== FASKES & LAYANAN (LIGHT & COOL) ===== -->
    <section id="layanan" class="section-gap">
        <div class="container-tight">
            <div class="text-center mb-5">
                <span class="badge-pill">Jejaring Kesehatan</span>
                <h2 class="hero-title-main" style="font-size: 3.5rem;">Layanan Faskes <br><span style="color: var(--brand-s);">Dekat Dengan Anda.</span></h2>
            </div>

            <div class="row g-4">
                <div class="col-lg-7">
                    <div class="faskes-card-light">
                        <div class="position-relative rounded-4 overflow-hidden mb-4" style="height: 300px;">
                            <img src="https://images.unsplash.com/photo-1516549655169-df83a0774514?auto=format&fit=crop&q=80&w=1200" class="w-100 h-100 object-fit-cover">
                        </div>
                        <div class="icon-circle-s"><i class="fa fa-map-marker"></i></div>
                        <h3 class="sora fw-bold mb-3">Puskesmas Standar Internasional</h3>
                        <p class="text-muted">Fasilitas kesehatan primer dengan peralatan medis modern dan tenaga ahli untuk pelayanan KIA terbaik.</p>
                        <div class="mt-4">
                            <a href="#" class="btn-s">Cek Lokasi Terdekat</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="faskes-card-light" style="background: #F0FDFA; border-color: #CCFBF1;">
                        <div class="icon-circle-s" style="background: #fff;"><i class="fa fa-hospital-o"></i></div>
                        <h3 class="sora fw-bold mb-3">RS Umum Daerah</h3>
                        <p class="text-muted">Rujukan utama untuk penanganan medis tingkat lanjut bagi ibu dan anak dengan fasilitas rawat inap lengkap.</p>
                        <div class="mt-auto">
                            <div class="p-4 bg-white rounded-4 border border-info border-opacity-10 d-flex align-items-center mb-4">
                                <div class="me-3"><i class="fa fa-bed text-info fs-3"></i></div>
                                <div>
                                    <span class="d-block small text-muted">Ketersediaan Bed</span>
                                    <strong class="text-dark">12 Bed Tersedia</strong>
                                </div>
                            </div>
                            <a href="#" class="btn-p w-100 justify-content-center">Pesan Kamar</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== KONSULTASI ONLINE (MORE ROUNDED) ===== -->
    <section class="section-gap">
        <div class="container-tight">
            <div class="konsultasi-online p-5 shadow-2xl overflow-hidden position-relative" style="background: linear-gradient(135deg, #0F172A 0%, #1E293B 100%); border-radius: 80px;">
                <div class="row align-items-center py-5">
                    <div class="col-lg-7 px-lg-5" style="z-index: 2;">
                        <h2 class="sora fw-bold text-white mb-4" style="font-size: 4rem; line-height: 1;">Konsultasi <br><span style="color: var(--brand-p);">Cepat & Akurat.</span></h2>
                        <p class="text-white opacity-50 fs-4 mb-5">Terhubung langsung dengan dokter spesialis anak dan obgyn melalui integrasi WhatsApp Medis.</p>
                        <div class="d-flex gap-4">
                            <a href="{{ route('konsultasi-publik.form') }}" class="btn-p">Chat Sekarang</a>
                            <button type="button" class="btn-s-white" data-toggle="modal" data-target="#jadwalTemuModal">Jadwalkan Temu</button>
                        </div>
                    </div>
                    <div class="col-lg-5 text-center position-relative" style="z-index: 2;">
                        <!-- Floating Badge -->
                        <div class="position-absolute bg-white rounded-pill shadow-sm px-3 py-2 d-flex align-items-center gap-2" style="top: -20px; right: 20px; z-index: 3; color: var(--brand-p);">
                            <i class="bi bi-patch-check-fill fs-5"></i>
                            <span class="fw-bold small">Dokter Spesialis</span>
                        </div>
                        <img src="{{ asset('assets/img/telemedisin-hero.png') }}" class="rounded-5 shadow-lg w-100" style="height: 300px; object-fit: cover; border: 6px solid rgba(255,255,255,0.1);">
                    </div>
                </div>
                <!-- Abstract Glow -->
                <div style="position: absolute; top: -100px; right: -100px; width: 400px; height: 400px; background: radial-gradient(circle, rgba(236, 30, 136, 0.2) 0%, transparent 70%);"></div>
            </div>
        </div>
    </section>

    <!-- ===== FAQ & HELPDESK (HORIZONTAL LOOP) ===== -->
    <section class="section-gap overflow-hidden">
        <div class="container-tight">
            <div class="text-center mb-5">
                <span class="badge-pill">Pusat Bantuan</span>
                <h2 class="sora fw-bold" style="font-size: 3.5rem; line-height: 1.1;">Pertanyaan <br><span style="color: var(--brand-p);">Sering Diajukan.</span></h2>
                <p class="mt-4 text-muted fs-5 mx-auto" style="max-width: 600px;">Masih bingung? Tim kami siap membantu Anda 24/7 melalui pusat bantuan.</p>
            </div>
        </div>

        <div class="faq-marquee-container">
            <div class="faq-marquee-inner">
                @php
                    $staticFaqs = [
                        [
                            'pertanyaan' => 'Bagaimana cara mengakses Buku KIA Digital?',
                            'jawaban' => 'Anda cukup masuk ke akun KIA Care Anda, lalu pilih menu "Buku Digital". Semua data riwayat kesehatan Anda dan buah hati.',
                            'tips' => 'Perbarui data rutin setiap bulan.'
                        ],
                        [
                            'pertanyaan' => 'Apakah konsultasi online tersedia 24/7?',
                            'jawaban' => 'Layanan bantuan kami tersedia 24 jam, namun untuk konsultasi langsung mengikuti jadwal praktik dokter.',
                            'tips' => 'Gunakan fitur "Jadwalkan Temu".'
                        ]
                    ];

                    // Convert database collection to array or use static if empty
                    if ($faqs->count() > 0) {
                        $displayFaqs = $faqs->map(function($f) {
                            return [
                                'pertanyaan' => $f->pertanyaan,
                                'jawaban' => $f->jawaban,
                                'tips' => $f->tips ?? 'Patuhi jadwal kontrol rutin Anda.'
                            ];
                        })->toArray();
                    } else {
                        $displayFaqs = $staticFaqs;
                    }

                    // Duplicate items to ensure seamless loop if count is small
                    if (count($displayFaqs) < 6) {
                        $displayFaqs = array_merge($displayFaqs, $displayFaqs, $displayFaqs);
                    }
                @endphp

                @foreach($displayFaqs as $faq)
                    <div class="faq-marquee-card">
                        <div class="icon-circle" style="width: 50px; height: 50px; margin-bottom: 20px;"><i class="fa fa-question-circle" style="font-size: 1.2rem;"></i></div>
                        <h4 class="sora fw-bold mb-3">{{ $faq['pertanyaan'] }}</h4>
                        <p class="text-muted small mb-4">{{ $faq['jawaban'] }}</p>
                        <div class="p-3 rounded-4 bg-light border-start border-4 border-magenta">
                             <strong class="text-dark d-block mb-1 small">Tips:</strong>
                             <p class="x-small mb-0 text-muted">{{ $faq['tips'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- ===== SOLUSI KESEHATAN IBU & ANAK (REFINED) ===== -->
    <section class="section-gap pb-5" style="background: #F8FAFC;">
        <div class="container-tight">
            <div class="text-center mb-5">
                <span class="badge-pill">Layanan Kami</span>
                <h2 class="hero-title-main">Solusi Kesehatan <br><span style="color: var(--brand-p);">Ibu & Anak.</span></h2>
                <p class="hero-subtitle mx-auto">Pendampingan lengkap mulai dari masa kehamilan hingga tumbuh kembang anak.</p>
            </div>
            
            <div class="row g-5">
                <div class="col-md-4 py-4">
                    <div class="service-mini-card">
                        <div class="icon-box"><i class="fa fa-female"></i></div>
                        <h4 class="sora fw-bold mb-3">Panduan Kehamilan</h4>
                        <p class="text-muted">Informasi lengkap mengenai perkembangan janin dari minggu ke minggu.</p>
                        <a href="#" class="service-btn">Selengkapnya <i class="fa fa-arrow-right"></i></a>
                    </div>
                </div>
                <div class="col-md-4 py-4">
                    <div class="service-mini-card">
                        <div class="icon-box"><i class="fa fa-line-chart"></i></div>
                        <h4 class="sora fw-bold mb-3">Tumbuh Kembang</h4>
                        <p class="text-muted">Pantau perkembangan motorik, sensorik, dan kognitif buah hati Anda.</p>
                        <a href="#" class="service-btn">Selengkapnya <i class="fa fa-arrow-right"></i></a>
                    </div>
                </div>
                <div class="col-md-4 py-4">
                    <div class="service-mini-card">
                        <div class="icon-box"><i class="fa fa-calendar-check-o"></i></div>
                        <h4 class="sora fw-bold mb-3">Jadwal Imunisasi</h4>
                        <p class="text-muted">Jangan lewatkan pengingat jadwal imunisasi dasar lengkap.</p>
                        <a href="#" class="service-btn">Selengkapnya <i class="fa fa-arrow-right"></i></a>
                    </div>
                </div>
                <div class="col-md-4 py-4">
                    <div class="service-mini-card">
                        <div class="icon-box"><i class="fa fa-cutlery"></i></div>
                        <h4 class="sora fw-bold mb-3">Gizi Ibu & Anak</h4>
                        <p class="text-muted">Rekomendasi asupan nutrisi seimbang untuk Ibu dan MPASI sehat.</p>
                        <a href="#" class="service-btn">Selengkapnya <i class="fa fa-arrow-right"></i></a>
                    </div>
                </div>
                <div class="col-md-4 py-4">
                    <div class="service-mini-card">
                        <div class="icon-box"><i class="fa fa-stethoscope"></i></div>
                        <h4 class="sora fw-bold mb-3">Tips Persalinan</h4>
                        <p class="text-muted">Persiapkan diri menyambut kelahiran dengan panduan teknik pernapasan.</p>
                        <a href="#" class="service-btn">Selengkapnya <i class="fa fa-arrow-right"></i></a>
                    </div>
                </div>
                <div class="col-md-4 py-4">
                    <div class="service-mini-card">
                        <div class="icon-box"><i class="fa fa-heart"></i></div>
                        <h4 class="sora fw-bold mb-3">Kesehatan Mental</h4>
                        <p class="text-muted">Dukungan emosional dan tips mengatasi baby blues pasca persalinan.</p>
                        <a href="#" class="service-btn">Selengkapnya <i class="fa fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== WHY US (two-column: image left, content right) ===== -->
    <section class="ve-section ve-whyus-section">
        <div class="container">
            <div class="row align-items-center">
                <!-- Image Side -->
                <div class="col-12 col-lg-5">
                    <div class="ve-whyus-img-wrap wow fadeInLeft" data-wow-delay="100ms">
                        <div class="ve-whyus-img-main bg-img" style="background-image:url({{ asset('homepage/img/bg-img/pediatrician_accent.png') }});"></div>
                        <div class="ve-whyus-badge">
                            <strong>10rb+</strong>
                            <span>Ibu Terbantu</span>
                        </div>
                    </div>
                </div>
                <!-- Content Side -->
                <div class="col-12 col-lg-7 wow fadeInRight" data-wow-delay="200ms">
                    <div class="ve-whyus-content">
                        <span class="ve-section-tag">Mengapa Memilih KIA Care</span>
                        <h2>Mitra Terpercaya Untuk <span>Kesehatan Keluarga</span></h2>
                        <p>Kami memahami bahwa kesehatan Ibu dan Anak adalah prioritas utama. Dengan pendekatan yang ramah dan informasi yang akurat, kami hadir untuk mendukung setiap langkah perjalanan Anda.</p>
                        <div class="ve-checklist">
                            <div class="ve-check-item">
                                <i class="fa fa-heartbeat"></i>
                                <div><strong>Informasi Terverifikasi</strong><p>Semua panduan kesehatan disusun oleh tenaga medis profesional sesuai standar Kemenkes.</p></div>
                            </div>
                            <div class="ve-check-item">
                                <i class="fa fa-bell"></i>
                                <div><strong>Pengingat Otomatis</strong><p>Notifikasi pintar untuk jadwal imunisasi dan kontrol rutin kehamilan Anda.</p></div>
                            </div>
                            <div class="ve-check-item">
                                <i class="fa fa-users"></i>
                                <div><strong>Komunitas Ibu</strong><p>Bergabung dengan ribuan Ibu lainnya untuk berbagi pengalaman dan dukungan.</p></div>
                            </div>
                        </div>
                        <a href="about.html" class="ve-btn-primary mt-30">Selengkapnya Tentang Kami</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== COUNTERS ===== -->
    <section class="ve-counter-section">
        <div class="container">
            <div class="ve-counter-grid">
                <div class="ve-counter-item wow fadeInUp" data-wow-delay="100ms">
                    <i class="fa fa-users"></i>
                    <strong class="counter" data-count="15000">0</strong><span>+</span>
                    <p>Ibu Terdaftar</p>
                </div>
                <div class="ve-counter-item wow fadeInUp" data-wow-delay="200ms">
                    <i class="fa fa-child"></i>
                    <strong class="counter" data-count="12000">0</strong><span>+</span>
                    <p>Anak Terpantau</p>
                </div>
                <div class="ve-counter-item wow fadeInUp" data-wow-delay="300ms">
                    <i class="fa fa-hospital-o"></i>
                    <strong class="counter" data-count="500">0</strong><span>+</span>
                    <p>Mitra Klinik</p>
                </div>
                <div class="ve-counter-item wow fadeInUp" data-wow-delay="400ms">
                    <i class="fa fa-stethoscope"></i>
                    <strong class="counter" data-count="250">0</strong><span>+</span>
                    <p>Tenaga Medis</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== TESTIMONIALS ===== -->
    <section class="ve-section ve-testimonials-section">
        <div class="container">
            <div class="ve-section-header text-center">
                <span class="ve-section-tag">Kisah Sukses</span>
                <h2>Apa Kata <span>Para Ibu?</span></h2>
            </div>
            <div class="ve-testi-grid">
                <div class="ve-testi-card wow fadeInUp" data-wow-delay="100ms">
                    <div class="ve-testi-stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
                    <p>"Sangat membantu memantau jadwal imunisasi anak saya. Pengingatnya sangat akurat dan informasinya sangat lengkap."</p>
                    <div class="ve-testi-author">
                        <div class="ve-testi-avatar bg-img" style="background-image:url({{ asset('homepage/img/bg-img/mother_avatar.png') }});"></div>
                        <div><strong>Ibu Rahma</strong><span>Ibu Rumah Tangga</span></div>
                    </div>
                </div>
                <div class="ve-testi-card wow fadeInUp" data-wow-delay="250ms">
                    <div class="ve-testi-stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
                    <p>"Panduan kehamilannya sangat detail. Saya jadi tidak khawatir lagi menghadapi persalinan anak pertama saya."</p>
                    <div class="ve-testi-author">
                        <div class="ve-testi-avatar bg-img" style="background-image:url({{ asset('homepage/img/bg-img/mother_avatar.png') }});"></div>
                        <div><strong>Ibu Sari</strong><span>Guru SD</span></div>
                    </div>
                </div>
                <div class="ve-testi-card wow fadeInUp" data-wow-delay="400ms">
                    <div class="ve-testi-stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
                    <p>"Konsultasi gizi lewat KIA Care sangat praktis. Menu MPASI yang disarankan sangat disukai oleh buah hati saya."</p>
                    <div class="ve-testi-author">
                        <div class="ve-testi-avatar bg-img" style="background-image:url({{ asset('homepage/img/bg-img/mother_avatar.png') }});"></div>
                        <div><strong>Ibu Linda</strong><span>Karyawan Swasta</span></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== CTA BANNER ===== -->
    <section class="ve-cta-banner bg-img" style="background-image:url({{ asset('homepage/img/bg-img/maternity_clinic_bg.png') }});">
        <div class="ve-cta-overlay"></div>
        <div class="container ve-cta-content">
            <div class="row align-items-center">
                <div class="col-12 col-lg-8">
                    <h2>Siap Menyambut Buah Hati <span>Dengan Bahagia?</span></h2>
                    <p>Dapatkan konsultasi gratis 30 menit dengan bidan atau ahli gizi kami hari ini.</p>
                </div>
                <div class="col-12 col-lg-4 text-lg-right">
                    <a href="contact.html" class="ve-btn-white">Hubungi Kami Sekarang</a>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== LATEST INSIGHTS ===== -->
    <section class="ve-section ve-insights-section">
        <div class="container">
            <div class="ve-section-header text-center">
                <span class="ve-section-tag">Artikel & Tips</span>
                <h2>Wawasan Kesehatan <span>Terbaru</span></h2>
                <p>Tetap terinformasi dengan tips ahli, analisis kesehatan, dan panduan praktis untuk Ibu & Anak.</p>
            </div>
            <div class="row">
                <div class="col-12 col-md-4 wow fadeInUp" data-wow-delay="100ms">
                    <div class="ve-insight-card">
                        <div class="ve-insight-img bg-img" style="background-image:url({{ asset('homepage/img/bg-img/mother_baby_hero.png') }});"></div>
                        <div class="ve-insight-body">
                            <span class="ve-insight-cat">Kehamilan</span>
                            <h5><a href="single-post.html">5 Tips Menjaga Nutrisi Selama Trimester Pertama</a></h5>
                            <p>Pelajari asupan makanan penting yang dibutuhkan janin Anda di awal masa kehamilan.</p>
                            <div class="ve-insight-meta">
                                <span><i class="fa fa-calendar"></i> April 26</span>
                                <a href="single-post.html">Baca Selengkapnya <i class="fa fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-4 wow fadeInUp" data-wow-delay="250ms">
                    <div class="ve-insight-card">
                        <div class="ve-insight-img bg-img" style="background-image:url({{ asset('homepage/img/bg-img/') }}pediatrician_accent.png);"></div>
                        <div class="ve-insight-body">
                            <span class="ve-insight-cat">Imunisasi</span>
                            <h5><a href="single-post.html">Pentingnya Imunisasi Dasar Lengkap Bagi Bayi</a></h5>
                            <p>Kenali jenis-jenis imunisasi yang wajib diberikan untuk melindungi buah hati dari penyakit berbahaya.</p>
                            <div class="ve-insight-meta">
                                <span><i class="fa fa-calendar"></i> April 20</span>
                                <a href="single-post.html">Baca Selengkapnya <i class="fa fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-4 wow fadeInUp" data-wow-delay="400ms">
                    <div class="ve-insight-card">
                        <div class="ve-insight-img bg-img" style="background-image:url({{ asset('homepage/img/bg-img/') }}mother_baby_hero.png);"></div>
                        <div class="ve-insight-body">
                            <span class="ve-insight-cat">Parenting</span>
                            <h5><a href="single-post.html">Membangun Ikatan Batin Sejak Anak dalam Kandungan</a></h5>
                            <p>Cara-cara sederhana namun efektif untuk mulai berkomunikasi dengan calon buah hati Anda.</p>
                            <div class="ve-insight-meta">
                                <span><i class="fa fa-calendar"></i> April 14</span>
                                <a href="single-post.html">Baca Selengkapnya <i class="fa fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== NEWSLETTER ===== -->
    <section class="ve-newsletter-section">
        <div class="container">
            <div class="ve-newsletter-wrap">
                <div class="ve-nl-left">
                    <i class="fa fa-envelope-o"></i>
                    <div>
                        <h3>Dapatkan Tips Mingguan</h3>
                        <p>Wawasan kesehatan, tips kehamilan, dan penawaran eksklusif langsung ke email Anda.</p>
                    </div>
                </div>
                <div class="ve-nl-right">
                    <form class="ve-nl-form" action="#" method="post">
                        <input type="email" placeholder="Masukkan alamat email Anda" required>
                        <button type="submit">Berlangganan</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== FOOTER (dark, 4-column) ===== -->
    <footer class="ve-footer">
        <div class="container">
            <div class="row">
                <!-- Col 1: Brand -->
                <div class="col-12 col-sm-6 col-lg-4 mb-50">
                    <div class="ve-footer-brand">
                        <a href="{{ route('homepage') }}" class="ve-footer-logo d-flex align-items-center mb-4">
                            <img src="{{ asset('assets/img/logo.png') }}" alt="Logo" style="height: 50px;" class="me-2">
                            <span class="ve-logo-text" style="font-size: 1.5rem; font-weight: 700; color: #fff;">Buku <strong>KIA</strong></span>
                        </a>
                        <p>Pendamping terpercaya dalam menjaga kesehatan Ibu dan Anak dengan informasi medis terkini dan layanan penuh kasih.</p>
                        <div class="ve-social">
                            <a href="#"><i class="fa fa-facebook"></i></a>
                            <a href="#"><i class="fa fa-instagram"></i></a>
                            <a href="#"><i class="fa fa-whatsapp"></i></a>
                            <a href="#"><i class="fa fa-youtube"></i></a>
                        </div>
                    </div>
                </div>
                <!-- Col 2: Quick Links -->
                <div class="col-12 col-sm-6 col-lg-2 mb-50">
                    <h5 class="ve-footer-title">Tautan Cepat</h5>
                    <ul class="ve-footer-links">
                        <li><a href="index.html">Beranda</a></li>
                        <li><a href="about.html">Tentang Kami</a></li>
                        <li><a href="services.html">Layanan</a></li>
                        <li><a href="post.html">Artikel</a></li>
                        <li><a href="contact.html">Kontak</a></li>
                    </ul>
                </div>
                <!-- Col 3: Services -->
                <div class="col-12 col-sm-6 col-lg-3 mb-50">
                    <h5 class="ve-footer-title">Layanan Utama</h5>
                    <ul class="ve-footer-links">
                        <li><a href="#">Panduan Kehamilan</a></li>
                        <li><a href="#">Jadwal Imunisasi</a></li>
                        <li><a href="#">Konsultasi Gizi</a></li>
                        <li><a href="#">Tumbuh Kembang</a></li>
                        <li><a href="#">Kesehatan Ibu</a></li>
                    </ul>
                </div>
                <!-- Col 4: Contact -->
                <div class="col-12 col-sm-6 col-lg-3 mb-50">
                    <h5 class="ve-footer-title">Hubungi Kami</h5>
                    <ul class="ve-footer-contact">
                        <li><i class="fa fa-map-marker"></i> Jl. Kesehatan No. 123, Jakarta Pusat</li>
                        <li><i class="fa fa-phone"></i> +62 21 5555 0001</li>
                        <li><i class="fa fa-envelope"></i> info@kiacare.id</li>
                        <li><i class="fa fa-clock-o"></i> Senin–Jumat, 08:00 – 17:00</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Footer Bottom Bar -->
        <div class="ve-footer-bottom">
            <div class="container">
                <div class="ve-footer-bottom-inner">
                    <p>Copyright &copy; <script>document.write(new Date().getFullYear());</script> KIA Care. All Rights Reserved</p>
                    <ul>
                        <li><a href="#">Privacy Policy</a></li>
                        <li><a href="#">Terms of Use</a></li>
                        <li><a href="#">Cookie Policy</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="{{ asset('homepage/js/jquery/jquery-2.2.4.min.js') }}"></script>
    <script src="{{ asset('homepage/js/bootstrap/popper.min.js') }}"></script>
    <script src="{{ asset('homepage/js/bootstrap/bootstrap.min.js') }}"></script>
    <script src="{{ asset('homepage/js/plugins/plugins.js') }}"></script>
    <script src="{{ asset('homepage/js/active.js') }}"></script>
    <script src="{{ asset('homepage/js/vaultedge.js') }}"></script>
    <script>
        $(window).on('load', function() {
            $('.preloader').addClass('fade-out');
            setTimeout(function() {
                $('.preloader').hide();
            }, 800);
        });
    </script>

    <!-- Modal Jadwal Temu -->
    <div class="modal fade" id="jadwalTemuModal" tabindex="-1" role="dialog" aria-labelledby="jadwalTemuModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content rounded-4 border-0 shadow-lg">
                <div class="modal-header border-0 pb-0 d-flex justify-content-between align-items-center" style="background: var(--brand-p); color: white; border-radius: 15px 15px 0 0; padding: 25px;">
                    <h5 class="modal-title fw-bold" id="jadwalTemuModalLabel"><i class="fa fa-calendar-check-o me-2"></i> Jadwalkan Temu Dokter</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" style="opacity: 1; text-shadow: none;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-4">
                    <p class="text-muted small mb-4">Silakan lengkapi form berikut untuk membuat janji temu dengan dokter spesialis di fasilitas kesehatan kami.</p>
                    <form id="formJadwalTemu">
                        <div class="form-group mb-3">
                            <label class="form-label fw-bold small text-dark">Nama Lengkap Pasien</label>
                            <input type="text" class="form-control rounded-3" placeholder="Masukkan nama Anda" required>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label fw-bold small text-dark">Nomor WhatsApp</label>
                            <input type="tel" class="form-control rounded-3" placeholder="Contoh: 08123456789" required>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label fw-bold small text-dark">Pilih Layanan Poli</label>
                            <select class="form-control rounded-3" required>
                                <option value="">-- Pilih Poli --</option>
                                <option value="Kandungan (Obgyn)">Kandungan (Obgyn)</option>
                                <option value="Anak (Pediatri)">Anak (Pediatri)</option>
                                <option value="Gizi">Konsultasi Gizi</option>
                                <option value="Umum">Dokter Umum</option>
                            </select>
                        </div>
                        <div class="form-group mb-4">
                            <label class="form-label fw-bold small text-dark">Rencana Tanggal Kunjungan</label>
                            <input type="date" class="form-control rounded-3" required>
                        </div>
                        <button type="submit" class="btn-p w-100 p-3" style="border-radius: 12px; font-size: 1rem;">Kirim Permintaan Jadwal</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.getElementById('formJadwalTemu').addEventListener('submit', function(e) {
            e.preventDefault();
            // Tutup modal bootstrap menggunakan jQuery (kompatibel BS4 & BS5)
            $('#jadwalTemuModal').modal('hide');

            // Tampilkan notifikasi sukses
            Swal.fire({
                title: 'Permintaan Berhasil!',
                text: 'Jadwal temu Anda sedang diproses. Petugas kami akan segera menghubungi Anda melalui WhatsApp untuk konfirmasi jam kehadiran.',
                icon: 'success',
                confirmButtonColor: '#EC1E88',
                confirmButtonText: 'Tutup'
            }).then(() => {
                this.reset();
            });
        });
    </script>
@endsection
