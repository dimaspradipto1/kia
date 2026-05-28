@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Detail Kategori Artikel</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('kategori-artikel.index') }}">Kategori Artikel</a></li>
            <li class="breadcrumb-item active">Detail</li>
        </ol>
    </nav>
</div>

<div class="row">
    {{-- Left Card: Detail Kategori --}}
    <div class="col-md-4">
        <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px; overflow: hidden; border-top: 5px solid #EC1E88 !important;">
            <div class="card-header bg-white border-bottom py-3 px-4">
                <h5 class="m-0 fw-bold text-dark" style="font-size: 1rem;">
                    <i class="bi bi-info-circle me-1" style="color:#EC1E88;"></i> Informasi Kategori
                </h5>
            </div>
            <div class="card-body p-4">
                <div class="mb-3">
                    <label class="text-muted small fw-bold text-uppercase">Nama Kategori</label>
                    <div class="text-dark fw-bold" style="font-size:1.1rem;">{{ $kategoriArtikel->nama }}</div>
                </div>

                <div class="mb-3">
                    <label class="text-muted small fw-bold text-uppercase">Slug</label>
                    <div><code style="color:#EC1E88;">{{ $kategoriArtikel->slug }}</code></div>
                </div>

                <div class="mb-3">
                    <label class="text-muted small fw-bold text-uppercase">Jumlah Artikel</label>
                    <div>
                        <span class="badge rounded-pill" style="background:#EC1E88;font-size:.8rem;padding:6px 12px;">
                            {{ $kategoriArtikel->artikels_count ?? $kategoriArtikel->artikels()->count() }} artikel
                        </span>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="text-muted small fw-bold text-uppercase">Deskripsi</label>
                    <div class="text-secondary" style="font-size:.85rem; line-height:1.5;">
                        {{ $kategoriArtikel->deskripsi ?: 'Tidak ada deskripsi.' }}
                    </div>
                </div>

                <div class="d-grid gap-2">
                    <a href="{{ route('kategori-artikel.edit', $kategoriArtikel->id) }}" class="btn btn-warning btn-sm" style="border-radius:8px;">
                        <i class="bi bi-pencil-square me-1"></i> Edit Kategori
                    </a>
                    <a href="{{ route('kategori-artikel.index') }}" class="btn btn-outline-secondary btn-sm" style="border-radius:8px;">
                        <i class="bi bi-arrow-left me-1"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Right Card: Daftar Artikel --}}
    <div class="col-md-8">
        <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px; overflow: hidden; border-top: 5px solid #EC1E88 !important;">
            <div class="card-header bg-white border-bottom py-3 px-4">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="m-0 fw-bold text-dark" style="font-size: 1rem;">
                        <i class="bi bi-newspaper me-1" style="color:#EC1E88;"></i> Artikel dalam Kategori Ini
                    </h5>
                    <a href="{{ route('artikel-edukasi.create', ['kategori' => $kategoriArtikel->id]) }}" class="btn btn-sm text-white" style="background-color:#EC1E88; border-radius: 8px; font-size:11px;">
                        <i class="bi bi-plus-lg me-1"></i> Tulis Artikel Baru
                    </a>
                </div>
            </div>
            <div class="card-body p-4">
                @php
                    $artikels = $kategoriArtikel->artikels()->latest()->get();
                @endphp

                @if($artikels->isEmpty())
                    <div class="text-center py-5 text-muted">
                        <i class="bi bi-newspaper fs-1 d-block mb-2" style="color:#cbd5e1;"></i>
                        Belum ada artikel dalam kategori ini.
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered align-middle" style="width:100%">
                            <thead>
                                <tr>
                                    <th style="width: 50px;" class="text-center">No</th>
                                    <th>Judul Artikel</th>
                                    <th>Penulis</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($artikels as $index => $artikel)
                                    <tr>
                                        <td class="text-center">{{ $index + 1 }}</td>
                                        <td>
                                            <strong>{{ $artikel->judul }}</strong>
                                        </td>
                                        <td>{{ $artikel->penulis }}</td>
                                        <td class="text-center">
                                            @if($artikel->status === 'published')
                                                <span class="badge bg-success">Published</span>
                                            @else
                                                <span class="badge bg-secondary">Draft</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-1">
                                                <a href="{{ route('artikel-edukasi.show', $artikel->id) }}" class="btn btn-info btn-sm text-white" title="Detail">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="{{ route('artikel-edukasi.edit', $artikel->id) }}" class="btn btn-warning btn-sm" title="Edit">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
