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
                        @if($ibu->isEmpty())
                            <div class="alert alert-warning d-flex align-items-center mb-4 rounded-3">
                                <i class="bi bi-exclamation-triangle-fill me-2 fs-5 text-warning"></i>
                                <div>
                                    Belum ada data Profil Ibu terdaftar di fasilitas kesehatan Anda. Silakan daftarkan Profil Ibu terlebih dahulu melalui menu 
                                    <a href="{{ route('profil-ibu.create') }}" class="fw-bold text-decoration-underline text-dark">Tambah Profil Ibu</a>.
                                </div>
                            </div>
                        @endif

                        <form action="{{ route('buku-kia.store') }}" method="POST">
                            @csrf

                            {{-- Relasi --}}
                            <div class="row mb-3">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Nama Ibu</label>
                                    <select name="profil_ibu_id" id="profil_ibu_id" class="form-select select2 @error('profil_ibu_id') is-invalid @enderror" data-placeholder="Pilih Profil Ibu" required>
                                        <option value="">Pilih Profil Ibu</option>
                                        @foreach ($ibu as $i)
                                            <option value="{{ $i->id }}" 
                                                data-faskes-id="{{ $i->fasilitas_kesehatan_id }}" 
                                                data-faskes-name="{{ $i->fasilitasKesehatan->nama_faskes ?? '' }}"
                                                {{ old('profil_ibu_id') == $i->id ? 'selected' : '' }}>
                                                {{ $i->nama_lengkap }} (NIK: {{ $i->nik }}){{ $i->fasilitasKesehatan ? ' - ' . $i->fasilitasKesehatan->nama_faskes : '' }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('profil_ibu_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Fasilitas Kesehatan</label>
                                    <select name="fasilitas_kesehatan_id" id="fasilitas_kesehatan_id" class="form-select select2 @error('fasilitas_kesehatan_id') is-invalid @enderror" data-placeholder="Pilih Faskes" required>
                                        <option value="">Pilih Faskes</option>
                                        @foreach ($faskes as $f)
                                            <option value="{{ $f->id }}" {{ old('fasilitas_kesehatan_id', auth()->user()->fasilitas_kesehatan_id) == $f->id ? 'selected' : '' }}>
                                                {{ $f->nama_faskes }} ({{ $f->jenis }})
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
                                    <input type="text" name="no_reg_kohort_ibu" class="form-control @error('no_reg_kohort_ibu') is-invalid @enderror" value="{{ old('no_reg_kohort_ibu') }}" placeholder="cth: KHR-IBU-001" required>
                                    @error('no_reg_kohort_ibu') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-bold">No. Reg Kohort Bayi</label>
                                    <input type="text" name="no_reg_kohort_bayi" class="form-control @error('no_reg_kohort_bayi') is-invalid @enderror" value="{{ old('no_reg_kohort_bayi', '-') }}" placeholder="Diisi saat bayi lahir atau '-' jika belum">
                                    @error('no_reg_kohort_bayi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-bold">No. Reg Kohort Balita</label>
                                    <input type="text" name="no_reg_kohort_balita" class="form-control @error('no_reg_kohort_balita') is-invalid @enderror" value="{{ old('no_reg_kohort_balita', '-') }}" placeholder="Diisi saat usia balita atau '-' jika belum">
                                    @error('no_reg_kohort_balita') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            {{-- Riwayat Kehamilan --}}
                            <div class="row mb-3">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-bold">Kehamilan Ke-</label>
                                    <input type="number" name="kehamilan_ke" class="form-control @error('kehamilan_ke') is-invalid @enderror" value="{{ old('kehamilan_ke', 1) }}" min="1" required>
                                    @error('kehamilan_ke') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-bold">Jumlah Anak Hidup</label>
                                    <input type="number" name="jumlah_anak_hidup" class="form-control @error('jumlah_anak_hidup') is-invalid @enderror" value="{{ old('jumlah_anak_hidup', 0) }}" min="0" required>
                                    @error('jumlah_anak_hidup') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-bold">Riwayat Keguguran</label>
                                    <input type="text" name="riwayat_keguguran" class="form-control @error('riwayat_keguguran') is-invalid @enderror" value="{{ old('riwayat_keguguran', 'Tidak Ada') }}" placeholder="cth: Tidak Ada / 1x" required>
                                    @error('riwayat_keguguran') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            {{-- Catatan Medis --}}
                            <div class="row mb-3">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Riwayat Penyakit</label>
                                    <input type="text" name="riwayat_penyakit" class="form-control" value="{{ old('riwayat_penyakit', '-') }}" placeholder="cth: Hipertensi, Diabetes, atau '-' (opsional)">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">No. Catatan Medik RS</label>
                                    <input type="text" name="no_catatan_medik_rs" class="form-control" value="{{ old('no_catatan_medik_rs', '-') }}" placeholder="cth: RM-12345 atau '-' (opsional)">
                                </div>
                            </div>

                            {{-- Penerbitan & Status --}}
                            <div class="row mb-3">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-bold">Status</label>
                                    <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                                        <option value="Aktif" {{ old('status', 'Aktif') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                        <option value="Tidak Aktif" {{ old('status') == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                                    </select>
                                    @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-bold">Diterbitkan Pada</label>
                                    <input type="text" name="diterbitkan_pada" id="diterbitkan_pada" class="form-control @error('diterbitkan_pada') is-invalid @enderror" value="{{ old('diterbitkan_pada', auth()->user()->fasilitasKesehatan->nama_faskes ?? '') }}" placeholder="cth: Posyandu Sri Purnama / Puskesmas" required>
                                    @error('diterbitkan_pada') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-bold">Diterbitkan Oleh</label>
                                    <input type="text" name="diterbitkan_oleh" class="form-control @error('diterbitkan_oleh') is-invalid @enderror" value="{{ old('diterbitkan_oleh', auth()->user()->name) }}" placeholder="cth: Nama Petugas / Bidan / Kader" required>
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

@push('scripts')
<script>
    $(document).ready(function() {
        $('#profil_ibu_id').on('change', function() {
            let selectedOpt = $(this).find('option:selected');
            let faskesId = selectedOpt.data('faskes-id');
            let faskesName = selectedOpt.data('faskes-name');

            if (faskesId) {
                $('#fasilitas_kesehatan_id').val(faskesId).trigger('change');
            }
            if (faskesName && (!$('#diterbitkan_pada').val() || $('#diterbitkan_pada').val() === '-')) {
                $('#diterbitkan_pada').val(faskesName);
            }
        });
    });
</script>
@endpush
@endsection
