@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Tambah Kategori Artikel</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('kategori-artikel.index') }}">Kategori Artikel</a></li>
            <li class="breadcrumb-item active">Tambah</li>
        </ol>
    </nav>
</div>

<section class="section">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px; overflow: hidden; border-top: 5px solid #EC1E88 !important;">
                <div class="card-header bg-white border-bottom py-3 px-4">
                    <h5 class="m-0 fw-bold" style="color:#EC1E88; font-size: 1rem;">
                        <i class="bi bi-tags me-2"></i>Form Tambah Kategori Artikel
                    </h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('kategori-artikel.store') }}" method="POST">
                        @csrf

                        {{-- Nama Kategori --}}
                        <div class="mb-4">
                            <label for="nama" class="form-label fw-bold">
                                Nama Kategori <span class="text-danger">*</span>
                            </label>
                            <input
                                type="text"
                                id="nama"
                                name="nama"
                                class="form-control @error('nama') is-invalid @enderror"
                                value="{{ old('nama') }}"
                                placeholder="Contoh: Kesehatan Ibu, Nutrisi Bayi, Imunisasi..."
                                required
                                autofocus
                            >
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text text-muted mt-1">
                                <i class="bi bi-info-circle me-1"></i>
                                Slug akan digenerate otomatis dari nama kategori.
                            </div>
                        </div>

                        {{-- Preview Slug --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold text-muted">Preview Slug</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light text-muted" style="font-size:0.85rem;">/artikel/kategori/</span>
                                <input
                                    type="text"
                                    id="slug-preview"
                                    class="form-control bg-light text-muted"
                                    placeholder="nama-kategori"
                                    readonly
                                >
                            </div>
                            <div class="form-text text-muted">Dihasilkan otomatis, tidak perlu diisi.</div>
                        </div>

                        {{-- Deskripsi --}}
                        <div class="mb-4">
                            <label for="deskripsi" class="form-label fw-bold">
                                Deskripsi <span class="text-muted fw-normal">(Opsional)</span>
                            </label>
                            <textarea
                                id="deskripsi"
                                name="deskripsi"
                                rows="4"
                                class="form-control @error('deskripsi') is-invalid @enderror"
                                placeholder="Penjelasan singkat tentang kategori ini..."
                            >{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr class="my-4">

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn text-white px-5" style="background:#EC1E88; border-radius:8px;">
                                <i class="bi bi-save me-1"></i> Simpan
                            </button>
                            <a href="{{ route('kategori-artikel.index') }}" class="btn btn-secondary px-4" style="border-radius:8px;">
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    // Auto-generate slug preview dari nama
    const namaInput = document.getElementById('nama');
    const slugPreview = document.getElementById('slug-preview');

    function generateSlug(text) {
        return text
            .toLowerCase()
            .replace(/[^a-z0-9\s-]/g, '')
            .trim()
            .replace(/[\s_-]+/g, '-')
            .replace(/^-+|-+$/g, '');
    }

    namaInput.addEventListener('input', function () {
        slugPreview.value = generateSlug(this.value);
    });
</script>
@endpush
