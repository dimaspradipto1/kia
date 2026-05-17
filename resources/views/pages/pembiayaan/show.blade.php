@extends('layouts.dashboard.template')

@section('content')
    <div class="pagetitle">
        <h1>Detail Pembiayaan</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('pembiayaan.index') }}">Pembiayaan</a></li>
                <li class="breadcrumb-item active">Detail</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm" style="border-radius:12px; border-top:5px solid #EC1E88 !important;">
                    <div class="card-header bg-white border-bottom py-3 px-4">
                        <h5 class="m-0 fw-bold text-dark">Informasi Pembiayaan</h5>
                    </div>
                    <div class="card-body p-4">
                        <table class="table table-bordered table-sm align-middle">
                            <tbody>
                                <tr><th class="bg-light w-40">Nama Ibu</th><td>{{ $pembiayaan->profilIbu->nama_lengkap ?? '-' }}</td></tr>
                                <tr><th class="bg-light">Jenis Pembiayaan</th><td>{{ $pembiayaan->jenis_pembiayaan }}</td></tr>
                                <tr><th class="bg-light">Nama Asuransi</th><td>{{ $pembiayaan->nama_asuransi ?? '-' }}</td></tr>
                                <tr><th class="bg-light">Nomor Polis</th><td>{{ $pembiayaan->nomor_polis ?? '-' }}</td></tr>
                                <tr>
                                    <th class="bg-light">Tanggal Berlaku</th>
                                    <td>{{ $pembiayaan->tanggal_berlaku ? $pembiayaan->tanggal_berlaku->translatedFormat('d F Y') : '-' }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Status</th>
                                    <td>
                                        @if($pembiayaan->is_active)
                                            <span class="badge bg-success">Aktif</span>
                                        @else
                                            <span class="badge bg-secondary">Tidak Aktif</span>
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer bg-white border-0 p-4 pt-0">
                        <a href="{{ route('pembiayaan.edit', $pembiayaan->id) }}" class="btn text-white px-4 me-2"
                           style="background-color:#EC1E88; border-radius:8px;">Edit Data</a>
                        <a href="{{ route('pembiayaan.index') }}" class="btn btn-secondary px-4"
                           style="border-radius:8px;">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>.w-40 { width: 40%; }</style>
@endsection
