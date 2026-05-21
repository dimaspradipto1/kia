@extends('layouts.homepage.template')

@section('title', 'Tentang KIA Care')

@section('content')
    <section class="ve-page-hero" style="background-image:url('{{ asset('homepage/img/bg-img/13.jpg') }}');">
        <div class="ve-page-hero-overlay"></div>
        <div class="container ve-page-hero-content">
            <span class="ve-section-tag">Cerita Kami</span>
            <h1>Mendampingi Ibu dan Anak <span>Sejak Hari Pertama</span></h1>
            <nav aria-label="breadcrumb">
                <ol class="ve-breadcrumb">
                    <li><a href="{{ route('homepage') }}">Beranda</a></li>
                    <li class="active">Tentang Kami</li>
                </ol>
            </nav>
        </div>
    </section>

    <section class="ve-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-12 col-lg-6">
                    <div class="ve-about-img-stack">
                        <div class="ve-about-img-1 bg-img" style="background-image:url('{{ asset('homepage/img/bg-img/14.jpg') }}');"></div>
                        <div class="ve-about-img-2 bg-img" style="background-image:url('{{ asset('homepage/img/bg-img/5.jpg') }}');"></div>
                        <div class="ve-about-ribbon"><strong>10+</strong><span>Tahun Mengabdi</span></div>
                    </div>
                </div>
                <div class="col-12 col-lg-6">
                    <div class="ve-about-text">
                        <span class="ve-section-tag">Siapa Kami</span>
                        <h2>KIA Care adalah <span>platform kesehatan</span> ibu dan anak yang terpercaya</h2>
                        <p class="ve-lead">Kami membantu keluarga di seluruh Indonesia mengakses informasi kesehatan, pemantauan kehamilan, dan dukungan medis digital secara mudah.</p>
                        <p>KIA Care hadir untuk menjembatani kebutuhan ibu hamil, bayi, dan balita dengan layanan kesehatan yang terintegrasi dan ramah pengguna.</p>
                        <div class="ve-about-features">
                            <div class="ve-af-item"><i class="fa fa-check"></i><span>Panduan Kehamilan Terstruktur</span></div>
                            <div class="ve-af-item"><i class="fa fa-check"></i><span>Informasi Imunisasi dan Tumbuh Kembang</span></div>
                            <div class="ve-af-item"><i class="fa fa-check"></i><span>Sistem Pemantauan Buku KIA Digital</span></div>
                            <div class="ve-af-item"><i class="fa fa-check"></i><span>Fitur Konsultasi Online Bagi Ibu</span></div>
                        </div>
                        <a href="{{ route('homepage.contact') }}" class="ve-btn-primary mt-30">Hubungi Kami</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="ve-mvv-section">
        <div class="container">
            <div class="ve-section-header text-center">
                <span class="ve-section-tag">Pondasi Kami</span>
                <h2>Misi, Visi & <span>Nilai</span></h2>
            </div>
            <div class="ve-mvv-grid">
                <div class="ve-mvv-card">
                    <div class="ve-mvv-icon"><i class="fa fa-bullseye"></i></div>
                    <h4>Misi Kami</h4>
                    <p>Meningkatkan akses informasi kesehatan ibu dan anak melalui teknologi yang mudah digunakan dan terpercaya.</p>
                </div>
                <div class="ve-mvv-card">
                    <div class="ve-mvv-icon"><i class="fa fa-eye"></i></div>
                    <h4>Visi Kami</h4>
                    <p>Menjadi platform kesehatan ibu dan anak pilihan utama di Indonesia dengan pengalaman digital yang aman dan personal.</p>
                </div>
                <div class="ve-mvv-card">
                    <div class="ve-mvv-icon"><i class="fa fa-heart"></i></div>
                    <h4>Nilai Kami</h4>
                    <p>Transparansi, empati, inovasi, dan komitmen terhadap kesejahteraan ibu serta keluarga.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="ve-section ve-team-section">
        <div class="container">
            <div class="ve-section-header text-center">
                <span class="ve-section-tag">Tim KIA Care</span>
                <h2>Profesional <span>di Balik Layar</span></h2>
                <p>Tim kami terdiri dari tenaga kesehatan dan pengembang yang berfokus pada pengalaman ibu dan anak.</p>
            </div>
            <div class="row">
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="ve-team-card">
                        <div class="ve-team-img bg-img" style="background-image:url('{{ asset('homepage/img/bg-img/15.jpg') }}');"></div>
                        <div class="ve-team-info">
                            <h5>Dr. Sari Wati</h5><span>Chief Medical Officer</span>
                            <div class="ve-team-social"><a href="#"><i class="fa fa-linkedin"></i></a><a href="#"><i class="fa fa-twitter"></i></a></div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="ve-team-card">
                        <div class="ve-team-img bg-img" style="background-image:url('{{ asset('homepage/img/bg-img/16.jpg') }}');"></div>
                        <div class="ve-team-info">
                            <h5>Anton Prasetyo</h5><span>Head of Product</span>
                            <div class="ve-team-social"><a href="#"><i class="fa fa-linkedin"></i></a><a href="#"><i class="fa fa-twitter"></i></a></div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="ve-team-card">
                        <div class="ve-team-img bg-img" style="background-image:url('{{ asset('homepage/img/bg-img/17.jpg') }}');"></div>
                        <div class="ve-team-info">
                            <h5>Rina Mulyani</h5><span>Head of Customer Care</span>
                            <div class="ve-team-social"><a href="#"><i class="fa fa-linkedin"></i></a><a href="#"><i class="fa fa-twitter"></i></a></div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="ve-team-card">
                        <div class="ve-team-img bg-img" style="background-image:url('{{ asset('homepage/img/bg-img/18.jpg') }}');"></div>
                        <div class="ve-team-info">
                            <h5>Budi Santoso</h5><span>Head of Development</span>
                            <div class="ve-team-social"><a href="#"><i class="fa fa-linkedin"></i></a><a href="#"><i class="fa fa-twitter"></i></a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="ve-counter-section">
        <div class="container">
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
                    <i class="fa fa-globe"></i>
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

    <section class="ve-newsletter-section">
        <div class="container">
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
@endsection
