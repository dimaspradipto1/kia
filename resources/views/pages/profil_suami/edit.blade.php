@extends('layouts.dashboard.template')

@section('content')
    <div class="pagetitle">
        <h1>Edit Profil Suami</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('profil-suami.index') }}">Profil Suami</a></li>
                <li class="breadcrumb-item active">Edit</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px; border-top: 5px solid #EC1E88 !important;">
                    <div class="card-header bg-white border-bottom py-3 px-4">
                        <h5 class="m-0 fw-bold text-dark">Form Edit Profil Suami</h5>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('profil-suami.update', $profilSuami->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <label class="form-label fw-bold">Pilih Istri (Profil Ibu)</label>
                                    <select name="profil_ibu_id" class="form-select @error('profil_ibu_id') is-invalid @enderror" required>
                                        <option value="">Pilih Istri</option>
                                        @foreach ($ibu as $i)
                                            <option value="{{ $i->id }}" {{ old('profil_ibu_id', $profilSuami->profil_ibu_id) == $i->id ? 'selected' : '' }}>
                                                {{ $i->nama_lengkap }} (NIK: {{ $i->nik }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('profil_ibu_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">NIK Suami</label>
                                    <input type="number" name="nik" class="form-control @error('nik') is-invalid @enderror" value="{{ old('nik', $profilSuami->nik) }}" required>
                                    @error('nik') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Nama Lengkap Suami</label>
                                    <input type="text" name="nama_lengkap" class="form-control @error('nama_lengkap') is-invalid @enderror" value="{{ old('nama_lengkap', $profilSuami->nama_lengkap) }}" required>
                                    @error('nama_lengkap') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Tempat Lahir</label>
                                    <input type="text" name="tempat_lahir" class="form-control @error('tempat_lahir') is-invalid @enderror" value="{{ old('tempat_lahir', $profilSuami->tempat_lahir) }}" required>
                                    @error('tempat_lahir') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Tanggal Lahir</label>
                                    <input type="text" name="tanggal_lahir" class="form-control datepicker @error('tanggal_lahir') is-invalid @enderror" value="{{ old('tanggal_lahir', $profilSuami->tanggal_lahir) }}" required placeholder="Pilih Tanggal">
                                    @error('tanggal_lahir') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-bold">Golongan Darah</label>
                                    <select name="golongan_darah" class="form-select">
                                        <option value="">Pilih</option>
                                        @foreach(['A', 'B', 'AB', 'O'] as $g)
                                            <option value="{{ $g }}" {{ old('golongan_darah', $profilSuami->golongan_darah) == $g ? 'selected' : '' }}>{{ $g }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-bold">Pendidikan Terakhir</label>
                                    <select name="pendidikan" class="form-select">
                                        <option value="">Pilih Pendidikan</option>
                                        @foreach(['Tidak Sekolah', 'SD', 'SMP', 'SMA', 'D3', 'S1', 'S2', 'S3'] as $p)
                                            <option value="{{ $p }}" {{ old('pendidikan', $profilSuami->pendidikan) == $p ? 'selected' : '' }}>{{ $p }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-bold">Pekerjaan</label>
                                    <input type="text" name="pekerjaan" class="form-control" value="{{ old('pekerjaan', $profilSuami->pekerjaan) }}">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Nomor WhatsApp</label>
                                <input type="number" name="nomor_wa" class="form-control @error('nomor_wa') is-invalid @enderror" value="{{ old('nomor_wa', $profilSuami->nomor_wa) }}">
                                @error('nomor_wa') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="row mt-4">
                                <div class="col-12 text-end">
                                    <a href="{{ route('profil-suami.index') }}" class="btn btn-light border px-4 me-2" style="border-radius: 8px;">Batal</a>
                                    <button type="submit" class="btn text-white px-4" style="background-color: #EC1E88; border-radius: 8px;">Perbarui Profil Suami</button>
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
                flatpickr(".datepicker", {
                    locale: "id",
                    dateFormat: "Y-m-d",
                    altInput: true,
                    altFormat: "d F Y",
                    allowInput: true
                });
            });
        </script>
    @endpush
@endsection
