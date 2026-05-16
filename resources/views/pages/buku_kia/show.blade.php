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
            <div class="col-xl-4">
                <div class="card shadow-sm border-0" style="border-radius:12px; border-top:5px solid #EC1E88 !important;">
                    <div class="card-body pt-4 d-flex flex-column align-items-center">
                        <div class="d-flex align-items-center justify-content-center mb-3" style="width:100px;height:100px;border-radius:50%;background:#fce4f1;">
                            <i class="bi bi-journal-medical" style="font-size:3rem;color:#EC1E88;"></i>
                        </div>
                        <h2 class="fw-bold text-center fs-5">{{ $bukuKia->profilIbu->nama_lengkap ?? '-' }}</h2>
                        <p class="text-muted">QR: <strong>{{ $bukuKia->qr_code }}</strong></p>
                        <span class="badge {{ $bukuKia->status === 'Aktif' ? 'bg-success' : 'bg-secondary' }} fs-6">{{ $bukuKia->status }}</span>
                    </div>
                </div>
            </div>

            <div class="col-xl-8">
                <div class="card shadow-sm border-0" style="border-radius:12px;">
                    <div class="card-body pt-3">
                        <ul class="nav nav-tabs nav-tabs-bordered">
                            <li class="nav-item">
                                <button class="nav-link active fw-bold" data-bs-toggle="tab" data-bs-target="#overview">Informasi Detail</button>
                            </li>
                        </ul>
                        <div class="tab-content pt-2">
                            <div class="tab-pane fade show active" id="overview">
                                <h5 class="card-title fw-bold">Data Buku KIA</h5>

                                @php
                                    $rows = [
                                        'Fasilitas Kesehatan' => $bukuKia->fasilitasKesehatan->nama_faskes ?? '-',
                                        'No. Reg Kohort Ibu'  => $bukuKia->no_reg_kohort_ibu,
                                        'No. Reg Kohort Bayi' => $bukuKia->no_reg_kohort_bayi,
                                        'No. Reg Kohort Balita' => $bukuKia->no_reg_kohort_balita,
                                        'Kehamilan Ke-'       => $bukuKia->kehamilan_ke,
                                        'Jumlah Anak Hidup'   => $bukuKia->jumlah_anak_hidup,
                                        'Riwayat Keguguran'   => $bukuKia->riwayat_keguguran,
                                        'Riwayat Penyakit'    => $bukuKia->riwayat_penyakit ?? '-',
                                        'No. Catatan Medik RS'=> $bukuKia->no_catatan_medik_rs ?? '-',
                                        'Diterbitkan Pada'    => $bukuKia->diterbitkan_pada,
                                        'Diterbitkan Oleh'    => $bukuKia->diterbitkan_oleh,
                                    ];
                                @endphp

                                @foreach ($rows as $label => $value)
                                    <div class="row mb-3">
                                        <div class="col-lg-4 col-md-4 label fw-bold text-muted">{{ $label }}</div>
                                        <div class="col-lg-8 col-md-8">{{ $value }}</div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-white border-0 p-4 pt-0">
                        <a href="{{ route('buku-kia.edit', $bukuKia->id) }}" class="btn text-white px-4" style="background-color:#EC1E88;border-radius:8px;">Edit Data</a>
                        <a href="{{ route('buku-kia.index') }}" class="btn btn-secondary px-4" style="border-radius:8px;">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
