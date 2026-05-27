@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Edit Visi & Misi</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('visi-misi.index') }}">Visi & Misi</a></li>
            <li class="breadcrumb-item active">Edit</li>
        </ol>
    </nav>
</div>

<section class="section">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <form action="{{ route('visi-misi.update', $visiMisi->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- ===== VISI ===== --}}
                <div class="card border-0 shadow-sm mb-4" style="border-radius:12px;border-top:5px solid #EC1E88 !important;">
                    <div class="card-header bg-white border-bottom py-3 px-4">
                        <h5 class="m-0 fw-bold" style="color:#EC1E88;font-size:1rem;">
                            <i class="fa fa-eye me-2"></i>Visi
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Pernyataan Visi <span class="text-danger">*</span></label>
                            <textarea name="visi" rows="3"
                                      class="form-control @error('visi') is-invalid @enderror"
                                      placeholder="Tuliskan pernyataan visi organisasi..."
                                      required>{{ old('visi', $visiMisi->visi) }}</textarea>
                            @error('visi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>

                {{-- ===== MISI ===== --}}
                <div class="card border-0 shadow-sm mb-4" style="border-radius:12px;border-top:5px solid #0EA5E9 !important;">
                    <div class="card-header bg-white border-bottom py-3 px-4">
                        <h5 class="m-0 fw-bold" style="color:#0EA5E9;font-size:1rem;">
                            <i class="fa fa-bullseye me-2"></i>Misi
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="mb-1">
                            <label class="form-label fw-bold">Poin-Poin Misi <span class="text-danger">*</span></label>
                            <div class="form-text text-muted mb-2">
                                <i class="bi bi-info-circle me-1"></i>
                                Satu baris = satu poin misi. Tekan <kbd>Enter</kbd> untuk baris baru.
                            </div>
                            <textarea name="misi_raw" rows="6"
                                      class="form-control @error('misi_raw') is-invalid @enderror"
                                      required>{{ old('misi_raw', $misiRaw) }}</textarea>
                            @error('misi_raw')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>

                {{-- ===== NILAI (Ringkasan) ===== --}}
                <div class="card border-0 shadow-sm mb-4" style="border-radius:12px;border-top:5px solid #22C55E !important;">
                    <div class="card-header bg-white border-bottom py-3 px-4">
                        <h5 class="m-0 fw-bold" style="color:#22C55E;font-size:1rem;">
                            <i class="fa fa-heart me-2"></i>Nilai (Ringkasan)
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Paragraf Nilai</label>
                            <div class="form-text text-muted mb-2">Ditampilkan di kartu "Nilai Kami" pada halaman homepage.</div>
                            <textarea name="nilai" rows="3"
                                      class="form-control @error('nilai') is-invalid @enderror"
                                      placeholder="Transparansi informasi, empati yang tulus dalam pelayanan...">{{ old('nilai', $visiMisi->nilai) }}</textarea>
                            @error('nilai')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>

                {{-- ===== NILAI ITEMS (Kartu Detail) ===== --}}
                <div class="card border-0 shadow-sm mb-4" style="border-radius:12px;border-top:5px solid #8B5CF6 !important;">
                    <div class="card-header bg-white border-bottom py-3 px-4 d-flex justify-content-between align-items-center">
                        <h5 class="m-0 fw-bold" style="color:#8B5CF6;font-size:1rem;">
                            <i class="bi bi-grid-3x2-gap me-2"></i>Item Nilai Detail
                            <small class="fw-normal text-muted ms-2">(Kartu-kartu di bagian bawah halaman)</small>
                        </h5>
                        <button type="button" id="btn-add-nilai" class="btn btn-sm px-3" style="background:#8B5CF6;color:#fff;border-radius:8px;">
                            <i class="bi bi-plus-circle me-1"></i> Tambah Item
                        </button>
                    </div>
                    <div class="card-body p-4">
                        <div id="nilai-items-container">
                            {{-- Existing items rendered by JS below --}}
                        </div>
                        <div id="empty-nilai-hint" class="text-center text-muted py-4" style="border:2px dashed #e2e8f0;border-radius:12px;display:none;">
                            <i class="bi bi-grid-3x2-gap" style="font-size:2rem;opacity:.4;"></i>
                            <p class="mt-2 mb-0">Belum ada item nilai. Klik <strong>Tambah Item</strong> untuk menambahkan.</p>
                        </div>

                        <div class="mt-4 p-3" style="background:#F8FAFC;border-radius:10px;">
                            <p class="fw-bold mb-2 small">Referensi Ikon Font Awesome:</p>
                            <div class="d-flex flex-wrap gap-2">
                                @foreach(['fa-shield','fa-heart','fa-users','fa-graduation-cap','fa-heartbeat','fa-globe','fa-lock','fa-star','fa-bolt','fa-leaf','fa-handshake-o','fa-trophy'] as $icon)
                                    <span class="badge bg-secondary py-2 px-3" style="font-size:.8rem;cursor:pointer;"
                                          onclick="navigator.clipboard.writeText('{{ $icon }}');this.textContent='✓ disalin'">
                                        <i class="fa {{ $icon }} me-1"></i>{{ $icon }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                {{-- STATUS --}}
                <div class="card border-0 shadow-sm mb-4" style="border-radius:12px;">
                    <div class="card-body p-4">
                        <div class="row align-items-center">
                            <div class="col-sm-3">
                                <label class="form-label fw-bold">Status <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-sm-4">
                                <select name="is_active" class="form-select @error('is_active') is-invalid @enderror" required>
                                    <option value="1" {{ old('is_active', $visiMisi->is_active ? '1' : '0') == '1' ? 'selected' : '' }}>Aktif</option>
                                    <option value="0" {{ old('is_active', $visiMisi->is_active ? '1' : '0') == '0' ? 'selected' : '' }}>Non-Aktif</option>
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
                    <a href="{{ route('visi-misi.index') }}" class="btn btn-secondary px-4" style="border-radius:8px;">Batal</a>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
const temaColors = @json($temaColors);
let itemIndex = 0;

function createNilaiItem(data = {}) {
    const idx = itemIndex++;
    const judul     = data.judul     || '';
    const deskripsi = data.deskripsi || '';
    const ikon      = data.ikon      || 'fa-star';
    const tema      = data.tema      || 'blue';

    const temaOptions = Object.keys(temaColors).map(t => {
        const label = { pink:'Pink', green:'Hijau', blue:'Biru', yellow:'Kuning', purple:'Ungu', orange:'Oranye' }[t] || t;
        return `<option value="${t}" ${tema === t ? 'selected' : ''}>${label}</option>`;
    }).join('');

    const html = `
    <div class="nilai-item-row mb-3 p-3" data-idx="${idx}"
         style="border:1px solid #e2e8f0;border-radius:12px;background:#fff;">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <span class="fw-bold text-muted small">Item #${idx + 1}</span>
            <button type="button" class="btn btn-sm btn-outline-danger py-0 px-2 btn-remove-nilai">
                <i class="bi bi-trash"></i>
            </button>
        </div>
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label small fw-bold">Judul <span class="text-danger">*</span></label>
                <input type="text" name="nilai_items[${idx}][judul]" class="form-control form-control-sm"
                       value="${judul}" placeholder="Keamanan Data" required>
            </div>
            <div class="col-md-3">
                <label class="form-label small fw-bold">Ikon FA</label>
                <div class="input-group input-group-sm">
                    <span class="input-group-text px-2"><i class="fa fa-star icon-preview-${idx}"></i></span>
                    <input type="text" name="nilai_items[${idx}][ikon]" class="form-control form-control-sm ikon-input"
                           value="${ikon}" placeholder="fa-shield" data-preview="${idx}">
                </div>
            </div>
            <div class="col-md-3">
                <label class="form-label small fw-bold">Tema Warna</label>
                <select name="nilai_items[${idx}][tema]" class="form-select form-select-sm tema-select" data-preview="${idx}">
                    ${temaOptions}
                </select>
            </div>
            <div class="col-12">
                <label class="form-label small fw-bold">Deskripsi <span class="text-danger">*</span></label>
                <textarea name="nilai_items[${idx}][deskripsi]" class="form-control form-control-sm" rows="2"
                          placeholder="Deskripsi singkat nilai ini..." required>${deskripsi}</textarea>
            </div>
        </div>
    </div>`;

    document.getElementById('nilai-items-container').insertAdjacentHTML('beforeend', html);
    updateIconPreview(idx);
    bindEvents();
}

function updateIconPreview(idx) {
    const ikonInput  = document.querySelector(`[data-preview="${idx}"].ikon-input`);
    const temaSelect = document.querySelector(`[data-preview="${idx}"].tema-select`);
    const preview    = document.querySelector(`.icon-preview-${idx}`);
    if (!ikonInput || !preview) return;
    preview.className = `fa ${ikonInput.value.trim() || 'fa-star'} icon-preview-${idx}`;
    if (temaSelect) {
        const colors = temaColors[temaSelect.value] || temaColors['blue'];
        preview.style.color = colors.ikon;
        ikonInput.closest('.input-group').querySelector('.input-group-text').style.background = colors.bg;
    }
}

function bindEvents() {
    document.querySelectorAll('.btn-remove-nilai').forEach(btn => {
        btn.onclick = function () {
            this.closest('.nilai-item-row').remove();
            const remaining = document.querySelectorAll('.nilai-item-row').length;
            document.getElementById('empty-nilai-hint').style.display = remaining === 0 ? '' : 'none';
        };
    });
    document.querySelectorAll('.ikon-input').forEach(inp => {
        inp.oninput = function () { updateIconPreview(this.dataset.preview); };
    });
    document.querySelectorAll('.tema-select').forEach(sel => {
        sel.onchange = function () { updateIconPreview(this.dataset.preview); };
    });
}

document.getElementById('btn-add-nilai').addEventListener('click', () => createNilaiItem());

// Load existing nilai items
@php $existingItems = old('nilai_items', $visiMisi->nilai_items ?? []); @endphp
@if(!empty($existingItems))
    @foreach($existingItems as $item)
    createNilaiItem({
        judul:     {!! json_encode($item['judul']     ?? '') !!},
        deskripsi: {!! json_encode($item['deskripsi'] ?? '') !!},
        ikon:      {!! json_encode($item['ikon']      ?? 'fa-star') !!},
        tema:      {!! json_encode($item['tema']      ?? 'blue') !!},
    });
    @endforeach
@else
    document.getElementById('empty-nilai-hint').style.display = '';
@endif
</script>
@endpush
