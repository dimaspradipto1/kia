@extends('layouts.dashboard.template')

@section('content')
    <div class="pagetitle">
        <h1>Edit Kunjungan ANC</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('kunjungan-anc.index') }}">Kunjungan ANC</a></li>
                <li class="breadcrumb-item active">Edit</li>
            </ol>
        </nav>
    </div>

    <section class="section animate__animated animate__fadeIn">
        <form action="{{ route('kunjungan-anc.update', $kunjunganAnc->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                {{-- Kolom Kiri: Informasi Kunjungan & Faskes --}}
                <div class="col-lg-5 mb-4">
                    <div class="card border-0 shadow-sm mb-4" style="border-radius:12px; border-top:5px solid #EC1E88 !important; height: 100%;">
                        <div class="card-header bg-white border-bottom py-3 px-4">
                            <h5 class="m-0 fw-bold text-dark"><i class="bi bi-pencil-square text-pink me-1"></i> Edit Kunjungan</h5>
                        </div>
                        <div class="card-body p-4">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Pilih Buku KIA (Ibu Hamil) <span class="text-danger">*</span></label>
                                <select name="buku_kia_id" class="form-select select2 @error('buku_kia_id') is-invalid @enderror" data-placeholder="Pilih Ibu Hamil" required>
                                    <option value=""></option>
                                    @foreach ($bukuKias as $bk)
                                        <option value="{{ $bk->id }}" {{ old('buku_kia_id', $kunjunganAnc->buku_kia_id) == $bk->id ? 'selected' : '' }}>
                                            {{ $bk->profilIbu->nama_lengkap ?? 'Tidak Diketahui' }} (Reg Kohort: {{ $bk->no_reg_kohort_ibu ?? '-' }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('buku_kia_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Tenaga Kesehatan (Pemeriksa) <span class="text-danger">*</span></label>
                                <select name="nakes_id" class="form-select select2 @error('nakes_id') is-invalid @enderror" data-placeholder="Pilih Tenaga Kesehatan" required>
                                    <option value=""></option>
                                    @foreach ($nakes as $n)
                                        <option value="{{ $n->id }}" {{ old('nakes_id', $kunjunganAnc->nakes_id) == $n->id ? 'selected' : '' }}>
                                            {{ $n->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('nakes_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Fasilitas Kesehatan <span class="text-danger">*</span></label>
                                <select name="fasilitas_kesehatan_id" class="form-select select2 @error('fasilitas_kesehatan_id') is-invalid @enderror" data-placeholder="Pilih Fasilitas Kesehatan" required>
                                    <option value=""></option>
                                    @foreach ($faskes as $f)
                                        <option value="{{ $f->id }}" {{ old('fasilitas_kesehatan_id', $kunjunganAnc->fasilitas_kesehatan_id) == $f->id ? 'selected' : '' }}>
                                            {{ $f->nama_faskes }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('fasilitas_kesehatan_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Trimester <span class="text-danger">*</span></label>
                                    <select name="trimester" class="form-select @error('trimester') is-invalid @enderror" required>
                                        <option value="">Pilih Trimester</option>
                                        @foreach ([1 => 'Trimester I', 2 => 'Trimester II', 3 => 'Trimester III'] as $tVal => $tLabel)
                                            <option value="{{ $tVal }}" {{ old('trimester', $kunjunganAnc->trimester) == $tVal ? 'selected' : '' }}>{{ $tLabel }}</option>
                                        @endforeach
                                    </select>
                                    @error('trimester') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Kunjungan Ke <span class="text-danger">*</span></label>
                                    <input type="number" name="kunjungan_ke" class="form-control @error('kunjungan_ke') is-invalid @enderror" value="{{ old('kunjungan_ke', $kunjunganAnc->kunjungan_ke) }}" min="1" max="10" required>
                                    @error('kunjungan_ke') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Tanggal Pemeriksaan <span class="text-danger">*</span></label>
                                <input type="text" name="tanggal_kunjungan" class="form-control datepicker @error('tanggal_kunjungan') is-invalid @enderror" value="{{ old('tanggal_kunjungan', $kunjunganAnc->tanggal_kunjungan) }}" placeholder="Pilih Tanggal" required>
                                @error('tanggal_kunjungan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Kolom Kanan: Parameter Medis & Detail Janin --}}
                <div class="col-lg-7 mb-4">
                    <div class="card border-0 shadow-sm" style="border-radius:12px; border-top:5px solid #16B3AC !important; height: 100%;">
                        <div class="card-header bg-white border-bottom py-3 px-4">
                            <h5 class="m-0 fw-bold text-dark"><i class="bi bi-heart-pulse text-teal me-1"></i> Pengukuran Klinis & Janin</h5>
                        </div>
                        <div class="card-body p-4">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Berat Badan (BB) <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="number" step="0.1" name="berat_badan" class="form-control @error('berat_badan') is-invalid @enderror" value="{{ old('berat_badan', $kunjunganAnc->berat_badan) }}" placeholder="Contoh: 55.4" required>
                                        <span class="input-group-text bg-light text-muted">kg</span>
                                    </div>
                                    @error('berat_badan') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Lingkar Lengan Atas (LiLA) <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="number" step="0.1" name="lila_cm" class="form-control @error('lila_cm') is-invalid @enderror" value="{{ old('lila_cm', $kunjunganAnc->lila_cm) }}" placeholder="Contoh: 24.5" required>
                                        <span class="input-group-text bg-light text-muted">cm</span>
                                    </div>
                                    @error('lila_cm') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Tekanan Darah Sistolik <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="number" name="tekanan_darah_sistolik" class="form-control @error('tekanan_darah_sistolik') is-invalid @enderror" value="{{ old('tekanan_darah_sistolik', $kunjunganAnc->tekanan_darah_sistolik) }}" placeholder="Sistolik" required>
                                        <span class="input-group-text bg-light text-muted">mmHg</span>
                                    </div>
                                    @error('tekanan_darah_sistolik') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Tekanan Darah Diastolik <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="number" name="tekanan_darah_diastolik" class="form-control @error('tekanan_darah_diastolik') is-invalid @enderror" value="{{ old('tekanan_darah_diastolik', $kunjunganAnc->tekanan_darah_diastolik) }}" placeholder="Diastolik" required>
                                        <span class="input-group-text bg-light text-muted">mmHg</span>
                                    </div>
                                    @error('tekanan_darah_diastolik') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Tinggi Fundus Uteri (TFU)</label>
                                    <div class="input-group">
                                        <input type="number" step="0.1" name="tinggi_fundus_cm" class="form-control @error('tinggi_fundus_cm') is-invalid @enderror" value="{{ old('tinggi_fundus_cm', $kunjunganAnc->tinggi_fundus_cm) }}" placeholder="Kosongkan jika belum teraba">
                                        <span class="input-group-text bg-light text-muted">cm</span>
                                    </div>
                                    @error('tinggi_fundus_cm') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Status Imunisasi TT</label>
                                    <select name="status_tt" class="form-select @error('status_tt') is-invalid @enderror">
                                        <option value="">Pilih Status TT (Opsional)</option>
                                        @foreach (['T1', 'T2', 'T3', 'T4', 'T5'] as $tt)
                                            <option value="{{ $tt }}" {{ old('status_tt', $kunjunganAnc->status_tt) == $tt ? 'selected' : '' }}>{{ $tt }}</option>
                                        @endforeach
                                    </select>
                                    @error('status_tt') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="row border-top pt-3 mt-3 border-light">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Denyut Jantung Janin (DJJ)</label>
                                    <div class="input-group">
                                        <input type="text" name="denyut_jantung_janin" class="form-control @error('denyut_jantung_janin') is-invalid @enderror" value="{{ old('denyut_jantung_janin', $kunjunganAnc->denyut_jantung_janin) }}" placeholder="Contoh: 140 / Negatif">
                                        <span class="input-group-text bg-light text-muted">bpm</span>
                                    </div>
                                    @error('denyut_jantung_janin') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Letak / Presentasi Janin</label>
                                    <select name="letak_janin" class="form-select @error('letak_janin') is-invalid @enderror">
                                        <option value="">Pilih Letak Janin (Opsional)</option>
                                        @foreach (['Kepala Bawah (Presentasi Kepala)', 'Sungsang / Bokong', 'Lintang', 'Belum Teraba'] as $letak)
                                            <option value="{{ $letak }}" {{ old('letak_janin', $kunjunganAnc->letak_janin) == $letak ? 'selected' : '' }}>{{ $letak }}</option>
                                        @endforeach
                                    </select>
                                    @error('letak_janin') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Dilakukan USG? <span class="text-danger">*</span></label>
                                    <select name="usg_dilakukan" id="usg_dilakukan" class="form-select @error('usg_dilakukan') is-invalid @enderror" required>
                                        <option value="Tidak" {{ old('usg_dilakukan', $kunjunganAnc->usg_dilakukan) == 'Tidak' ? 'selected' : '' }}>Tidak</option>
                                        <option value="Ya" {{ old('usg_dilakukan', $kunjunganAnc->usg_dilakukan) == 'Ya' ? 'selected' : '' }}>Ya</option>
                                    </select>
                                    @error('usg_dilakukan') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6 mb-3" id="hasil_usg_wrapper" style="display: none;">
                                    <label class="form-label fw-bold">Hasil USG</label>
                                    <input type="text" name="hasil_usg" class="form-control @error('hasil_usg') is-invalid @enderror" value="{{ old('hasil_usg', $kunjunganAnc->hasil_usg) }}" placeholder="Contoh: Normal / Sesuai Usia Kehamilan">
                                    @error('hasil_usg') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label fw-bold">Skrining Kesehatan Jiwa</label>
                                    <select name="skrining_jiwa" class="form-select @error('skrining_jiwa') is-invalid @enderror">
                                        <option value="Sehat / Normal" {{ old('skrining_jiwa', $kunjunganAnc->skrining_jiwa) == 'Sehat / Normal' ? 'selected' : '' }}>Sehat / Normal</option>
                                        <option value="Berisiko Depresi" {{ old('skrining_jiwa', $kunjunganAnc->skrining_jiwa) == 'Berisiko Depresi' ? 'selected' : '' }}>Berisiko Depresi / Gangguan Kecemasan</option>
                                    </select>
                                    @error('skrining_jiwa') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Catatan & Rekomendasi Medis</label>
                                <textarea name="catatan" class="form-control @error('catatan') is-invalid @enderror" rows="3" placeholder="Rekomendasi diet, suplemen TTD, rencana persalinan, dll.">{{ old('catatan', $kunjunganAnc->catatan) }}</textarea>
                                @error('catatan') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>

                            <div class="row mt-4">
                                <div class="col-12 text-end">
                                    <a href="{{ route('kunjungan-anc.index') }}" class="btn btn-light border px-4 me-2" style="border-radius:30px; font-weight: 600;">Batal</a>
                                    <button type="submit" class="btn text-white px-5 shadow-sm" style="background-color:#EC1E88; border-radius:30px; font-weight: 600;">
                                        <i class="bi bi-save me-1"></i> Perbarui ANC
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
        .text-pink { color: #EC1E88 !important; }
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

                // Handle USG toggle
                const usgSelect = document.getElementById('usg_dilakukan');
                const usgWrapper = document.getElementById('hasil_usg_wrapper');

                function toggleUsg() {
                    if (usgSelect.value === 'Ya') {
                        usgWrapper.style.display = 'block';
                    } else {
                        usgWrapper.style.display = 'none';
                    }
                }

                usgSelect.addEventListener('change', toggleUsg);
                toggleUsg(); // Run once initially
            });
        </script>
    @endpush
@endsection
