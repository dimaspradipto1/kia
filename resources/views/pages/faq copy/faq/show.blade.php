@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Detail FAQ</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('faqs.index') }}">FAQ</a></li>
            <li class="breadcrumb-item active">Detail</li>
        </ol>
    </nav>
</div>

<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px; overflow: hidden; border-top: 5px solid #EC1E88 !important;">
                <div class="card-header bg-white border-bottom py-3 px-4 d-flex justify-content-between align-items-center">
                    <h5 class="m-0 fw-bold text-dark" style="font-size: 1.1rem;">Informasi FAQ</h5>
                    <a href="{{ route('faqs.index') }}" class="btn btn-secondary btn-sm px-3">
                        <i class="bi bi-arrow-left me-1"></i> Kembali
                    </a>
                </div>
                <div class="card-body p-4">
                    <div class="faq-detail-container">
                        <div class="d-flex align-items-start mb-4">
                            <div class="icon-box me-3" style="background: rgba(22, 179, 172, 0.1); color: #16B3AC; padding: 12px; border-radius: 12px;">
                                <i class="bi bi-tag-fill fs-4"></i>
                            </div>
                            <div>
                                <label class="text-uppercase small fw-bold text-muted mb-1 d-block" style="letter-spacing: 1px;">Kategori</label>
                                <span class="badge px-3 py-2" style="background-color: #16B3AC; color: white; border-radius: 8px;">{{ $faq->kategori }}</span>
                            </div>
                        </div>

                        <div class="d-flex align-items-start mb-4">
                            <div class="icon-box me-3" style="background: rgba(236, 30, 136, 0.1); color: #EC1E88; padding: 12px; border-radius: 12px;">
                                <i class="bi bi-question-circle-fill fs-4"></i>
                            </div>
                            <div>
                                <label class="text-uppercase small fw-bold text-muted mb-1 d-block" style="letter-spacing: 1px;">Pertanyaan</label>
                                <h4 class="fw-bold text-dark mb-0">{{ $faq->pertanyaan }}</h4>
                            </div>
                        </div>

                        <div class="p-4 mb-4" style="background-color: #f8fafc; border-radius: 16px; border-left: 5px solid #EC1E88;">
                            <label class="text-uppercase small fw-bold text-muted mb-3 d-block" style="letter-spacing: 1px;">Jawaban</label>
                            <div class="text-dark" style="line-height: 1.8; font-size: 1.05rem; white-space: pre-wrap;">{{ $faq->jawaban }}</div>
                        </div>

                        @if($faq->tips)
                        <div class="p-4 mb-4" style="background-color: rgba(22, 179, 172, 0.05); border-radius: 16px; border-left: 5px solid #16B3AC;">
                            <label class="text-uppercase small fw-bold text-muted mb-3 d-block" style="letter-spacing: 1px; color: #16B3AC !important;">Tips Tambahan</label>
                            <div class="text-dark" style="line-height: 1.8; font-size: 1.05rem; white-space: pre-wrap;"><i class="bi bi-lightbulb me-2" style="color: #16B3AC;"></i>{{ $faq->tips }}</div>
                        </div>
                        @endif

                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="d-flex align-items-center">
                                    <div class="icon-box me-3" style="background: rgba(0, 0, 0, 0.05); color: #64748b; padding: 10px; border-radius: 10px;">
                                        <i class="bi bi-info-circle fs-5"></i>
                                    </div>
                                    <div>
                                        <label class="text-uppercase tiny-text fw-bold text-muted mb-0 d-block" style="font-size: 0.7rem; letter-spacing: 1px;">STATUS</label>
                                        @if($faq->is_active)
                                            <span class="text-success fw-bold"><i class="bi bi-check-circle-fill me-1"></i>Aktif</span>
                                        @else
                                            <span class="text-danger fw-bold"><i class="bi bi-x-circle-fill me-1"></i>Non-Aktif</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 text-md-end">
                                <div class="d-inline-flex align-items-center text-start">
                                    <div class="icon-box me-3" style="background: rgba(0, 0, 0, 0.05); color: #64748b; padding: 10px; border-radius: 10px;">
                                        <i class="bi bi-clock-history fs-5"></i>
                                    </div>
                                    <div>
                                        <label class="text-uppercase tiny-text fw-bold text-muted mb-0 d-block" style="font-size: 0.7rem; letter-spacing: 1px;">TERAKHIR DIPERBARUI</label>
                                        <span class="text-muted fw-semibold small">{{ $faq->updated_at->format('d M Y, H:i') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-white border-top p-4 text-end">
                    <a href="{{ route('faqs.edit', $faq->id) }}" class="btn text-white px-5 py-2 fw-bold shadow-sm" style="background-color: #EC1E88; border-radius: 10px;">
                        <i class="bi bi-pencil-square me-2"></i> Edit Data FAQ
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
