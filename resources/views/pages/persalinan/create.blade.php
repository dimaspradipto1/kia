@extends('layouts.dashboard.template')

@section('content')
    <div class="pagetitle">
        <h1>Catat Data Persalinan</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('persalinan.index') }}">Data Persalinan</a></li>
                <li class="breadcrumb-item active">Tambah</li>
            </ol>
        </nav>
    </div>

    <section class="section animate__animated animate__fadeIn">
        <form action="{{ route('persalinan.store') }}" method="POST">
            @csrf

            <div class="row">
                {{-- Kolom Kiri: Detail Persalinan --}}
                <div class="col-lg-6 mb-4">
                    <div class="card border-0 shadow-sm" style="border-radius:12px; border-top:5px solid #7E22CE !important; height: 100%;">
                        <div class="card-header bg-white border-bottom py-3 px-4">
                            <h5 class="m-0 fw-bold text-dark"><i class="bi bi-heart-pulse-fill text-purple me-1"></i> Informasi Persalinan</h5>
                        </div>
                        <div class="card-body p-4">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Pilih Buku KIA (Pasien) <span class="text-danger">*</span></label>
                                <select name="buku_kia_id" class="form-select select2 @error('buku_kia_id') is-invalid @enderror" data-placeholder="Pilih Pasien / Buku KIA" required>
                                    <option value=""></option>
                                    @foreach ($bukuKias as $bk)
                                        <option value="{{ $bk->id }}" {{ old('buku_kia_id', $selectedBukuKiaId ?? '') == $bk->id ? 'selected' : '' }}>
                                            {{ $bk->profilIbu->nama_lengkap ?? 'Tidak Diketahui' }} (Reg Kohort: {{ $bk->no_reg_kohort_ibu ?? '-' }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('buku_kia_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Fasilitas Kesehatan <span class="text-danger">*</span></label>
                                <select name="fasilitas_kesehatan_id" class="form-select select2 @error('fasilitas_kesehatan_id') is-invalid @enderror" data-placeholder="Pilih Tempat Persalinan (Faskes)" required>
                                    <option value=""></option>
                                    @foreach ($faskes as $f)
                                        <option value="{{ $f->id }}" {{ old('fasilitas_kesehatan_id') == $f->id ? 'selected' : '' }}>
                                            {{ $f->nama_faskes }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('fasilitas_kesehatan_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Tanggal Persalinan <span class="text-danger">*</span></label>
                                    <input type="text" name="tanggal_lahir" class="form-control datepicker @error('tanggal_lahir') is-invalid @enderror" value="{{ old('tanggal_lahir', date('Y-m-d')) }}" placeholder="Pilih Tanggal" required>
                                    @error('tanggal_lahir') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Jam Lahir <span class="text-danger">*</span></label>
                                    <input type="text" name="jam_lahir" class="form-control timepicker @error('jam_lahir') is-invalid @enderror" value="{{ old('jam_lahir', date('H:i')) }}" placeholder="Contoh: 08:30" required>
                                    @error('jam_lahir') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Jenis Persalinan <span class="text-danger">*</span></label>
                                    <select name="jenis_persalinan" class="form-select @error('jenis_persalinan') is-invalid @enderror" required>
                                        <option value="">Pilih Jenis</option>
                                        @foreach (['Spontan / Normal', 'Seksio Sesarea (Caesar)', 'Vakum Ekstraksi', 'Forsep', 'Induksi'] as $type)
                                            <option value="{{ $type }}" {{ old('jenis_persalinan') == $type ? 'selected' : '' }}>{{ $type }}</option>
                                        @endforeach
                                    </select>
                                    @error('jenis_persalinan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Penolong Persalinan <span class="text-danger">*</span></label>
                                    <select name="penolong" class="form-select @error('penolong') is-invalid @enderror" required>
                                        <option value="">Pilih Penolong</option>
                                        @foreach (['Dokter Kandungan (Sp.OG)', 'Dokter Umum', 'Bidan', 'Dukun Beranak', 'Lainnya'] as $p)
                                            <option value="{{ $p }}" {{ old('penolong') == $p ? 'selected' : '' }}>{{ $p }}</option>
                                        @endforeach
                                    </select>
                                    @error('penolong') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Petugas Kesehatan (Nakes) <span class="text-danger">*</span></label>
                                <select name="nakes_id" class="form-select select2 @error('nakes_id') is-invalid @enderror" data-placeholder="Pilih Tenaga Kesehatan" required>
                                    <option value=""></option>
                                    @foreach ($nakes as $n)
                                        <option value="{{ $n->id }}" {{ old('nakes_id', in_array(Auth::user()->roles_id, [3, 5]) ? Auth::id() : '') == $n->id ? 'selected' : '' }}>
                                            {{ $n->name }} ({{ $n->role->nama_role ?? 'Petugas' }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('nakes_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Kolom Kanan: Detail Bayi & Kondisi --}}
                <div class="col-lg-6 mb-4">
                    <div class="card border-0 shadow-sm" style="border-radius:12px; border-top:5px solid #16B3AC !important; height: 100%;">
                        <div class="card-header bg-white border-bottom py-3 px-4">
                            <h5 class="m-0 fw-bold text-dark"><i class="bi bi-emoji-smile-fill text-teal me-1"></i> Data Kondisi Bayi & Ibu</h5>
                        </div>
                        <div class="card-body p-4">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Berat Bayi (kg) <span class="text-danger">*</span></label>
                                    <input type="number" step="0.01" name="berat_bayi_kg" class="form-control @error('berat_bayi_kg') is-invalid @enderror" value="{{ old('berat_bayi_kg') }}" placeholder="Contoh: 3.10" required>
                                    @error('berat_bayi_kg') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Panjang Bayi (cm) <span class="text-danger">*</span></label>
                                    <input type="number" step="0.1" name="panjang_bayi_cm" class="form-control @error('panjang_bayi_cm') is-invalid @enderror" value="{{ old('panjang_bayi_cm') }}" placeholder="Contoh: 49.5" required>
                                    @error('panjang_bayi_cm') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Apgar Score (1 Menit) <span class="text-danger">*</span></label>
                                    <input type="number" min="0" max="10" name="apgar_score_1" class="form-control @error('apgar_score_1') is-invalid @enderror" value="{{ old('apgar_score_1') }}" placeholder="0 - 10" required>
                                    @error('apgar_score_1') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Apgar Score (5 Menit) <span class="text-danger">*</span></label>
                                    <input type="number" min="0" max="10" name="apgar_score_5" class="form-control @error('apgar_score_5') is-invalid @enderror" value="{{ old('apgar_score_5') }}" placeholder="0 - 10" required>
                                    @error('apgar_score_5') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Kondisi Ibu <span class="text-danger">*</span></label>
                                    <select name="kondisi_ibu" class="form-select @error('kondisi_ibu') is-invalid @enderror" required>
                                        <option value="">Pilih Kondisi</option>
                                        @foreach (['Sehat', 'Sakit / Lemah', 'Meninggal Dunia', 'Pendarahan Berat', 'Preeklamsia'] as $cond)
                                            <option value="{{ $cond }}" {{ old('kondisi_ibu', 'Sehat') == $cond ? 'selected' : '' }}>{{ $cond }}</option>
                                        @endforeach
                                    </select>
                                    @error('kondisi_ibu') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Kondisi Bayi <span class="text-danger">*</span></label>
                                    <select name="kondisi_bayi" class="form-select @error('kondisi_bayi') is-invalid @enderror" required>
                                        <option value="">Pilih Kondisi</option>
                                        @foreach (['Sehat', 'Asfiksia', 'Prematur', 'Meninggal Dunia (IUFD)', 'Cacat Bawaan'] as $cond)
                                            <option value="{{ $cond }}" {{ old('kondisi_bayi', 'Sehat') == $cond ? 'selected' : '' }}>{{ $cond }}</option>
                                        @endforeach
                                    </select>
                                    @error('kondisi_bayi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Komplikasi Persalinan (Jika Ada)</label>
                                <input type="text" name="komplikasi" class="form-control @error('komplikasi') is-invalid @enderror" value="{{ old('komplikasi') }}" placeholder="Contoh: Ketuban pecah dini, plasenta previa...">
                                @error('komplikasi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="row mt-4">
                                <div class="col-12 text-end">
                                    <a href="{{ route('persalinan.index') }}" class="btn btn-light border px-4 me-2" style="border-radius:30px; font-weight: 600;">Batal</a>
                                    <button type="submit" class="btn text-white px-5 shadow-sm" style="background-color:#7E22CE; border-radius:30px; font-weight: 600;">
                                        <i class="bi bi-save me-1"></i> Simpan Persalinan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>

    <style>
        .text-purple { color: #7E22CE !important; }
        .text-teal { color: #16B3AC !important; }
    </style>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                flatpickr('.datepicker', {
                    locale: 'id',
                    dateFormat: 'Y-m-d',
                    altInput: true,
                    altFormat: 'd F Y',
                    allowInput: true
                });

                flatpickr('.timepicker', {
                    enableTime: true,
                    noCalendar: true,
                    dateFormat: 'H:i',
                    time_24hr: true,
                    allowInput: true
                });

                if ($.fn.select2) {
                    $('.select2').select2({
                        theme: 'bootstrap-5',
                        width: '100%',
                        placeholder: function() {
                            return $(this).data('placeholder');
                        },
                        allowClear: true
                    });
                }
            });
        </script>
    @endpush
@endsection
