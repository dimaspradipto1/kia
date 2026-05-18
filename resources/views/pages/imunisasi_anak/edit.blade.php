@extends('layouts.dashboard.template')

@section('content')
    <div class="pagetitle">
        <h1>Edit Imunisasi Anak</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('imunisasi-anak.index') }}">Imunisasi Anak</a></li>
                <li class="breadcrumb-item active">Edit</li>
            </ol>
        </nav>
    </div>

    <section class="section animate__animated animate__fadeIn">
        <form action="{{ route('imunisasi-anak.update', $imunisasiAnak->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                {{-- Kolom Kiri: Identitas --}}
                <div class="col-lg-5 mb-4">
                    <div class="card border-0 shadow-sm" style="border-radius:12px; border-top:5px solid #16a34a !important; height:100%;">
                        <div class="card-header bg-white border-bottom py-3 px-4">
                            <h5 class="m-0 fw-bold text-dark"><i class="bi bi-pencil-square text-success me-1"></i> Edit Identitas & Petugas</h5>
                        </div>
                        <div class="card-body p-4">
                            {{-- Profil Anak --}}
                            <div class="mb-3">
                                <label class="form-label fw-bold">Profil Anak <span class="text-danger">*</span></label>
                                <select name="profil_anak_id" class="form-select select2 @error('profil_anak_id') is-invalid @enderror" data-placeholder="Pilih Nama Anak" required>
                                    <option value=""></option>
                                    @foreach ($profilAnaks as $pa)
                                        <option value="{{ $pa->id }}" {{ old('profil_anak_id', $imunisasiAnak->profil_anak_id) == $pa->id ? 'selected' : '' }}>
                                            {{ $pa->nama_lengkap }}
                                            @if ($pa->bukuKia && $pa->bukuKia->profilIbu)
                                                (Ibu: {{ $pa->bukuKia->profilIbu->nama_lengkap }})
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                                @error('profil_anak_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            {{-- Fasilitas Kesehatan --}}
                            <div class="mb-3">
                                <label class="form-label fw-bold">Fasilitas Kesehatan <span class="text-danger">*</span></label>
                                <select name="fasilitas_kesehatan_id" class="form-select select2 @error('fasilitas_kesehatan_id') is-invalid @enderror" data-placeholder="Pilih Fasilitas Kesehatan" required>
                                    <option value=""></option>
                                    @foreach ($faskes as $f)
                                        <option value="{{ $f->id }}" {{ old('fasilitas_kesehatan_id', $imunisasiAnak->fasilitas_kesehatan_id) == $f->id ? 'selected' : '' }}>
                                            {{ $f->nama_faskes }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('fasilitas_kesehatan_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            {{-- Tenaga Kesehatan --}}
                            <div class="mb-3">
                                <label class="form-label fw-bold">Tenaga Kesehatan <span class="text-danger">*</span></label>
                                <select name="nakes_id" class="form-select select2 @error('nakes_id') is-invalid @enderror" data-placeholder="Pilih Tenaga Kesehatan" required>
                                    <option value=""></option>
                                    @foreach ($nakes as $n)
                                        <option value="{{ $n->id }}" {{ old('nakes_id', $imunisasiAnak->nakes_id) == $n->id ? 'selected' : '' }}>
                                            {{ $n->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('nakes_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            {{-- Tanggal Pemberian --}}
                            <div class="mb-3">
                                <label class="form-label fw-bold">Tanggal Pemberian <span class="text-danger">*</span></label>
                                <input type="text" name="tanggal_pemberian" class="form-control datepicker @error('tanggal_pemberian') is-invalid @enderror"
                                       value="{{ old('tanggal_pemberian', $imunisasiAnak->tanggal_pemberian->format('Y-m-d')) }}" placeholder="Pilih Tanggal" required>
                                @error('tanggal_pemberian') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Kolom Kanan: Detail Vaksin --}}
                <div class="col-lg-7 mb-4">
                    <div class="card border-0 shadow-sm" style="border-radius:12px; border-top:5px solid #16B3AC !important; height:100%;">
                        <div class="card-header bg-white border-bottom py-3 px-4">
                            <h5 class="m-0 fw-bold text-dark"><i class="bi bi-capsule-pill text-teal me-1"></i> Detail Vaksin</h5>
                        </div>
                        <div class="card-body p-4">
                            {{-- Jenis Imunisasi --}}
                            <div class="mb-3">
                                <label class="form-label fw-bold">Jenis Imunisasi <span class="text-danger">*</span></label>
                                @php
                                    $currentJenis = old('jenis_imunisasi', $imunisasiAnak->jenis_imunisasi);
                                    $isCustomJenis = !in_array($currentJenis, $jenisOptions);
                                @endphp
                                <select name="{{ $isCustomJenis ? '_jenis_tmp' : 'jenis_imunisasi' }}" id="jenis_select" class="form-select @error('jenis_imunisasi') is-invalid @enderror" required>
                                    <option value="">Pilih Jenis Imunisasi</option>
                                    @foreach ($jenisOptions as $jenis)
                                        <option value="{{ $jenis }}" {{ $currentJenis == $jenis ? 'selected' : '' }}>{{ $jenis }}</option>
                                    @endforeach
                                    <option value="Lainnya" {{ $isCustomJenis ? 'selected' : '' }}>Lainnya</option>
                                </select>
                                @error('jenis_imunisasi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                <div id="jenis_lainnya_wrapper" class="mt-2" style="display:{{ $isCustomJenis ? 'block' : 'none' }};">
                                    <input type="text" id="jenis_imunisasi_lainnya" name="{{ $isCustomJenis ? 'jenis_imunisasi' : '_jenis_tmp_input' }}"
                                           class="form-control" value="{{ $isCustomJenis ? $currentJenis : '' }}" placeholder="Tuliskan nama imunisasi...">
                                </div>
                            </div>

                            {{-- Dosis --}}
                            <div class="mb-3">
                                <label class="form-label fw-bold">Dosis Ke- <span class="text-danger">*</span></label>
                                <div class="d-flex gap-2 flex-wrap" id="dosis-picker">
                                    @for ($d = 1; $d <= 5; $d++)
                                        <input type="radio" class="btn-check" name="dosis_ke" id="dosis_{{ $d }}" value="{{ $d }}"
                                               {{ old('dosis_ke', $imunisasiAnak->dosis_ke) == $d ? 'checked' : '' }}>
                                        <label class="btn btn-outline-success" for="dosis_{{ $d }}">Dosis {{ $d }}</label>
                                    @endfor
                                </div>
                                @error('dosis_ke') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>

                            {{-- Batch Vaksin --}}
                            <div class="mb-3">
                                <label class="form-label fw-bold">Nomor Batch Vaksin</label>
                                <input type="text" name="batch_vaksin" class="form-control @error('batch_vaksin') is-invalid @enderror"
                                       value="{{ old('batch_vaksin', $imunisasiAnak->batch_vaksin == '-' ? '' : $imunisasiAnak->batch_vaksin) }}"
                                       placeholder="Contoh: BV-2026-001 (opsional)">
                                @error('batch_vaksin') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            {{-- Efek Samping --}}
                            <div class="mb-3">
                                @php
                                    $currentEfek = old('efek_samping', $imunisasiAnak->efek_samping);
                                    $efekOptions = ['Tidak Ada', 'Demam Ringan', 'Bengkak di Tempat Suntik', 'Rewel / Menangis', 'Kemerahan'];
                                    $isCustomEfek = !in_array($currentEfek, $efekOptions);
                                @endphp
                                <label class="form-label fw-bold">Efek Samping</label>
                                <select name="{{ $isCustomEfek ? '_efek_tmp' : 'efek_samping' }}" id="efek_samping" class="form-select @error('efek_samping') is-invalid @enderror">
                                    @foreach ($efekOptions as $efek)
                                        <option value="{{ $efek }}" {{ $currentEfek == $efek ? 'selected' : '' }}>{{ $efek }}</option>
                                    @endforeach
                                    <option value="Lainnya" {{ $isCustomEfek ? 'selected' : '' }}>Lainnya (Tuliskan)</option>
                                </select>
                                @error('efek_samping') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                <div id="efek_lainnya_wrapper" class="mt-2" style="display:{{ $isCustomEfek ? 'block' : 'none' }};">
                                    <input type="text" id="efek_samping_lainnya" name="{{ $isCustomEfek ? 'efek_samping' : '_efek_tmp_input' }}"
                                           class="form-control" value="{{ $isCustomEfek ? $currentEfek : '' }}" placeholder="Tuliskan efek samping...">
                                </div>
                            </div>

                            {{-- Tombol --}}
                            <div class="text-end mt-4">
                                <a href="{{ route('imunisasi-anak.index') }}" class="btn btn-light border px-4 me-2" style="border-radius:30px; font-weight:600;">Batal</a>
                                <button type="submit" class="btn text-white px-5 shadow-sm" style="background:linear-gradient(135deg,#16a34a,#15803d); border-radius:30px; font-weight:600;">
                                    <i class="bi bi-save me-1"></i> Perbarui Imunisasi
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>

    <style>
        .text-teal { color: #16B3AC !important; }
    </style>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                if (typeof flatpickr !== 'undefined') {
                    flatpickr('.datepicker', {
                        locale: 'id', dateFormat: 'Y-m-d',
                        altInput: true, altFormat: 'd F Y', allowInput: true
                    });
                }

                if ($.fn.select2) {
                    $('.select2').select2({
                        theme: 'bootstrap-5', width: '100%',
                        placeholder: function() { return $(this).data('placeholder'); },
                        allowClear: true
                    });
                }

                // Toggle jenis imunisasi lainnya
                const jenisSelect = document.getElementById('jenis_select');
                const jenisInput  = document.getElementById('jenis_imunisasi_lainnya');
                const jenisWrapper = document.getElementById('jenis_lainnya_wrapper');
                jenisSelect.addEventListener('change', function () {
                    if (this.value === 'Lainnya') {
                        jenisWrapper.style.display = 'block';
                        this.name = '_jenis_tmp';
                        jenisInput.name = 'jenis_imunisasi';
                    } else {
                        jenisWrapper.style.display = 'none';
                        this.name = 'jenis_imunisasi';
                        jenisInput.name = '_jenis_tmp_input';
                    }
                });

                // Toggle efek samping lainnya
                const efekSelect  = document.getElementById('efek_samping');
                const efekInput   = document.getElementById('efek_samping_lainnya');
                const efekWrapper = document.getElementById('efek_lainnya_wrapper');
                efekSelect.addEventListener('change', function () {
                    if (this.value === 'Lainnya') {
                        efekWrapper.style.display = 'block';
                        this.name = '_efek_tmp';
                        efekInput.name = 'efek_samping';
                    } else {
                        efekWrapper.style.display = 'none';
                        this.name = 'efek_samping';
                        efekInput.name = '_efek_tmp_input';
                    }
                });
            });
        </script>
    @endpush
@endsection
