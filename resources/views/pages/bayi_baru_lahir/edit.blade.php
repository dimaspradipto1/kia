@extends('layouts.dashboard.template')

@section('content')
    <div class="pagetitle">
        <h1>Edit Data Bayi Baru Lahir</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('bayi-baru-lahir.index') }}">Bayi Baru Lahir</a></li>
                <li class="breadcrumb-item active">Edit</li>
            </ol>
        </nav>
    </div>

    <section class="section animate__animated animate__fadeIn">
        <form action="{{ route('bayi-baru-lahir.update', $bayiBaruLahir->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                {{-- Kolom Kiri: Identitas & Petugas --}}
                <div class="col-lg-5 mb-4">
                    <div class="card border-0 shadow-sm mb-4" style="border-radius:12px; border-top:5px solid #0d6efd !important;">
                        <div class="card-header bg-white border-bottom py-3 px-4">
                            <h5 class="m-0 fw-bold text-dark"><i class="bi bi-pencil-square text-primary me-1"></i> Edit Identitas Bayi</h5>
                        </div>
                        <div class="card-body p-4">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Profil Anak <span class="text-danger">*</span></label>
                                <select name="profil_anak_id" class="form-select select2 @error('profil_anak_id') is-invalid @enderror" data-placeholder="Pilih Profil Anak" required>
                                    <option value=""></option>
                                    @foreach ($profilAnaks as $pa)
                                        <option value="{{ $pa->id }}" {{ old('profil_anak_id', $bayiBaruLahir->profil_anak_id) == $pa->id ? 'selected' : '' }}>
                                            {{ $pa->nama_lengkap }}
                                            @if ($pa->bukuKia && $pa->bukuKia->profilIbu)
                                                (Ibu: {{ $pa->bukuKia->profilIbu->nama_lengkap }})
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                                @error('profil_anak_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Tenaga Kesehatan <span class="text-danger">*</span></label>
                                <select name="nakes_id" class="form-select select2 @error('nakes_id') is-invalid @enderror" data-placeholder="Pilih Nakes" required>
                                    <option value=""></option>
                                    @foreach ($nakes as $n)
                                        <option value="{{ $n->id }}" {{ old('nakes_id', $bayiBaruLahir->nakes_id) == $n->id ? 'selected' : '' }}>
                                            {{ $n->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('nakes_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Kondisi Umum Bayi <span class="text-danger">*</span></label>
                                <select name="kondisi_umum" class="form-select @error('kondisi_umum') is-invalid @enderror" required>
                                    <option value="">Pilih Kondisi</option>
                                    @foreach (['Baik', 'Sedang', 'Buruk'] as $k)
                                        <option value="{{ $k }}" {{ old('kondisi_umum', $bayiBaruLahir->kondisi_umum) == $k ? 'selected' : '' }}>{{ $k }}</option>
                                    @endforeach
                                </select>
                                @error('kondisi_umum') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Kolom Kanan: Imunisasi & Skrining --}}
                <div class="col-lg-7 mb-4">
                    {{-- Imunisasi Awal --}}
                    <div class="card border-0 shadow-sm mb-4" style="border-radius:12px; border-top:5px solid #16B3AC !important;">
                        <div class="card-header bg-white border-bottom py-3 px-4">
                            <h5 class="m-0 fw-bold text-dark"><i class="bi bi-shield-plus text-teal me-1"></i> Imunisasi Awal</h5>
                        </div>
                        <div class="card-body p-4">
                            {{-- HB0 --}}
                            <div class="row align-items-end mb-3">
                                <div class="col-md-5">
                                    <label class="form-label fw-bold">Imunisasi HB0 <span class="text-danger">*</span></label>
                                    <select name="hb0_diberikan" id="hb0_diberikan" class="form-select @error('hb0_diberikan') is-invalid @enderror" required>
                                        <option value="1" {{ old('hb0_diberikan', $bayiBaruLahir->hb0_diberikan ? '1' : '0') == '1' ? 'selected' : '' }}>Diberikan</option>
                                        <option value="0" {{ old('hb0_diberikan', $bayiBaruLahir->hb0_diberikan ? '1' : '0') == '0' ? 'selected' : '' }}>Tidak Diberikan</option>
                                    </select>
                                    @error('hb0_diberikan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-7" id="hb0_waktu_wrapper">
                                    <label class="form-label fw-bold">Waktu Pemberian HB0</label>
                                    <input type="time" name="hb0_waktu" class="form-control @error('hb0_waktu') is-invalid @enderror" value="{{ old('hb0_waktu', $bayiBaruLahir->hb0_waktu) }}">
                                    @error('hb0_waktu') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            {{-- Vit K1 --}}
                            <div class="mb-3">
                                <label class="form-label fw-bold">Vitamin K1 <span class="text-danger">*</span></label>
                                <select name="vit_k1_diberikan" class="form-select @error('vit_k1_diberikan') is-invalid @enderror" required>
                                    <option value="1" {{ old('vit_k1_diberikan', $bayiBaruLahir->vit_k1_diberikan ? '1' : '0') == '1' ? 'selected' : '' }}>Diberikan</option>
                                    <option value="0" {{ old('vit_k1_diberikan', $bayiBaruLahir->vit_k1_diberikan ? '1' : '0') == '0' ? 'selected' : '' }}>Tidak Diberikan</option>
                                </select>
                                @error('vit_k1_diberikan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            {{-- Salep Mata --}}
                            <div class="mb-3">
                                <label class="form-label fw-bold">Salep Mata <span class="text-danger">*</span></label>
                                <select name="salep_mata_diberikan" class="form-select @error('salep_mata_diberikan') is-invalid @enderror" required>
                                    <option value="1" {{ old('salep_mata_diberikan', $bayiBaruLahir->salep_mata_diberikan ? '1' : '0') == '1' ? 'selected' : '' }}>Diberikan</option>
                                    <option value="0" {{ old('salep_mata_diberikan', $bayiBaruLahir->salep_mata_diberikan ? '1' : '0') == '0' ? 'selected' : '' }}>Tidak Diberikan</option>
                                </select>
                                @error('salep_mata_diberikan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Skrining --}}
                    <div class="card border-0 shadow-sm mb-4" style="border-radius:12px; border-top:5px solid #EC1E88 !important;">
                        <div class="card-header bg-white border-bottom py-3 px-4">
                            <h5 class="m-0 fw-bold text-dark"><i class="bi bi-activity text-pink me-1"></i> Skrining Bayi Baru Lahir</h5>
                        </div>
                        <div class="card-body p-4">
                            {{-- SHK --}}
                            <div class="row align-items-end mb-3">
                                <div class="col-md-5">
                                    <label class="form-label fw-bold">SHK Dilakukan? <span class="text-danger">*</span></label>
                                    <select name="shk_dilakukan" id="shk_dilakukan" class="form-select @error('shk_dilakukan') is-invalid @enderror" required>
                                        <option value="0" {{ old('shk_dilakukan', $bayiBaruLahir->shk_dilakukan ? '1' : '0') == '0' ? 'selected' : '' }}>Tidak</option>
                                        <option value="1" {{ old('shk_dilakukan', $bayiBaruLahir->shk_dilakukan ? '1' : '0') == '1' ? 'selected' : '' }}>Ya</option>
                                    </select>
                                    @error('shk_dilakukan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-7" id="shk_fields_wrapper" style="display:none;">
                                    <label class="form-label fw-bold">Waktu SHK</label>
                                    <input type="time" name="shk_waktu" class="form-control @error('shk_waktu') is-invalid @enderror" value="{{ old('shk_waktu', $bayiBaruLahir->shk_waktu) }}">
                                    @error('shk_waktu') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div id="shk_hasil_wrapper" style="display:none;" class="mb-3">
                                <label class="form-label fw-bold">Hasil SHK</label>
                                <input type="text" name="shk_hasil" class="form-control @error('shk_hasil') is-invalid @enderror" value="{{ old('shk_hasil', $bayiBaruLahir->shk_hasil) }}" placeholder="Contoh: Normal / Reaktif">
                                @error('shk_hasil') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            {{-- PJB --}}
                            <div class="row align-items-end mb-3">
                                <div class="col-md-5">
                                    <label class="form-label fw-bold">PJB (Deteksi Jantung) <span class="text-danger">*</span></label>
                                    <select name="pjb_dilakukan" id="pjb_dilakukan" class="form-select @error('pjb_dilakukan') is-invalid @enderror" required>
                                        <option value="0" {{ old('pjb_dilakukan', $bayiBaruLahir->pjb_dilakukan ? '1' : '0') == '0' ? 'selected' : '' }}>Tidak</option>
                                        <option value="1" {{ old('pjb_dilakukan', $bayiBaruLahir->pjb_dilakukan ? '1' : '0') == '1' ? 'selected' : '' }}>Ya</option>
                                    </select>
                                    @error('pjb_dilakukan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-7" id="pjb_hasil_wrapper" style="display:none;">
                                    <label class="form-label fw-bold">Hasil PJB</label>
                                    <input type="text" name="pjb_hasil" class="form-control @error('pjb_hasil') is-invalid @enderror" value="{{ old('pjb_hasil', $bayiBaruLahir->pjb_hasil) }}" placeholder="Contoh: Normal / Kelainan">
                                    @error('pjb_hasil') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Tombol --}}
                    <div class="text-end">
                        <a href="{{ route('bayi-baru-lahir.index') }}" class="btn btn-light border px-4 me-2" style="border-radius:30px; font-weight:600;">Batal</a>
                        <button type="submit" class="btn text-white px-5 shadow-sm" style="background:linear-gradient(135deg,#0d6efd,#0a58ca); border-radius:30px; font-weight:600;">
                            <i class="bi bi-save me-1"></i> Perbarui Data
                        </button>
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
                if ($.fn.select2) {
                    $('.select2').select2({
                        theme: 'bootstrap-5',
                        width: '100%',
                        placeholder: function() { return $(this).data('placeholder'); },
                        allowClear: true
                    });
                }

                // Toggle SHK fields
                function toggleShk() {
                    const val = document.getElementById('shk_dilakukan').value;
                    document.getElementById('shk_fields_wrapper').style.display = val == '1' ? 'block' : 'none';
                    document.getElementById('shk_hasil_wrapper').style.display = val == '1' ? 'block' : 'none';
                }
                document.getElementById('shk_dilakukan').addEventListener('change', toggleShk);
                toggleShk();

                // Toggle PJB hasil
                function togglePjb() {
                    const val = document.getElementById('pjb_dilakukan').value;
                    document.getElementById('pjb_hasil_wrapper').style.display = val == '1' ? 'block' : 'none';
                }
                document.getElementById('pjb_dilakukan').addEventListener('change', togglePjb);
                togglePjb();
            });
        </script>
    @endpush
@endsection
