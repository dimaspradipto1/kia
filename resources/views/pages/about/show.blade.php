@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Detail About</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('abouts.index') }}">About</a></li>
            <li class="breadcrumb-item active">Detail</li>
        </ol>
    </nav>
</div>

<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="card border-0 shadow-sm mb-4" style="border-radius:12px;overflow:hidden;border-top:5px solid #EC1E88 !important;">
                <div class="card-header bg-white border-bottom py-3 px-4 d-flex justify-content-between align-items-center">
                    <h5 class="m-0 fw-bold text-dark" style="font-size:1.1rem;">Informasi About</h5>
                    <a href="{{ route('abouts.index') }}" class="btn btn-secondary btn-sm px-3">
                        <i class="bi bi-arrow-left me-1"></i> Kembali
                    </a>
                </div>
                <div class="card-body p-4">

                    {{-- Top row --}}
                    <div class="row g-4 mb-4">
                        <div class="col-md-8">
                            <label class="text-uppercase small fw-bold text-muted mb-1 d-block" style="letter-spacing:1px;">Judul</label>
                            <h4 class="fw-bold text-dark mb-0">{{ $about->judul }}</h4>
                        </div>
                        <div class="col-md-4 text-md-end">
                            @if($about->is_active)
                                <span class="badge bg-success px-3 py-2">Aktif</span>
                            @else
                                <span class="badge bg-danger px-3 py-2">Non-Aktif</span>
                            @endif
                        </div>
                    </div>

                    @if($about->sub_judul)
                    <div class="mb-3">
                        <label class="text-uppercase small fw-bold text-muted mb-1 d-block" style="letter-spacing:1px;">Sub Judul / Label</label>
                        <span class="badge px-3 py-2" style="background:#EC1E88;color:#fff;">{{ $about->sub_judul }}</span>
                    </div>
                    @endif

                    @if($about->deskripsi_pendek)
                    <div class="p-4 mb-4" style="background:#f8fafc;border-radius:16px;border-left:5px solid #EC1E88;">
                        <label class="text-uppercase small fw-bold text-muted mb-2 d-block" style="letter-spacing:1px;">Deskripsi Singkat</label>
                        <p class="mb-0" style="line-height:1.8;font-size:1.05rem;">{{ $about->deskripsi_pendek }}</p>
                    </div>
                    @endif

                    @if($about->deskripsi_panjang)
                    <div class="p-4 mb-4" style="background:#f8fafc;border-radius:16px;border-left:5px solid #16B3AC;">
                        <label class="text-uppercase small fw-bold text-muted mb-2 d-block" style="letter-spacing:1px;">Deskripsi Lengkap</label>
                        <p class="mb-0" style="line-height:1.8;white-space:pre-wrap;">{{ $about->deskripsi_panjang }}</p>
                    </div>
                    @endif

                    @if($about->fitur && count($about->fitur))
                    <div class="mb-4">
                        <label class="text-uppercase small fw-bold text-muted mb-2 d-block" style="letter-spacing:1px;">Fitur / Keunggulan</label>
                        <ul class="list-unstyled mb-0">
                            @foreach($about->fitur as $f)
                            <li class="d-flex align-items-center mb-2">
                                <i class="bi bi-check-circle-fill me-2" style="color:#16B3AC;"></i>
                                <span>{{ $f }}</span>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    @if($about->tahun_mengabdi)
                    <div class="mb-4">
                        <label class="text-uppercase small fw-bold text-muted mb-1 d-block" style="letter-spacing:1px;">Tahun Mengabdi</label>
                        <span class="fw-bold fs-4" style="color:#EC1E88;">{{ $about->tahun_mengabdi }}+</span> <span class="text-muted">Tahun</span>
                    </div>
                    @endif

                </div>
            </div>

            {{-- ===== GALERI GAMBAR ===== --}}
            <div class="card border-0 shadow-sm mb-4" style="border-radius:12px;overflow:hidden;border-top:5px solid #16B3AC !important;">
                <div class="card-header bg-white border-bottom py-3 px-4">
                    <h5 class="m-0 fw-bold text-dark" style="font-size:1.1rem;">
                        <i class="bi bi-images me-2" style="color:#16B3AC;"></i>Galeri Gambar
                        <span class="badge ms-2" style="background:#16B3AC;font-size:.75rem;">{{ $about->images->count() }} foto</span>
                    </h5>
                </div>
                <div class="card-body p-4">
                    @if($about->images->count() > 0)
                        <div class="row g-3">
                            @foreach($about->images as $img)
                            <div class="col-6 col-md-3 col-lg-2">
                                <div class="position-relative rounded-3 overflow-hidden border {{ $img->is_default ? 'border-warning border-2' : 'border-light' }}"
                                     style="aspect-ratio:1;">
                                    <img src="{{ $img->url }}" alt="{{ $img->keterangan ?? 'Gambar' }}"
                                         style="width:100%;height:100%;object-fit:cover;">
                                    @if($img->is_default)
                                        <span class="position-absolute top-0 start-0 badge bg-warning text-dark m-1" style="font-size:.65rem;">
                                            <i class="bi bi-star-fill"></i> Default
                                        </span>
                                    @endif
                                </div>
                                @if($img->keterangan)
                                <p class="text-muted mt-1 mb-0" style="font-size:.75rem;">{{ $img->keterangan }}</p>
                                @endif
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4 text-muted">
                            <i class="bi bi-image fs-1 mb-2 d-block"></i>
                            <p class="mb-0">Belum ada gambar. <a href="{{ route('abouts.edit', $about->id) }}">Tambah gambar</a></p>
                        </div>
                    @endif
                </div>
            </div>

            <div class="text-end">
                <a href="{{ route('abouts.edit', $about->id) }}" class="btn text-white px-5 py-2 fw-bold shadow-sm" style="background-color:#EC1E88;border-radius:10px;">
                    <i class="bi bi-pencil-square me-2"></i> Edit
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
