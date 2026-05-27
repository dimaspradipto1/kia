@extends('layouts.homepage.template')

@section('title', 'Kontak KIA Care')

@section('content')
<section class="section-gap">
    <div class="container-tight">
        <div class="text-center">
            <span class="badge-pill">Kontak</span>
            <h2 class="hero-title-main">Hubungi KIA Care</h2>
            <p class="hero-subtitle mx-auto">Halaman kontak ini menampilkan alamat, telepon, dan formulir untuk menghubungi tim KIA Care.</p>
        </div>

        <div class="row mt-5">
            <!-- Left Column: Google Map -->
            <div class="col-12 col-lg-6 mb-4 mb-lg-0">
                <div style="border-radius: 30px; overflow: hidden; border: 1px solid rgba(15,23,42,0.08); box-shadow: 0 10px 40px rgba(0,0,0,0.02); height: 460px;">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.2737666244465!2d106.82855137583685!3d-6.227591693760731!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f3e4a2a16d51%3A0x67db23e9c607ec5c!2sGedung%20Kementerian%20Kesehatan%20RI!5e0!3m2!1sid!2sid!4v1716806000000!5m2!1sid!2sid" 
                        width="100%" 
                        height="100%" 
                        style="border:0;" 
                        allowfullscreen="" 
                        loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>

            <!-- Right Column: Contact Cards -->
            <div class="col-12 col-lg-6">
                <!-- Alamat Kantor -->
                <div class="p-4 p-md-5 mb-4" style="background: #fff; border-radius: 30px; border: 1px solid rgba(15,23,42,0.08); box-shadow: 0 10px 40px rgba(0,0,0,0.02);">
                    <h3 class="sora fw-bold mb-3" style="color: var(--brand-dark); font-size: 1.4rem;"><i class="fa fa-map-marker" style="color: var(--brand-p); margin-right: 10px;"></i> Alamat Kantor</h3>
                    <p class="mb-2" style="font-size: 1rem; color: #475569; line-height: 1.6;">Gedung Kementerian Kesehatan RI, Jl. HR. Rasuna Said Blok X-5 Kav. 4-9, Kuningan, Jakarta Selatan</p>
                    <p class="mb-0" style="font-size: 1rem; color: #475569;"><strong>Email:</strong> info@kia-care.id</p>
                </div>

                <!-- Telepon -->
                <div class="p-4 p-md-5" style="background: #fff; border-radius: 30px; border: 1px solid rgba(15,23,42,0.08); box-shadow: 0 10px 40px rgba(0,0,0,0.02);">
                    <h3 class="sora fw-bold mb-3" style="color: var(--brand-dark); font-size: 1.4rem;"><i class="fa fa-phone" style="color: var(--brand-p); margin-right: 10px;"></i> Telepon</h3>
                    <p class="mb-2" style="font-size: 1rem; color: #475569;">+62 812 3456 7890</p>
                    <p class="mb-0" style="font-size: 1rem; color: #475569; line-height: 1.6;"><strong>Jam Operasional:</strong><br>Senin - Jumat, 08.00 - 17.00 WIB</p>
                </div>
            </div>
        </div>

        <div style="margin-top: 40px; text-align: center;">
            <a href="{{ route('homepage') }}" class="btn-p">Kembali ke Beranda</a>
        </div>
    </div>
</section>
@endsection
