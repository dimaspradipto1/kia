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

        <div class="row" style="gap: 30px; margin-top: 40px;">
            <div style="flex: 1; min-width: 280px; background: #fff; border-radius: 30px; padding: 40px; border: 1px solid rgba(15,23,42,0.08);">
                <h3>Alamat Kantor</h3>
                <p>Jl. Contoh No. 123, Jakarta</p>
                <p>Email: info@kia-care.id</p>
            </div>
            <div style="flex: 1; min-width: 280px; background: #fff; border-radius: 30px; padding: 40px; border: 1px solid rgba(15,23,42,0.08);">
                <h3>Telepon</h3>
                <p>+62 812 3456 7890</p>
                <p>Jam Operasional: Senin - Jumat, 08.00 - 17.00</p>
            </div>
        </div>

        <div style="margin-top: 40px; text-align: center;">
            <a href="{{ route('homepage') }}" class="btn-p">Kembali ke Beranda</a>
        </div>
    </div>
</section>
@endsection
