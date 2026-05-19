@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1 class="fw-bold text-dark">Respons Konsultasi</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('konsultasi-online.index') }}">Konsultasi Online</a></li>
            <li class="breadcrumb-item active">Beri Tanggapan Medis</li>
        </ol>
    </nav>
</div>

<section class="section">
    <div class="row">
        
        {{-- Keluhan Pasien --}}
        <div class="col-lg-5 mb-4">
            <div class="card border-0 shadow-sm" style="border-radius: 16px; background-color: #F8FAFC;">
                <div class="card-header bg-white border-bottom py-3 px-4" style="border-top-left-radius: 16px; border-top-right-radius: 16px;">
                    <h5 class="fw-bold text-dark mb-0"><i class="bi bi-person-bounding-box text-primary me-2"></i>Identitas Ibu & Keluhan</h5>
                </div>
                <div class="card-body p-4">
                    
                    <!-- Patient profile summary -->
                    <div class="d-flex align-items-center mb-4 p-3 bg-white rounded-4 border">
                        <div class="bg-primary-subtle text-primary rounded-pill p-3 me-3" style="width: 52px; height: 52px; display: flex; align-items: center; justify-content: center;">
                            <i class="bi bi-person fs-3"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold text-dark mb-1">{{ optional($konsultasiOnline->user)->name ?? '-' }}</h6>
                            <span class="text-muted small d-block"><i class="bi bi-card-text me-1"></i>NIK: {{ optional($konsultasiOnline->user->profilIbu)->nik ?? '-' }}</span>
                            <span class="badge bg-secondary-subtle text-secondary small mt-1" style="font-size: 10px;">
                                <i class="bi bi-hospital me-1"></i>{{ optional($konsultasiOnline->fasilitasKesehatan)->nama_faskes ?? '-' }}
                            </span>
                        </div>
                    </div>

                    <!-- Consultation details -->
                    <div class="mb-3">
                        <span class="text-secondary small fw-bold uppercase">TOPIK KONSULTASI</span>
                        <h6 class="fw-bold text-dark mt-1">{{ $konsultasiOnline->topik ?? 'Keluhan Umum' }}</h6>
                    </div>

                    <div class="mb-4">
                        <span class="text-secondary small fw-bold uppercase">PESAN / KELUHAN IBU</span>
                        <div class="p-3 bg-white rounded-4 border mt-1 text-dark small" style="white-space: pre-wrap; line-height: 1.6;">{{ $konsultasiOnline->pesan }}</div>
                    </div>

                    <div class="small text-muted">
                        <i class="bi bi-calendar-event me-1"></i>Diajukan pada: {{ $konsultasiOnline->created_at ? $konsultasiOnline->created_at->translatedFormat('d F Y H:i') : '-' }}
                    </div>

                </div>
            </div>
        </div>

        {{-- Form Respons Bidan --}}
        <div class="col-lg-7 mb-4">
            <div class="card border-0 shadow-sm" style="border-radius: 16px;">
                <div class="card-header bg-white border-bottom py-3 px-4" style="border-top-left-radius: 16px; border-top-right-radius: 16px;">
                    <div class="d-flex align-items-center">
                        <div class="bg-success-subtle text-success rounded-3 p-2 me-3">
                            <i class="bi bi-chat-left-dots fs-4"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold text-dark mb-0">Formulir Tanggapan Tenaga Kesehatan</h5>
                            <span class="text-muted small">Tuliskan saran medis yang aman bagi ibu hamil sesuai standar MoH.</span>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('konsultasi-online.update', $konsultasiOnline->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Status Action -->
                        <div class="mb-4">
                            <label class="form-label fw-bold text-dark small">Keputusan / Status Tanggapan</label>
                            <div class="d-flex gap-3">
                                <div class="form-check p-3 border rounded-4 flex-fill d-flex align-items-center" style="cursor: pointer;">
                                    <input class="form-check-input ms-1 me-3" type="radio" name="status" id="status_accept" value="accepted" {{ old('status', $konsultasiOnline->status) !== 'rejected' ? 'checked' : '' }}>
                                    <label class="form-check-label fw-semibold text-success" for="status_accept" style="cursor: pointer;">
                                        <i class="bi bi-check-circle-fill me-1"></i> Beri Tanggapan Medis
                                    </label>
                                </div>
                                <div class="form-check p-3 border rounded-4 flex-fill d-flex align-items-center" style="cursor: pointer;">
                                    <input class="form-check-input ms-1 me-3" type="radio" name="status" id="status_reject" value="rejected" {{ old('status', $konsultasiOnline->status) === 'rejected' ? 'checked' : '' }}>
                                    <label class="form-check-label fw-semibold text-danger" for="status_reject" style="cursor: pointer;">
                                        <i class="bi bi-x-circle-fill me-1"></i> Tolak / Rujuk Segera
                                    </label>
                                </div>
                            </div>
                            @error('status')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Text Area Jawaban -->
                        <div class="mb-4">
                            <label class="form-label fw-bold text-dark small">Tulis Jawaban / Saran Medis</label>
                            <textarea name="respons" class="form-control rounded-4 @error('respons') is-invalid @enderror" rows="8" placeholder="Contoh: Selamat pagi Ibu, keluhan kram perut ringan di trimester kedua biasanya wajar karena peregangan rahim. Namun jika disertai flek darah, silakan beristirahat total dan segera hubungi tenaga kesehatan kami untuk pemeriksaan langsung..." style="padding: 15px;">{{ old('respons', $konsultasiOnline->respons) }}</textarea>
                            @error('respons')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Buttons -->
                        <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                            <a href="{{ route('konsultasi-online.index') }}" class="btn btn-outline-secondary rounded-pill px-4 fw-bold text-secondary bg-white border-light-subtle">
                                <i class="bi bi-arrow-left me-1"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-success rounded-pill px-5 fw-bold shadow-sm" style="background-color: #10B981; border-color: #10B981;">
                                <i class="bi bi-send-fill me-1"></i> Kirim Jawaban Medis
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>

    </div>
</section>
@endsection
