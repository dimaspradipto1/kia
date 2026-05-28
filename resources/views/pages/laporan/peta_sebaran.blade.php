@extends('layouts.dashboard.template')

@section('content')
@php
$bulanIndo = [1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',5=>'Mei',6=>'Juni',7=>'Juli',8=>'Agustus',9=>'September',10=>'Oktober',11=>'November',12=>'Desember'];
@endphp
<div class="pagetitle">
    <h1 class="fw-bold text-dark">Peta Sebaran Kasus Risiko Tinggi</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item">Laporan & Monitoring</li>
            <li class="breadcrumb-item active">Peta Sebaran GIS</li>
        </ol>
    </nav>
</div>

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    #map { height: 520px; border-radius: 16px; z-index: 1; }
    .legend-dot { width: 14px; height: 14px; border-radius: 50%; display: inline-block; }
    .leaflet-popup-content-wrapper { border-radius: 12px; box-shadow: 0 8px 30px rgba(0,0,0,0.15); }
    .popup-title { font-weight: 700; font-size: 14px; margin-bottom: 6px; }
    .popup-badge { display: inline-block; padding: 2px 8px; border-radius: 20px; font-size: 11px; font-weight: 600; }
    .no-coords-card { border-left: 4px solid #f59e0b; }
</style>
@endpush

<section class="section">
    <div class="row">

        {{-- Filter --}}
        <div class="col-12 mb-4">
            <div class="card border-0 shadow-sm rounded-4 p-4 border-start border-4 border-success">
                <form action="{{ route('laporan.peta-sebaran') }}" method="GET" class="row align-items-end g-3">
                    <div class="col-md-3">
                        <label class="form-label fw-bold text-secondary small">Tahun</label>
                        <select name="tahun" class="form-select rounded-pill">
                            @foreach([2024,2025,2026,2027] as $y)
                                <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>{{ $y }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold text-secondary small">Bulan</label>
                        <select name="bulan" class="form-select rounded-pill">
                            @foreach(range(1,12) as $m)
                                <option value="{{ $m }}" {{ $bulan == $m ? 'selected' : '' }}>{{ $bulanIndo[$m] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-success rounded-pill w-100 fw-bold"><i class="bi bi-filter me-1"></i> Filter</button>
                    </div>
                    <div class="col-md-4 text-md-end">
                        <div class="d-flex gap-2 justify-content-md-end align-items-center flex-wrap">
                            <span><span class="legend-dot" style="background:#dc2626;"></span> <small class="fw-semibold">Risiko Tinggi</small></span>
                            <span><span class="legend-dot" style="background:#f59e0b;"></span> <small class="fw-semibold">Risiko Sedang</small></span>
                            <span><span class="legend-dot" style="background:#16a34a;"></span> <small class="fw-semibold">Risiko Rendah</small></span>
                            @php $tanpaKoordinat = $faskesList->filter(fn($f) => !$f->latitude || !$f->longitude)->count(); @endphp
                            @if($tanpaKoordinat > 0)
                            <button type="button" id="btn-geocode" class="btn btn-warning rounded-pill fw-bold" style="font-size:0.8rem;">
                                <i class="bi bi-geo me-1"></i> Geocode Otomatis ({{ $tanpaKoordinat }})
                            </button>
                            @endif
                        </div>
                        <div id="geocode-progress" class="mt-2 d-none">
                            <div class="progress rounded-pill" style="height:8px;">
                                <div id="geocode-bar" class="progress-bar bg-warning progress-bar-striped progress-bar-animated" style="width:0%"></div>
                            </div>
                            <small id="geocode-status" class="text-muted d-block mt-1 text-end"></small>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- Kartu Statistik --}}
        <div class="col-12 mb-4">
            <div class="row g-3">
                @php
                    $tinggi  = $faskesList->where('risiko_level', 'tinggi')->count();
                    $sedang  = $faskesList->where('risiko_level', 'sedang')->count();
                    $rendah  = $faskesList->where('risiko_level', 'rendah')->count();
                    $hasCoord = $faskesList->filter(fn($f) => $f->latitude && $f->longitude)->count();
                @endphp
                <div class="col-6 col-md-3">
                    <div class="card border-0 shadow-sm rounded-4 p-3 text-center" style="border-top:4px solid #dc2626 !important;">
                        <div class="fw-bold fs-2 text-danger">{{ $tinggi }}</div>
                        <div class="text-muted small fw-semibold">Risiko Tinggi</div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="card border-0 shadow-sm rounded-4 p-3 text-center" style="border-top:4px solid #f59e0b !important;">
                        <div class="fw-bold fs-2 text-warning">{{ $sedang }}</div>
                        <div class="text-muted small fw-semibold">Risiko Sedang</div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="card border-0 shadow-sm rounded-4 p-3 text-center" style="border-top:4px solid #16a34a !important;">
                        <div class="fw-bold fs-2 text-success">{{ $rendah }}</div>
                        <div class="text-muted small fw-semibold">Risiko Rendah</div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="card border-0 shadow-sm rounded-4 p-3 text-center" style="border-top:4px solid #3b82f6 !important;">
                        <div class="fw-bold fs-2 text-primary">{{ $hasCoord }}</div>
                        <div class="text-muted small fw-semibold">Faskes Terpetakan</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Peta --}}
        <div class="col-lg-8 mb-4">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-bottom py-3 px-4">
                    <h5 class="fw-bold mb-0"><i class="bi bi-geo-alt-fill text-danger me-2"></i>Peta Persebaran Faskes — {{ $bulanIndo[$bulan] }} {{ $tahun }}</h5>
                </div>
                <div class="card-body p-3">
                    <div id="map"></div>
                    @php $tanpaKoordCount = $faskesList->filter(fn($f) => !$f->latitude || !$f->longitude)->count(); @endphp
                    @if($tanpaKoordCount > 0)
                        <div class="alert alert-warning mt-3 rounded-3 no-coords-card mb-0 d-flex align-items-start gap-3">
                            <i class="bi bi-exclamation-triangle fs-5 mt-1 flex-shrink-0"></i>
                            <div>
                                <strong>{{ $tanpaKoordCount }} faskes belum memiliki koordinat.</strong><br>
                                <span class="small">
                                    Gunakan tombol <strong>"Geocode Otomatis"</strong> di atas untuk mengisi koordinat secara otomatis,
                                    atau edit setiap faskes di halaman
                                    <a href="{{ route('fasilitas-kesehatan.index') }}" class="fw-bold">Fasilitas Kesehatan</a>
                                    dan gunakan peta interaktif untuk menentukan lokasi.
                                </span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Tabel Risiko --}}
        <div class="col-lg-4 mb-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white border-bottom py-3 px-4">
                    <h5 class="fw-bold mb-0">Daftar Faskes by Risiko</h5>
                </div>
                <div class="card-body p-0" style="overflow-y:auto; max-height:540px;">
                    @foreach(['tinggi' => ['dc2626','Tinggi'], 'sedang' => ['f59e0b','Sedang'], 'rendah' => ['16a34a','Rendah']] as $lvl => [$color, $label])
                        @php $group = $faskesList->where('risiko_level', $lvl); @endphp
                        @if($group->count())
                            <div class="px-3 pt-3 pb-1">
                                <span class="badge rounded-pill text-white px-3 fw-bold" style="background:#{{ $color }}; font-size:0.78rem;">{{ strtoupper($label) }}</span>
                            </div>
                            @foreach($group as $f)
                                <div class="px-4 py-2 border-bottom">
                                    <div class="fw-semibold small text-dark">{{ $f->nama_faskes }}</div>
                                    <div class="text-muted" style="font-size:0.75rem;">
                                        <i class="bi bi-geo-alt me-1"></i>{{ $f->kecamatan }}
                                        @if($f->kematian)
                                            &bull; AKI: {{ $f->kematian->kematian_ibu }} | AKB: {{ $f->kematian->kematian_bayi }}
                                        @endif
                                        @if($f->gizi && $f->gizi->stunting > 0)
                                            &bull; Stunting: {{ $f->gizi->stunting }}
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    @endforeach
                </div>
            </div>
        </div>

    </div>
