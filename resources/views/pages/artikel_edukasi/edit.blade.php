@extends('layouts.dashboard.template')

@push('styles')
<style>
.gb-wrap { display:grid; grid-template-columns:1fr 320px; gap:24px; align-items:start; }
@media (max-width: 991px) { .gb-wrap { grid-template-columns: 1fr; } }
.gb-toolbar { position:sticky;top:0;z-index:100;background:#fff;border-bottom:1px solid #e2e8f0;padding:12px 24px;display:flex;align-items:center;gap:12px;margin-bottom:24px;border-radius:12px;box-shadow:0 2px 8px rgba(0,0,0,.06); }
.gb-toolbar .article-title-bar { flex:1;font-size:.9rem;color:#64748b;font-style:italic;white-space:nowrap;overflow:hidden;text-overflow:ellipsis; }
.gb-editor-card { background:#fff;border-radius:16px;box-shadow:0 4px 24px rgba(0,0,0,.06);overflow:hidden; }
.gb-editor-inner { padding:32px 40px 40px; }
.gb-title-input { width:100%;border:none;outline:none;font-size:2rem;font-weight:700;color:#1e293b;line-height:1.25;padding:0;margin-bottom:8px;background:transparent;resize:none;font-family:inherit; }
.gb-title-input::placeholder { color:#cbd5e1; }
.gb-slug-row { display:flex;align-items:center;gap:8px;padding:8px 0 20px;border-bottom:1px solid #f1f5f9;margin-bottom:24px; }
.gb-slug-label { font-size:.75rem;color:#94a3b8;flex-shrink:0; }
.gb-slug-val { font-size:.75rem;color:#EC1E88;font-weight:600;font-family:monospace;word-break:break-all; }
/* TinyMCE self-hosted wrapper */
#tinymce-editor { min-height:460px; }
.tox-tinymce { border-radius:0 0 12px 12px !important; border:none !important; }
.tox .tox-toolbar__primary { background:#f8fafc !important; border-bottom:1px solid #f1f5f9 !important; }
.gb-sidebar-panel { background:#fff;border-radius:16px;box-shadow:0 4px 24px rgba(0,0,0,.06);overflow:hidden;position:sticky;top:80px; }
.gb-panel-tab { display:flex;border-bottom:2px solid #f1f5f9; }
.gb-panel-tab button { flex:1;border:none;background:none;padding:14px 0;font-size:.8rem;font-weight:600;color:#94a3b8;cursor:pointer;transition:all .2s;position:relative; }
.gb-panel-tab button.active { color:#EC1E88; }
.gb-panel-tab button.active::after { content:'';position:absolute;bottom:-2px;left:0;right:0;height:2px;background:#EC1E88; }
.gb-panel-body { padding:20px; }
.gb-panel-section { border-bottom:1px solid #f1f5f9;padding:16px 0; }
.gb-panel-section:first-child { padding-top:0; }
.gb-panel-section:last-child { border-bottom:none;padding-bottom:0; }
.gb-section-label { font-size:.7rem;font-weight:700;text-transform:uppercase;letter-spacing:.06em;color:#94a3b8;margin-bottom:10px;display:flex;align-items:center;gap:6px; }
.gb-featured-img { width:100%;aspect-ratio:16/9;background:#f8fafc;border:2px dashed #e2e8f0;border-radius:12px;display:flex;flex-direction:column;align-items:center;justify-content:center;cursor:pointer;overflow:hidden;transition:border-color .2s;position:relative; }
.gb-featured-img:hover { border-color:#EC1E88; }
.gb-featured-img img { width:100%;height:100%;object-fit:cover;position:absolute;inset:0; }
.gb-featured-img .upload-hint { font-size:.78rem;color:#94a3b8;text-align:center;z-index:1; }
.gb-featured-img .remove-img-btn { position:absolute;top:6px;right:6px;background:rgba(220,38,38,.9);color:#fff;border:none;border-radius:50%;width:24px;height:24px;font-size:.7rem;align-items:center;justify-content:center;cursor:pointer;z-index:2; }
.status-indicator { display:inline-flex;align-items:center;gap:6px;font-size:.78rem;font-weight:600;padding:4px 12px;border-radius:20px; }
.status-indicator.draft { background:#fef9c3;color:#854d0e; }
.status-indicator.published { background:#dcfce7;color:#166534; }
.btn-publish { background:#EC1E88;color:#fff;border:none;border-radius:8px;padding:10px 20px;font-size:.85rem;font-weight:600;width:100%;cursor:pointer;transition:opacity .2s;display:flex;align-items:center;justify-content:center;gap:6px; }
.btn-publish:hover { opacity:.88; }
.btn-save-draft { background:transparent;color:#64748b;border:1px solid #e2e8f0;border-radius:8px;padding:8px 20px;font-size:.82rem;font-weight:500;width:100%;cursor:pointer;transition:all .2s;display:flex;align-items:center;justify-content:center;gap:6px;margin-top:8px; }
.btn-save-draft:hover { border-color:#94a3b8;color:#334155; }
</style>
@endpush

@section('content')
<div class="pagetitle">
    <h1>Edit Artikel</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('artikel-edukasi.index') }}">Artikel Edukasi</a></li>
            <li class="breadcrumb-item active">Edit</li>
        </ol>
    </nav>
</div>

<form id="artikel-form" action="{{ route('artikel-edukasi.update', $artikelEdukasi->id) }}" method="POST" enctype="multipart/form-data">
@csrf
@method('PUT')
<input type="hidden" name="status" id="status-input" value="{{ old('status', $artikelEdukasi->status) }}">

{{-- Top Toolbar --}}
<div class="gb-toolbar">
    <a href="{{ route('artikel-edukasi.index') }}" class="btn btn-sm btn-outline-secondary" style="border-radius:8px;">
        <i class="bi bi-arrow-left"></i>
    </a>
    <span class="article-title-bar" id="title-bar-preview">{{ $artikelEdukasi->judul }}</span>
    <span id="toolbar-status-badge" class="status-indicator {{ $artikelEdukasi->status }}">
        <i class="bi bi-circle-fill" style="font-size:.5rem;"></i>
        {{ $artikelEdukasi->status === 'published' ? 'Published' : 'Draft' }}
    </span>
    @if($artikelEdukasi->status === 'published')
        <a href="{{ route('homepage.artikel.show', $artikelEdukasi->slug) }}" target="_blank"
           class="btn btn-sm btn-outline-secondary" style="border-radius:8px;">
            <i class="bi bi-box-arrow-up-right me-1"></i> Lihat
        </a>
    @endif
    <button type="button" onclick="submitAs('draft')" class="btn btn-sm btn-outline-secondary" style="border-radius:8px;min-width:120px;">
        <i class="bi bi-floppy me-1"></i> Simpan Draft
    </button>
    <button type="button" onclick="submitAs('published')" class="btn btn-sm text-white" style="background:#EC1E88;border-radius:8px;min-width:120px;">
        <i class="bi bi-send me-1"></i> {{ $artikelEdukasi->status === 'published' ? 'Perbarui' : 'Terbitkan' }}
    </button>
</div>

<div class="gb-wrap">
    {{-- LEFT: Editor --}}
    <div class="gb-editor-card">
        <div class="gb-editor-inner">
            <textarea id="judul-input" name="judul" class="gb-title-input @error('judul') is-invalid @enderror"
                      rows="2" placeholder="Tulis judul artikel di sini…" required>{{ old('judul', $artikelEdukasi->judul) }}</textarea>
            @error('judul')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror

            <div class="gb-slug-row">
                <span class="gb-slug-label"><i class="bi bi-link-45deg"></i> Permalink:</span>
                <span class="gb-slug-val">/artikel/<em id="slug-val">{{ $artikelEdukasi->slug }}</em></span>
            </div>

            {{-- Rich Text Body — TinyMCE Self-Hosted --}}
            <div>
                <textarea id="tinymce-editor" name="isi"
                          class="@error('isi') is-invalid @enderror"
                          style="visibility:hidden;">{{ old('isi', $artikelEdukasi->isi) }}</textarea>
                @error('isi')
                    <div class="invalid-feedback d-block mt-1">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>

    {{-- RIGHT: Sidebar --}}
    <div class="gb-sidebar-panel">
        <div class="gb-panel-tab">
            <button type="button" class="active" onclick="switchTab(this,'tab-post')">
                <i class="bi bi-gear me-1"></i> Pengaturan
            </button>
            <button type="button" onclick="switchTab(this,'tab-block')">
                <i class="bi bi-image me-1"></i> Media
            </button>
        </div>

        <div id="tab-post" class="gb-panel-body">
            <div class="gb-panel-section">
                <div class="gb-section-label"><i class="bi bi-send"></i> Penerbitan</div>
                <button type="button" class="btn-publish" onclick="submitAs('published')">
                    <i class="bi bi-globe"></i>
                    {{ $artikelEdukasi->status === 'published' ? 'Perbarui Artikel' : 'Terbitkan Sekarang' }}
                </button>
                <button type="button" class="btn-save-draft" onclick="submitAs('draft')">
                    <i class="bi bi-floppy"></i> Simpan sebagai Draft
                </button>
            </div>

            <div class="gb-panel-section">
                <div class="gb-section-label"><i class="bi bi-calendar3"></i> Tanggal Terbit</div>
                <input type="date" name="diterbitkan_pada"
                    class="form-control form-control-sm @error('diterbitkan_pada') is-invalid @enderror"
                    value="{{ old('diterbitkan_pada', optional($artikelEdukasi->diterbitkan_pada)->format('Y-m-d')) }}"
                    style="border-radius:8px;">
                @error('diterbitkan_pada')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="gb-panel-section">
                <div class="gb-section-label"><i class="bi bi-tags"></i> Kategori</div>
                <select name="kategori_artikel_id"
                    class="form-select form-select-sm @error('kategori_artikel_id') is-invalid @enderror"
                    style="border-radius:8px;" required>
                    <option value="">— Pilih Kategori —</option>
                    @foreach($kategoris as $kat)
                        <option value="{{ $kat->id }}"
                            {{ old('kategori_artikel_id', $artikelEdukasi->kategori_artikel_id) == $kat->id ? 'selected' : '' }}>
                            {{ $kat->nama }}
                        </option>
                    @endforeach
                </select>
                @error('kategori_artikel_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="gb-panel-section">
                <div class="gb-section-label"><i class="bi bi-person"></i> Penulis</div>
                <input type="text" name="penulis"
                    class="form-control form-control-sm @error('penulis') is-invalid @enderror"
                    value="{{ old('penulis', $artikelEdukasi->penulis) }}"
                    placeholder="Nama penulis" style="border-radius:8px;" required>
                @error('penulis')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div id="tab-block" class="gb-panel-body" style="display:none;">
            <div class="gb-panel-section">
                <div class="gb-section-label"><i class="bi bi-image"></i> Gambar Unggulan</div>
                <div class="gb-featured-img" id="feat-img-zone">
                    @if($artikelEdukasi->gambar)
                        <img id="feat-img-preview" src="{{ $artikelEdukasi->gambar_url }}" alt="" style="display:block;">
                        <button type="button" class="remove-img-btn" id="feat-img-remove"
                                onclick="removeFeaturedImg()" style="display:flex;">
                            <i class="bi bi-x-lg"></i>
                        </button>
                        <div class="upload-hint" id="feat-img-hint" style="display:none;"></div>
                    @else
                        <img id="feat-img-preview" src="" alt="" style="display:none;">
                        <button type="button" class="remove-img-btn" id="feat-img-remove"
                                onclick="removeFeaturedImg()" style="display:none;">
                            <i class="bi bi-x-lg"></i>
                        </button>
                        <div class="upload-hint" id="feat-img-hint">
                            <i class="bi bi-cloud-arrow-up fs-3 text-muted mb-1 d-block"></i>
                            Klik untuk ganti gambar<br>
                            <small>JPG, PNG, WEBP — maks. 3 MB</small>
                        </div>
                    @endif
                </div>
                <input type="file" id="gambar-input" name="gambar" class="d-none"
                       accept="image/jpg,image/jpeg,image/png,image/webp">
                @error('gambar')
                    <div class="text-danger mt-1" style="font-size:.8rem;">{{ $message }}</div>
                @enderror
                <button type="button" class="btn btn-sm btn-outline-secondary w-100 mt-2"
                        style="border-radius:8px;font-size:.78rem;"
                        onclick="document.getElementById('gambar-input').click()">
                    <i class="bi bi-folder2-open me-1"></i> Ganti Gambar
                </button>
            </div>
        </div>
    </div>
</div>
</form>
@endsection

@push('scripts')
{{-- TinyMCE Self-Hosted (dari node_modules, tanpa API key, tanpa warning) --}}
<script src="{{ asset('tinymce/tinymce.min.js') }}"></script>
<script>
tinymce.init({
    selector: '#tinymce-editor',
    height: 520,
    menubar: false,
    base_url: '{{ asset('tinymce') }}',
    suffix: '.min',
    plugins: [
        'advlist', 'autolink', 'lists', 'link', 'image', 'charmap',
        'preview', 'anchor', 'searchreplace', 'visualblocks', 'code',
        'fullscreen', 'insertdatetime', 'media', 'table', 'wordcount'
    ],
    toolbar:
        'undo redo | blocks | bold italic underline strikethrough | ' +
        'forecolor backcolor | alignleft aligncenter alignright alignjustify | ' +
        'bullist numlist outdent indent | blockquote link image | ' +
        'removeformat | code fullscreen',
    content_style: `
        body {
            font-family: system-ui, -apple-system, sans-serif;
            font-size: 16px;
            color: #334155;
            line-height: 1.8;
            padding: 8px 16px;
            margin: 0;
        }
        h2, h3, h4, h5, h6 { color: #1e293b; font-weight: 700; margin-top: 1.5em; }
        blockquote {
            border-left: 4px solid #EC1E88;
            margin: 16px 0;
            padding: 8px 16px;
            background: #fdf2f8;
            color: #64748b;
            font-style: italic;
        }
        a { color: #EC1E88; }
        img { max-width: 100%; border-radius: 8px; }
        pre { background: #1e293b; color: #e2e8f0; padding: 12px 16px; border-radius: 8px; }
    `,
    promotion: false,
    branding: false,
    image_title: true,
    automatic_uploads: true,
    images_upload_handler: function (blobInfo, progress) {
        return new Promise(function (resolve, reject) {
            var xhr = new XMLHttpRequest();
            xhr.withCredentials = false;
            xhr.open('POST', '{{ route("artikel-edukasi.upload-image") }}');
            xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');

            xhr.upload.onprogress = function (e) {
                progress(e.loaded / e.total * 100);
            };

            xhr.onload = function () {
                if (xhr.status === 403) {
                    reject({ message: 'HTTP Error: ' + xhr.status, remove: true });
                    return;
                }

                if (xhr.status < 200 || xhr.status >= 300) {
                    reject('HTTP Error: ' + xhr.status);
                    return;
                }

                var json = JSON.parse(xhr.responseText);

                if (!json || typeof json.location != 'string') {
                    reject('Invalid JSON: ' + xhr.responseText);
                    return;
                }

                resolve(json.location);
            };

            xhr.onerror = function () {
                reject('Image upload failed due to a XHR Transport error. Code: ' + xhr.status);
            };

            var formData = new FormData();
            formData.append('file', blobInfo.blob(), blobInfo.filename());

            xhr.send(formData);
        });
    }
});

// Isi konten dari DB
const judulInput   = document.getElementById('judul-input');
const slugVal      = document.getElementById('slug-val');
const titleBarPrev = document.getElementById('title-bar-preview');
const origSlug     = '{{ $artikelEdukasi->slug }}';

function generateSlug(text) {
    return text.toLowerCase().replace(/[^a-z0-9\s-]/g,'').trim().replace(/[\s_-]+/g,'-').replace(/^-+|-+$/g,'');
}
judulInput.addEventListener('input', function () {
    const val = this.value.trim();
    slugVal.textContent = val ? generateSlug(val) : origSlug;
    titleBarPrev.textContent = val || 'Edit Artikel…';
    this.style.height = 'auto';
    this.style.height = this.scrollHeight + 'px';
});

function switchTab(btn, tabId) {
    document.querySelectorAll('.gb-panel-tab button').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    document.getElementById('tab-post').style.display = tabId === 'tab-post' ? '' : 'none';
    document.getElementById('tab-block').style.display = tabId === 'tab-block' ? '' : 'none';
}

function submitAs(status) {
    // TinyMCE auto-sync ke textarea saat submit
    if (typeof tinymce !== 'undefined') {
        tinymce.triggerSave();
    }
    document.getElementById('status-input').value = status;
    const badge = document.getElementById('toolbar-status-badge');
    if (status === 'published') {
        badge.className = 'status-indicator published';
        badge.innerHTML = '<i class="bi bi-circle-fill" style="font-size:.5rem;"></i> Published';
    } else {
        badge.className = 'status-indicator draft';
        badge.innerHTML = '<i class="bi bi-circle-fill" style="font-size:.5rem;"></i> Draft';
    }
    document.getElementById('artikel-form').submit();
}

const featZone    = document.getElementById('feat-img-zone');
const featPreview = document.getElementById('feat-img-preview');
const featHint    = document.getElementById('feat-img-hint');
const featRemove  = document.getElementById('feat-img-remove');
const gambarInput = document.getElementById('gambar-input');

featZone.addEventListener('click', function(e) {
    if (featRemove.contains(e.target)) return;
    gambarInput.click();
});
gambarInput.addEventListener('change', function() {
    const file = this.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = function(e) {
        featPreview.src = e.target.result;
        featPreview.style.display = 'block';
        featHint.style.display = 'none';
        featRemove.style.display = 'flex';
    };
    reader.readAsDataURL(file);
});
function removeFeaturedImg() {
    gambarInput.value = '';
    featPreview.src = '';
    featPreview.style.display = 'none';
    featHint.style.display = '';
    featRemove.style.display = 'none';
}
</script>
@endpush
