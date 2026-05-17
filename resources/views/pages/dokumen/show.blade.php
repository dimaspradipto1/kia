@extends('layouts.dashboard.template')

@section('content')
    <div class="pagetitle">
        <h1>Detail Dokumen</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('dokumen.index') }}">Dokumen</a></li>
                <li class="breadcrumb-item active">Detail</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm" style="border-radius:12px; border-top:5px solid #EC1E88 !important;">
                    <div class="card-header bg-white border-bottom py-3 px-4">
                        <h5 class="m-0 fw-bold text-dark">Informasi Dokumen</h5>
                    </div>
                    <div class="card-body p-4">
                        <table class="table table-bordered table-sm align-middle">
                            <tbody>
                                <tr><th class="bg-light w-40">Nama Pemilik (Ibu)</th><td>{{ $dokumen->bukuKia->profilIbu->nama_lengkap ?? '-' }}</td></tr>
                                <tr><th class="bg-light">Jenis Dokumen</th><td>{{ $dokumen->jenis_dokumen }}</td></tr>
                                <tr>
                                    <th class="bg-light">Status Verifikasi</th>
                                    <td>
                                        @php
                                            $badgeClass = [
                                                'pending'  => 'bg-warning text-dark',
                                                'verified' => 'bg-success',
                                                'rejected' => 'bg-danger'
                                            ];
                                        @endphp
                                        <span class="badge {{ $badgeClass[$dokumen->status_verifikasi] ?? 'bg-secondary' }}">
                                            {{ ucfirst($dokumen->status_verifikasi) }}
                                        </span>
                                    </td>
                                </tr>
                                <tr><th class="bg-light">Diverifikasi Oleh</th><td>{{ $dokumen->verifikator->name ?? '-' }}</td></tr>
                                <tr><th class="bg-light">Tanggal Verifikasi</th><td>{{ $dokumen->tanggal_verifikasi ? \Carbon\Carbon::parse($dokumen->tanggal_verifikasi)->translatedFormat('d F Y') : '-' }}</td></tr>
                                <tr>
                                    <th class="bg-light">Berkas</th>
                                    <td>
                                        <a href="{{ asset('storage/' . $dokumen->file) }}" target="_blank" class="btn btn-sm btn-primary">
                                            <i class="bi bi-download"></i> Unduh / Lihat File
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        @if(Str::endsWith($dokumen->file, ['.jpg', '.jpeg', '.png']))
                            <div class="mt-4 text-center">
                                <h6 class="fw-bold">Pratinjau Gambar:</h6>
                                <img src="{{ asset('storage/' . $dokumen->file) }}" alt="Preview" class="img-fluid border rounded shadow-sm" style="max-height: 400px;">
                            </div>
                        @elseif(Str::endsWith($dokumen->file, ['.pdf']))
                            <div class="mt-4">
                                <h6 class="fw-bold">Pratinjau PDF:</h6>
                                <iframe src="{{ asset('storage/' . $dokumen->file) }}" width="100%" height="500px" class="border rounded shadow-sm"></iframe>
                            </div>
                        @endif
                    </div>
                    <div class="card-footer bg-white border-0 p-4 pt-0 text-end">
                        <a href="{{ route('dokumen.edit', $dokumen->id) }}" class="btn text-white px-4 me-2"
                           style="background-color:#EC1E88; border-radius:8px;">Edit / Verifikasi</a>
                        <a href="{{ route('dokumen.index') }}" class="btn btn-secondary px-4"
                           style="border-radius:8px;">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>.w-40 { width: 40%; }</style>
@endsection
