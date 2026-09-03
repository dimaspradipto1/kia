@extends('layouts.dashboard.template')

@section('content')
    <div class="pagetitle">
        <h1>Catat Imunisasi Anak</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('imunisasi-anak.index') }}">Imunisasi Anak</a></li>
                <li class="breadcrumb-item active">Catat</li>
            </ol>
        </nav>
    </div>

    <section class="section animate__animated animate__fadeIn">
        <form action="{{ route('imunisasi-anak.store') }}" method="POST">
            @csrf

            <div class="row">
                {{-- Kolom Kiri: Identitas --}}
                <div class="col-lg-5 mb-4">
                    <div class="card border-0 shadow-sm" style="border-radius:12px; border-top:5px solid #16a34a !important; height:100%;">
                        <div class="card-header bg-white border-bottom py-3 px-4">
                            <h5 class="m-0 fw-bold text-dark"><i class="bi bi-person-badge text-success me-1"></i> Identitas & Petugas</h5>
                        </div>
                        <div class="card-body p-4">
                            {{-- Profil Anak --}}
                            <div class="mb-3">
                                <label class="form-label fw-bold">Profil Anak <span class="text-danger">*</span></label>
                                <select name="profil_anak_id" class="form-select select2 @error('profil_anak_id') is-invalid @enderror" data-placeholder="Pilih Nama Anak" required>
                                    <option value=""></option>
                                    @foreach ($profilAnaks as $pa)
                                        <option value="{{ $pa->id }}" {{ old('profil_anak_id', $selectedProfilAnakId) == $pa->id ? 'selected' : '' }}>
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
                                        <option value="{{ $f->id }}" {{ old('fasilitas_kesehatan_id', Auth::user()->fasilitas_kesehatan_id ?? '') == $f->id ? 'selected' : '' }}>
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
                                        <option value="{{ $n->id }}" {{ old('nakes_id', in_array(Auth::user()->roles_id, [3, 5]) ? Auth::id() : '') == $n->id ? 'selected' : '' }}>
                                            {{ $n->name }} ({{ $n->role->nama_role ?? 'Petugas' }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('nakes_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            {{-- Tanggal Pemberian --}}
                            <div class="mb-3">
                                <label class="form-label fw-bold">Tanggal Pemberian <span class="text-danger">*</span></label>
                                <input type="text" name="tanggal_pemberian" class="form-control datepicker @error('tanggal_pemberian') is-invalid @enderror"
                                       value="{{ old('tanggal_pemberian', date('Y-m-d')) }}" placeholder="Pilih Tanggal" required>
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
                                <select name="jenis_imunisasi" class="form-select @error('jenis_imunisasi') is-invalid @enderror" required>
                                    <option value="">Pilih Jenis Imunisasi</option>
                                    @foreach ($jenisOptions as $jenis)
                                        <option value="{{ $jenis }}" {{ old('jenis_imunisasi') == $jenis ? 'selected' : '' }}>{{ $jenis }}</option>
                                    @endforeach
                                    <option value="Lainnya" {{ old('jenis_imunisasi') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                </select>
                                @error('jenis_imunisasi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                <div id="jenis_lainnya_wrapper" class="mt-2" style="display:none;">
                                    <input type="text" id="jenis_imunisasi_lainnya" class="form-control" placeholder="Tuliskan nama imunisasi...">
                                </div>
                            </div>

                            {{-- Dosis --}}
                            <div class="mb-3">
                                <label class="form-label fw-bold">Dosis Ke- <span class="text-danger">*</span></label>
                                <div class="d-flex gap-2 flex-wrap" id="dosis-picker">
                                    @for ($d = 1; $d <= 5; $d++)
                                        <input type="radio" class="btn-check" name="dosis_ke" id="dosis_{{ $d }}" value="{{ $d }}" {{ old('dosis_ke', 1) == $d ? 'checked' : '' }}>
                                        <label class="btn btn-outline-success" for="dosis_{{ $d }}">Dosis {{ $d }}</label>
                                    @endfor
                                </div>
                                @error('dosis_ke') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>

                            {{-- Batch Vaksin --}}
                            <div class="mb-3">
                                <label class="form-label fw-bold">Nomor Batch Vaksin</label>
                                <input type="text" name="batch_vaksin" class="form-control @error('batch_vaksin') is-invalid @enderror"
                                       value="{{ old('batch_vaksin') }}" placeholder="Contoh: BV-2026-001 (opsional)">
                                @error('batch_vaksin') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            {{-- Efek Samping --}}
                            <div class="mb-3">
                                <label class="form-label fw-bold">Efek Samping</label>
                                <select name="efek_samping" id="efek_samping" class="form-select @error('efek_samping') is-invalid @enderror">
                                    <option value="Tidak Ada" {{ old('efek_samping', 'Tidak Ada') == 'Tidak Ada' ? 'selected' : '' }}>Tidak Ada</option>
                                    <option value="Demam Ringan" {{ old('efek_samping') == 'Demam Ringan' ? 'selected' : '' }}>Demam Ringan</option>
                                    <option value="Bengkak di Tempat Suntik" {{ old('efek_samping') == 'Bengkak di Tempat Suntik' ? 'selected' : '' }}>Bengkak di Tempat Suntik</option>
                                    <option value="Rewel / Menangis" {{ old('efek_samping') == 'Rewel / Menangis' ? 'selected' : '' }}>Rewel / Menangis</option>
                                    <option value="Kemerahan" {{ old('efek_samping') == 'Kemerahan' ? 'selected' : '' }}>Kemerahan</option>
                                    <option value="Lainnya" {{ old('efek_samping') == 'Lainnya' ? 'selected' : '' }}>Lainnya (Tuliskan)</option>
                                </select>
                                @error('efek_samping') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                <div id="efek_lainnya_wrapper" class="mt-2" style="display:none;">
                                    <input type="text" id="efek_samping_lainnya" class="form-control" placeholder="Tuliskan efek samping...">
                                </div>
                            </div>

                            {{-- Tombol --}}
                            <div class="text-end mt-4">
                                <a href="{{ route('imunisasi-anak.index') }}" class="btn btn-light border px-4 me-2" style="border-radius:30px; font-weight:600;">Batal</a>
                                <button type="submit" class="btn text-white px-5 shadow-sm" style="background:linear-gradient(135deg,#16a34a,#15803d); border-radius:30px; font-weight:600;">
                                    <i class="bi bi-save me-1"></i> Simpan Imunisasi
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
        .btn-outline-success.btn-check:checked + label,
        .btn-outline-success:active { background-color: #16a34a !important; color: white !important; }
    </style>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Flatpickr
                if (typeof flatpickr !== 'undefined') {
                    flatpickr('.datepicker', {
                        locale: 'id', dateFormat: 'Y-m-d',
                        altInput: true, altFormat: 'd F Y', allowInput: true
                    });
                }

                // Select2
                if ($.fn.select2) {
                    $('.select2').select2({
                        theme: 'bootstrap-5', width: '100%',
                        placeholder: function() { return $(this).data('placeholder'); },
                        allowClear: true
                    });
                }

                // Toggle jenis imunisasi lainnya
                const jenisSelect = document.querySelector('select[name="jenis_imunisasi"]');
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
