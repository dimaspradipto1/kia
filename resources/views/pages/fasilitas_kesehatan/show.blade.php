@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Detail Fasilitas Kesehatan</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('fasilitas-kesehatan.index') }}">Fasilitas Kesehatan</a></li>
            <li class="breadcrumb-item active">Detail</li>
        </ol>
    </nav>
</div>

<section class="section profile">
    <div class="row">
        <div class="col-xl-4">
            <div class="card shadow-sm border-0" style="border-radius: 12px; border-top: 5px solid #EC1E88 !important;">
                <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                    <div class="icon-circle bg-light d-flex align-items-center justify-content-center mb-3" style="width: 100px; height: 100px; border-radius: 50%;">
                        <i class="bi bi-hospital text-magenta" style="font-size: 3rem;"></i>
                    </div>
                    <h2 class="fw-bold text-center">{{ $fasilitasKesehatan->nama_faskes }}</h2>
                    <h3>{{ $fasilitasKesehatan->jenis }}</h3>
                    <div class="mt-3">
                         @if($fasilitasKesehatan->is_active)
                            <span class="badge bg-success px-3 py-2">Aktif</span>
                         @else
                            <span class="badge bg-danger px-3 py-2">Non-Aktif</span>
                         @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-8">
            <div class="card shadow-sm border-0" style="border-radius: 12px;">
                <div class="card-body pt-3">
                    <ul class="nav nav-tabs nav-tabs-bordered">
                        <li class="nav-item">
                            <button class="nav-link active fw-bold" data-bs-toggle="tab" data-bs-target="#profile-overview">Informasi Umum</button>
                        </li>
                    </ul>
                    <div class="tab-content pt-2">
                        <div class="tab-pane fade show active profile-overview" id="profile-overview">
                            <h5 class="card-title fw-bold">Detail Lokasi & Kontak</h5>

                            <div class="row mb-3">
                                <div class="col-lg-3 col-md-4 label fw-bold text-muted">Alamat</div>
                                <div class="col-lg-9 col-md-8">{{ $fasilitasKesehatan->alamat }}</div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-lg-3 col-md-4 label fw-bold text-muted">Kecamatan</div>
                                <div class="col-lg-9 col-md-8">{{ $fasilitasKesehatan->kecamatan }}</div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-lg-3 col-md-4 label fw-bold text-muted">Kab/Kota</div>
                                <div class="col-lg-9 col-md-8">{{ $fasilitasKesehatan->kab_kota }}</div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-lg-3 col-md-4 label fw-bold text-muted">Provinsi</div>
                                <div class="col-lg-9 col-md-8">{{ $fasilitasKesehatan->provinsi }}</div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-lg-3 col-md-4 label fw-bold text-muted">Telepon</div>
                                <div class="col-lg-9 col-md-8 text-magenta fw-bold">{{ $fasilitasKesehatan->telepon }}</div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-lg-3 col-md-4 label fw-bold text-muted">Jam Operasional</div>
                                <div class="col-lg-9 col-md-8">{{ $fasilitasKesehatan->jam_operasional }}</div>
                            </div>

                            @if($fasilitasKesehatan->embed_map)
                            <div class="row mb-3">
                                <div class="col-lg-3 col-md-4 label fw-bold text-muted">Mapping</div>
                                <div class="col-lg-9 col-md-8">
                                    <div class="ratio ratio-16x9 border rounded shadow-sm" style="overflow: hidden;">
                                        @php
                                            $cleanedMap = str_replace(['width="600"', 'height="450"'], ['width="100%"', 'height="100%"'], $fasilitasKesehatan->embed_map);
                                            // Fallback for other sizes
                                            $cleanedMap = preg_replace('/width="[0-9]*"/', 'width="100%"', $cleanedMap);
                                            $cleanedMap = preg_replace('/height="[0-9]*"/', 'height="100%"', $cleanedMap);
                                        @endphp
                                        {!! $cleanedMap !!}
                                    </div>
                                </div>
                            </div>
                            @endif

                        </div>
                    </div>
                </div>
                <div class="card-footer bg-white border-0 p-4 pt-0">
                    <a href="{{ route('fasilitas-kesehatan.edit', $fasilitasKesehatan->id) }}" class="btn text-white px-4" style="background-color: #EC1E88; border-radius: 8px;">Edit Data</a>
                    <a href="{{ route('fasilitas-kesehatan.index') }}" class="btn btn-secondary px-4" style="border-radius: 8px;">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
