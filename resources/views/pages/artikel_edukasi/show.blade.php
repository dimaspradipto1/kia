@extends('layouts.dashboard.template')

@push('styles')
<style>
.gb-wrap {
    display: grid;
    grid-template-columns: 1fr 320px;
    gap: 24px;
    align-items: start;
}
@media (max-width: 991px) {
    .gb-wrap { grid-template-columns: 1fr; }
}
.gb-toolbar {
    position: sticky;
    top: 0;
    z-index: 100;
    background: #fff;
    border-bottom: 1px solid #e2e8f0;
    padding: 12px 24px;
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 24px;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,.06);
}
.gb-toolbar .article-title-bar {
    flex: 1;
    font-size: 0.9rem;
    color: #64748b;
    font-style: italic;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.gb-editor-card {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 4px 24px rgba(0,0,0,.06);
    overflow: hidden;
}
.gb-editor-inner {
    padding: 32px 40px 40px;
}
.article-title-h1 {
    font-size: 2.2rem;
    font-weight: 800;
    color: #1e293b;
    line-height: 1.3;
    margin-bottom: 12px;
}
.gb-slug-row {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 8px 0 20px;
    border-bottom: 1px solid #f1f5f9;
    margin-bottom: 24px;
}
.gb-slug-label {
    font-size: 0.75rem;
    color: #94a3b8;
}
.gb-slug-val {
    font-size: 0.75rem;
    color: #EC1E88;
    font-weight: 600;
    font-family: monospace;
}
.gb-sidebar-panel {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 4px 24px rgba(0,0,0,.06);
    overflow: hidden;
    position: sticky;
    top: 80px;
}
.gb-panel-header {
    background: #f8fafc;
    border-bottom: 1px solid #f1f5f9;
    padding: 14px 20px;
    font-size: 0.8rem;
    font-weight: 600;
    color: #475569;
}
.gb-panel-body {
    padding: 20px;
}
.gb-panel-section {
    border-bottom: 1px solid #f1f5f9;
    padding: 16px 0;
}
.gb-panel-section:first-child { padding-top: 0; }
.gb-panel-section:last-child { border-bottom: none; padding-bottom: 0; }
.gb-section-label {
    font-size: 0.7rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .06em;
    color: #94a3b8;
    margin-bottom: 8px;
    display: flex;
    align-items: center;
    gap: 6px;
}
.status-indicator {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: .78rem;
    font-weight: 600;
    padding: 4px 12px;
    border-radius: 20px;
}
.status-indicator.draft { background: #fef9c3; color: #854d0e; }
.status-indicator.published { background: #dcfce7; color: #166534; }
.article-content {
    font-family: system-ui, -apple-system, sans-serif;
    font-size: 16px;
    color: #334155;
    line-height: 1.8;
}
.article-content h2, .article-content h3, .article-content h4 {
    color: #1e293b;
    font-weight: 700;
    margin-top: 1.5em;
    margin-bottom: 0.5em;
}
.article-content blockquote {
    border-left: 4px solid #EC1E88;
    margin: 16px 0;
    padding: 8px 16px;
    background: #fdf2f8;
    color: #64748b;
    font-style: italic;
}
.article-content img {
    max-width: 100%;
    height: auto;
    border-radius: 8px;
    margin: 16px 0;
}
</style>
@endpush

@section('content')
<div class="pagetitle">
    <h1>Detail Artikel</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('artikel-edukasi.index') }}">Artikel Edukasi</a></li>
            <li class="breadcrumb-item active">Detail</li>
        </ol>
    </nav>
</div>

<div class="gb-toolbar">
    <a href="{{ route('artikel-edukasi.index') }}" class="btn btn-sm btn-outline-secondary" style="border-radius:8px;">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
    <span class="article-title-bar">{{ $artikelEdukasi->judul }}</span>
    <a href="{{ route('artikel-edukasi.edit', $artikelEdukasi->id) }}" class="btn btn-sm btn-warning" style="border-radius:8px;">
        <i class="bi bi-pencil-square me-1"></i> Edit Artikel
    </a>
    @if($artikelEdukasi->status === 'published')
        <a href="{{ route('homepage.artikel.show', $artikelEdukasi->slug) }}" target="_blank"
           class="btn btn-sm btn-outline-secondary" style="border-radius:8px;">
            <i class="bi bi-box-arrow-up-right me-1"></i> Lihat di Publik
        </a>
    @endif
</div>

<div class="gb-wrap">
    {{-- LEFT: Content --}}
    <div class="gb-editor-card">
        <div class="gb-editor-inner">
            <h1 class="article-title-h1">{{ $artikelEdukasi->judul }}</h1>
            
            <div class="gb-slug-row">
                <span class="gb-slug-label"><i class="bi bi-link-45deg"></i> Permalink:</span>
                <span class="gb-slug-val">/artikel/{{ $artikelEdukasi->slug }}</span>
            </div>

            <div class="article-content">
                {!! $artikelEdukasi->isi !!}
            </div>
        </div>
    </div>

    {{-- RIGHT: Sidebar Metadata --}}
    <div class="gb-sidebar-panel">
        <div class="gb-panel-header">
            <i class="bi bi-info-circle me-1"></i> Informasi Artikel
        </div>
        <div class="gb-panel-body">
            <div class="gb-panel-section">
                <div class="gb-section-label"><i class="bi bi-send"></i> Status</div>
                <span class="status-indicator {{ $artikelEdukasi->status }}">
                    <i class="bi bi-circle-fill" style="font-size:.5rem;"></i>
                    {{ ucfirst($artikelEdukasi->status) }}
                </span>
            </div>

            <div class="gb-panel-section">
                <div class="gb-section-label"><i class="bi bi-tag"></i> Kategori</div>
                @if($artikelEdukasi->kategoriArtikel)
                    <span class="badge rounded-pill" style="background:#EC1E88; font-size:.8rem; padding: 6px 12px;">
                        {{ $artikelEdukasi->kategoriArtikel->nama }}
                    </span>
                @else
                    <span class="text-muted">-</span>
                @endif
            </div>

            <div class="gb-panel-section">
                <div class="gb-section-label"><i class="bi bi-person"></i> Penulis</div>
                <span class="text-dark fw-bold" style="font-size:.85rem;">{{ $artikelEdukasi->penulis }}</span>
            </div>

            <div class="gb-panel-section">
                <div class="gb-section-label"><i class="bi bi-calendar3"></i> Tanggal Terbit</div>
                <span class="text-secondary" style="font-size:.85rem;">
                    {{ $artikelEdukasi->diterbitkan_pada ? $artikelEdukasi->diterbitkan_pada->format('d F Y') : '-' }}
                </span>
            </div>

            @if($artikelEdukasi->gambar)
                <div class="gb-panel-section">
                    <div class="gb-section-label"><i class="bi bi-image"></i> Gambar Unggulan</div>
                    <img src="{{ $artikelEdukasi->gambar_url }}" class="img-fluid rounded border mt-1" alt="Featured Image">
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
