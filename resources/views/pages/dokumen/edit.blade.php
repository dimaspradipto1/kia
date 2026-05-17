@extends('layouts.dashboard.template')

@section('content')
    <div class="pagetitle">
        <h1>Edit / Verifikasi Dokumen</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('dokumen.index') }}">Dokumen</a></li>
                <li class="breadcrumb-item active">Edit</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card border-0 shadow-sm mb-4" style="border-radius:12px; border-top:5px solid #EC1E88 !important;">
                    <div class="card-header bg-white border-bottom py-3 px-4">
                        <h5 class="m-0 fw-bold text-dark">Form Edit Dokumen</h5>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('dokumen.update', $dokumen->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row mb-3">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label fw-bold">Pilih Buku KIA (Ibu) <span class="text-danger">*</span></label>
                                    <select name="buku_kia_id" class="form-select select2 @error('buku_kia_id') is-invalid @enderror" data-placeholder="Pilih Pemilik Buku KIA" required>
                                        <option value=""></option>
                                        @foreach ($bukuKia as $b)
                                            <option value="{{ $b->id }}" {{ old('buku_kia_id', $dokumen->buku_kia_id) == $b->id ? 'selected' : '' }}>
                                                {{ $b->profilIbu->nama_lengkap }} (QR: {{ $b->qr_code }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('buku_kia_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Jenis Dokumen <span class="text-danger">*</span></label>
                                    <select name="jenis_dokumen" class="form-select select2 @error('jenis_dokumen') is-invalid @enderror" data-placeholder="Pilih Jenis Dokumen" required>
                                        <option value=""></option>
                                        @foreach(['KTP Ibu', 'KTP Suami', 'Kartu Keluarga', 'Buku Nikah', 'Kartu BPJS/Asuransi', 'Lainnya'] as $j)
                                            <option value="{{ $j }}" {{ old('jenis_dokumen', $dokumen->jenis_dokumen) == $j ? 'selected' : '' }}>{{ $j }}</option>
                                        @endforeach
                                    </select>
                                    @error('jenis_dokumen') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Update File (Opsional)</label>
                                    <input type="file" name="file" class="form-control @error('file') is-invalid @enderror">
                                    <small class="text-muted">Biarkan kosong jika tidak ingin mengubah file.</small>
                                    @error('file') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    <div class="mt-2">
                                        <a href="{{ asset('storage/' . $dokumen->file) }}" target="_blank" class="btn btn-sm btn-outline-primary">Lihat File Saat Ini</a>
                                    </div>
                                </div>
                            </div>

                            @if(Auth::user()->role->nama_role == 'nakes' || Auth::user()->role->nama_role == 'administrator')
                            <hr>
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label class="form-label fw-bold">Status Verifikasi</label>
                                    <select name="status_verifikasi" class="form-select @error('status_verifikasi') is-invalid @enderror">
                                        <option value="pending" {{ old('status_verifikasi', $dokumen->status_verifikasi) == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="verified" {{ old('status_verifikasi', $dokumen->status_verifikasi) == 'verified' ? 'selected' : '' }}>Verified</option>
                                        <option value="rejected" {{ old('status_verifikasi', $dokumen->status_verifikasi) == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                    </select>
                                    @error('status_verifikasi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            @endif

                            <div class="row mt-4">
                                <div class="col-12">
                                    <a href="{{ route('dokumen.index') }}" class="btn btn-light border px-4 me-2" style="border-radius:8px;">Batal</a>
                                    <button type="submit" class="btn text-white px-4" style="background-color:#EC1E88; border-radius:8px;">Perbarui Dokumen</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
