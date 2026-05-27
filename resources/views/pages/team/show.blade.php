@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Detail Anggota Tim</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('teams.index') }}">Tim</a></li>
            <li class="breadcrumb-item active">Detail</li>
        </ol>
    </nav>
</div>

<section class="section">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4" style="border-radius:12px;overflow:hidden;border-top:5px solid #EC1E88 !important;">
                <div class="card-header bg-white border-bottom py-3 px-4 d-flex justify-content-between align-items-center">
                    <h5 class="m-0 fw-bold text-dark" style="font-size:1.1rem;">Informasi Anggota Tim</h5>
                    <a href="{{ route('teams.index') }}" class="btn btn-secondary btn-sm px-3">
                        <i class="bi bi-arrow-left me-1"></i> Kembali
                    </a>
                </div>
                <div class="card-body p-4">

                    {{-- Foto + nama --}}
                    <div class="text-center mb-4">
                        <img src="{{ $team->foto_url }}" alt="{{ $team->nama }}"
                             style="width:130px;height:130px;border-radius:50%;object-fit:cover;
                                    border:4px solid #EC1E88;box-shadow:0 8px 24px rgba(236,30,136,.2);">
                        <h4 class="fw-bold mt-3 mb-1">{{ $team->nama }}</h4>
                        <span class="badge px-3 py-2" style="background:#EC1E88;font-size:.9rem;">{{ $team->jabatan }}</span>
                    </div>

                    <hr>

                    {{-- Info grid --}}
                    <div class="row g-3 mt-2">
                        <div class="col-md-6">
                            <label class="text-uppercase small fw-bold text-muted d-block" style="letter-spacing:1px;font-size:.7rem;">Status</label>
                            @if($team->is_active)
                                <span class="badge bg-success px-3 py-2">Aktif</span>
                            @else
                                <span class="badge bg-danger px-3 py-2">Non-Aktif</span>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <label class="text-uppercase small fw-bold text-muted d-block" style="letter-spacing:1px;font-size:.7rem;">Urutan Tampil</label>
                            <span class="fw-bold fs-5" style="color:#EC1E88;">{{ $team->urutan }}</span>
                        </div>
                        <div class="col-md-6">
                            <label class="text-uppercase small fw-bold text-muted d-block mb-1" style="letter-spacing:1px;font-size:.7rem;">LinkedIn</label>
                            @if($team->linkedin)
                                <a href="{{ $team->linkedin }}" target="_blank" class="btn btn-sm" style="background:#0077b5;color:#fff;border-radius:20px;">
                                    <i class="bi bi-linkedin me-1"></i> Lihat Profil
                                </a>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <label class="text-uppercase small fw-bold text-muted d-block mb-1" style="letter-spacing:1px;font-size:.7rem;">TikTok</label>
                            @if($team->tiktok)
                                <a href="{{ $team->tiktok }}" target="_blank" class="btn btn-sm btn-dark" style="border-radius:20px;">
                                    <i class="bi bi-tiktok me-1"></i> Lihat Profil
                                </a>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <label class="text-uppercase small fw-bold text-muted d-block mb-1" style="letter-spacing:1px;font-size:.7rem;">Instagram</label>
                            @if($team->instagram)
                                <a href="{{ $team->instagram }}" target="_blank" class="btn btn-sm" style="background:#E1306C;color:#fff;border-radius:20px;">
                                    <i class="bi bi-instagram me-1"></i> Lihat Profil
                                </a>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <label class="text-uppercase small fw-bold text-muted d-block mb-1" style="letter-spacing:1px;font-size:.7rem;">Facebook</label>
                            @if($team->facebook)
                                <a href="{{ $team->facebook }}" target="_blank" class="btn btn-sm" style="background:#1877F2;color:#fff;border-radius:20px;">
                                    <i class="bi bi-facebook me-1"></i> Lihat Profil
                                </a>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-white border-top p-4 text-end">
                    <a href="{{ route('teams.edit', $team->id) }}" class="btn text-white px-5 py-2 fw-bold shadow-sm"
                       style="background-color:#EC1E88;border-radius:10px;">
                        <i class="bi bi-pencil-square me-2"></i> Edit
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
