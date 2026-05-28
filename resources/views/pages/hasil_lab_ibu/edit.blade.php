@extends('layouts.dashboard.template')

@section('content')
    <div class="pagetitle">
        <h1>Edit Hasil Laboratorium Ibu</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('hasil-lab-ibu.index') }}">Hasil Lab Ibu</a></li>
                <li class="breadcrumb-item active">Edit</li>
            </ol>
        </nav>
    </div>

    <section class="section animate__animated animate__fadeIn">
        <form action="{{ route('hasil-lab-ibu.update', $hasilLabIbu->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                {{-- Kolom Kiri: Kunjungan ANC & Tanggal --}}
                <div class="col-lg-5 mb-4">
                    <div class="card border-0 shadow-sm" style="border-radius:12px; border-top:5px solid #16B3AC !important; height: 100%;">
                        <div class="card-header bg-white border-bottom py-3 px-4">
                            <h5 class="m-0 fw-bold text-dark"><i class="bi bi-calendar-check text-teal me-1"></i> Data Kunjungan & Tanggal</h5>
                        </div>
                        <div class="card-body p-4">
                            <div class="mb-4">
                                <label class="form-label fw-bold">Pilih Kunjungan ANC Ibu <span class="text-danger">*</span></label>
                                <select name="kunjungan_anc_id" class="form-select select2 @error('kunjungan_anc_id') is-invalid @enderror" data-placeholder="Pilih Kunjungan ANC" required>
                                    <option value=""></option>
                                    @foreach ($kunjunganAncs as $kanc)
                                        @php
                                            $namaIbu = $kanc->bukuKia->profilIbu->nama_lengkap ?? 'Tidak Diketahui';
                                            $kohort = $kanc->bukuKia->no_reg_kohort_ibu ?? '-';
                                            $tglKunjungan = $kanc->tanggal_kunjungan ? \Carbon\Carbon::parse($kanc->tanggal_kunjungan)->translatedFormat('d M Y') : '-';
                                        @endphp
                                        <option value="{{ $kanc->id }}" {{ old('kunjungan_anc_id', $hasilLabIbu->kunjungan_anc_id) == $kanc->id ? 'selected' : '' }}>
                                            {{ $namaIbu }} (Trimester {{ $kanc->trimester }} - K{{ $kanc->kunjungan_ke }} | {{ $tglKunjungan }})
                                        </option>
                                    @endforeach
                                </select>
                                <div class="form-text">Hubungkan hasil laboratorium ini dengan riwayat kunjungan pemeriksaan antenatal care.</div>
                                @error('kunjungan_anc_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Tanggal Pemeriksaan Lab <span class="text-danger">*</span></label>
                                <input type="text" name="tanggal_periksa" class="form-control datepicker @error('tanggal_periksa') is-invalid @enderror" value="{{ old('tanggal_periksa', $hasilLabIbu->tanggal_periksa) }}" placeholder="Pilih Tanggal Pemeriksaan" required>
                                @error('tanggal_periksa') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Kolom Kanan: Parameter Lab & Hasil Pemeriksaan --}}
                <div class="col-lg-7 mb-4">
                    <div class="card border-0 shadow-sm" style="border-radius:12px; border-top:5px solid #EC1E88 !important; height: 100%;">
                        <div class="card-header bg-white border-bottom py-3 px-4">
                            <h5 class="m-0 fw-bold text-dark"><i class="bi bi-droplet text-pink me-1"></i> Parameter & Hasil Laboratorium</h5>
                        </div>
                        <div class="card-body p-4">
                            @php
                                $presets = [
                                    'Hemoglobin (Hb)',
                                    'Protein Urine',
                                    'Gula Darah Sewaktu (GDS)',
                                    'Golongan Darah & Rhesus',
                                    'Sifilis (Syphilis)',
                                    'HIV (Rapid Test)',
                                    'Hepatitis B (HBsAg)'
                                ];
                                $isPreset = in_array($hasilLabIbu->jenis_pemeriksaan, $presets);
                            @endphp

                            <div class="mb-3">
                                <label class="form-label fw-bold">Pilih Jenis Pemeriksaan Lab <span class="text-danger">*</span></label>
                                <select id="pilih_jenis" class="form-select" required>
                                    <option value="">-- Pilih Jenis Tes / Parameter --</option>
                                    @foreach ($presets as $p)
                                        <option value="{{ $p }}" {{ old('jenis_pemeriksaan', $hasilLabIbu->jenis_pemeriksaan) == $p ? 'selected' : '' }}>{{ $p }}</option>
                                    @endforeach
                                    <option value="Lainnya" {{ !$isPreset ? 'selected' : '' }}>-- Tulis Parameter Kustom Lainnya --</option>
                                </select>
                            </div>

                            <div class="mb-3" id="kustom_jenis_wrapper" style="display:none;">
                                <label class="form-label fw-bold">Tulis Nama Pemeriksaan Kustom <span class="text-danger">*</span></label>
                                <input type="text" id="kustom_jenis" class="form-control" placeholder="Contoh: Eritrosit, Trombosit, Leukosit, dll." value="{{ !$isPreset ? $hasilLabIbu->jenis_pemeriksaan : '' }}">
                            </div>

                            {{-- Hidden input yang dikirim ke backend --}}
                            <input type="hidden" name="jenis_pemeriksaan" id="jenis_pemeriksaan" value="{{ old('jenis_pemeriksaan', $hasilLabIbu->jenis_pemeriksaan) }}">
                            @error('jenis_pemeriksaan') <div class="text-danger small mt-1">{{ $message }}</div> @enderror

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Hasil Laboratorium <span class="text-danger">*</span></label>
                                    <input type="text" name="hasil" id="hasil" class="form-control @error('hasil') is-invalid @enderror" value="{{ old('hasil', $hasilLabIbu->hasil) }}" placeholder="Contoh: 11.5 atau Negatif" required>
                                    @error('hasil') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Satuan Hasil <span class="text-danger">*</span></label>
                                    <input type="text" name="satuan" id="satuan" class="form-control @error('satuan') is-invalid @enderror" value="{{ old('satuan', $hasilLabIbu->satuan) }}" placeholder="Contoh: g/dl atau mg/dl" required>
                                    @error('satuan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Nilai Normal / Rujukan <span class="text-danger">*</span></label>
                                <input type="text" name="nilai_normal" id="nilai_normal" class="form-control @error('nilai_normal') is-invalid @enderror" value="{{ old('nilai_normal', $hasilLabIbu->nilai_normal) }}" placeholder="Contoh: >= 11.0 atau Negatif" required>
                                @error('nilai_normal') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="row mt-4 pt-3 border-top border-light">
                                <div class="col-12 text-end">
                                    <a href="{{ route('hasil-lab-ibu.index') }}" class="btn btn-light border px-4 me-2" style="border-radius:30px; font-weight: 600;">Batal</a>
                                    <button type="submit" class="btn text-white px-5 shadow-sm" style="background-color:#16B3AC; border-radius:30px; font-weight: 600;">
                                        <i class="bi bi-save me-1"></i> Perbarui Hasil Lab
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

                    $('.select2-no-clear').select2({
                        theme: 'bootstrap-5',
                        width: '100%'
                    });
                }

                // Autocompletion & preset values based on selected lab test
                const presets = {
                    'Hemoglobin (Hb)': { satuan: 'g/dl', normal: '11.0 - 16.0' },
                    'Protein Urine': { satuan: '-', normal: 'Negatif' },
                    'Gula Darah Sewaktu (GDS)': { satuan: 'mg/dl', normal: '< 140' },
                    'Golongan Darah & Rhesus': { satuan: '-', normal: '-' },
                    'Sifilis (Syphilis)': { satuan: 'Reaktif/Non', normal: 'Non Reaktif' },
                    'HIV (Rapid Test)': { satuan: 'Reaktif/Non', normal: 'Non Reaktif' },
                    'Hepatitis B (HBsAg)': { satuan: 'Reaktif/Non', normal: 'Non Reaktif' }
                };

                const selectJenis = document.getElementById('pilih_jenis');
                const customJenisWrapper = document.getElementById('kustom_jenis_wrapper');
                const customJenisInput = document.getElementById('kustom_jenis');
                const hiddenJenis = document.getElementById('jenis_pemeriksaan');
                
                const inputSatuan = document.getElementById('satuan');
                const inputNormal = document.getElementById('nilai_normal');

                function updateJenis() {
                    const val = selectJenis.value;
                    if (val === 'Lainnya') {
                        customJenisWrapper.style.display = 'block';
                        customJenisInput.setAttribute('required', 'required');
                        hiddenJenis.value = customJenisInput.value;
                    } else {
                        customJenisWrapper.style.display = 'none';
                        customJenisInput.removeAttribute('required');
                        hiddenJenis.value = val;

                        // Apply presets only if they were just changed (prevent overriding original bound data initially)
                        if (presets[val] && selectJenis.dataset.initialized) {
                            inputSatuan.value = presets[val].satuan;
                            inputNormal.value = presets[val].normal;
                        }
                    }
                    selectJenis.dataset.initialized = "true";
                }

                selectJenis.addEventListener('change', updateJenis);
                customJenisInput.addEventListener('input', function() {
                    hiddenJenis.value = customJenisInput.value;
                });

                // Init values on reload / validation back
                updateJenis();
            });
        </script>
    @endpush
@endsection
