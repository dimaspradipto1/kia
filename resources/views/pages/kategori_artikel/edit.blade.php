@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Edit Kategori Artikel</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('kategori-artikel.index') }}">Kategori Artikel</a></li>
            <li class="breadcrumb-item active">Edit</li>
        </ol>
    </nav>
</div>

<section class="section">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px; overflow: hidden; border-top: 5px solid #EC1E88 !important;">
                <div class="card-header bg-white border-bottom py-3 px-4">
                    <h5 class="m-0 fw-bold" style="color:#EC1E88; font-size: 1rem;">
                        <i class="bi bi-pencil-square me-2"></i>Form Edit Kategori Artikel
                    </h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('kategori-artikel.update', $kategoriArtikel->id) }}" method="POST">
                        @csrf
                        @method('PUT')

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
                                value="{{ old('nama', $kategoriArtikel->nama) }}"
                                placeholder="Contoh: Kesehatan Ibu, Nutrisi Bayi, Imunisasi..."
                                required
                                autofocus
                            >
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Slug (readonly) --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold text-muted">Preview Slug</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light text-muted" style="font-size:0.85rem;">/artikel/kategori/</span>
                                <input
                                    type="text"
                                    id="slug-preview"
                                    class="form-control bg-light text-muted"
                                    value="{{ $kategoriArtikel->slug }}"
                                    readonly
                                >
                            </div>
                            <div class="form-text text-muted">Diperbarui otomatis saat nama kategori diubah.</div>
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
                            >{{ old('deskripsi', $kategoriArtikel->deskripsi) }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr class="my-4">

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn text-white px-5" style="background:#EC1E88; border-radius:8px;">
                                <i class="bi bi-save me-1"></i> Perbarui
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
    // Auto-update slug preview dari nama
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
