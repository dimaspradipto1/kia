@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1 class="fw-bold text-dark">Konsultasi Baru</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('konsultasi-online.index') }}">Konsultasi Online</a></li>
            <li class="breadcrumb-item active">Buat Konsultasi</li>
        </ol>
    </nav>
</div>

<section class="section">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm" style="border-radius: 16px;">
                <div class="card-header bg-white border-bottom py-3 px-4" style="border-top-left-radius: 16px; border-top-right-radius: 16px;">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary-subtle text-primary rounded-3 p-2 me-3">
                            <i class="bi bi-chat-left-heart fs-4"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold text-dark mb-0">Ajukan Keluhan Baru</h5>
                            <span class="text-muted small">Pesan Anda akan langsung masuk ke panel Tenaga Kesehatan faskes terkait.</span>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('konsultasi-online.store') }}" method="POST">
                        @csrf

                        <!-- Faskes Selector -->
                        <div class="mb-4">
                            <label class="form-label fw-bold text-dark small">Pilih Fasilitas Kesehatan Tujuan</label>
                            <select name="fasilitas_kesehatan_id" class="form-select rounded-4 select2 @error('fasilitas_kesehatan_id') is-invalid @enderror" style="padding: 10px 15px;">
                                <option value="">-- Pilih Fasilitas Kesehatan --</option>
                                @foreach($faskesList as $fk)
                                    <option value="{{ $fk->id }}" {{ old('fasilitas_kesehatan_id', $userFaskesId) == $fk->id ? 'selected' : '' }}>
                                        {{ $fk->nama_faskes }} ({{ $fk->jenis }})
                                    </option>
                                @endforeach
                            </select>
                            @error('fasilitas_kesehatan_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            @if($userFaskesId)
                                <div class="form-text mt-2 small text-success">
                                    <i class="bi bi-bookmark-check-fill me-1"></i> Sistem otomatis memilih Fasilitas Kesehatan tempat profil Anda terdaftar saat ini.
                                </div>
                            @endif
                        </div>

                        <!-- Topik Keluhan -->
                        <div class="mb-4">
                            <label class="form-label fw-bold text-dark small">Topik Keluhan / Gejala Utama</label>
                            <input type="text" name="topik" class="form-control rounded-4 @error('topik') is-invalid @enderror" placeholder="Contoh: Kram perut hebat di trimester 2, atau mual berlebih" value="{{ old('topik') }}" style="padding: 10px 15px;">
                            @error('topik')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text small text-muted">
                                Tuliskan keluhan atau gejala utama secara singkat dan jelas.
                            </div>
                        </div>

                        <!-- Detail Pertanyaan / Pesan -->
                        <div class="mb-4">
                            <label class="form-label fw-bold text-dark small">Detail Keluhan Medis (Deskripsi Lengkap)</label>
                            <textarea name="pesan" class="form-control rounded-4 @error('pesan') is-invalid @enderror" rows="6" placeholder="Tuliskan gejala lengkap Anda secara menyeluruh. \nMisalnya: Kapan gejala dimulai? Bagaimana rasanya? Apakah ada obat/tindakan awal yang sudah dicoba? Apakah disertai demam/lemas?" style="padding: 15px;">{{ old('pesan') }}</textarea>
                            @error('pesan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Info Alert -->
                        <div class="alert alert-info border-0 rounded-4 p-3 mb-4 d-flex">
                            <i class="bi bi-info-circle-fill fs-4 me-3 text-info"></i>
                            <div class="small">
                                <strong class="text-info d-block mb-1">Peringatan Kedaruratan:</strong>
                                Jika Anda mengalami tanda-tanda bahaya kehamilan darurat seperti perdarahan masif, pecah ketuban dini, atau kejang, <strong>jangan menunggu jawaban online</strong>. Silakan langsung menuju UGD rumah sakit terdekat.
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                            <a href="{{ route('konsultasi-online.index') }}" class="btn btn-outline-secondary rounded-pill px-4 fw-bold text-secondary bg-white border-light-subtle">
                                <i class="bi bi-arrow-left me-1"></i> Batal & Kembali
                            </a>
                            <button type="submit" class="btn btn-success rounded-pill px-5 fw-bold shadow-sm" style="background-color: #10B981; border-color: #10B981;">
                                <i class="bi bi-send me-1"></i> Kirim Pertanyaan
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
