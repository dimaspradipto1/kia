@extends('layouts.homepage.template')

@section('title', 'Artikel KIA Care')

@section('content')
<section class="section-gap">
    <div class="container-tight">
        <div class="text-center">
            <span class="badge-pill">Artikel</span>
            <h2 class="hero-title-main">Kumpulan Artikel Kesehatan</h2>
            <p class="hero-subtitle mx-auto">Halaman ini menampilkan daftar artikel kesehatan ibu dan anak yang dapat digunakan untuk mengembangkan konten edukasi homepage.</p>
        </div>

        <div class="row" style="gap: 30px; margin-top: 40px;">
            <div style="flex: 1; min-width: 280px; background: #fff; border-radius: 30px; padding: 40px; border: 1px solid rgba(15,23,42,0.08);">
                <h3>Artikel Terbaru</h3>
                <p>Temukan artikel terkait kehamilan, imunisasi, nutrisi, dan tumbuh kembang anak di sini.</p>
            </div>
            <div style="flex: 1; min-width: 280px; background: #fff; border-radius: 30px; padding: 40px; border: 1px solid rgba(15,23,42,0.08);">
                <h3>Konten Edukasi</h3>
                <p>Kelola artikel edukasi yang ditampilkan di homepage dan hubungkan dengan kategori artikel.</p>
            </div>
        </div>

        <div style="margin-top: 40px; text-align: center;">
            <a href="{{ route('homepage') }}" class="btn-p">Kembali ke Beranda</a>
        </div>
    </div>
</section>
@endsection
