@extends('layouts.dashboard.template')

@section('content')
    <div class="pagetitle">
        <h1>Tambah Profil Ibu</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('profil-ibu.index') }}">Profil Ibu</a></li>
                <li class="breadcrumb-item active">Tambah</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card border-0 shadow-sm mb-4"
                    style="border-radius: 12px; overflow: hidden; border-top: 5px solid #EC1E88 !important;">
                    <div class="card-header bg-white border-bottom py-3 px-4">
                        <h5 class="m-0 fw-bold text-dark" style="font-size: 1.1rem;">Form Tambah Profil Ibu</h5>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('profil-ibu.store') }}" method="POST">
                            @csrf
                            <div class="row mb-4">
                                <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label fw-bold">Fasilitas Kesehatan</label>
                                    <select name="fasilitas_kesehatan_id"
                                        class="form-select @error('fasilitas_kesehatan_id') is-invalid @enderror" required>
                                        <option value="">Pilih Faskes</option>
                                        @foreach ($faskes as $f)
                                            <option value="{{ $f->id }}"
                                                {{ old('fasilitas_kesehatan_id') == $f->id ? 'selected' : '' }}>
                                                {{ $f->nama_faskes }}</option>
                                        @endforeach
                                    </select>
                                    @error('fasilitas_kesehatan_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">NIK</label>
                                    <input type="number" name="nik"
                                        class="form-control @error('nik') is-invalid @enderror" value="{{ old('nik') }}"
                                        required>
                                    @error('nik') <div class="invalid-feedback text-danger" style="font-size: 0.8rem;">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Nama Lengkap</label>
                                    <input type="text" name="nama_lengkap"
                                        class="form-control @error('nama_lengkap') is-invalid @enderror"
                                        value="{{ old('nama_lengkap') }}" required>
                                    @error('nama_lengkap') <div class="invalid-feedback text-danger" style="font-size: 0.8rem;">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Tempat Lahir</label>
                                    <input type="text" name="tempat_lahir" class="form-control"
                                        value="{{ old('tempat_lahir') }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Tanggal Lahir</label>
                                    <input type="text" name="tanggal_lahir" class="form-control datepicker"
                                        value="{{ old('tanggal_lahir') }}" required placeholder="Pilih Tanggal">
                                </div>
                            </div>

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

                            <div class="row mb-3">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-bold">Golongan Darah</label>
                                    <select name="golongan_darah" class="form-select">
                                        <option value="">Pilih</option>
                                        <option value="A" {{ old('golongan_darah') == 'A' ? 'selected' : '' }}>A</option>
                                        <option value="B" {{ old('golongan_darah') == 'B' ? 'selected' : '' }}>B</option>
                                        <option value="AB" {{ old('golongan_darah') == 'AB' ? 'selected' : '' }}>AB</option>
                                        <option value="O" {{ old('golongan_darah') == 'O' ? 'selected' : '' }}>O</option>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-bold">Pendidikan</label>
                                    <select name="pendidikan" class="form-select">
                                        <option value="">Pilih Pendidikan</option>
                                        @foreach(['Tidak Sekolah', 'SD', 'SMP', 'SMA', 'D3', 'S1', 'S2', 'S3'] as $p)
                                            <option value="{{ $p }}" {{ old('pendidikan') == $p ? 'selected' : '' }}>{{ $p }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-bold">Pekerjaan</label>
                                    <input type="text" name="pekerjaan" class="form-control"
                                        value="{{ old('pekerjaan') }}">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Agama</label>
                                    <select name="agama" class="form-select">
                                        <option value="">Pilih Agama</option>
                                        @foreach(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Budha', 'Khonghucu'] as $a)
                                            <option value="{{ $a }}" {{ old('agama', 'Islam') == $a ? 'selected' : '' }}>{{ $a }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Nomor WhatsApp</label>
                                    <input type="number" name="nomor_wa" class="form-control @error('nomor_wa') is-invalid @enderror"
                                        value="{{ old('nomor_wa') }}">
                                    @error('nomor_wa') <div class="invalid-feedback text-danger" style="font-size: 0.8rem;">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Alamat Lengkap</label>
                                <textarea name="alamat" class="form-control" rows="3">{{ old('alamat') }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Nomor JKN/BPJS (Opsional)</label>
                                <input type="number" name="nomor_jkn" class="form-control @error('nomor_jkn') is-invalid @enderror"
                                    value="{{ old('nomor_jkn') }}">
                                @error('nomor_jkn') <div class="invalid-feedback text-danger" style="font-size: 0.8rem;">{{ $message }}</div> @enderror
                            </div>

                            <div class="row mt-4">
                                <div class="col-12">
                                    <button type="submit" class="btn text-white px-4"
                                        style="background-color: #EC1E88; border-radius: 8px;">Simpan Profil</button>
                                    <a href="{{ route('profil-ibu.index') }}" class="btn btn-light border px-4"
                                        style="border-radius: 8px;">Batal</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
