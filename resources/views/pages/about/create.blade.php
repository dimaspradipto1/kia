@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Tambah Konten About</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('abouts.index') }}">About</a></li>
            <li class="breadcrumb-item active">Tambah</li>
        </ol>
    </nav>
</div>

<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <form action="{{ route('abouts.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- ===== INFORMASI UTAMA ===== --}}
                <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px; overflow: hidden; border-top: 5px solid #EC1E88 !important;">
                    <div class="card-header bg-white border-bottom py-3 px-4">
                        <h5 class="m-0 fw-bold text-dark" style="font-size: 1.1rem;">
                            <i class="bi bi-info-circle me-2" style="color:#EC1E88;"></i>Informasi Konten
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label fw-bold">Judul <span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <input type="text" name="judul" class="form-control @error('judul') is-invalid @enderror"
                                    value="{{ old('judul') }}" placeholder="Contoh: KIA Care adalah platform kesehatan..." required>
                                @error('judul') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label fw-bold">Sub Judul / Label</label>
                            <div class="col-sm-9">
                                <input type="text" name="sub_judul" class="form-control @error('sub_judul') is-invalid @enderror"
                                    value="{{ old('sub_judul') }}" placeholder="Contoh: Siapa Kami">
                                @error('sub_judul') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label fw-bold">Deskripsi Singkat</label>
                            <div class="col-sm-9">
                                <textarea name="deskripsi_pendek" rows="3"
                                    class="form-control @error('deskripsi_pendek') is-invalid @enderror"
                                    placeholder="Paragraf pendek yang ditampilkan sebagai lead text...">{{ old('deskripsi_pendek') }}</textarea>
                                @error('deskripsi_pendek') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label fw-bold">Deskripsi Lengkap</label>
                            <div class="col-sm-9">
                                <textarea name="deskripsi_panjang" rows="5"
                                    class="form-control @error('deskripsi_panjang') is-invalid @enderror"
                                    placeholder="Deskripsi lengkap...">{{ old('deskripsi_panjang') }}</textarea>
                                @error('deskripsi_panjang') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label fw-bold">Fitur / Keunggulan</label>
                            <div class="col-sm-9">
                                <textarea name="fitur" rows="5"
                                    class="form-control @error('fitur') is-invalid @enderror"
                                    placeholder="Satu fitur per baris, contoh:&#10;Panduan Kehamilan Terstruktur&#10;Informasi Imunisasi&#10;Sistem Pemantauan Buku KIA Digital">{{ old('fitur') }}</textarea>
                                <div class="form-text text-muted"><i class="bi bi-info-circle me-1"></i>Tulis satu fitur per baris.</div>
                                @error('fitur') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label fw-bold">Tahun Mengabdi</label>
                            <div class="col-sm-3">
                                <input type="number" name="tahun_mengabdi" class="form-control @error('tahun_mengabdi') is-invalid @enderror"
                                    value="{{ old('tahun_mengabdi') }}" placeholder="Contoh: 10" min="1" max="9999">
                                @error('tahun_mengabdi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <div class="row mb-0">
                            <label class="col-sm-3 col-form-label fw-bold">Status <span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <select name="is_active" class="form-select @error('is_active') is-invalid @enderror" required>
                                    <option value="1" {{ old('is_active', '1') == '1' ? 'selected' : '' }}>Aktif</option>
                                    <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>Non-Aktif</option>
                                </select>
                                @error('is_active') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ===== UPLOAD GAMBAR ===== --}}
                <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px; overflow: hidden; border-top: 5px solid #16B3AC !important;">
                    <div class="card-header bg-white border-bottom py-3 px-4">
                        <h5 class="m-0 fw-bold text-dark" style="font-size: 1.1rem;">
                            <i class="bi bi-images me-2" style="color:#16B3AC;"></i>Galeri Gambar
                            <span class="badge bg-secondary ms-2" style="font-size:0.75rem;">Opsional</span>
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        @error('images.*')
                            <div class="alert alert-danger py-2">{{ $message }}</div>
                        @enderror

                        {{-- Drop Zone --}}
                        <div id="drop-zone"
                            class="border-2 border-dashed rounded-3 d-flex flex-column align-items-center justify-content-center p-5 mb-3"
                            style="border: 2px dashed #dee2e6; cursor:pointer; min-height:160px; background:#fafafa; transition: border-color .2s;">
                            <i class="bi bi-cloud-arrow-up fs-1 text-muted mb-2"></i>
                            <p class="text-muted mb-1">Seret & lepas gambar di sini, atau</p>
                            <label for="images" class="btn btn-sm px-4" style="background:#16B3AC;color:#fff;border-radius:20px;cursor:pointer;">
                                Pilih File
                            </label>
                            <input type="file" id="images" name="images[]" class="d-none" multiple accept="image/jpg,image/jpeg,image/png,image/webp">
                            <p class="text-muted mt-2" style="font-size:0.8rem;">JPG, PNG, WEBP — maks. 3 MB per file</p>
                        </div>

                        {{-- Preview grid --}}
                        <div id="preview-grid" class="row g-3"></div>
                        <input type="hidden" name="default_index" id="default_index" value="0">
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn text-white px-5" style="background-color:#EC1E88;border-radius:8px;">
                        <i class="bi bi-save me-1"></i> Simpan
                    </button>
                    <a href="{{ route('abouts.index') }}" class="btn btn-secondary px-4" style="border-radius:8px;">Batal</a>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
