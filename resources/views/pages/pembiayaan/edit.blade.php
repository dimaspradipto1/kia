@extends('layouts.dashboard.template')

@section('content')
    <div class="pagetitle">
        <h1>Edit Pembiayaan</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('pembiayaan.index') }}">Pembiayaan</a></li>
                <li class="breadcrumb-item active">Edit</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card border-0 shadow-sm mb-4" style="border-radius:12px; border-top:5px solid #EC1E88 !important;">
                    <div class="card-header bg-white border-bottom py-3 px-4">
                        <h5 class="m-0 fw-bold text-dark">Form Edit Pembiayaan</h5>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('pembiayaan.update', $pembiayaan->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row mb-3">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label fw-bold">Nama Ibu <span class="text-danger">*</span></label>
                                    <select name="profil_ibu_id" class="form-select select2 @error('profil_ibu_id') is-invalid @enderror" data-placeholder="Pilih Profil Ibu" required>
                                        <option value=""></option>
                                        @foreach ($ibu as $i)
                                            <option value="{{ $i->id }}" {{ old('profil_ibu_id', $pembiayaan->profil_ibu_id) == $i->id ? 'selected' : '' }}>
                                                {{ $i->nama_lengkap }} (NIK: {{ $i->nik }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('profil_ibu_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Jenis Pembiayaan <span class="text-danger">*</span></label>
                                    <select name="jenis_pembiayaan" class="form-select select2 @error('jenis_pembiayaan') is-invalid @enderror" data-placeholder="Pilih Jenis" required>
                                        <option value=""></option>
                                        @foreach(['BPJS Kesehatan', 'Asuransi Swasta', 'Umum / Mandiri', 'Jampersal', 'Lainnya'] as $j)
                                            <option value="{{ $j }}" {{ old('jenis_pembiayaan', $pembiayaan->jenis_pembiayaan) == $j ? 'selected' : '' }}>{{ $j }}</option>
                                        @endforeach
                                    </select>
                                    @error('jenis_pembiayaan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-6 mb-3" id="field-nama-asuransi">
                                    <label class="form-label fw-bold" id="label-nama-asuransi">Nama Asuransi / No. BPJS</label>
                                    <input type="text" name="nama_asuransi" id="input-nama-asuransi"
                                           class="form-control @error('nama_asuransi') is-invalid @enderror"
                                           value="{{ old('nama_asuransi', $pembiayaan->nama_asuransi) }}"
                                           placeholder="-">
                                    @error('nama_asuransi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6 mb-3" id="field-nomor-polis">
                                    <label class="form-label fw-bold">Nomor Polis</label>
                                    <input type="text" name="nomor_polis" class="form-control @error('nomor_polis') is-invalid @enderror"
                                           value="{{ old('nomor_polis', $pembiayaan->nomor_polis) }}">
                                    @error('nomor_polis') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Tanggal Berlaku</label>
                                    <input type="text" name="tanggal_berlaku"
                                           class="form-control datepicker @error('tanggal_berlaku') is-invalid @enderror"
                                           value="{{ old('tanggal_berlaku', $pembiayaan->tanggal_berlaku?->format('Y-m-d')) }}"
                                           placeholder="Pilih Tanggal">
                                    @error('tanggal_berlaku') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="is_active" id="is_active"
                                           {{ old('is_active', $pembiayaan->is_active) ? 'checked' : '' }}>
                                    <label class="form-check-label fw-bold" for="is_active">Aktif</label>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-12">
                                    <a href="{{ route('pembiayaan.index') }}" class="btn btn-light border px-4 me-2" style="border-radius:8px;">Batal</a>
                                    <button type="submit" class="btn text-white px-4" style="background-color:#EC1E88; border-radius:8px;">Perbarui</button>
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
                flatpickr('.datepicker', {
                    locale: 'id',
                    dateFormat: 'Y-m-d',
                    altInput: true,
                    altFormat: 'd F Y',
                    allowInput: true
                });

                const jenisSelect  = document.querySelector('select[name="jenis_pembiayaan"]');
                const fieldWrap    = document.getElementById('field-nama-asuransi');
                const label        = document.getElementById('label-nama-asuransi');
                const input        = document.getElementById('input-nama-asuransi');
                const fieldPolis   = document.getElementById('field-nomor-polis');

                const config = {
                    'BPJS Kesehatan'  : { label: 'No. JKN / BPJS',       placeholder: 'cth: 0001234567890',       showPolis: false },
                    'Asuransi Swasta' : { label: 'Nama Asuransi',         placeholder: 'cth: Prudential, AXA, dll', showPolis: true  },
                    'Umum / Mandiri'  : { label: 'Keterangan Pembayaran', placeholder: 'opsional',                 showPolis: false },
                    'Jampersal'       : { label: 'No. Kartu Jampersal',   placeholder: 'opsional',                 showPolis: false },
                    'Lainnya'         : { label: 'Keterangan',            placeholder: 'opsional',                 showPolis: true  },
                };

                function updateField(val) {
                    if (config[val]) {
                        fieldWrap.style.display  = '';
                        label.textContent        = config[val].label;
                        input.placeholder        = config[val].placeholder;
                        fieldPolis.style.display = config[val].showPolis ? '' : 'none';
                    } else {
                        fieldWrap.style.display  = 'none';
                        fieldPolis.style.display = 'none';
                    }
                }

                updateField(jenisSelect ? jenisSelect.value : '');

                $(jenisSelect).on('change', function () {
                    updateField(this.value);
                });
            });
        </script>
    @endpush
@endsection
