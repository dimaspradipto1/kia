@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Edit Layanan</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('layanans.index') }}">Layanan</a></li>
            <li class="breadcrumb-item active">Edit</li>
        </ol>
    </nav>
</div>

<section class="section">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <form action="{{ route('layanans.update', $layanan->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- ===== INFO UTAMA ===== --}}
                <div class="card border-0 shadow-sm mb-4" style="border-radius:12px;border-top:5px solid #EC1E88 !important;">
                    <div class="card-header bg-white border-bottom py-3 px-4">
                        <h5 class="m-0 fw-bold" style="color:#EC1E88;font-size:1rem;">
                            <i class="bi bi-grid-1x2 me-2"></i>Informasi Layanan
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Judul Layanan <span class="text-danger">*</span></label>
                            <input type="text" name="judul"
                                   class="form-control @error('judul') is-invalid @enderror"
                                   value="{{ old('judul', $layanan->judul) }}"
                                   placeholder="Pemeriksaan Kehamilan" required>
                            @error('judul')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Deskripsi Singkat</label>
                            <div class="form-text text-muted mb-2">Ditampilkan di kartu layanan (maks. 300 karakter).</div>
                            <textarea name="deskripsi" rows="2"
                                      class="form-control @error('deskripsi') is-invalid @enderror"
                                      maxlength="300">{{ old('deskripsi', $layanan->deskripsi) }}</textarea>
                            @error('deskripsi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Deskripsi Lengkap</label>
                            <div class="form-text text-muted mb-2">Deskripsi panjang untuk halaman layanan (opsional).</div>
                            <textarea name="deskripsi_panjang" rows="4"
                                      class="form-control @error('deskripsi_panjang') is-invalid @enderror">{{ old('deskripsi_panjang', $layanan->deskripsi_panjang) }}</textarea>
                            @error('deskripsi_panjang')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>

                {{-- ===== TAMPILAN ===== --}}
                <div class="card border-0 shadow-sm mb-4" style="border-radius:12px;border-top:5px solid #8B5CF6 !important;">
                    <div class="card-header bg-white border-bottom py-3 px-4">
                        <h5 class="m-0 fw-bold" style="color:#8B5CF6;font-size:1rem;">
                            <i class="bi bi-palette me-2"></i>Ikon & Tampilan
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3">
                            <div class="col-md-5">
                                <label class="form-label fw-bold">Ikon Font Awesome <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text" id="icon-preview-box" style="background:#F5F3FF;width:44px;justify-content:center;">
                                        <i class="fa {{ $layanan->ikon }}" id="icon-preview" style="color:#8B5CF6;font-size:1.2rem;"></i>
                                    </span>
                                    <input type="text" name="ikon" id="ikon-input"
                                           class="form-control @error('ikon') is-invalid @enderror"
                                           value="{{ old('ikon', $layanan->ikon) }}"
                                           placeholder="fa-female" required>
                                    @error('ikon')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="d-flex flex-wrap gap-1 mt-2">
                                    @foreach(['fa-female','fa-child','fa-stethoscope','fa-line-chart','fa-cutlery','fa-heart','fa-hospital-o','fa-heartbeat','fa-users','fa-shield','fa-star','fa-leaf'] as $icon)
                                        <span class="badge bg-secondary py-1 px-2 icon-pick" data-icon="{{ $icon }}"
                                              style="cursor:pointer;font-size:.75rem;">
                                            <i class="fa {{ $icon }} me-1"></i>{{ $icon }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-bold">Tema Warna <span class="text-danger">*</span></label>
                                <select name="tema" id="tema-select"
                                        class="form-select @error('tema') is-invalid @enderror" required>
                                    @foreach(['pink','green','blue','yellow','purple','orange'] as $t)
                                        <option value="{{ $t }}" {{ old('tema', $layanan->tema) == $t ? 'selected' : '' }}>
                                            {{ ucfirst($t) }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('tema')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-3">
                                <label class="form-label fw-bold">Urutan Tampil <span class="text-danger">*</span></label>
                                <input type="number" name="urutan" min="0"
                                       class="form-control @error('urutan') is-invalid @enderror"
                                       value="{{ old('urutan', $layanan->urutan) }}" required>
                                @error('urutan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="mt-4 p-3" style="background:#F8FAFC;border-radius:12px;">
                            <p class="fw-bold mb-2 small text-muted">Preview Kartu:</p>
                            <div id="card-preview" class="service-mini-card d-inline-block text-center" style="min-width:180px;padding:20px;border-radius:16px;cursor:default;">
                                <div style="width:52px;height:52px;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 12px;border:2px solid;">
                                    <i class="fa {{ old('ikon',$layanan->ikon) }}" id="preview-icon" style="font-size:1.4rem;"></i>
                                </div>
                                <p class="mb-0 fw-bold" id="preview-judul" style="font-size:.9rem;">{{ $layanan->judul }}</p>
                            </div>
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
                                    <option value="1" {{ old('is_active', $layanan->is_active ? '1' : '0') == '1' ? 'selected' : '' }}>Aktif</option>
                                    <option value="0" {{ old('is_active', $layanan->is_active ? '1' : '0') == '0' ? 'selected' : '' }}>Non-Aktif</option>
                                </select>
                                @error('is_active')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn text-white px-5" style="background:#EC1E88;border-radius:8px;">
                        <i class="bi bi-save me-1"></i> Perbarui
                    </button>
                    <a href="{{ route('layanans.index') }}" class="btn btn-secondary px-4" style="border-radius:8px;">Batal</a>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
const temaColors = @json($temaColors);

const ikonInput   = document.getElementById('ikon-input');
const temaSelect  = document.getElementById('tema-select');
const previewIcon = document.getElementById('preview-icon');
const ikonPrev    = document.getElementById('icon-preview');
const prevBox     = document.getElementById('icon-preview-box');
const cardPreview = document.getElementById('card-preview');
const prevJudul   = document.getElementById('preview-judul');
const judulInput  = document.querySelector('input[name="judul"]');

function updatePreview() {
    const ikon  = ikonInput.value.trim() || 'fa-star';
    const tema  = temaSelect.value;
    const colors = temaColors[tema] || temaColors['pink'];

    ikonPrev.className      = `fa ${ikon}`;
    ikonPrev.style.color    = colors.ikon;
    prevBox.style.background = colors.bg;

    previewIcon.className       = `fa ${ikon}`;
    previewIcon.style.color     = colors.ikon;
    cardPreview.style.background  = colors.bg;
    cardPreview.style.borderColor = colors.border;
    const iconBox = cardPreview.querySelector('div');
    iconBox.style.background  = colors.bg;
    iconBox.style.borderColor = colors.border;
}

ikonInput.addEventListener('input', updatePreview);
temaSelect.addEventListener('change', updatePreview);
judulInput.addEventListener('input', () => { prevJudul.textContent = judulInput.value || 'Judul Layanan'; });

document.querySelectorAll('.icon-pick').forEach(el => {
    el.addEventListener('click', () => {
        ikonInput.value = el.dataset.icon;
        updatePreview();
    });
});

updatePreview();
</script>
@endpush
