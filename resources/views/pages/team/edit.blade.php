@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Edit Anggota Tim</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('teams.index') }}">Tim</a></li>
            <li class="breadcrumb-item active">Edit</li>
        </ol>
    </nav>
</div>

<section class="section">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4" style="border-radius:12px;overflow:hidden;border-top:5px solid #EC1E88 !important;">
                <div class="card-header bg-white border-bottom py-3 px-4">
                    <h5 class="m-0 fw-bold text-dark" style="font-size:1.1rem;">
                        <i class="bi bi-pencil-square me-2" style="color:#EC1E88;"></i>Form Edit Anggota Tim
                    </h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('teams.update', $team->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        {{-- Foto --}}
                        <div class="row mb-4">
                            <label class="col-sm-3 col-form-label fw-bold">Foto</label>
                            <div class="col-sm-9">
                                <div class="d-flex align-items-start gap-4">
                                    {{-- Preview saat ini --}}
                                    <div style="flex-shrink:0;">
                                        <div id="foto-preview"
                                             style="width:110px;height:110px;border-radius:50%;border:3px solid #EC1E88;
                                                    overflow:hidden;cursor:pointer;" title="Klik untuk ganti foto">
                                            <img id="foto-img" src="{{ $team->foto_url }}" alt="{{ $team->nama }}"
                                                 style="width:100%;height:100%;object-fit:cover;">
                                        </div>
                                        <p class="text-muted text-center mt-1" style="font-size:.72rem;">Klik untuk ganti</p>
                                    </div>
                                    <div class="flex-grow-1">
                                        <input type="file" name="foto" id="foto" class="form-control @error('foto') is-invalid @enderror"
                                               accept="image/jpg,image/jpeg,image/png,image/webp">
                                        <div class="form-text text-muted">Kosongkan jika tidak ingin mengganti foto. JPG, PNG, WEBP — maks. 2 MB.</div>
                                        @error('foto') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror

                                        @if($team->foto)
                                        <div class="form-check mt-2">
                                            <input type="checkbox" name="hapus_foto" value="1" id="hapus_foto"
                                                   class="form-check-input" style="accent-color:#dc3545;">
                                            <label for="hapus_foto" class="form-check-label text-danger small">
                                                <i class="bi bi-trash me-1"></i>Hapus foto ini (tanpa upload pengganti)
                                            </label>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Nama --}}
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label fw-bold">Nama <span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror"
                                       value="{{ old('nama', $team->nama) }}" required>
                                @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        {{-- Jabatan --}}
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label fw-bold">Jabatan <span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <input type="text" name="jabatan" class="form-control @error('jabatan') is-invalid @enderror"
                                       value="{{ old('jabatan', $team->jabatan) }}" required>
                                @error('jabatan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        {{-- LinkedIn --}}
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label fw-bold">
                                <i class="bi bi-linkedin me-1" style="color:#0077b5;"></i>LinkedIn
                            </label>
                            <div class="col-sm-9">
                                <input type="url" name="linkedin" class="form-control @error('linkedin') is-invalid @enderror"
                                       value="{{ old('linkedin', $team->linkedin) }}" placeholder="https://linkedin.com/in/username">
                                @error('linkedin') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        {{-- TikTok --}}
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label fw-bold">
                                <i class="bi bi-tiktok me-1"></i>TikTok
                            </label>
                            <div class="col-sm-9">
                                <input type="url" name="tiktok" class="form-control @error('tiktok') is-invalid @enderror"
                                       value="{{ old('tiktok', $team->tiktok) }}" placeholder="https://tiktok.com/@username">
                                @error('tiktok') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        {{-- Instagram --}}
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label fw-bold">
                                <i class="bi bi-instagram me-1" style="color:#E1306C;"></i>Instagram
                            </label>
                            <div class="col-sm-9">
                                <input type="url" name="instagram" class="form-control @error('instagram') is-invalid @enderror"
                                       value="{{ old('instagram', $team->instagram) }}" placeholder="https://instagram.com/username">
                                @error('instagram') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        {{-- Facebook --}}
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label fw-bold">
                                <i class="bi bi-facebook me-1" style="color:#1877F2;"></i>Facebook
                            </label>
                            <div class="col-sm-9">
                                <input type="url" name="facebook" class="form-control @error('facebook') is-invalid @enderror"
                                       value="{{ old('facebook', $team->facebook) }}" placeholder="https://facebook.com/username">
                                @error('facebook') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        {{-- Urutan --}}
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label fw-bold">Urutan Tampil</label>
                            <div class="col-sm-3">
                                <input type="number" name="urutan" class="form-control @error('urutan') is-invalid @enderror"
                                       value="{{ old('urutan', $team->urutan) }}" min="0">
                                @error('urutan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        {{-- Status --}}
                        <div class="row mb-4">
                            <label class="col-sm-3 col-form-label fw-bold">Status <span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <select name="is_active" class="form-select @error('is_active') is-invalid @enderror" required>
                                    <option value="1" {{ old('is_active', $team->is_active ? '1' : '0') == '1' ? 'selected' : '' }}>Aktif</option>
                                    <option value="0" {{ old('is_active', $team->is_active ? '1' : '0') == '0' ? 'selected' : '' }}>Non-Aktif</option>
                                </select>
                                @error('is_active') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn text-white px-5" style="background-color:#EC1E88;border-radius:8px;">
                                <i class="bi bi-save me-1"></i> Perbarui
                            </button>
                            <a href="{{ route('teams.index') }}" class="btn btn-secondary px-4" style="border-radius:8px;">Batal</a>
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
    const fotoInput   = document.getElementById('foto');
    const fotoPreview = document.getElementById('foto-preview');
    const hapusCheck  = document.getElementById('hapus_foto');

    fotoPreview.addEventListener('click', () => fotoInput.click());

    fotoInput.addEventListener('change', function () {
        if (this.files && this.files[0]) {
            // Auto-uncheck "hapus foto" saat upload baru
            if (hapusCheck) hapusCheck.checked = false;
            const reader = new FileReader();
            reader.onload = e => {
                fotoPreview.innerHTML = `<img src="${e.target.result}"
                    style="width:100%;height:100%;object-fit:cover;border-radius:50%;">`;
            };
            reader.readAsDataURL(this.files[0]);
        }
    });

    // Jika hapus foto dicentang → tampilkan placeholder
    if (hapusCheck) {
        hapusCheck.addEventListener('change', function () {
            if (this.checked) {
                fotoPreview.innerHTML = `<div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;background:#f8f9fa;">
                    <i class="bi bi-person-circle text-muted" style="font-size:3rem;"></i></div>`;
                fotoInput.value = '';
            } else {
                fotoPreview.innerHTML = `<img src="{{ $team->foto_url }}"
                    style="width:100%;height:100%;object-fit:cover;border-radius:50%;">`;
            }
        });
    }
</script>
@endpush
