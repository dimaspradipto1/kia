@extends('layouts.dashboard.template')

@section('content')
    <div class="pagetitle">
        <h1>Edit Fasilitas Kesehatan</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('fasilitas-kesehatan.index') }}">Fasilitas Kesehatan</a></li>
                <li class="breadcrumb-item active">Edit</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card border-0 shadow-sm mb-4"
                    style="border-radius: 12px; overflow: hidden; border-top: 5px solid #EC1E88 !important;">
                    <div class="card-header bg-white border-bottom py-3 px-4">
                        <h5 class="m-0 fw-bold text-dark" style="font-size: 1.1rem;">Form Edit Faskes</h5>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('fasilitas-kesehatan.update', $fasilitasKesehatan->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label fw-bold">Nama Faskes</label>
                                <div class="col-sm-10">
                                    <input type="text" name="nama_faskes"
                                        class="form-control @error('nama_faskes') is-invalid @enderror"
                                        value="{{ old('nama_faskes', $fasilitasKesehatan->nama_faskes) }}" required>
                                    @error('nama_faskes')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label fw-bold">Jenis</label>
                                <div class="col-sm-10">
                                    <select name="jenis" class="form-select @error('jenis') is-invalid @enderror"
                                        required>
                                        <option value="">Pilih Jenis</option>
                                        <option value="Puskesmas"
                                            {{ old('jenis', $fasilitasKesehatan->jenis) == 'Puskesmas' ? 'selected' : '' }}>
                                            Puskesmas</option>
                                        <option value="Rumah Sakit"
                                            {{ old('jenis', $fasilitasKesehatan->jenis) == 'Rumah Sakit' ? 'selected' : '' }}>
                                            Rumah Sakit</option>
                                        <option value="Klinik"
                                            {{ old('jenis', $fasilitasKesehatan->jenis) == 'Klinik' ? 'selected' : '' }}>
                                            Klinik</option>
                                        <option value="Bidan"
                                            {{ old('jenis', $fasilitasKesehatan->jenis) == 'Bidan' ? 'selected' : '' }}>
                                            Bidan</option>
                                    </select>
                                    @error('jenis')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label fw-bold">Alamat</label>
                                <div class="col-sm-10">
                                    <textarea name="alamat" class="form-control @error('alamat') is-invalid @enderror" rows="3" required>{{ old('alamat', $fasilitasKesehatan->alamat) }}</textarea>
                                    @error('alamat')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label fw-bold">Kecamatan</label>
                                <div class="col-sm-4">
                                    <input type="text" name="kecamatan"
                                        class="form-control @error('kecamatan') is-invalid @enderror"
                                        value="{{ old('kecamatan', $fasilitasKesehatan->kecamatan) }}" required>
                                </div>
                                <label class="col-sm-2 col-form-label fw-bold text-sm-end">Kab/Kota</label>
                                <div class="col-sm-4">
                                    <input type="text" name="kab_kota"
                                        class="form-control @error('kab_kota') is-invalid @enderror"
                                        value="{{ old('kab_kota', $fasilitasKesehatan->kab_kota) }}" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label fw-bold">Provinsi</label>
                                <div class="col-sm-10">
                                    <input type="text" name="provinsi"
                                        class="form-control @error('provinsi') is-invalid @enderror"
                                        value="{{ old('provinsi', $fasilitasKesehatan->provinsi) }}" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label fw-bold">Telepon</label>
                                <div class="col-sm-10">
                                    <input type="number" name="telepon"
                                        class="form-control @error('telepon') is-invalid @enderror"
                                        value="{{ old('telepon', $fasilitasKesehatan->telepon) }}" required>
                                    @error('telepon')
                                        <div class="invalid-feedback text-danger" style="font-size: 0.8rem;">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            @php
                                $jam = explode(' - ', $fasilitasKesehatan->jam_operasional);
                                $jam_buka = isset($jam[0]) ? trim($jam[0]) : '08:00';
                                $jam_tutup = isset($jam[1]) ? trim($jam[1]) : '16:00';
                            @endphp

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label fw-bold">Jam Operasional</label>
                                <div class="col-sm-10">
                                    <div class="input-group">
                                        <input type="time" name="jam_buka" class="form-control"
                                            value="{{ old('jam_buka', $jam_buka) }}">
                                        <span class="input-group-text">sampai</span>
                                        <input type="time" name="jam_tutup" class="form-control"
                                            value="{{ old('jam_tutup', $jam_tutup) }}">
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label fw-bold">Sematkan Peta</label>
                                <div class="col-sm-10">
                                    <textarea name="embed_map" id="embed_map" class="form-control" rows="3"
                                        placeholder="Tempelkan kode HTML iframe dari Google Maps di sini">{{ old('embed_map', $fasilitasKesehatan->embed_map) }}</textarea>
                                    <div class="mt-2 text-muted" style="font-size: 0.85rem;">
                                        Buka Google Maps > Bagikan > Sematkan peta > Salin HTML
                                    </div>
                                    <div id="map-preview" class="mt-3 border rounded p-2 {{ $fasilitasKesehatan->embed_map ? '' : 'd-none' }}" style="background: #f8f9fa;">
                                        <div class="fw-bold mb-2 text-primary"><i class="bi bi-geo-alt"></i> Pratinjau Peta:</div>
                                        <div class="ratio ratio-16x9" id="preview-content">
                                            {!! $fasilitasKesehatan->embed_map !!}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label fw-bold">Status</label>
                                <div class="col-sm-10">
                                    <select name="is_active" class="form-select">
                                        <option value="1"
                                            {{ old('is_active', $fasilitasKesehatan->is_active) == '1' ? 'selected' : '' }}>
                                            Aktif</option>
                                        <option value="0"
                                            {{ old('is_active', $fasilitasKesehatan->is_active) == '0' ? 'selected' : '' }}>
                                            Non-Aktif</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-sm-10 offset-sm-2">
                                    <button type="submit" class="btn text-white px-4"
                                        style="background-color: #EC1E88; border-radius: 8px;">Perbarui Data</button>
                                    <a href="{{ route('fasilitas-kesehatan.index') }}" class="btn btn-light border px-4"
                                        style="border-radius: 8px;">Batal</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const embedInput = document.getElementById('embed_map');
            const previewContainer = document.getElementById('map-preview');
            const previewContent = document.getElementById('preview-content');

            function updatePreview() {
                const val = embedInput.value.trim();
                if (val.includes('<iframe')) {
                    previewContainer.classList.remove('d-none');
                    // Clean the iframe for responsiveness
                    let cleanedIframe = val.replace(/width="[0-9]*"/, 'width="100%"')
                                           .replace(/height="[0-9]*"/, 'height="100%"');
                    previewContent.innerHTML = cleanedIframe;
                } else {
                    previewContainer.classList.add('d-none');
                    previewContent.innerHTML = '';
                }
            }

            embedInput.addEventListener('input', updatePreview);
            
            // Initial cleaning for responsiveness if exists
            if (embedInput.value.trim() !== '') {
                let val = embedInput.value.trim();
                let cleanedIframe = val.replace(/width="[0-9]*"/, 'width="100%"')
                                       .replace(/height="[0-9]*"/, 'height="100%"');
                previewContent.innerHTML = cleanedIframe;
            }
        });
    </script>
@endpush
@endsection
