@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Edit Intro Layanan</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('layanan-intro.index') }}">Intro Layanan</a></li>
            <li class="breadcrumb-item active">Edit</li>
        </ol>
    </nav>
</div>

<section class="section">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <form action="{{ route('layanan-intro.update', $layananIntro->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- ===== KONTEN UTAMA ===== --}}
                <div class="card border-0 shadow-sm mb-4" style="border-radius:12px;border-top:5px solid #EC1E88 !important;">
                    <div class="card-header bg-white border-bottom py-3 px-4">
                        <h5 class="m-0 fw-bold" style="color:#EC1E88;font-size:1rem;">
                            <i class="bi bi-layout-text-window-reverse me-2"></i>Konten Utama
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Teks Badge <span class="text-danger">*</span></label>
                            <div class="form-text text-muted mb-2">Teks kecil di atas judul, contoh: <em>Tentang Layanan</em></div>
                            <input type="text" name="badge_text"
                                   class="form-control @error('badge_text') is-invalid @enderror"
                                   value="{{ old('badge_text', $layananIntro->badge_text) }}"
                                   placeholder="Tentang Layanan" required>
                            @error('badge_text')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Judul Utama <span class="text-danger">*</span></label>
                            <div class="form-text text-muted mb-2">Teks yang diapit <code>**teks**</code> akan berwarna brand (pink) di halaman publik.</div>
                            <input type="text" name="judul"
                                   class="form-control @error('judul') is-invalid @enderror"
                                   value="{{ old('judul', $layananIntro->judul) }}"
                                   placeholder="KIA Care adalah **platform kesehatan** ibu dan anak" required>
                            @error('judul')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Deskripsi</label>
                            <textarea name="deskripsi" rows="3"
                                      class="form-control @error('deskripsi') is-invalid @enderror">{{ old('deskripsi', $layananIntro->deskripsi) }}</textarea>
                            @error('deskripsi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>

                {{-- ===== FITUR UNGGULAN ===== --}}
                <div class="card border-0 shadow-sm mb-4" style="border-radius:12px;border-top:5px solid #22C55E !important;">
                    <div class="card-header bg-white border-bottom py-3 px-4 d-flex justify-content-between align-items-center">
                        <h5 class="m-0 fw-bold" style="color:#22C55E;font-size:1rem;">
                            <i class="fa fa-check-circle me-2"></i>Fitur Unggulan
                            <small class="fw-normal text-muted ms-2">(Poin ✓ di bawah deskripsi)</small>
                        </h5>
                        <button type="button" id="btn-add-fitur" class="btn btn-sm px-3" style="background:#22C55E;color:#fff;border-radius:8px;">
                            <i class="bi bi-plus-circle me-1"></i> Tambah Fitur
                        </button>
                    </div>
                    <div class="card-body p-4">
                        <div id="fitur-container"></div>
                        <div id="fitur-empty" class="text-center text-muted py-4" style="border:2px dashed #e2e8f0;border-radius:12px;display:none;">
                            <i class="fa fa-check-circle" style="font-size:2rem;opacity:.3;"></i>
                            <p class="mt-2 mb-0">Belum ada fitur. Klik <strong>Tambah Fitur</strong>.</p>
                        </div>
                    </div>
                </div>

                {{-- ===== STATUS ===== --}}
                <div class="card border-0 shadow-sm mb-4" style="border-radius:12px;">
                    <div class="card-body p-4">
                        <div class="row align-items-center">
                            <div class="col-sm-3">
                                <label class="form-label fw-bold">Status <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-sm-4">
                                <select name="is_active" class="form-select @error('is_active') is-invalid @enderror" required>
                                    <option value="1" {{ old('is_active', $layananIntro->is_active ? '1' : '0') == '1' ? 'selected' : '' }}>Aktif</option>
                                    <option value="0" {{ old('is_active', $layananIntro->is_active ? '1' : '0') == '0' ? 'selected' : '' }}>Non-Aktif</option>
                                </select>
                                @error('is_active')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ===== GAMBAR YANG SUDAH ADA ===== --}}
                @if($layananIntro->images->count() > 0)
                <div class="card border-0 shadow-sm mb-4" style="border-radius:12px;overflow:hidden;border-top:5px solid #16B3AC !important;">
                    <div class="card-header bg-white border-bottom py-3 px-4 d-flex justify-content-between align-items-center">
                        <h5 class="m-0 fw-bold text-dark" style="font-size:1.1rem;">
                            <i class="bi bi-images me-2" style="color:#16B3AC;"></i>Gambar Tersimpan
                            <span class="badge ms-2" style="background:#16B3AC;font-size:.75rem;">{{ $layananIntro->images->count() }} foto</span>
                        </h5>
                        <small class="text-muted">Centang untuk hapus · Klik ★ untuk jadikan default</small>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3">
                            @foreach($layananIntro->images as $img)
                            <div class="col-6 col-md-4 col-lg-3" id="img-card-{{ $img->id }}">
                                <div class="position-relative rounded-3 overflow-hidden border {{ $img->is_default ? 'border-warning border-2' : 'border-secondary' }}"
                                     style="aspect-ratio:1;background:#f8f9fa;">
                                    <img src="{{ $img->url }}" alt="{{ $img->keterangan ?? 'Gambar' }}"
                                         style="width:100%;height:100%;object-fit:cover;">

                                    {{-- Default badge --}}
                                    @if($img->is_default)
                                        <span class="position-absolute top-0 start-0 badge bg-warning text-dark m-1" style="font-size:.65rem;">
                                            <i class="bi bi-star-fill"></i> Default
                                        </span>
                                    @endif

                                    {{-- Action bar --}}
                                    <div class="position-absolute bottom-0 start-0 end-0 d-flex justify-content-between align-items-center p-1"
                                         style="background:rgba(0,0,0,.5);">
                                        {{-- Set default radio --}}
                                        <label class="d-flex align-items-center gap-1 text-white m-0" style="font-size:.7rem;cursor:pointer;" title="Jadikan Default">
                                            <input type="radio" name="default_image_id" value="{{ $img->id }}"
                                                   {{ $img->is_default ? 'checked' : '' }} style="accent-color:#ffc107;">
                                            <i class="bi bi-star{{ $img->is_default ? '-fill' : '' }} text-warning"></i>
                                        </label>

                                        {{-- Delete checkbox --}}
                                        <label class="d-flex align-items-center gap-1 text-white m-0" style="font-size:.7rem;cursor:pointer;" title="Tandai untuk Hapus">
                                            <input type="checkbox" name="delete_images[]" value="{{ $img->id }}"
                                                   class="form-check-input delete-check m-0" style="accent-color:#dc3545;">
                                            <i class="bi bi-trash text-danger"></i>
                                        </label>
                                    </div>
                                </div>
                                <p class="text-muted mt-1 mb-0" style="font-size:.7rem;text-overflow:ellipsis;overflow:hidden;white-space:nowrap;">
                                    {{ $img->keterangan ?: 'Tanpa keterangan' }}
                                </p>
                            </div>
                            @endforeach
                        </div>
                        <div class="alert alert-warning d-flex align-items-center mt-3 py-2" role="alert">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            <small>Gambar yang dicentang (<i class="bi bi-trash text-danger"></i>) akan <strong>dihapus permanen</strong> saat disimpan.</small>
                        </div>
                    </div>
                </div>
                @endif

                {{-- ===== TAMBAH GAMBAR BARU ===== --}}
                <div class="card border-0 shadow-sm mb-4" style="border-radius:12px;overflow:hidden;border-top:5px solid #6c757d !important;">
                    <div class="card-header bg-white border-bottom py-3 px-4">
                        <h5 class="m-0 fw-bold text-dark" style="font-size:1.1rem;">
                            <i class="bi bi-plus-circle me-2"></i>Tambah Gambar Baru
                            <span class="badge bg-secondary ms-2" style="font-size:.75rem;">Opsional</span>
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        @error('images.*')
                            <div class="alert alert-danger py-2">{{ $message }}</div>
                        @enderror

                        <div id="new-drop-zone"
                            class="rounded-3 d-flex flex-column align-items-center justify-content-center p-4 mb-3"
                            style="border:2px dashed #dee2e6;cursor:pointer;min-height:130px;background:#fafafa;transition:border-color .2s;">
                            <i class="bi bi-cloud-arrow-up fs-2 text-muted mb-1"></i>
                            <p class="text-muted mb-1 small">Seret gambar atau</p>
                            <label for="new-images" class="btn btn-sm px-4" style="background:#6c757d;color:#fff;border-radius:20px;cursor:pointer;">
                                Pilih File
                            </label>
                            <input type="file" id="new-images" name="images[]" class="d-none" multiple accept="image/jpg,image/jpeg,image/png,image/webp">
                        </div>

                        <div id="new-preview-grid" class="row g-3"></div>
                        <input type="hidden" name="new_default_index" id="new_default_index" value="-1">
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn text-white px-5" style="background:#EC1E88;border-radius:8px;">
                        <i class="bi bi-save me-1"></i> Perbarui
                    </button>
                    <a href="{{ route('layanan-intro.index') }}" class="btn btn-secondary px-4" style="border-radius:8px;">Batal</a>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
