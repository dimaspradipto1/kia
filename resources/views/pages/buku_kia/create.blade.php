@extends('layouts.dashboard.template')

@section('content')
    <div class="pagetitle">
        <h1>Tambah Buku KIA</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('buku-kia.index') }}">Buku KIA</a></li>
                <li class="breadcrumb-item active">Tambah</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px; border-top: 5px solid #EC1E88 !important;">
                    <div class="card-header bg-white border-bottom py-3 px-4">
                        <h5 class="m-0 fw-bold text-dark">Form Tambah Buku KIA</h5>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('buku-kia.store') }}" method="POST">
                            @csrf

                            {{-- Relasi --}}
                            <div class="row mb-3">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Nama Ibu</label>
                                    <select name="profil_ibu_id" class="form-select select2 @error('profil_ibu_id') is-invalid @enderror" data-placeholder="Pilih Profil Ibu" required>
                                        <option value="">Pilih Profil Ibu</option>
                                        @foreach ($ibu as $i)
                                            <option value="{{ $i->id }}" {{ old('profil_ibu_id') == $i->id ? 'selected' : '' }}>
                                                {{ $i->nama_lengkap }} (NIK: {{ $i->nik }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('profil_ibu_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Fasilitas Kesehatan</label>
                                    <select name="fasilitas_kesehatan_id" class="form-select select2 @error('fasilitas_kesehatan_id') is-invalid @enderror" data-placeholder="Pilih Faskes" required>
                                        <option value="">Pilih Faskes</option>
                                        @foreach ($faskes as $f)
                                            <option value="{{ $f->id }}" {{ old('fasilitas_kesehatan_id') == $f->id ? 'selected' : '' }}>
                                                {{ $f->nama_faskes }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('fasilitas_kesehatan_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            {{-- No Registrasi --}}
                            <div class="row mb-3">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-bold">No. Reg Kohort Ibu</label>
                                    <input type="text" name="no_reg_kohort_ibu" class="form-control @error('no_reg_kohort_ibu') is-invalid @enderror" value="{{ old('no_reg_kohort_ibu') }}" required>
                                    @error('no_reg_kohort_ibu') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-bold">No. Reg Kohort Bayi</label>
                                    <input type="text" name="no_reg_kohort_bayi" class="form-control @error('no_reg_kohort_bayi') is-invalid @enderror" value="{{ old('no_reg_kohort_bayi') }}" required>
                                    @error('no_reg_kohort_bayi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-bold">No. Reg Kohort Balita</label>
                                    <input type="text" name="no_reg_kohort_balita" class="form-control @error('no_reg_kohort_balita') is-invalid @enderror" value="{{ old('no_reg_kohort_balita') }}" required>
                                    @error('no_reg_kohort_balita') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            {{-- Riwayat Kehamilan --}}
                            <div class="row mb-3">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-bold">Kehamilan Ke-</label>
                                    <input type="number" name="kehamilan_ke" class="form-control @error('kehamilan_ke') is-invalid @enderror" value="{{ old('kehamilan_ke') }}" min="1" required>
                                    @error('kehamilan_ke') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-bold">Jumlah Anak Hidup</label>
                                    <input type="number" name="jumlah_anak_hidup" class="form-control @error('jumlah_anak_hidup') is-invalid @enderror" value="{{ old('jumlah_anak_hidup') }}" min="0" required>
                                    @error('jumlah_anak_hidup') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-bold">Riwayat Keguguran</label>
                                    <input type="text" name="riwayat_keguguran" class="form-control @error('riwayat_keguguran') is-invalid @enderror" value="{{ old('riwayat_keguguran') }}" placeholder="cth: Tidak Ada / 1x" required>
                                    @error('riwayat_keguguran') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            {{-- Catatan Medis --}}
                            <div class="row mb-3">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Riwayat Penyakit</label>
                                    <input type="text" name="riwayat_penyakit" class="form-control" value="{{ old('riwayat_penyakit') }}" placeholder="cth: Hipertensi, Diabetes (opsional)">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">No. Catatan Medik RS</label>
                                    <input type="text" name="no_catatan_medik_rs" class="form-control" value="{{ old('no_catatan_medik_rs') }}">
                                </div>
                            </div>

                            {{-- Penerbitan & Status --}}
                            <div class="row mb-3">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-bold">Status</label>
                                    <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                                        <option value="">Pilih Status</option>
                                        <option value="Aktif" {{ old('status') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                        <option value="Tidak Aktif" {{ old('status') == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                                    </select>
                                    @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-bold">Diterbitkan Pada</label>
                                    <input type="text" name="diterbitkan_pada" class="form-control @error('diterbitkan_pada') is-invalid @enderror" value="{{ old('diterbitkan_pada') }}" placeholder="cth: Puskesmas Kedaton" required>
                                    @error('diterbitkan_pada') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-bold">Diterbitkan Oleh</label>
                                    <input type="text" name="diterbitkan_oleh" class="form-control @error('diterbitkan_oleh') is-invalid @enderror" value="{{ old('diterbitkan_oleh') }}" placeholder="cth: dr. Siti Rahayu" required>
                                    @error('diterbitkan_oleh') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-12 text-end">
                                    <a href="{{ route('buku-kia.index') }}" class="btn btn-light border px-4 me-2" style="border-radius: 8px;">Batal</a>
                                    <button type="submit" class="btn text-white px-4" style="background-color: #EC1E88; border-radius: 8px;">Simpan Buku KIA</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