(function () {
    const input      = document.getElementById('images');
    const dropZone   = document.getElementById('drop-zone');
    const grid       = document.getElementById('preview-grid');
    const defInput   = document.getElementById('default_index');
    let files        = [];          // DataTransfer-like list

    // ---- Drag & Drop ----
    dropZone.addEventListener('dragover', e => { e.preventDefault(); dropZone.style.borderColor = '#EC1E88'; });
    dropZone.addEventListener('dragleave', () => { dropZone.style.borderColor = '#dee2e6'; });
    dropZone.addEventListener('drop', e => {
        e.preventDefault();
        dropZone.style.borderColor = '#dee2e6';
        addFiles(e.dataTransfer.files);
    });
    dropZone.addEventListener('click', e => { if (e.target !== input && !e.target.closest('label')) input.click(); });
    input.addEventListener('change', () => { addFiles(input.files); input.value = ''; });

    function addFiles(newFiles) {
        Array.from(newFiles).forEach(f => {
            if (!f.type.startsWith('image/')) return;
            files.push(f);
        });
        rebuildInput();
        renderPreviews();
    }

    function rebuildInput() {
        // Replace the file input with the current files list using DataTransfer
        const dt = new DataTransfer();
        files.forEach(f => dt.items.add(f));
        input.files = dt.files;
    }

    function renderPreviews() {
        grid.innerHTML = '';
        files.forEach((f, i) => {
            const url = URL.createObjectURL(f);
            const isDefault = parseInt(defInput.value) === i;
            const col = document.createElement('div');
            col.className = 'col-6 col-md-3 col-lg-2';
            col.innerHTML = `
                <div class="position-relative rounded-3 overflow-hidden border ${isDefault ? 'border-warning border-2' : 'border-secondary'}"
                     style="aspect-ratio:1; background:#f8f9fa;">
                    <img src="${url}" style="width:100%;height:100%;object-fit:cover;">
                    <!-- Default badge -->
                    ${isDefault ? '<span class="position-absolute top-0 start-0 badge bg-warning text-dark m-1" style="font-size:.65rem;"><i class="bi bi-star-fill"></i> Default</span>' : ''}
                    <!-- Actions -->
                    <div class="position-absolute bottom-0 start-0 end-0 d-flex justify-content-between p-1"
                         style="background:rgba(0,0,0,.45);">
                        <button type="button" class="btn btn-xs text-white px-1 py-0 btn-set-default"
                                data-index="${i}" style="font-size:.7rem;background:rgba(255,193,7,.8);border-radius:4px;"
                                title="Jadikan Default">
                            <i class="bi bi-star${isDefault ? '-fill' : ''}"></i>
                        </button>
                        <input type="text" name="keterangan[${i}]" placeholder="Keterangan..."
                               class="form-control form-control-sm border-0"
                               style="font-size:.65rem;height:20px;width:65%;background:rgba(255,255,255,.85);">
                        <button type="button" class="btn btn-xs text-white px-1 py-0 btn-remove"
                                data-index="${i}" style="font-size:.7rem;background:rgba(220,53,69,.8);border-radius:4px;"
                                title="Hapus">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </div>
                </div>`;
            grid.appendChild(col);
        });

        // Bind events
        grid.querySelectorAll('.btn-set-default').forEach(btn => {
            btn.addEventListener('click', () => {
                defInput.value = btn.dataset.index;
                renderPreviews();
            });
        });
        grid.querySelectorAll('.btn-remove').forEach(btn => {
            btn.addEventListener('click', () => {
                const idx = parseInt(btn.dataset.index);
                files.splice(idx, 1);
                if (parseInt(defInput.value) >= files.length) defInput.value = 0;
                rebuildInput();
                renderPreviews();
            });
        });
    }
})();
</script>
@endpush