let fiturIdx = 0;

function addFitur(data = {}) {
    const idx = fiturIdx++;
    const judul     = data.judul     || '';
    const deskripsi = data.deskripsi || '';

    const html = `
    <div class="fitur-row mb-3 p-3" style="border:1px solid #e2e8f0;border-radius:12px;background:#fff;">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <span class="fw-bold text-muted small">Fitur #${idx + 1}</span>
            <button type="button" class="btn btn-sm btn-outline-danger py-0 px-2 btn-rm-fitur"><i class="bi bi-trash"></i></button>
        </div>
        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label small fw-bold">Judul <span class="text-danger">*</span></label>
                <input type="text" name="fitur[${idx}][judul]" class="form-control form-control-sm"
                       value="${judul}" placeholder="Jejaring Kesehatan Luas" required>
            </div>
            <div class="col-md-8">
                <label class="form-label small fw-bold">Deskripsi <span class="text-danger">*</span></label>
                <input type="text" name="fitur[${idx}][deskripsi]" class="form-control form-control-sm"
                       value="${deskripsi}" placeholder="Bekerjasama dengan puskesmas dan rumah sakit terpercaya" required>
            </div>
        </div>
    </div>`;

    document.getElementById('fitur-container').insertAdjacentHTML('beforeend', html);
    document.getElementById('fitur-empty').style.display = 'none';
    bindFiturEvents();
}

