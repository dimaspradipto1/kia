@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Detail Profil Ibu</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('profil-ibu.index') }}">Profil Ibu</a></li>
            <li class="breadcrumb-item active">Detail</li>
        </ol>
    </nav>
</div>

<section class="section profile">
    <div class="row">
        <div class="col-xl-3">
            <div class="card shadow-sm border-0" style="border-radius: 12px; border-top: 5px solid #EC1E88 !important;">
                <div class="card-body profile-card pt-3 d-flex flex-column align-items-center">
                    <div class="d-flex align-items-center justify-content-center mb-2" style="width:72px;height:72px;border-radius:50%;background:#fce4f1;">
                        <i class="bi bi-person-fill" style="font-size:2rem;color:#EC1E88;"></i>
                    </div>
                    <h5 class="fw-bold text-center mb-0">{{ $profilIbu->nama_lengkap }}</h5>
                    <p class="text-muted small mb-1">NIK: {{ $profilIbu->nik }}</p>
                    <div class="mt-3 text-center">
                        <div class="small text-muted mb-1">Terdaftar di:</div>
                        <div class="fw-bold text-magenta">{{ $profilIbu->fasilitasKesehatan->nama_faskes ?? 'Faskes tidak ditemukan' }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-9">
            <div class="card shadow-sm border-0" style="border-radius: 12px;">
                <div class="card-body pt-3">
                    <ul class="nav nav-tabs nav-tabs-bordered">
                        <li class="nav-item">
                            <button class="nav-link active fw-bold" data-bs-toggle="tab" data-bs-target="#profile-overview">Biodata Lengkap</button>
                        </li>
                    </ul>
                    <div class="tab-content pt-2">
                        <div class="tab-pane fade show active profile-overview" id="profile-overview">
                            <h5 class="card-title fw-bold">Informasi Pribadi</h5>

                            <div class="row mb-3">
                                <div class="col-lg-3 col-md-4 label fw-bold text-muted">Tempat, Tgl Lahir</div>
                                <div class="col-lg-9 col-md-8">{{ $profilIbu->tempat_lahir }}, {{ \Carbon\Carbon::parse($profilIbu->tanggal_lahir)->format('d F Y') }}</div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-lg-3 col-md-4 label fw-bold text-muted">Nama Ibu Kandung</div>
                                <div class="col-lg-9 col-md-8">{{ $profilIbu->nama_ibu_kandung ?? '-' }}</div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-lg-3 col-md-4 label fw-bold text-muted">Golongan Darah</div>
                                <div class="col-lg-9 col-md-8"><span class="badge bg-danger px-3">{{ $profilIbu->golongan_darah ?? '-' }}</span></div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-lg-3 col-md-4 label fw-bold text-muted">Pendidikan</div>
                                <div class="col-lg-9 col-md-8">{{ $profilIbu->pendidikan ?? '-' }}</div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-lg-3 col-md-4 label fw-bold text-muted">Pekerjaan</div>
                                <div class="col-lg-9 col-md-8">{{ $profilIbu->pekerjaan ?? '-' }}</div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-lg-3 col-md-4 label fw-bold text-muted">Agama</div>
                                <div class="col-lg-9 col-md-8">{{ $profilIbu->agama ?? '-' }}</div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-lg-3 col-md-4 label fw-bold text-muted">WhatsApp</div>
                                <div class="col-lg-9 col-md-8 text-success fw-bold">{{ $profilIbu->nomor_wa ?? '-' }}</div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-lg-3 col-md-4 label fw-bold text-muted">Alamat</div>
                                <div class="col-lg-9 col-md-8">{{ $profilIbu->alamat ?? '-' }}</div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-lg-3 col-md-4 label fw-bold text-muted">No. JKN/BPJS</div>
                                <div class="col-lg-9 col-md-8">{{ $profilIbu->nomor_jkn ?? '-' }}</div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="card-footer bg-white border-0 p-4 pt-0">
                    <a href="{{ route('profil-ibu.edit', $profilIbu->id) }}" class="btn text-white px-4" style="background-color: #EC1E88; border-radius: 8px;">Edit Profil</a>
                    <a href="{{ route('profil-ibu.index') }}" class="btn btn-secondary px-4" style="border-radius: 8px;">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
