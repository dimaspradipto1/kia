@extends('layouts.dashboard.template')

@section('content')
    <div class="pagetitle">
        <h1>Detail Buku KIA</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('buku-kia.index') }}">Buku KIA</a></li>
                <li class="breadcrumb-item active">Detail</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            {{-- Card Kiri --}}
            <div class="col-xl-4">
                <div class="card shadow-sm border-0" style="border-radius:12px; border-top:5px solid #EC1E88 !important;">
                    <div class="card-body pt-4 d-flex flex-column align-items-center">
                        <div class="d-flex align-items-center justify-content-center mb-3"
                             style="width:100px;height:100px;border-radius:50%;background:#fce4f1;">
                            <i class="bi bi-journal-medical" style="font-size:3rem;color:#EC1E88;"></i>
                        </div>
                        <h2 class="fw-bold text-center fs-5">{{ $bukuKia->profilIbu->nama_lengkap ?? '-' }}</h2>
                        <p class="text-muted small">QR: <strong>{{ $bukuKia->qr_code }}</strong></p>
                        <span class="badge {{ $bukuKia->status === 'Aktif' ? 'bg-success' : 'bg-secondary' }} fs-6">
                            {{ $bukuKia->status }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- Card Kanan --}}
            <div class="col-xl-8">
                <div class="card shadow-sm border-0" style="border-radius:12px;">
                    <div class="card-body pt-3">
                        <ul class="nav nav-tabs nav-tabs-bordered">
                            <li class="nav-item">
                                <button class="nav-link active fw-bold" data-bs-toggle="tab" data-bs-target="#tab-buku">Buku KIA</button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link fw-bold" data-bs-toggle="tab" data-bs-target="#tab-ibu">Profil Ibu</button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link fw-bold" data-bs-toggle="tab" data-bs-target="#tab-suami">Profil Suami</button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link fw-bold" data-bs-toggle="tab" data-bs-target="#tab-anak">Profil Anak</button>
                            </li>
                        </ul>

                        <div class="tab-content pt-3">

                            {{-- Tab Buku KIA --}}
                            <div class="tab-pane fade show active" id="tab-buku">
                                <h5 class="fw-bold mb-3">Data Buku KIA</h5>
                                <table class="table table-bordered table-hover table-sm align-middle">
                                    <tbody>
                                        <tr><th class="bg-light w-40">Fasilitas Kesehatan</th><td>{{ $bukuKia->fasilitasKesehatan->nama_faskes ?? '-' }}</td></tr>
                                        <tr><th class="bg-light">No. Reg Kohort Ibu</th><td>{{ $bukuKia->no_reg_kohort_ibu }}</td></tr>
                                        <tr><th class="bg-light">No. Reg Kohort Bayi</th><td>{{ $bukuKia->no_reg_kohort_bayi }}</td></tr>
                                        <tr><th class="bg-light">No. Reg Kohort Balita</th><td>{{ $bukuKia->no_reg_kohort_balita }}</td></tr>
                                        <tr><th class="bg-light">Kehamilan Ke-</th><td>{{ $bukuKia->kehamilan_ke }}</td></tr>
                                        <tr><th class="bg-light">Jumlah Anak Hidup</th><td>{{ $bukuKia->jumlah_anak_hidup }}</td></tr>
                                        <tr><th class="bg-light">Riwayat Keguguran</th><td>{{ $bukuKia->riwayat_keguguran }}</td></tr>
                                        <tr><th class="bg-light">Riwayat Penyakit</th><td>{{ $bukuKia->riwayat_penyakit ?? '-' }}</td></tr>
                                        <tr><th class="bg-light">No. Catatan Medik RS</th><td>{{ $bukuKia->no_catatan_medik_rs ?? '-' }}</td></tr>
                                        <tr><th class="bg-light">Diterbitkan Pada</th><td>{{ $bukuKia->diterbitkan_pada }}</td></tr>
                                        <tr><th class="bg-light">Diterbitkan Oleh</th><td>{{ $bukuKia->diterbitkan_oleh }}</td></tr>
                                    </tbody>
                                </table>
                            </div>

                            {{-- Tab Profil Ibu --}}
                            <div class="tab-pane fade" id="tab-ibu">
                                @if($bukuKia->profilIbu)
                                    @php $ibu = $bukuKia->profilIbu; @endphp
                                    <h5 class="fw-bold mb-3">Data Profil Ibu</h5>
                                    <table class="table table-bordered table-hover table-sm align-middle">
                                        <tbody>
                                            <tr><th class="bg-light w-40">NIK</th><td>{{ $ibu->nik }}</td></tr>
                                            <tr><th class="bg-light">Nama Lengkap</th><td>{{ $ibu->nama_lengkap }}</td></tr>
                                            <tr><th class="bg-light">Tempat Lahir</th><td>{{ $ibu->tempat_lahir }}</td></tr>
                                            <tr><th class="bg-light">Tanggal Lahir</th><td>{{ $ibu->tanggal_lahir ? \Carbon\Carbon::parse($ibu->tanggal_lahir)->translatedFormat('d F Y') : '-' }}</td></tr>
                                            <tr><th class="bg-light">Golongan Darah</th><td>{{ $ibu->golongan_darah ?? '-' }}</td></tr>
                                            <tr><th class="bg-light">Pendidikan</th><td>{{ $ibu->pendidikan ?? '-' }}</td></tr>
                                            <tr><th class="bg-light">Pekerjaan</th><td>{{ $ibu->pekerjaan ?? '-' }}</td></tr>
                                            <tr><th class="bg-light">Agama</th><td>{{ $ibu->agama ?? '-' }}</td></tr>
                                            <tr><th class="bg-light">Alamat</th><td>{{ $ibu->alamat ?? '-' }}</td></tr>
                                            <tr><th class="bg-light">No. WhatsApp</th><td>{{ $ibu->nomor_wa ?? '-' }}</td></tr>
                                            <tr><th class="bg-light">No. JKN</th><td>{{ $ibu->nomor_jkn ?? '-' }}</td></tr>
                                            <tr><th class="bg-light">Nama Puskesmas</th><td>{{ $ibu->nama_puskesmas ?? '-' }}</td></tr>
                                        </tbody>
                                    </table>
                                @else
                                    <div class="text-center text-muted py-4">
                                        <i class="bi bi-person-x fs-1"></i>
                                        <p class="mt-2">Data profil ibu belum tersedia.</p>
                                    </div>
                                @endif
                            </div>

                            {{-- Tab Profil Suami --}}
                            <div class="tab-pane fade" id="tab-suami">
                                @if($bukuKia->profilSuami)
                                    @php $suami = $bukuKia->profilSuami; @endphp
                                    <h5 class="fw-bold mb-3">Data Profil Suami</h5>
                                    <table class="table table-bordered table-hover table-sm align-middle">
                                        <tbody>
                                            <tr><th class="bg-light w-40">NIK</th><td>{{ $suami->nik }}</td></tr>
                                            <tr><th class="bg-light">Nama Lengkap</th><td>{{ $suami->nama_lengkap }}</td></tr>
                                            <tr><th class="bg-light">Tempat Lahir</th><td>{{ $suami->tempat_lahir ?? '-' }}</td></tr>
                                            <tr><th class="bg-light">Tanggal Lahir</th><td>{{ $suami->tanggal_lahir ? \Carbon\Carbon::parse($suami->tanggal_lahir)->translatedFormat('d F Y') : '-' }}</td></tr>
                                            <tr><th class="bg-light">Golongan Darah</th><td>{{ $suami->golongan_darah ?? '-' }}</td></tr>
                                            <tr><th class="bg-light">Pendidikan</th><td>{{ $suami->pendidikan ?? '-' }}</td></tr>
                                            <tr><th class="bg-light">Pekerjaan</th><td>{{ $suami->pekerjaan ?? '-' }}</td></tr>
                                            <tr><th class="bg-light">No. WhatsApp</th><td>{{ $suami->nomor_wa ?? '-' }}</td></tr>
                                        </tbody>
                                    </table>
                                @else
                                    <div class="text-center text-muted py-4">
                                        <i class="bi bi-person-x fs-1"></i>
                                        <p class="mt-2">Data profil suami belum tersedia.</p>
                                    </div>
                                @endif
                            </div>

                            {{-- Tab Profil Anak --}}
                            <div class="tab-pane fade" id="tab-anak">
                                <h5 class="fw-bold mb-3">Data Profil Anak</h5>
                                @if($bukuKia->profilAnak->count() > 0)
                                    @foreach($bukuKia->profilAnak as $index => $anak)
                                        <div class="mb-3">
                                            <div class="fw-bold text-white px-3 py-2 mb-0 rounded-top" style="background:#EC1E88;">
                                                Anak ke-{{ $index + 1 }}: {{ $anak->nama_anak }}
                                            </div>
                                            <table class="table table-bordered table-sm align-middle mb-0">
                                                <tbody>
                                                    <tr><th class="bg-light w-40">Tanggal Lahir</th><td>{{ $anak->tanggal_lahir ? \Carbon\Carbon::parse($anak->tanggal_lahir)->translatedFormat('d F Y') : '-' }}</td></tr>
                                                    <tr><th class="bg-light">Jenis Kelamin</th><td>{{ $anak->jenis_kelamin ?? '-' }}</td></tr>
                                                    <tr><th class="bg-light">Berat Lahir</th><td>{{ $anak->berat_lahir ?? '-' }} gram</td></tr>
                                                    <tr><th class="bg-light">Panjang Lahir</th><td>{{ $anak->panjang_lahir ?? '-' }} cm</td></tr>
                                                    <tr><th class="bg-light">Golongan Darah</th><td>{{ $anak->golongan_darah ?? '-' }}</td></tr>
                                                    <tr><th class="bg-light">Tempat Lahir</th><td>{{ $anak->tempat_lahir ?? '-' }}</td></tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="text-center text-muted py-4">
                                        <i class="bi bi-person-x fs-1"></i>
                                        <p class="mt-2">Belum ada data profil anak.</p>
                                    </div>
                                @endif
                            </div>

                        </div>{{-- end tab-content --}}
                    </div>
                    <div class="card-footer bg-white border-0 p-4 pt-0">
                        <a href="{{ route('buku-kia.edit', $bukuKia->id) }}" class="btn text-white px-4"
                           style="background-color:#EC1E88;border-radius:8px;">Edit Data</a>
                        <a href="{{ route('buku-kia.index') }}" class="btn btn-secondary px-4"
                           style="border-radius:8px;">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
        .w-40 { width: 40%; }
    </style>
@endsection
