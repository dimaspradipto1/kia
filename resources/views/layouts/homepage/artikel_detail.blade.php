@extends('layouts.homepage.template')

@section('title', $article->judul . ' - KIA Care')

@section('content')
    <!-- Page Hero -->
    <section class="ve-page-hero" style="background-image:url('{{ asset('homepage/img/clinic_bg_1779872776394.png') }}');">
        <div class="ve-page-hero-overlay"></div>
        <div class="container ve-page-hero-content">
            <span class="ve-section-tag">{{ $article->kategoriArtikel?->nama ?? 'Artikel' }}</span>
            <h1 style="font-size: clamp(1.8rem, 4.5vw, 3rem); line-height: 1.2; max-width: 900px; margin: 0 auto 24px;">
                {{ $article->judul }}
            </h1>
            <nav aria-label="breadcrumb">
                <ol class="ve-breadcrumb">
                    <li><a href="{{ route('homepage') }}">Beranda</a></li>
                    <li><a href="{{ route('homepage.artikel') }}">Artikel</a></li>
                    <li class="active">{{ Str::limit($article->judul, 30) }}</li>
                </ol>
            </nav>
        </div>
    </section>

    <!-- Main Content Area -->
    <section class="section-gap" style="background: #F8FAFC; padding-top: 80px; padding-bottom: 80px;">
        <div class="container-tight" style="max-width: 1400px;">
            <div class="row">
                <!-- Main Column: Article Body -->
                <div class="col-12 col-lg-8 mb-5 mb-lg-0">
                    <div class="p-4 p-md-5"
                         style="background: #fff; border-radius: 40px; border: 1px solid var(--border-color); box-shadow: 0 10px 40px rgba(0,0,0,0.02);">

                        <!-- Featured Image -->
                        @if($article->gambar_url)
                            <img src="{{ $article->gambar_url }}"
                                 class="w-100 mb-4"
                                 style="width:100%;height:auto;border-radius:24px;box-shadow:0 15px 45px rgba(0,0,0,0.05);"
                                 alt="{{ $article->judul }}">
                        @endif

                        <!-- Metadata Row -->
                        <div class="d-flex align-items-center flex-wrap gap-2 mb-4 text-muted small">
                            <span>
                                <i class="fa fa-user" style="color: var(--brand-p); margin-right: 5px;"></i>
                                Penulis: <strong>{{ $article->penulis }}</strong>
                            </span>
                            <span class="mx-2 text-muted">|</span>
                            <span>
                                <i class="fa fa-calendar" style="color: var(--brand-p); margin-right: 5px;"></i>
                                {{ $article->diterbitkan_pada?->isoFormat('D MMMM Y') ?? $article->diterbitkan_pada?->format('d M Y') }}
                            </span>
                            @if($article->kategoriArtikel)
                                <span class="mx-2 text-muted">|</span>
                                <a href="{{ route('homepage.artikel', ['category' => $article->kategoriArtikel->slug]) }}"
                                   class="text-decoration-none badge-pill py-1 px-3"
                                   style="background: var(--magenta-soft); color: var(--brand-p); font-weight: 700; font-size: 0.75rem; border-radius:20px;">
                                    {{ $article->kategoriArtikel->nama }}
                                </a>
                            @endif
                        </div>

                        <hr class="mb-4" style="border-top: 1px solid var(--border-color);">

                        <!-- Article Body Content -->
                        <div class="article-detail-content"
                             style="font-size: 1.08rem; line-height: 1.9; color: #475569; text-align: justify; text-justify: inter-word;">
                            {!! $article->isi !!}
                        </div>

                        <!-- Back Button -->
                        <div class="mt-5 pt-4 border-top" style="border-top: 1px solid var(--border-color);">
                            <a href="{{ route('homepage.artikel') }}" class="btn-s"
                               style="border-radius: 100px; padding: 14px 32px !important; font-size: 0.95rem !important;">
                                <i class="fa fa-arrow-left" style="margin-right: 8px;"></i> Kembali ke Artikel
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Sidebar -->
                <div class="col-12 col-lg-4">
                    <!-- Widget: Search -->
                    <div class="p-4 mb-4"
                         style="background: #fff; border-radius: 24px; border: 1px solid var(--border-color); box-shadow: 0 5px 15px rgba(0,0,0,0.01);">
                        <h5 class="sora fw-bold mb-3" style="color: var(--brand-dark); font-size: 1.15rem;">Cari Artikel</h5>
                        <form action="{{ route('homepage.artikel') }}" method="GET">
                            <div class="position-relative d-flex align-items-center">
                                <input type="text" name="search" placeholder="Ketik kata kunci..."
                                       class="w-100 py-3 pl-4 pr-5"
                                       style="border: 1px solid var(--border-color); border-radius: 50px; font-size: 0.95rem; outline: none;">
                                <button type="submit" class="position-absolute border-0"
                                        style="right: 15px; background: transparent; color: var(--brand-p); font-size: 1.1rem; outline: none;">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Widget: Categories -->
                    <div class="p-4 mb-4"
                         style="background: #fff; border-radius: 24px; border: 1px solid var(--border-color); box-shadow: 0 5px 15px rgba(0,0,0,0.01);">
                        <h5 class="sora fw-bold mb-3" style="color: var(--brand-dark); font-size: 1.15rem;">Kategori</h5>
                        <ul class="list-unstyled mb-0">
                            @foreach($categories as $cat)
                                @if($cat['count'] > 0 || $cat['slug'] === '')
                                    <li class="mb-2">
                                        <a href="{{ route('homepage.artikel', ['category' => $cat['slug']]) }}"
                                           class="d-flex align-items-center justify-content-between p-3 text-decoration-none rounded-3"
                                           style="background: {{ $article->kategoriArtikel?->slug === $cat['slug'] ? 'var(--magenta-soft)' : '#F8FAFC' }}; color: {{ $article->kategoriArtikel?->slug === $cat['slug'] ? 'var(--brand-p)' : 'var(--brand-dark)' }}; font-weight: {{ $article->kategoriArtikel?->slug === $cat['slug'] ? '700' : '500' }}; font-size: 0.95rem;">
                                            <span>{{ $cat['nama'] }}</span>
                                            <span class="badge py-1 px-2"
                                                  style="background: {{ $article->kategoriArtikel?->slug === $cat['slug'] ? 'var(--brand-p)' : '#E2E8F0' }}; color: {{ $article->kategoriArtikel?->slug === $cat['slug'] ? '#fff' : '#64748B' }}; border-radius: 50px; font-size: 0.8rem;">
                                                {{ $cat['count'] }}
                                            </span>
                                        </a>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>

                    <!-- Widget: Recent Posts -->
                    <div class="p-4"
                         style="background: #fff; border-radius: 24px; border: 1px solid var(--border-color); box-shadow: 0 5px 15px rgba(0,0,0,0.01);">
                        <h5 class="sora fw-bold mb-3" style="color: var(--brand-dark); font-size: 1.15rem;">Artikel Terbaru</h5>
                        <div class="d-flex flex-column gap-3">
                            @foreach($recentArticles as $recent)
                                <div class="d-flex align-items-start gap-3 @if(!$loop->last) pb-3 @endif"
                                     style="gap:15px; @if(!$loop->last) border-bottom: 1px solid var(--border-color); margin-bottom: 15px; padding-bottom: 15px; @endif">
                                    @if($recent->gambar_url)
                                        <div style="width:80px;height:80px;flex-shrink:0;border-radius:12px;overflow:hidden;">
                                            <img src="{{ $recent->gambar_url }}" alt="{{ $recent->judul }}"
                                                 style="width:100%;height:100%;object-fit:cover;">
                                        </div>
                                    @else
                                        <div style="width:80px;height:80px;flex-shrink:0;border-radius:12px;background:linear-gradient(135deg,#fdf2f8,#eff6ff);display:flex;align-items:center;justify-content:center;">
                                            <i class="bi bi-newspaper" style="color:#EC1E88;opacity:.4;"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <span class="text-muted d-block mb-1" style="font-size: 0.75rem;">
                                            <i class="fa fa-calendar"></i>
                                            {{ $recent->diterbitkan_pada?->format('d M Y') }}
                                        </span>
                                        <h6 class="sora fw-bold mb-0" style="font-size: 0.9rem; line-height: 1.3;">
                                            <a href="{{ route('homepage.artikel.show', $recent->slug) }}"
                                               class="text-decoration-none"
                                               style="color: var(--brand-dark);">
                                                {{ Str::limit($recent->judul, 55) }}
                                            </a>
                                        </h6>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
