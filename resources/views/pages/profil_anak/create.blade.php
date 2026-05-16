@extends('layouts.dashboard.template')

@section('content')
    <div class="pagetitle">
        <h1>Tambah Profil Anak</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('profil-anak.index') }}">Profil Anak</a></li>
                <li class="breadcrumb-item active">Tambah</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px; border-top: 5px solid #EC1E88 !important;">
                    <div class="card-header bg-white border-bottom py-3 px-4">
                        <h5 class="m-0 fw-bold text-dark">Form Tambah Profil Anak</h5>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('profil-anak.store') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label fw-bold">Buku KIA (Nama Ibu)</label>
                                <select name="buku_kia_id" class="form-select select2 @error('buku_kia_id') is-invalid @enderror" data-placeholder="Pilih Buku KIA" required>
                                    <option value="">Pilih Buku KIA</option>
                                    @foreach ($bukuKia as $b)
                                        <option value="{{ $b->id }}" {{ old('buku_kia_id') == $b->id ? 'selected' : '' }}>
                                            {{ $b->profilIbu->nama_lengkap ?? '-' }} (No. Reg: {{ $b->no_reg_kohort_bayi }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('buku_kia_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Nama Lengkap Anak</label>
                                    <input type="text" name="nama_lengkap" class="form-control @error('nama_lengkap') is-invalid @enderror" value="{{ old('nama_lengkap') }}" required>
                                    @error('nama_lengkap') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label fw-bold">Jenis Kelamin</label>
                                    <select name="jenis_kelamin" class="form-select select2 @error('jenis_kelamin') is-invalid @enderror" data-placeholder="Pilih" required>
                                        <option value="">Pilih</option>
                                        <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                    @error('jenis_kelamin') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label fw-bold">Anak Ke-</label>
                                    <input type="number" name="anak_ke" class="form-control @error('anak_ke') is-invalid @enderror" value="{{ old('anak_ke') }}" min="1" required>
                                    @error('anak_ke') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Tempat Lahir</label>
                                    <input type="text" name="tempat_lahir" class="form-control @error('tempat_lahir') is-invalid @enderror" value="{{ old('tempat_lahir') }}" required>
                                    @error('tempat_lahir') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Tanggal Lahir</label>
                                    <input type="text" name="tanggal_lahir" class="form-control datepicker @error('tanggal_lahir') is-invalid @enderror" value="{{ old('tanggal_lahir') }}" required placeholder="Pilih Tanggal">
                                    @error('tanggal_lahir') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-bold">Golongan Darah</label>
                                    <select name="golongan_darah" class="form-select select2" data-placeholder="Pilih">
                                        <option value="">Pilih</option>
                                        @foreach(['A', 'B', 'AB', 'O'] as $g)
                                            <option value="{{ $g }}" {{ old('golongan_darah') == $g ? 'selected' : '' }}>{{ $g }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-bold">Berat Lahir (kg)</label>
                                    <input type="number" step="0.01" name="berat_lahir_kg" class="form-control" value="{{ old('berat_lahir_kg') }}" placeholder="cth: 3.2">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-bold">Panjang Lahir (cm)</label>
                                    <input type="number" step="0.1" name="panjang_lahir_cm" class="form-control" value="{{ old('panjang_lahir_cm') }}" placeholder="cth: 50">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Nomor Akta Kelahiran</label>
                                <input type="text" name="nomor_akta_kelahiran" class="form-control" value="{{ old('nomor_akta_kelahiran') }}">
                            </div>

                            <div class="row mt-4">
                                <div class="col-12 text-end">
                                    <a href="{{ route('profil-anak.index') }}" class="btn btn-light border px-4 me-2" style="border-radius: 8px;">Batal</a>
                                    <button type="submit" class="btn text-white px-4" style="background-color: #EC1E88; border-radius: 8px;">Simpan Profil Anak</button>
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
            document.addEventListener('DOMContentLoaded', function () {
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
