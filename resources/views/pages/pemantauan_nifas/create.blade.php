@extends('layouts.dashboard.template')

@section('content')
    <div class="pagetitle">
        <h1>Tambah Pemantauan Nifas</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('pemantauan-nifas.index') }}">Pemantauan Nifas</a></li>
                <li class="breadcrumb-item active">Tambah</li>
            </ol>
        </nav>
    </div>

    <section class="section animate__animated animate__fadeIn">
        <form action="{{ route('pemantauan-nifas.store') }}" method="POST">
            @csrf

            <div class="row">
                {{-- Kolom Kiri: Data Kunjungan --}}
                <div class="col-lg-5 mb-4">
                    <div class="card border-0 shadow-sm mb-4" style="border-radius:12px; border-top:5px solid #EC1E88 !important; height: 100%;">
                        <div class="card-header bg-white border-bottom py-3 px-4">
                            <h5 class="m-0 fw-bold text-dark"><i class="bi bi-person-fill text-pink me-1"></i> Data Kunjungan Nifas</h5>
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
                                <label class="form-label fw-bold">Tenaga Kesehatan (Petugas) <span class="text-danger">*</span></label>
                                <select name="nakes_id" class="form-select select2 @error('nakes_id') is-invalid @enderror" data-placeholder="Pilih Tenaga Kesehatan" required>
                                    <option value=""></option>
                                    @foreach ($nakes as $n)
                                        <option value="{{ $n->id }}" {{ old('nakes_id', Auth::user()->roles_id == 3 ? Auth::id() : '') == $n->id ? 'selected' : '' }}>
                                            {{ $n->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('nakes_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Tanggal Pemantauan <span class="text-danger">*</span></label>
                                    <input type="text" name="tanggal" class="form-control datepicker @error('tanggal') is-invalid @enderror" value="{{ old('tanggal', date('Y-m-d')) }}" placeholder="Pilih Tanggal" required>
                                    @error('tanggal') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Hari Ke / KF <span class="text-danger">*</span></label>
                                    <select name="hari_ke" class="form-select @error('hari_ke') is-invalid @enderror" required>
                                        <option value="">Pilih Hari Ke / KF</option>
                                        @foreach (['KF 1 (6 Jam - 3 Hari)', 'KF 2 (4 Hari - 28 Hari)', 'KF 3 (29 Hari - 42 Hari)'] as $kf)
                                            <option value="{{ $kf }}" {{ old('hari_ke') == $kf ? 'selected' : '' }}>{{ $kf }}</option>
                                        @endforeach
                                    </select>
                                    @error('hari_ke') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Catatan Tambahan</label>
                                <textarea name="catatan" class="form-control @error('catatan') is-invalid @enderror" rows="5" placeholder="Keterangan tambahan atau rekomendasi bidan/dokter...">{{ old('catatan') }}</textarea>
                                @error('catatan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Kolom Kanan: Evaluasi Gejala / Keluhan --}}
                <div class="col-lg-7 mb-4">
                    <div class="card border-0 shadow-sm" style="border-radius:12px; border-top:5px solid #16B3AC !important; height: 100%;">
                        <div class="card-header bg-white border-bottom py-3 px-4">
                            <h5 class="m-0 fw-bold text-dark"><i class="bi bi-activity text-teal me-1"></i> Deteksi Dini Keluhan Nifas</h5>
                        </div>
                        <div class="card-body p-4">
                            <p class="text-muted small mb-4">Silakan centang/pilih jika Ibu Nifas memiliki gejala atau keluhan klinis berikut:</p>
                            
                            @php
                                $gejalaFields = [
                                    'demam' => 'Mengalami Demam (Suhu > 38°C)',
                                    'pendarahan' => 'Pendarahan Lewat Jalan Lahir',
                                    'nyeri_ulu_hati' => 'Nyeri Ulu Hati / Sakit Kepala Hebat',
                                    'pandangan_kabur' => 'Pandangan Kabur / Pandangan Ganda',
                                    'keluar_cairan_berbau' => 'Keluar Cairan Berbau dari Jalan Lahir',
                                    'payudara_bengkak' => 'Payudara Bengkak / Merah / Sakit',
                                    'gangguan_jiwa' => 'Sedih / Depresi / Cemas Berlebihan',
                                    'gangguan_bak' => 'Gangguan Buang Air Kecil (BAK)',
                                ];
                            @endphp

                            <div class="row">
                                @foreach($gejalaFields as $field => $label)
                                    <div class="col-md-12 mb-3 pb-3 border-bottom border-light">
                                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                                            <span class="fw-semibold text-dark small" style="max-width: 70%;">{{ $label }}</span>
                                            <div class="d-flex gap-3 mt-2 mt-sm-0">
                                                <div class="form-check form-check-inline m-0">
                                                    <input class="form-check-input" type="radio" name="{{ $field }}" id="{{ $field }}_ya" value="Ya" {{ old($field) == 'Ya' ? 'checked' : '' }} required>
                                                    <label class="form-check-label fw-bold text-danger small cursor-pointer" for="{{ $field }}_ya">Ya</label>
                                                </div>
                                                <div class="form-check form-check-inline m-0">
                                                    <input class="form-check-input" type="radio" name="{{ $field }}" id="{{ $field }}_tidak" value="Tidak" {{ old($field, 'Tidak') == 'Tidak' ? 'checked' : '' }} required>
                                                    <label class="form-check-label fw-bold text-success small cursor-pointer" for="{{ $field }}_tidak">Tidak</label>
                                                </div>
                                            </div>
                                        </div>
                                        @error($field) <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                    </div>
                                @endforeach
                            </div>

                            <div class="row mt-4">
                                <div class="col-12 text-end">
                                    <a href="{{ route('pemantauan-nifas.index') }}" class="btn btn-light border px-4 me-2" style="border-radius:30px; font-weight: 600;">Batal</a>
                                    <button type="submit" class="btn text-white px-5 shadow-sm" style="background-color:#EC1E88; border-radius:30px; font-weight: 600;">
                                        <i class="bi bi-save me-1"></i> Simpan Catatan
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
        .cursor-pointer { cursor: pointer; }
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
            });
        </script>
    @endpush
@endsection
