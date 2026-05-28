@extends('layouts.homepage.template')

@section('title', 'Artikel & Edukasi Kesehatan - KIA Care')

@section('content')
    <!-- Page Hero -->
    <section class="ve-page-hero" style="background-image:url('{{ asset('homepage/img/clinic_bg_1779872776394.png') }}');">
        <div class="ve-page-hero-overlay"></div>
        <div class="container ve-page-hero-content">
            <span class="ve-section-tag">Pusat Informasi</span>
            <h1>Artikel & <span>Edukasi KIA</span></h1>
            <nav aria-label="breadcrumb">
                <ol class="ve-breadcrumb">
                    <li><a href="{{ route('homepage') }}">Beranda</a></li>
                    <li class="active">Artikel</li>
                </ol>
            </nav>
        </div>
    </section>

    <!-- Main Content Area -->
    <section class="section-gap" style="background: #F8FAFC; padding-top: 80px; padding-bottom: 80px;">
        <div class="container-tight" style="max-width: 1400px;">
            <div class="row">
                <!-- Left/Main Column: Articles Grid -->
                <div class="col-12 col-lg-8 mb-5 mb-lg-0">

                    @if($search || $category)
                        <div class="d-flex align-items-center justify-content-between p-4 mb-4"
                             style="background: #fff; border-radius: 20px; border: 1px solid var(--border-color);">
                            <div class="small">
                                @if($search)
                                    Hasil pencarian untuk: <strong>"{{ $search }}"</strong>
                                @endif
                                @if($search && $category) dan @endif
                                @if($category)
                                    Kategori: <strong>"{{ ucfirst($category) }}"</strong>
                                @endif
                            </div>
                            <a href="{{ route('homepage.artikel') }}" class="small fw-bold text-decoration-none"
                               style="color: var(--brand-p);">
                                <i class="fa fa-times-circle"></i> Reset Filter
                            </a>
                        </div>
                    @endif

                    @if($articles->isEmpty())
                        <div class="text-center py-5 px-4"
                             style="background: #fff; border-radius: 40px; border: 1px solid var(--border-color);">
                            <div style="font-size: 4rem; color: #CBD5E1;" class="mb-4">
                                <i class="fa fa-search-minus"></i>
                            </div>
                            <h4 class="sora fw-bold mb-3" style="color: var(--brand-dark);">Artikel Tidak Ditemukan</h4>
                            <p class="text-muted mx-auto mb-4" style="max-width: 400px;">
                                Maaf, kami tidak dapat menemukan artikel yang cocok. Silakan coba kata kunci lain atau pilih kategori yang tersedia.
                            </p>
                            <a href="{{ route('homepage.artikel') }}" class="btn-p"
                               style="padding: 14px 30px !important; font-size: 0.95rem !important;">
                                Tampilkan Semua Artikel
                            </a>
                        </div>
                    @else
                        <div class="row">
                            @foreach($articles as $article)
                                <div class="col-12 col-md-6 mb-4">
                                    <div class="ve-insight-card d-flex flex-column h-100"
                                         style="background: #fff; border-radius: 24px; border: 1px solid var(--border-color); overflow: hidden; transition: var(--transition-smooth);">

                                        {{-- Featured Image --}}
                                        @if($article->gambar_url)
                                            <div class="ve-insight-img"
                                                 style="background-image:url('{{ $article->gambar_url }}'); background-size: cover; background-repeat: no-repeat; background-position: center top; height: 220px;">
                                            </div>
                                        @else
                                            <div class="ve-insight-img d-flex align-items-center justify-content-center"
                                                 style="height:220px; background: linear-gradient(135deg,#fdf2f8,#eff6ff);">
                                                <i class="bi bi-newspaper" style="font-size:3rem;color:#EC1E88;opacity:.4;"></i>
                                            </div>
                                        @endif

                                        <div class="ve-insight-body p-4 d-flex flex-column flex-grow-1">
                                            <span class="ve-insight-cat align-self-start mb-3"
                                                  style="font-size: 0.75rem; font-weight: 700; text-transform: uppercase; color: var(--brand-p); background: var(--magenta-soft); padding: 4px 12px; border-radius: 50px;">
                                                {{ $article->kategoriArtikel?->nama ?? 'Umum' }}
                                            </span>
                                            <h5 class="sora fw-bold mb-3" style="font-size: 1.1rem; line-height: 1.4;">
                                                <a href="{{ route('homepage.artikel.show', $article->slug) }}"
                                                   class="text-decoration-none"
                                                   style="color: var(--brand-dark); transition: var(--transition-smooth);">
                                                    {{ $article->judul }}
                                                </a>
                                            </h5>
                                            <p class="text-muted small mb-4"
                                               style="line-height: 1.6; text-align: justify; text-justify: inter-word;">
                                                {{ Str::limit(strip_tags($article->isi), 120) }}
                                            </p>
                                            <div class="ve-insight-meta d-flex justify-content-between align-items-center mt-auto pt-3 border-top"
                                                 style="border-top-color: var(--border-color);">
                                                <span class="text-muted small">
                                                    <i class="fa fa-calendar"></i>
                                                    {{ $article->diterbitkan_pada?->format('d M Y') }}
                                                </span>
                                                <a href="{{ route('homepage.artikel.show', $article->slug) }}"
                                                   class="fw-bold text-decoration-none small"
                                                   style="color: var(--brand-p); transition: var(--transition-smooth);">
                                                    Selengkapnya <i class="fa fa-arrow-right"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        {{-- Pagination --}}
                        @if($articles->lastPage() > 1)
                            <div class="d-flex flex-column align-items-center mt-5">
                                <p class="text-muted small mb-3">
                                    Menampilkan {{ $articles->firstItem() }}–{{ $articles->lastItem() }}
                                    dari {{ $articles->total() }} artikel
                                </p>
                                <nav aria-label="Navigasi halaman">
                                    <ul class="pagination mb-0"
                                        style="gap: 6px; display: flex; align-items: center; list-style: none; padding: 0; flex-wrap: wrap; justify-content: center;">
                                        @if($articles->onFirstPage())
                                            <li style="opacity:0.4; pointer-events:none;">
                                                <span class="pagination-btn"
                                                      style="display:flex;align-items:center;justify-content:center;width:42px;height:42px;border-radius:12px;background:#fff;border:1px solid #E2E8F0;color:#64748B;">
                                                    <i class="fa fa-chevron-left"></i>
                                                </span>
                                            </li>
                                        @else
                                            <li>
                                                <a href="{{ $articles->previousPageUrl() }}" class="pagination-btn"
                                                   style="display:flex;align-items:center;justify-content:center;width:42px;height:42px;border-radius:12px;background:#fff;border:1px solid #E2E8F0;color:#64748B;text-decoration:none;">
                                                    <i class="fa fa-chevron-left"></i>
                                                </a>
                                            </li>
                                        @endif

                                        @foreach($articles->getUrlRange(1, $articles->lastPage()) as $page => $url)
                                            @if($page == $articles->currentPage())
                                                <li>
                                                    <span style="display:flex;align-items:center;justify-content:center;width:42px;height:42px;border-radius:12px;background:var(--brand-p);color:#fff;font-weight:700;">
                                                        {{ $page }}
                                                    </span>
                                                </li>
                                            @elseif($page == 1 || $page == $articles->lastPage() || abs($page - $articles->currentPage()) <= 2)
                                                <li>
                                                    <a href="{{ $url }}"
                                                       style="display:flex;align-items:center;justify-content:center;width:42px;height:42px;border-radius:12px;background:#fff;border:1px solid #E2E8F0;color:#475569;font-weight:500;text-decoration:none;">
                                                        {{ $page }}
                                                    </a>
                                                </li>
                                            @elseif(abs($page - $articles->currentPage()) == 3)
                                                <li>
                                                    <span style="display:flex;align-items:center;justify-content:center;width:42px;height:42px;color:#94a3b8;">…</span>
                                                </li>
                                            @endif
                                        @endforeach

                                        @if($articles->hasMorePages())
                                            <li>
                                                <a href="{{ $articles->nextPageUrl() }}" class="pagination-btn"
                                                   style="display:flex;align-items:center;justify-content:center;width:42px;height:42px;border-radius:12px;background:#fff;border:1px solid #E2E8F0;color:#64748B;text-decoration:none;">
                                                    <i class="fa fa-chevron-right"></i>
                                                </a>
                                            </li>
                                        @else
                                            <li style="opacity:0.4; pointer-events:none;">
                                                <span class="pagination-btn"
                                                      style="display:flex;align-items:center;justify-content:center;width:42px;height:42px;border-radius:12px;background:#fff;border:1px solid #E2E8F0;color:#64748B;">
                                                    <i class="fa fa-chevron-right"></i>
                                                </span>
                                            </li>
                                        @endif
                                    </ul>
                                </nav>
                            </div>
                        @endif
                    @endif

                </div>

                <!-- Right Column: Sidebar -->
                <div class="col-12 col-lg-4">
                    <!-- Widget: Search -->
                    <div class="p-4 mb-4" style="background: #fff; border-radius: 24px; border: 1px solid var(--border-color);">
                        <h5 class="sora fw-bold mb-3" style="color: var(--brand-dark); font-size: 1.15rem;">Cari Artikel</h5>
                        <form action="{{ route('homepage.artikel') }}" method="GET">
                            @if($category)
                                <input type="hidden" name="category" value="{{ $category }}">
                            @endif
                            <div class="position-relative d-flex align-items-center">
                                <input type="text" name="search" value="{{ $search }}"
                                       placeholder="Ketik kata kunci..." class="w-100 py-3 pl-4 pr-5"
                                       style="border: 1px solid var(--border-color); border-radius: 50px; font-size: 0.95rem; outline: none;">
                                <button type="submit" class="position-absolute border-0"
                                        style="right: 15px; background: transparent; color: var(--brand-p); font-size: 1.1rem; outline: none;">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Widget: Categories -->
                    <div class="p-4 mb-4" style="background: #fff; border-radius: 24px; border: 1px solid var(--border-color);">
                        <h5 class="sora fw-bold mb-3" style="color: var(--brand-dark); font-size: 1.15rem;">Kategori</h5>
                        <ul class="list-unstyled mb-0">
                            @foreach($categories as $cat)
                                @if($cat['count'] > 0 || $cat['slug'] === '')
                                    <li class="mb-2">
                                        <a href="{{ route('homepage.artikel', array_filter(['category' => $cat['slug'], 'search' => $search])) }}"
                                           class="d-flex align-items-center justify-content-between p-3 text-decoration-none rounded-3"
                                           style="background: {{ $category === $cat['slug'] ? 'var(--magenta-soft)' : '#F8FAFC' }}; color: {{ $category === $cat['slug'] ? 'var(--brand-p)' : 'var(--brand-dark)' }}; font-weight: {{ $category === $cat['slug'] ? '700' : '500' }}; font-size: 0.95rem;">
                                            <span>{{ $cat['nama'] }}</span>
                                            <span class="badge py-1 px-2"
                                                  style="background: {{ $category === $cat['slug'] ? 'var(--brand-p)' : '#E2E8F0' }}; color: {{ $category === $cat['slug'] ? '#fff' : '#64748B' }}; border-radius: 50px; font-size: 0.8rem;">
                                                {{ $cat['count'] }}
                                            </span>
                                        </a>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>

                    <!-- Widget: Recent Posts -->
                    <div class="p-4" style="background: #fff; border-radius: 24px; border: 1px solid var(--border-color);">
                        <h5 class="sora fw-bold mb-3" style="color: var(--brand-dark); font-size: 1.15rem;">Artikel Terbaru</h5>
                        <div class="d-flex flex-column gap-3">
                            @foreach($recentArticles as $recent)
                                <div class="d-flex align-items-start gap-3 @if(!$loop->last) pb-3 @endif"
                                     style="@if(!$loop->last) border-bottom: 1px solid var(--border-color); @endif">
                                    @if($recent->gambar_url)
                                        <div style="width:80px;height:80px;flex-shrink:0;border-radius:12px;overflow:hidden;background:#f1f5f9;">
                                            <img src="{{ $recent->gambar_url }}" alt="{{ $recent->judul }}"
                                                 style="width:100%;height:100%;object-fit:cover;">
                                        </div>
                                    @else
                                        <div style="width:80px;height:80px;flex-shrink:0;border-radius:12px;background:linear-gradient(135deg,#fdf2f8,#eff6ff);display:flex;align-items:center;justify-content:center;">
                                            <i class="bi bi-newspaper" style="color:#EC1E88;opacity:.5;font-size:1.4rem;"></i>
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
