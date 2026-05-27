@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Edit Kontak</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('contacts.index') }}">Kontak</a></li>
            <li class="breadcrumb-item active">Edit</li>
        </ol>
    </nav>
</div>

<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px; overflow: hidden; border-top: 5px solid #EC1E88 !important;">
                <div class="card-header bg-white border-bottom py-3 px-4">
                    <h5 class="m-0 fw-bold text-dark" style="font-size: 1.1rem;">Form Edit Kontak</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('contacts.update', $contact->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row mb-3">
                            <label for="nama_lokasi" class="col-sm-3 col-form-label fw-bold">Nama Lokasi <span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <input type="text" name="nama_lokasi" id="nama_lokasi"
                                    class="form-control @error('nama_lokasi') is-invalid @enderror"
                                    value="{{ old('nama_lokasi', $contact->nama_lokasi) }}" required>
                                @error('nama_lokasi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="alamat" class="col-sm-3 col-form-label fw-bold">Alamat <span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <textarea name="alamat" id="alamat" rows="3"
                                    class="form-control @error('alamat') is-invalid @enderror"
                                    required>{{ old('alamat', $contact->alamat) }}</textarea>
                                @error('alamat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-sm-3 col-form-label fw-bold">Email</label>
                            <div class="col-sm-9">
                                <input type="email" name="email" id="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    value="{{ old('email', $contact->email) }}">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="telepon" class="col-sm-3 col-form-label fw-bold">Telepon</label>
                            <div class="col-sm-9">
                                <input type="text" name="telepon" id="telepon"
                                    class="form-control @error('telepon') is-invalid @enderror"
                                    value="{{ old('telepon', $contact->telepon) }}">
                                @error('telepon')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="jam_operasional" class="col-sm-3 col-form-label fw-bold">Jam Operasional</label>
                            <div class="col-sm-9">
                                <input type="text" name="jam_operasional" id="jam_operasional"
                                    class="form-control @error('jam_operasional') is-invalid @enderror"
                                    value="{{ old('jam_operasional', $contact->jam_operasional) }}">
                                @error('jam_operasional')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="map_embed" class="col-sm-3 col-form-label fw-bold">Embed Google Maps</label>
                            <div class="col-sm-9">
                                <textarea name="map_embed" id="map_embed" rows="5"
                                    class="form-control font-monospace @error('map_embed') is-invalid @enderror">{{ old('map_embed', $contact->map_embed) }}</textarea>
                                <div class="form-text text-muted">
                                    <i class="bi bi-info-circle me-1"></i>
                                    Buka <a href="https://maps.google.com" target="_blank">Google Maps</a>, pilih lokasi,
                                    klik <strong>Bagikan &rarr; Sematkan peta</strong>, lalu copy kode iframe-nya.
                                </div>
                                @error('map_embed')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                                {{-- Live Preview --}}
                                <div id="map-preview-wrapper" class="mt-3" style="display:none;">
                                    <p class="small fw-semibold text-muted mb-1"><i class="bi bi-map me-1"></i> Preview Peta:</p>
                                    <div style="border-radius: 12px; overflow: hidden; border: 1px solid #dee2e6;">
                                        <div id="map-preview-container"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="is_active" class="col-sm-3 col-form-label fw-bold">Status <span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <select name="is_active" id="is_active"
                                    class="form-select @error('is_active') is-invalid @enderror" required>
                                    <option value="1" {{ old('is_active', $contact->is_active ? '1' : '0') == '1' ? 'selected' : '' }}>Aktif</option>
                                    <option value="0" {{ old('is_active', $contact->is_active ? '1' : '0') == '0' ? 'selected' : '' }}>Non-Aktif</option>
                                </select>
                                @error('is_active')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-9 offset-sm-3">
                                <button type="submit" class="btn text-white px-4" style="background-color: #EC1E88;">
                                    <i class="bi bi-save me-1"></i> Perbarui Kontak
                                </button>
                                <a href="{{ route('contacts.index') }}" class="btn btn-secondary px-4">Batal</a>
                            </div>
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
    const mapEmbedInput = document.getElementById('map_embed');
    const previewWrapper = document.getElementById('map-preview-wrapper');
    const previewContainer = document.getElementById('map-preview-container');

    function updateMapPreview() {
        const val = mapEmbedInput.value.trim();
        if (val.startsWith('<iframe')) {
            const updated = val.replace(/width="[^"]*"/, 'width="100%"').replace(/height="[^"]*"/, 'height="350"');
            previewContainer.innerHTML = updated;
            previewWrapper.style.display = 'block';
        } else {
            previewContainer.innerHTML = '';
            previewWrapper.style.display = 'none';
        }
    }

    mapEmbedInput.addEventListener('input', updateMapPreview);
    updateMapPreview();
</script>
@endpush