</section>

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const map = L.map('map').setView([1.1301, 104.0529], 12);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© <a href="https://www.openstreetmap.org/">OpenStreetMap</a>',
        maxZoom: 18
    }).addTo(map);

    const markerColor = { tinggi: '#dc2626', sedang: '#f59e0b', rendah: '#16a34a' };

    @php
    $faskesData = $faskesList->map(function($f) {
        return [
            'id'       => $f->id,
            'nama'     => $f->nama_faskes,
            'jenis'    => $f->jenis,
            'kecamatan'=> $f->kecamatan,
            'kab_kota' => $f->kab_kota,
            'lat'      => $f->latitude,
            'lng'      => $f->longitude,
            'risiko'   => $f->risiko_level,
            'score'    => $f->risiko_score,
            'aki'      => optional($f->kematian)->kematian_ibu ?? 0,
            'akb'      => optional($f->kematian)->kematian_bayi ?? 0,
            'stunting' => optional($f->gizi)->stunting ?? 0,
            'k1'       => optional($f->cakupan)->k1_total ?? 0,
        ];
    })->values();
    @endphp
    const faskes = @json($faskesData);

    let bounds = [];

    faskes.forEach(function (f) {
        if (!f.lat || !f.lng) return;

        const color  = markerColor[f.risiko] || '#16a34a';
        const icon   = L.divIcon({
            className: '',
            html: `<div style="width:22px;height:22px;border-radius:50%;background:${color};border:3px solid white;box-shadow:0 2px 8px rgba(0,0,0,0.35);"></div>`,
            iconSize: [22, 22],
            iconAnchor: [11, 11]
        });

        const marker = L.marker([f.lat, f.lng], { icon }).addTo(map);
        bounds.push([f.lat, f.lng]);

        const risikoLabel = { tinggi: '🔴 Risiko Tinggi', sedang: '🟡 Risiko Sedang', rendah: '🟢 Risiko Rendah' };

        marker.bindPopup(`
            <div style="min-width:200px;">
                <div class="popup-title">${f.nama}</div>
                <div style="font-size:12px; color:#64748b; margin-bottom:8px;">${f.jenis} — Kec. ${f.kecamatan}, ${f.kab_kota}</div>
                <div style="font-size:12px; font-weight:700;">${risikoLabel[f.risiko] || ''}</div>
                <hr style="margin:6px 0;">
                <table style="font-size:11px; width:100%;">
                    <tr><td>Kematian Ibu (AKI)</td><td style="text-align:right; font-weight:700; color:#dc2626;">${f.aki}</td></tr>
                    <tr><td>Kematian Bayi (AKB)</td><td style="text-align:right; font-weight:700; color:#dc2626;">${f.akb}</td></tr>
                    <tr><td>Stunting Balita</td><td style="text-align:right; font-weight:700; color:#f59e0b;">${f.stunting}</td></tr>
                    <tr><td>Cakupan K1</td><td style="text-align:right; font-weight:700; color:#16a34a;">${f.k1}</td></tr>
                </table>
            </div>
        `);
    });

    if (bounds.length > 0) {
        map.fitBounds(bounds, { padding: [40, 40] });
    } else {
        // Default view ke Batam / Indonesia jika belum ada koordinat
        map.setView([1.12, 104.04], 11);
    }

    // ── Geocode Otomatis ─────────────────────────────────────────────────────
    const btnGeocode = document.getElementById('btn-geocode');
    if (btnGeocode) {
        btnGeocode.addEventListener('click', async function () {
            const tanpaKoord = faskes.filter(f => !f.lat || !f.lng);
            if (tanpaKoord.length === 0) return;

            btnGeocode.disabled = true;
            document.getElementById('geocode-progress').classList.remove('d-none');
            const bar    = document.getElementById('geocode-bar');
            const status = document.getElementById('geocode-status');
            const csrf   = document.querySelector('meta[name="csrf-token"]').content;
            const markerColor = { tinggi: '#dc2626', sedang: '#f59e0b', rendah: '#16a34a' };

            let done = 0;
            for (const f of tanpaKoord) {
                status.textContent = `Mencari koordinat: ${f.nama}…`;
                try {
                    // Query Nominatim with faskes name + kecamatan + kab_kota
                    const q = encodeURIComponent(`${f.nama}, ${f.kecamatan}, ${f.kab_kota}, Indonesia`);
                    const res = await fetch(`https://nominatim.openstreetmap.org/search?q=${q}&format=json&limit=1`, {
                        headers: { 'Accept-Language': 'id', 'User-Agent': 'KIA-System/1.0' }
                    });
                    const data = await res.json();

                    if (data.length > 0) {
                        const lat = parseFloat(data[0].lat);
                        const lng = parseFloat(data[0].lon);

                        // Save to server
                        await fetch(`/fasilitas-kesehatan/${f.id}/koordinat`, {
                            method : 'PATCH',
                            headers: {
                                'Content-Type' : 'application/json',
                                'X-CSRF-TOKEN' : csrf,
                                'Accept'       : 'application/json',
                            },
                            body: JSON.stringify({ latitude: lat, longitude: lng }),
                        });

                        // Add marker to map immediately
                        f.lat = lat;
                        f.lng = lng;
                        const color = markerColor[f.risiko] || '#16a34a';
                        const icon = L.divIcon({
                            className: '',
                            html: `<div style="width:22px;height:22px;border-radius:50%;background:${color};border:3px solid white;box-shadow:0 2px 8px rgba(0,0,0,0.35);"></div>`,
                            iconSize: [22, 22], iconAnchor: [11, 11]
                        });
                        const risikoLabel = { tinggi: '🔴 Risiko Tinggi', sedang: '🟡 Risiko Sedang', rendah: '🟢 Risiko Rendah' };
                        L.marker([lat, lng], { icon }).addTo(map).bindPopup(`
                            <div style="min-width:200px;">
                                <div class="popup-title">${f.nama}</div>
                                <div style="font-size:12px;color:#64748b;margin-bottom:8px;">${f.jenis} — Kec. ${f.kecamatan}, ${f.kab_kota}</div>
                                <div style="font-size:12px;font-weight:700;">${risikoLabel[f.risiko] || ''}</div>
                                <hr style="margin:6px 0;">
                                <table style="font-size:11px;width:100%;">
                                    <tr><td>Kematian Ibu (AKI)</td><td style="text-align:right;font-weight:700;color:#dc2626;">${f.aki}</td></tr>
                                    <tr><td>Kematian Bayi (AKB)</td><td style="text-align:right;font-weight:700;color:#dc2626;">${f.akb}</td></tr>
                                    <tr><td>Stunting Balita</td><td style="text-align:right;font-weight:700;color:#f59e0b;">${f.stunting}</td></tr>
                                    <tr><td>Cakupan K1</td><td style="text-align:right;font-weight:700;color:#16a34a;">${f.k1}</td></tr>
                                </table>
                            </div>`);
                        bounds.push([lat, lng]);
                        status.textContent = `✓ ${f.nama} ditemukan`;
                    } else {
                        status.textContent = `✗ ${f.nama} tidak ditemukan di Nominatim`;
                    }
                } catch (e) {
                    status.textContent = `✗ Error: ${f.nama}`;
                }

                done++;
                bar.style.width = Math.round((done / tanpaKoord.length) * 100) + '%';

                // Nominatim rate limit: 1 request/second
                await new Promise(r => setTimeout(r, 1200));
            }

            if (bounds.length > 0) map.fitBounds(bounds, { padding: [40, 40] });
            bar.classList.remove('progress-bar-animated');
            bar.style.background = '#16a34a';
            status.textContent = `✓ Selesai! ${done} faskes diproses. Halaman akan direfresh…`;
            btnGeocode.disabled = false;
            setTimeout(() => location.reload(), 2000);
        });
    }
});
</script>
@endpush
@endsection