function bindFiturEvents() {
    document.querySelectorAll('.btn-rm-fitur').forEach(btn => {
        btn.onclick = function () {
            this.closest('.fitur-row').remove();
            if (!document.querySelectorAll('.fitur-row').length)
                document.getElementById('fitur-empty').style.display = '';
        };
    });
}

document.getElementById('btn-add-fitur').addEventListener('click', () => addFitur());

// Load existing data
@if(old('fitur'))
    @foreach(old('fitur') as $f)
        addFitur({ judul: '{{ addslashes($f["judul"] ?? "") }}', deskripsi: '{{ addslashes($f["deskripsi"] ?? "") }}' });
    @endforeach
@else
    @foreach($layananIntro->fitur ?? [] as $f)
        addFitur({ judul: '{{ addslashes($f["judul"] ?? "") }}', deskripsi: '{{ addslashes($f["deskripsi"] ?? "") }}' });
    @endforeach
@endif

// Show empty hint if no rows
if (!document.querySelectorAll('.fitur-row').length)
    document.getElementById('fitur-empty').style.display = '';

(function () {
    const input    = document.getElementById('new-images');
    const dropZone = document.getElementById('new-drop-zone');
    const grid     = document.getElementById('new-preview-grid');
    const defInput = document.getElementById('new_default_index');
    let files      = [];

    if(!input) return;

    dropZone.addEventListener('dragover', e => { e.preventDefault(); dropZone.style.borderColor = '#EC1E88'; });
    dropZone.addEventListener('dragleave', () => { dropZone.style.borderColor = '#dee2e6'; });
    dropZone.addEventListener('drop', e => { e.preventDefault(); dropZone.style.borderColor = '#dee2e6'; addFiles(e.dataTransfer.files); });
    dropZone.addEventListener('click', e => { if (e.target !== input && !e.target.closest('label')) input.click(); });
    input.addEventListener('change', () => { addFiles(input.files); input.value = ''; });

    function addFiles(newFiles) {
        Array.from(newFiles).forEach(f => { if (f.type.startsWith('image/')) files.push(f); });
        rebuildInput(); renderPreviews();
    }
    function rebuildInput() {
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
            col.className = 'col-6 col-md-4 col-lg-3';
            col.innerHTML = `
                <div class="position-relative rounded-3 overflow-hidden border ${isDefault ? 'border-warning border-2' : 'border-secondary'}"
                     style="aspect-ratio:1;background:#f8f9fa;">
                    <img src="${url}" style="width:100%;height:100%;object-fit:cover;">
                    ${isDefault ? '<span class="position-absolute top-0 start-0 badge bg-warning text-dark m-1" style="font-size:.65rem;"><i class="bi bi-star-fill"></i> Default</span>' : ''}
                    <div class="position-absolute bottom-0 start-0 end-0 d-flex justify-content-between p-1"
                         style="background:rgba(0,0,0,.45);">
                        <button type="button" class="btn btn-xs px-1 py-0 btn-set-default" data-index="${i}"
                                style="font-size:.7rem;background:rgba(255,193,7,.8);color:#000;border-radius:4px;" title="Jadikan Default Baru">
                            <i class="bi bi-star${isDefault ? '-fill' : ''}"></i>
                        </button>
                        <input type="text" name="new_keterangan[${i}]" placeholder="Keterangan..."
                               class="form-control form-control-sm border-0"
                               style="font-size:.65rem;height:20px;width:65%;background:rgba(255,255,255,.85);">
                        <button type="button" class="btn btn-xs px-1 py-0 btn-remove" data-index="${i}"
                                style="font-size:.7rem;background:rgba(220,53,69,.8);color:#fff;border-radius:4px;" title="Hapus">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </div>
                </div>`;
            grid.appendChild(col);
        });
        grid.querySelectorAll('.btn-set-default').forEach(btn => {
            btn.addEventListener('click', () => { defInput.value = btn.dataset.index; renderPreviews(); });
        });
        grid.querySelectorAll('.btn-remove').forEach(btn => {
            btn.addEventListener('click', () => {
                files.splice(parseInt(btn.dataset.index), 1);
                if (files.length === 0) defInput.value = -1;
                rebuildInput(); renderPreviews();
            });
        });
    }
})();
</script>
@endpush
