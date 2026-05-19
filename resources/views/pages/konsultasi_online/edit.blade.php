@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1 class="fw-bold text-dark">Edit Konsultasi</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('konsultasi-online.index') }}">Konsultasi Online</a></li>
            <li class="breadcrumb-item active">Ubah Pertanyaan</li>
        </ol>
    </nav>
</div>

<section class="section">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm" style="border-radius: 16px;">
                <div class="card-header bg-white border-bottom py-3 px-4" style="border-top-left-radius: 16px; border-top-right-radius: 16px;">
                    <div class="d-flex align-items-center">
                        <div class="bg-warning-subtle text-warning rounded-3 p-2 me-3">
                            <i class="bi bi-pencil-square fs-4"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold text-dark mb-0">Ubah Pertanyaan Anda</h5>
                            <span class="text-muted small">Ubah detail pesan sebelum Tenaga Kesehatan memberikan saran medis.</span>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('konsultasi-online.update', $konsultasiOnline->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Faskes Selector -->
                        <div class="mb-4">
                            <label class="form-label fw-bold text-dark small">Pilih Fasilitas Kesehatan Tujuan</label>
                            <select name="fasilitas_kesehatan_id" class="form-select rounded-4 select2 @error('fasilitas_kesehatan_id') is-invalid @enderror" style="padding: 10px 15px;">
                                <option value="">-- Pilih Fasilitas Kesehatan --</option>
                                @foreach($faskesList as $fk)
                                    <option value="{{ $fk->id }}" {{ old('fasilitas_kesehatan_id', $konsultasiOnline->fasilitas_kesehatan_id) == $fk->id ? 'selected' : '' }}>
                                        {{ $fk->nama_faskes }} ({{ $fk->jenis }})
                                    </option>
                                @endforeach
                            </select>
                            @error('fasilitas_kesehatan_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Topik Keluhan -->
                        <div class="mb-4">
                            <label class="form-label fw-bold text-dark small">Topik Keluhan / Gejala Utama</label>
                            <input type="text" name="topik" class="form-control rounded-4 @error('topik') is-invalid @enderror" placeholder="Contoh: Kram perut hebat di trimester 2" value="{{ old('topik', $konsultasiOnline->topik) }}" style="padding: 10px 15px;">
                            @error('topik')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Detail Pertanyaan / Pesan -->
                        <div class="mb-4">
                            <label class="form-label fw-bold text-dark small">Detail Keluhan Medis (Deskripsi Lengkap)</label>
                            <textarea name="pesan" class="form-control rounded-4 @error('pesan') is-invalid @enderror" rows="6" placeholder="Tuliskan gejala lengkap Anda secara menyeluruh..." style="padding: 15px;">{{ old('pesan', $konsultasiOnline->pesan) }}</textarea>
                            @error('pesan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Buttons -->
                        <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                            <a href="{{ route('konsultasi-online.index') }}" class="btn btn-outline-secondary rounded-pill px-4 fw-bold text-secondary bg-white border-light-subtle">
                                <i class="bi bi-arrow-left me-1"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-warning rounded-pill px-5 fw-bold shadow-sm text-white">
                                <i class="bi bi-check-circle me-1"></i> Simpan Perubahan
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
