@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Detail Kontak</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('contacts.index') }}">Kontak</a></li>
            <li class="breadcrumb-item active">Detail</li>
        </ol>
    </nav>
</div>

<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px; overflow: hidden; border-top: 5px solid #EC1E88 !important;">
                <div class="card-header bg-white border-bottom py-3 px-4 d-flex justify-content-between align-items-center">
                    <h5 class="m-0 fw-bold text-dark" style="font-size: 1.1rem;">Informasi Kontak</h5>
                    <a href="{{ route('contacts.index') }}" class="btn btn-secondary btn-sm px-3">
                        <i class="bi bi-arrow-left me-1"></i> Kembali
                    </a>
                </div>
                <div class="card-body p-4">

                    <div class="row g-4 mb-4">
                        {{-- Nama Lokasi --}}
                        <div class="col-md-6">
                            <div class="d-flex align-items-start">
                                <div class="icon-box me-3" style="background: rgba(236,30,136,0.1); color: #EC1E88; padding: 12px; border-radius: 12px; flex-shrink:0;">
                                    <i class="bi bi-geo-alt-fill fs-4"></i>
                                </div>
                                <div>
                                    <label class="text-uppercase small fw-bold text-muted mb-1 d-block" style="letter-spacing:1px;">Nama Lokasi</label>
                                    <h5 class="fw-bold text-dark mb-0">{{ $contact->nama_lokasi }}</h5>
                                </div>
                            </div>
                        </div>

                        {{-- Status --}}
                        <div class="col-md-6">
                            <div class="d-flex align-items-start">
                                <div class="icon-box me-3" style="background: rgba(0,0,0,0.05); color: #64748b; padding: 12px; border-radius: 12px; flex-shrink:0;">
                                    <i class="bi bi-info-circle-fill fs-4"></i>
                                </div>
                                <div>
                                    <label class="text-uppercase small fw-bold text-muted mb-1 d-block" style="letter-spacing:1px;">Status</label>
                                    @if($contact->is_active)
                                        <span class="badge bg-success px-3 py-2">Aktif</span>
                                    @else
                                        <span class="badge bg-danger px-3 py-2">Non-Aktif</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- Alamat --}}
                        <div class="col-md-12">
                            <div class="p-4" style="background-color: #f8fafc; border-radius: 16px; border-left: 5px solid #EC1E88;">
                                <label class="text-uppercase small fw-bold text-muted mb-2 d-block" style="letter-spacing:1px;">Alamat</label>
                                <p class="text-dark mb-0" style="line-height:1.8;">{{ $contact->alamat }}</p>
                            </div>
                        </div>

                        {{-- Email --}}
                        <div class="col-md-4">
                            <div class="d-flex align-items-start">
                                <div class="icon-box me-3" style="background: rgba(22,179,172,0.1); color: #16B3AC; padding: 10px; border-radius: 10px; flex-shrink:0;">
                                    <i class="bi bi-envelope-fill fs-5"></i>
                                </div>
                                <div>
                                    <label class="text-uppercase small fw-bold text-muted mb-1 d-block" style="letter-spacing:1px; font-size:0.7rem;">Email</label>
                                    <span class="text-dark fw-semibold">{{ $contact->email ?? '-' }}</span>
                                </div>
                            </div>
                        </div>

                        {{-- Telepon --}}
                        <div class="col-md-4">
                            <div class="d-flex align-items-start">
                                <div class="icon-box me-3" style="background: rgba(22,179,172,0.1); color: #16B3AC; padding: 10px; border-radius: 10px; flex-shrink:0;">
                                    <i class="bi bi-telephone-fill fs-5"></i>
                                </div>
                                <div>
                                    <label class="text-uppercase small fw-bold text-muted mb-1 d-block" style="letter-spacing:1px; font-size:0.7rem;">Telepon</label>
                                    <span class="text-dark fw-semibold">{{ $contact->telepon ?? '-' }}</span>
                                </div>
                            </div>
                        </div>

                        {{-- Jam Operasional --}}
                        <div class="col-md-4">
                            <div class="d-flex align-items-start">
                                <div class="icon-box me-3" style="background: rgba(22,179,172,0.1); color: #16B3AC; padding: 10px; border-radius: 10px; flex-shrink:0;">
                                    <i class="bi bi-clock-fill fs-5"></i>
                                </div>
                                <div>
                                    <label class="text-uppercase small fw-bold text-muted mb-1 d-block" style="letter-spacing:1px; font-size:0.7rem;">Jam Operasional</label>
                                    <span class="text-dark fw-semibold">{{ $contact->jam_operasional ?? '-' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Map Preview --}}
                    @if($contact->map_embed)
                    <div class="mt-2">
                        <label class="text-uppercase small fw-bold text-muted mb-2 d-block" style="letter-spacing:1px;">
                            <i class="bi bi-map me-1"></i> Peta Google Maps
                        </label>
                        <div style="border-radius: 16px; overflow: hidden; border: 1px solid #dee2e6; box-shadow: 0 4px 20px rgba(0,0,0,0.05);">
                            {!! str_replace(['width="600"', 'width="600px"'], 'width="100%"',
                                str_replace(['height="450"', 'height="450px"'], 'height="400"', $contact->map_embed)) !!}
                        </div>
                    </div>
                    @else
                    <div class="alert alert-secondary d-flex align-items-center" role="alert">
                        <i class="bi bi-map me-2 fs-5"></i>
                        <span>Belum ada embed peta untuk lokasi ini.</span>
                    </div>
                    @endif

                </div>
                <div class="card-footer bg-white border-top p-4 text-end">
                    <a href="{{ route('contacts.edit', $contact->id) }}" class="btn text-white px-5 py-2 fw-bold shadow-sm" style="background-color: #EC1E88; border-radius: 10px;">
                        <i class="bi bi-pencil-square me-2"></i> Edit Data Kontak
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
