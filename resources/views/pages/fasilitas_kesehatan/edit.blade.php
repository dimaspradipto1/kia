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
                                <label class="col-sm-2 col-form-label fw-bold">Koordinat GIS</label>
                                <div class="col-sm-10">
                                    <input type="hidden" name="latitude"  id="lat_input"  value="{{ old('latitude', $fasilitasKesehatan->latitude) }}">
                                    <input type="hidden" name="longitude" id="lng_input"  value="{{ old('longitude', $fasilitasKesehatan->longitude) }}">

                                    <div class="d-flex gap-2 align-items-center mb-2 flex-wrap">
                                        <span class="badge bg-light text-dark border fw-semibold" style="font-size:0.8rem;">
                                            Lat: <span id="lat_display">{{ old('latitude', $fasilitasKesehatan->latitude ?? '-') }}</span>
                                        </span>
                                        <span class="badge bg-light text-dark border fw-semibold" style="font-size:0.8rem;">
                                            Lng: <span id="lng_display">{{ old('longitude', $fasilitasKesehatan->longitude ?? '-') }}</span>
                                        </span>
                                        <button type="button" id="btn-geocode-form" class="btn btn-sm btn-outline-primary rounded-pill">
                                            <i class="bi bi-geo me-1"></i> Cari Otomatis dari Nama & Alamat
                                        </button>
                                        <button type="button" id="btn-clear-coords" class="btn btn-sm btn-outline-danger rounded-pill">
                                            <i class="bi bi-x-circle me-1"></i> Reset
                                        </button>
                                    </div>
                                    <div id="picker-map" style="height:280px; border-radius:12px; border:1px solid #dee2e6; z-index:1;"></div>
                                    <div class="mt-1 text-muted" style="font-size:0.78rem;">
                                        <i class="bi bi-hand-index me-1"></i>Klik pada peta untuk menempatkan pin, atau seret pin untuk mengubah posisi.
                                    </div>
                                    @error('latitude') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                    @error('longitude')<div class="text-danger small mt-1">{{ $message }}</div> @enderror
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
@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
@endpush

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {

    // ── Embed Map Preview ──────────────────────────────────────────────
    const embedInput = document.getElementById('embed_map');
    const previewContainer = document.getElementById('map-preview');
    const previewContent   = document.getElementById('preview-content');

    function updatePreview() {
        const val = embedInput.value.trim();
        if (val.includes('<iframe')) {
            previewContainer.classList.remove('d-none');
            previewContent.innerHTML = val.replace(/width="[0-9]*"/, 'width="100%"')
                                          .replace(/height="[0-9]*"/, 'height="100%"');
        } else {
            previewContainer.classList.add('d-none');
            previewContent.innerHTML = '';
        }
    }
    embedInput.addEventListener('input', updatePreview);
    if (embedInput.value.trim()) updatePreview();

    // ── Leaflet Map Picker ─────────────────────────────────────────────
    const DEFAULT_LAT = 1.1301, DEFAULT_LNG = 104.0529;
    const savedLat = parseFloat(document.getElementById('lat_input').value) || null;
    const savedLng = parseFloat(document.getElementById('lng_input').value) || null;

    const pickerMap = L.map('picker-map').setView(
        savedLat && savedLng ? [savedLat, savedLng] : [DEFAULT_LAT, DEFAULT_LNG],
        savedLat && savedLng ? 16 : 12
    );

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap', maxZoom: 19
    }).addTo(pickerMap);

    let marker = null;

    function setCoords(lat, lng) {
        lat = parseFloat(lat.toFixed(7));
        lng = parseFloat(lng.toFixed(7));
        document.getElementById('lat_input').value  = lat;
        document.getElementById('lng_input').value  = lng;
        document.getElementById('lat_display').textContent = lat;
        document.getElementById('lng_display').textContent = lng;
        if (marker) {
            marker.setLatLng([lat, lng]);
        } else {
            marker = L.marker([lat, lng], { draggable: true }).addTo(pickerMap);
            marker.on('dragend', function (e) {
                const pos = e.target.getLatLng();
                setCoords(pos.lat, pos.lng);
            });
        }
    }

    if (savedLat && savedLng) setCoords(savedLat, savedLng);

    pickerMap.on('click', function (e) {
        setCoords(e.latlng.lat, e.latlng.lng);
        pickerMap.setView([e.latlng.lat, e.latlng.lng], Math.max(pickerMap.getZoom(), 15));
    });

    document.getElementById('btn-clear-coords').addEventListener('click', function () {
        document.getElementById('lat_input').value  = '';
        document.getElementById('lng_input').value  = '';
        document.getElementById('lat_display').textContent = '-';
        document.getElementById('lng_display').textContent = '-';
        if (marker) { pickerMap.removeLayer(marker); marker = null; }
    });

    // ── Auto-geocode ───────────────────────────────────────────────────
    document.getElementById('btn-geocode-form').addEventListener('click', async function () {
        const nama = document.querySelector('[name="nama_faskes"]').value.trim();
        const kec  = document.querySelector('[name="kecamatan"]').value.trim();
        const kab  = document.querySelector('[name="kab_kota"]').value.trim();

        if (!nama && !kec && !kab) {
            alert('Isi terlebih dahulu Nama Faskes, Kecamatan, atau Kab/Kota sebelum mencari koordinat.');
            return;
        }

        this.disabled = true;
        this.innerHTML = '<i class="bi bi-hourglass-split me-1"></i> Mencari…';

        try {
            const q   = encodeURIComponent(`${nama} ${kec} ${kab} Indonesia`);
            const res = await fetch(`https://nominatim.openstreetmap.org/search?q=${q}&format=json&limit=1`, {
                headers: { 'Accept-Language': 'id' }
            });
            const data = await res.json();

            if (data.length > 0) {
                const lat = parseFloat(data[0].lat);
                const lng = parseFloat(data[0].lon);
                setCoords(lat, lng);
                pickerMap.setView([lat, lng], 16);
                this.innerHTML = '<i class="bi bi-check-circle me-1"></i> Ditemukan!';
            } else {
                this.innerHTML = '<i class="bi bi-x-circle me-1"></i> Tidak ditemukan';
                alert('Koordinat tidak ditemukan. Coba klik manual pada peta di atas.');
            }
        } catch (e) {
            this.innerHTML = '<i class="bi bi-x-circle me-1"></i> Error';
        }

        setTimeout(() => {
            this.disabled = false;
            this.innerHTML = '<i class="bi bi-geo me-1"></i> Cari Otomatis dari Nama & Alamat';
        }, 2000);
    });
});
</script>
@endpush
@endsection
