<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="KIA Care - Layanan Kesehatan Ibu dan Anak Terpercaya">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>KIA Care - Kesehatan Ibu &amp; Anak</title>

    <link rel="icon" href="{{ asset('homepage/img/core-img/logo.png') }}">
    <link rel="stylesheet" href="{{ asset('homepage/style.css') }}">
    <link rel="stylesheet" href="{{ asset('homepage/css/custom-override.css') }}">
</head>

<body>
    <!-- Preloader -->
    <div class="preloader d-flex align-items-center justify-content-center">
        <div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div>
    </div>

    <!-- ===== NAVBAR (single dark bar, logo left, nav center, CTA right) ===== -->
    <header class="ve-header" id="ve-sticky">
        <div class="container-fluid ve-nav-wrap">
            <!-- Logo -->
            <div class="ve-logo">
                <a href="{{ route('homepage') }}" class="d-flex align-items-center">
                    <img src="{{ asset('assets/img/logo.png') }}" alt="Logo" style="height: 45px;" class="me-2">
                    <div class="ve-logo-text">
                        <span style="font-size: 1.2rem; font-weight: 700; color: #EC1E88;"><strong style="color: var(--primary-color);">KIA</strong></span>
                    </div>
                </a>
            </div>

            <!-- Nav Links -->
            <nav class="ve-nav">
                <ul>
                    <li><a href="{{ route('homepage') }}" class="active">Beranda</a></li>
                    <li class="has-drop">
                        <a href="#">Tentang <i class="fa fa-angle-down"></i></a>
                        <ul class="ve-dropdown">
                            <li><a href="#">Tentang Kami</a></li>
                            <li><a href="#">Layanan</a></li>
                            <li><a href="#">Fitur App</a></li>
                        </ul>
                    </li>
                    <li><a href="#">Layanan</a></li>
                    <li class="has-drop">
                        <a href="#">Program <i class="fa fa-angle-down"></i></a>
                        <ul class="ve-dropdown">
                            <li><a href="#">Kehamilan Sehat</a></li>
                            <li><a href="#">Imunisasi Rutin</a></li>
                            <li><a href="#">Nutrisi & Gizi</a></li>
                            <li><a href="#">Tumbuh Kembang</a></li>
                        </ul>
                    </li>
                    <li><a href="#">Artikel</a></li>
                    <li><a href="#">Kontak</a></li>
                </ul>
            </nav>

            <!-- CTA -->
            <div class="ve-nav-cta">
                @auth
                    <a href="{{ route('dashboard') }}" class="ve-cta-btn">Dashboard <i class="fa fa-th-large"></i></a>
                @else
                    <a href="{{ route('login') }}" class="ve-cta-btn">Masuk <i class="fa fa-sign-in"></i></a>
                @endauth
            </div>

            <!-- Mobile Toggle -->
            <button class="ve-toggler" id="ve-toggle">
                <span></span><span></span><span></span>
            </button>
        </div>

        <!-- Mobile Menu -->
        <div class="ve-mobile-menu" id="ve-mobile-menu">
            <ul>
                <li><a href="{{ route('homepage') }}">Beranda</a></li>
                <li><a href="#">Tentang</a></li>
                <li><a href="#">Layanan</a></li>
                <li><a href="#">Program</a></li>
                <li><a href="#">Artikel</a></li>
                <li><a href="#">Kontak</a></li>
            </ul>
        </div>
    </header>

    <!-- ===== HERO: Split layout — left text, right image panel ===== -->
    <section class="ve-hero">
        <!-- Left Panel -->
        <div class="ve-hero-left">
            <span class="ve-hero-badge">Pendamping Setia Ibu & Anak &nbsp;·&nbsp; Terpercaya di Indonesia</span>
            <h1>Jaga Kesehatan <span class="ve-highlight">Ibu & Buah Hati</span><br>Dengan Cinta</h1>
            <p>KIA Care menyediakan panduan kesehatan lengkap, jadwal imunisasi, dan tips kehamilan untuk memastikan tumbuh kembang buah hati yang optimal.</p>
            <div class="ve-hero-btns">
                <a href="services.html" class="ve-btn-primary">Layanan Kami</a>
                <a href="about.html" class="ve-btn-ghost">Pelajari Selengkapnya</a>
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
        <!-- Right Panel: overlapping image cards -->
        <div class="ve-hero-right">
            <div class="ve-hero-img-main bg-img" style="background-image:url({{ asset('homepage/img/bg-img/mother_baby_hero.png') }});"></div>
            <div class="ve-hero-img-accent bg-img" style="background-image:url({{ asset('homepage/img/bg-img/pediatrician_accent.png') }});"></div>
            <!-- Floating card -->
            <div class="ve-float-card">
                <i class="fa fa-heart"></i>
                <div>
                    <strong>100% Aman</strong>
                    <span>Ibu & Anak Sehat</span>
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

    <!-- ===== SERVICES GRID (new card layout) ===== -->
    <section class="ve-section ve-services-section">
        <div class="container">
            <div class="ve-section-header text-center">
                <span class="ve-section-tag">Layanan Kami</span>
                <h2>Solusi Kesehatan <span>Ibu & Anak</span></h2>
                <p>Pendampingan lengkap mulai dari masa kehamilan hingga tumbuh kembang anak untuk masa depan yang lebih sehat.</p>
            </div>
            <div class="ve-services-grid">
                <div class="ve-service-card wow fadeInUp" data-wow-delay="100ms">
                    <div class="ve-service-icon"><i class="icon-profits"></i></div>
                    <h4>Panduan Kehamilan</h4>
                    <p>Informasi lengkap mengenai perkembangan janin dari minggu ke minggu serta tips menjaga kesehatan selama masa kehamilan.</p>
                    <a href="services.html" class="ve-card-link">Selengkapnya <i class="fa fa-long-arrow-right"></i></a>
                </div>
                <div class="ve-service-card wow fadeInUp" data-wow-delay="200ms">
                    <div class="ve-service-icon"><i class="icon-money-1"></i></div>
                    <h4>Tumbuh Kembang</h4>
                    <p>Pantau perkembangan motorik, sensorik, dan kognitif buah hati Anda dengan standar kurva kesehatan internasional.</p>
                    <a href="services.html" class="ve-card-link">Selengkapnya <i class="fa fa-long-arrow-right"></i></a>
                </div>
                <div class="ve-service-card wow fadeInUp" data-wow-delay="300ms">
                    <div class="ve-service-icon"><i class="icon-coin"></i></div>
                    <h4>Jadwal Imunisasi</h4>
                    <p>Jangan lewatkan momen penting perlindungan buah hati Anda dengan pengingat jadwal imunisasi dasar lengkap.</p>
                    <a href="services.html" class="ve-card-link">Selengkapnya <i class="fa fa-long-arrow-right"></i></a>
                </div>
                <div class="ve-service-card wow fadeInUp" data-wow-delay="400ms">
                    <div class="ve-service-icon"><i class="icon-smartphone-1"></i></div>
                    <h4>Gizi Ibu & Anak</h4>
                    <p>Rekomendasi asupan nutrisi seimbang untuk Ibu selama menyusui dan MPASI sehat untuk pertumbuhan Si Kecil.</p>
                    <a href="services.html" class="ve-card-link">Selengkapnya <i class="fa fa-long-arrow-right"></i></a>
                </div>
                <div class="ve-service-card wow fadeInUp" data-wow-delay="500ms">
                    <div class="ve-service-icon"><i class="icon-diamond"></i></div>
                    <h4>Tips Persalinan</h4>
                    <p>Persiapkan diri menyambut kelahiran dengan panduan teknik pernapasan, senam hamil, dan kebutuhan rumah sakit.</p>
                    <a href="services.html" class="ve-card-link">Selengkapnya <i class="fa fa-long-arrow-right"></i></a>
                </div>
                <div class="ve-service-card wow fadeInUp" data-wow-delay="600ms">
                    <div class="ve-service-icon"><i class="icon-piggy-bank"></i></div>
                    <h4>Kesehatan Mental</h4>
                    <p>Dukungan emosional dan tips mengatasi baby blues untuk menjaga kebahagiaan Ibu selama masa pasca persalinan.</p>
                    <a href="services.html" class="ve-card-link">Selengkapnya <i class="fa fa-long-arrow-right"></i></a>
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
                        <div class="ve-whyus-img-main bg-img" style="background-image:url({{ asset('homepage/img/bg-img/') }}pediatrician_accent.png);"></div>
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
                        <div class="ve-testi-avatar bg-img" style="background-image:url({{ asset('homepage/img/bg-img/') }}mother_avatar.png);"></div>
                        <div><strong>Ibu Rahma</strong><span>Ibu Rumah Tangga</span></div>
                    </div>
                </div>
                <div class="ve-testi-card wow fadeInUp" data-wow-delay="250ms">
                    <div class="ve-testi-stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
                    <p>"Panduan kehamilannya sangat detail. Saya jadi tidak khawatir lagi menghadapi persalinan anak pertama saya."</p>
                    <div class="ve-testi-author">
                        <div class="ve-testi-avatar bg-img" style="background-image:url({{ asset('homepage/img/bg-img/') }}mother_avatar.png);"></div>
                        <div><strong>Ibu Sari</strong><span>Guru SD</span></div>
                    </div>
                </div>
                <div class="ve-testi-card wow fadeInUp" data-wow-delay="400ms">
                    <div class="ve-testi-stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
                    <p>"Konsultasi gizi lewat KIA Care sangat praktis. Menu MPASI yang disarankan sangat disukai oleh buah hati saya."</p>
                    <div class="ve-testi-author">
                        <div class="ve-testi-avatar bg-img" style="background-image:url({{ asset('homepage/img/bg-img/') }}mother_avatar.png);"></div>
                        <div><strong>Ibu Linda</strong><span>Karyawan Swasta</span></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== CTA BANNER ===== -->
    <section class="ve-cta-banner bg-img" style="background-image:url({{ asset('homepage/img/bg-img/') }}maternity_clinic_bg.png);">
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
                        <div class="ve-insight-img bg-img" style="background-image:url({{ asset('homepage/img/bg-img/') }}mother_baby_hero.png);"></div>
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
</body>
</html>
