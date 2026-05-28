@extends('layouts.dashboard.template')

@section('content')
    <div class="pagetitle">
        <h1>Catat Perkembangan SIDTK</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('perkembangan-sidtk.index') }}">Perkembangan SIDTK</a></li>
                <li class="breadcrumb-item active">Catat</li>
            </ol>
        </nav>
    </div>

    <section class="section animate__animated animate__fadeIn">
        <form action="{{ route('perkembangan-sidtk.store') }}" method="POST">
            @csrf
            <div class="row">
                {{-- Kolom Kiri --}}
                <div class="col-lg-5 mb-4">
                    <div class="card border-0 shadow-sm h-100" style="border-radius:12px; border-top:5px solid #7c3aed !important;">
                        <div class="card-header bg-white border-bottom py-3 px-4">
                            <h5 class="m-0 fw-bold text-dark">
                                <i class="bi bi-person-badge me-1" style="color:#7c3aed;"></i> Identitas & Petugas
                            </h5>
                        </div>
                        <div class="card-body p-4">
                            {{-- Profil Anak --}}
                            <div class="mb-3">
                                <label class="form-label fw-bold">Profil Anak <span class="text-danger">*</span></label>
                                <select name="profil_anak_id" class="form-select select2 @error('profil_anak_id') is-invalid @enderror"
                                        data-placeholder="Pilih Nama Anak" required>
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

                            {{-- Tenaga Kesehatan --}}
                            <div class="mb-3">
                                <label class="form-label fw-bold">Tenaga Kesehatan <span class="text-danger">*</span></label>
                                <select name="nakes_id" class="form-select select2 @error('nakes_id') is-invalid @enderror"
                                        data-placeholder="Pilih Nakes" required>
                                    <option value=""></option>
                                    @foreach ($nakes as $n)
                                        <option value="{{ $n->id }}" {{ old('nakes_id', Auth::user()->roles_id == 3 ? Auth::id() : '') == $n->id ? 'selected' : '' }}>
                                            {{ $n->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('nakes_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            {{-- Tanggal --}}
                            <div class="mb-3">
                                <label class="form-label fw-bold">Tanggal Skrining <span class="text-danger">*</span></label>
                                <input type="text" name="tanggal_skrining" class="form-control datepicker @error('tanggal_skrining') is-invalid @enderror"
                                       value="{{ old('tanggal_skrining', date('Y-m-d')) }}" required>
                                @error('tanggal_skrining') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            {{-- Usia --}}
                            <div class="mb-3">
                                <label class="form-label fw-bold">Usia Anak (Bulan) <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" name="usia_bulan" class="form-control @error('usia_bulan') is-invalid @enderror"
                                           value="{{ old('usia_bulan', 0) }}" min="0" max="72" required>
                                    <span class="input-group-text bg-light text-muted">bulan</span>
                                </div>
                                <small class="text-muted">SIDTK untuk usia 0–72 bulan</small>
                                @error('usia_bulan') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Kolom Kanan --}}
                <div class="col-lg-7 mb-4">
                    <div class="card border-0 shadow-sm mb-4" style="border-radius:12px; border-top:5px solid #16B3AC !important;">
                        <div class="card-header bg-white border-bottom py-3 px-4">
                            <h5 class="m-0 fw-bold text-dark">
                                <i class="bi bi-puzzle text-teal me-1"></i> Hasil Skrining SIDTK
                            </h5>
                        </div>
                        <div class="card-body p-4">
                            {{-- Domain --}}
                            <div class="mb-4">
                                <label class="form-label fw-bold">Domain Perkembangan <span class="text-danger">*</span></label>
                                <div class="row g-2">
                                    @foreach ($domains as $domain)
                                        @php
                                            $domainColors = [
                                                'Gerak Kasar'              => ['outline' => '#0d6efd', 'id' => 'gerak_kasar'],
                                                'Gerak Halus'              => ['outline' => '#16B3AC', 'id' => 'gerak_halus'],
                                                'Bicara & Bahasa'          => ['outline' => '#8B5CF6', 'id' => 'bicara'],
                                                'Sosialisasi & Kemandirian'=> ['outline' => '#EC1E88', 'id' => 'sosialisasi'],
                                                'Kognitif'                 => ['outline' => '#F59E0B', 'id' => 'kognitif'],
                                            ];
                                            $dc = $domainColors[$domain] ?? ['outline' => '#6c757d', 'id' => 'other'];
                                        @endphp
                                        <div class="col-12 col-sm-6">
                                            <input type="radio" class="btn-check" name="domain" id="domain_{{ $dc['id'] }}"
                                                   value="{{ $domain }}" {{ old('domain') == $domain ? 'checked' : '' }} required>
                                            <label class="btn btn-outline-secondary w-100 text-start py-2 px-3 domain-btn"
                                                   for="domain_{{ $dc['id'] }}"
                                                   data-color="{{ $dc['outline'] }}"
                                                   style="border-radius:10px; font-size:0.88rem; border:2px solid #dee2e6;">
                                                <i class="bi bi-circle-fill me-2" style="font-size:0.6rem; color:{{ $dc['outline'] }};"></i>
                                                {{ $domain }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                                @error('domain') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>

                            {{-- Hasil --}}
                            <div class="mb-4">
                                <label class="form-label fw-bold">Hasil Skrining <span class="text-danger">*</span></label>
                                <div class="d-flex gap-3 flex-wrap">
                                    @php
                                        $hasilCfg = [
                                            'Sesuai'       => ['color' => 'success', 'icon' => 'bi-check-circle'],
                                            'Meragukan'    => ['color' => 'warning', 'icon' => 'bi-exclamation-circle'],
                                            'Penyimpangan' => ['color' => 'danger',  'icon' => 'bi-x-circle'],
                                        ];
                                    @endphp
                                    @foreach ($hasilOptions as $h)
                                        @php $hc = $hasilCfg[$h] ?? ['color' => 'secondary', 'icon' => 'bi-circle']; @endphp
                                        <div class="flex-grow-1">
                                            <input type="radio" class="btn-check" name="hasil" id="hasil_{{ Str::slug($h) }}"
                                                   value="{{ $h }}" {{ old('hasil') == $h ? 'checked' : '' }} required>
                                            <label class="btn btn-outline-{{ $hc['color'] }} w-100 py-3" for="hasil_{{ Str::slug($h) }}"
                                                   style="border-radius:10px; border-width:2px;">
                                                <i class="bi {{ $hc['icon'] }} d-block mb-1 fs-5"></i>
                                                <span class="fw-semibold small">{{ $h }}</span>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                                @error('hasil') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>

                            {{-- Tindak Lanjut --}}
                            <div class="mb-3">
                                <label class="form-label fw-bold">Tindak Lanjut <span class="text-danger">*</span></label>
                                <select name="tindak_lanjut" class="form-select @error('tindak_lanjut') is-invalid @enderror" required>
                                    <option value="">Pilih Tindak Lanjut</option>
                                    @foreach ($tindakLanjuts as $tl)
                                        <option value="{{ $tl }}" {{ old('tindak_lanjut') == $tl ? 'selected' : '' }}>{{ $tl }}</option>
                                    @endforeach
                                </select>
                                @error('tindak_lanjut') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Tombol --}}
                    <div class="text-end">
                        <a href="{{ route('perkembangan-sidtk.index') }}" class="btn btn-light border px-4 me-2"
                           style="border-radius:30px; font-weight:600;">Batal</a>
                        <button type="submit" class="btn text-white px-5 shadow-sm"
                                style="background:linear-gradient(135deg,#7c3aed,#6d28d9); border-radius:30px; font-weight:600;">
                            <i class="bi bi-save me-1"></i> Simpan Skrining
                        </button>
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
                        placeholder: function () { return $(this).data('placeholder'); },
                        allowClear: true
                    });
                }
            });
        </script>
    @endpush
@endsection
