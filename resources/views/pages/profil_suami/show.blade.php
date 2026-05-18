@extends('layouts.dashboard.template')

@section('content')
    <div class="pagetitle">
        <h1>Detail Profil Suami</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('profil-suami.index') }}">Profil Suami</a></li>
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
                            <i class="bi bi-person-badge" style="font-size:2rem;color:#EC1E88;"></i>
                        </div>
                        <h5 class="fw-bold text-center mb-0">{{ $profilSuami->nama_lengkap }}</h5>
                        <p class="text-muted small mb-1">NIK: {{ $profilSuami->nik }}</p>
                    </div>
                </div>
            </div>

            <div class="col-xl-9">
                <div class="card shadow-sm border-0" style="border-radius: 12px;">
                    <div class="card-body pt-3">
                        <ul class="nav nav-tabs nav-tabs-bordered">
                            <li class="nav-item">
                                <button class="nav-link active fw-bold" data-bs-toggle="tab" data-bs-target="#profile-overview">Informasi Detail</button>
                            </li>
                        </ul>
                        <div class="tab-content pt-2">
                            <div class="tab-pane fade show active profile-overview" id="profile-overview">
                                <h5 class="card-title fw-bold">Profil Suami</h5>

                                <div class="row mb-3">
                                    <div class="col-lg-3 col-md-4 label fw-bold text-muted">Nama Istri</div>
                                    <div class="col-lg-9 col-md-8">
                                        <a href="{{ route('profil-ibu.show', $profilSuami->profil_ibu_id) }}" class="text-magenta fw-bold">
                                            {{ $profilSuami->profilIbu->nama_lengkap ?? '-' }}
                                        </a>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-lg-3 col-md-4 label fw-bold text-muted">NIK</div>
                                    <div class="col-lg-9 col-md-8">{{ $profilSuami->nik }}</div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-lg-3 col-md-4 label fw-bold text-muted">Tempat, Tgl Lahir</div>
                                    <div class="col-lg-9 col-md-8">
                                        {{ $profilSuami->tempat_lahir }}, {{ \Carbon\Carbon::parse($profilSuami->tanggal_lahir)->translatedFormat('d F Y') }}
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-lg-3 col-md-4 label fw-bold text-muted">Golongan Darah</div>
                                    <div class="col-lg-9 col-md-8">{{ $profilSuami->golongan_darah ?? '-' }}</div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-lg-3 col-md-4 label fw-bold text-muted">Pendidikan</div>
                                    <div class="col-lg-9 col-md-8">{{ $profilSuami->pendidikan ?? '-' }}</div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-lg-3 col-md-4 label fw-bold text-muted">Pekerjaan</div>
                                    <div class="col-lg-9 col-md-8">{{ $profilSuami->pekerjaan ?? '-' }}</div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-lg-3 col-md-4 label fw-bold text-muted">WhatsApp</div>
                                    <div class="col-lg-9 col-md-8 text-magenta fw-bold">{{ $profilSuami->nomor_wa ?? '-' }}</div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-white border-0 p-4 pt-0">
                        <a href="{{ route('profil-suami.edit', $profilSuami->id) }}" class="btn text-white px-4" style="background-color: #EC1E88; border-radius: 8px;">Edit Data</a>
                        <a href="{{ route('profil-suami.index') }}" class="btn btn-secondary px-4" style="border-radius: 8px;">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
