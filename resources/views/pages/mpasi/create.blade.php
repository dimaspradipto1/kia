@extends('layouts.dashboard.template')

@section('content')
    <div class="pagetitle">
        <h1>Catat MPASI</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('mpasi.index') }}">MPASI</a></li>
                <li class="breadcrumb-item active">Catat</li>
            </ol>
        </nav>
    </div>

    <section class="section animate__animated animate__fadeIn">
        <form action="{{ route('mpasi.store') }}" method="POST">
            @csrf
            <div class="row">
                {{-- Kolom Kiri: Identitas --}}
                <div class="col-lg-4 mb-4">
                    <div class="card border-0 shadow-sm h-100" style="border-radius:12px; border-top:5px solid #16a34a !important;">
                        <div class="card-header bg-white border-bottom py-3 px-4">
                            <h5 class="m-0 fw-bold text-dark">
                                <i class="bi bi-person-badge me-1 text-success"></i> Identitas & Petugas
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

                            {{-- Nakes --}}
                            <div class="mb-3">
                                <label class="form-label fw-bold">Tenaga Kesehatan <span class="text-danger">*</span></label>
                                <select name="nakes_id" class="form-select select2 @error('nakes_id') is-invalid @enderror"
                                        data-placeholder="Pilih Nakes" required>
                                    <option value=""></option>
                                    @foreach ($nakes as $n)
                                        <option value="{{ $n->id }}" {{ old('nakes_id', in_array(Auth::user()->roles_id, [3, 5]) ? Auth::id() : '') == $n->id ? 'selected' : '' }}>
                                            {{ $n->name }} ({{ $n->role->nama_role ?? 'Petugas' }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('nakes_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            {{-- Tanggal Mulai MPASI --}}
                            <div class="mb-3">
                                <label class="form-label fw-bold">Tanggal Mulai MPASI <span class="text-danger">*</span></label>
                                <input type="text" name="tanggal_mulai_mpasi" class="form-control datepicker @error('tanggal_mulai_mpasi') is-invalid @enderror"
                                       value="{{ old('tanggal_mulai_mpasi', date('Y-m-d')) }}" required>
                                <small class="text-muted">MPASI dimulai usia ≥ 6 bulan</small>
                                @error('tanggal_mulai_mpasi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            {{-- Dibuat Pada --}}
                            <div class="mb-3">
                                <label class="form-label fw-bold">Tanggal Pencatatan <span class="text-danger">*</span></label>
                                <input type="text" name="dibuat_pada" class="form-control datepicker @error('dibuat_pada') is-invalid @enderror"
                                       value="{{ old('dibuat_pada', date('Y-m-d')) }}" required>
                                @error('dibuat_pada') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Kolom Tengah: Jenis & Tekstur --}}
                <div class="col-lg-4 mb-4">
                    <div class="card border-0 shadow-sm h-100" style="border-radius:12px; border-top:5px solid #16B3AC !important;">
                        <div class="card-header bg-white border-bottom py-3 px-4">
                            <h5 class="m-0 fw-bold text-dark">
                                <i class="bi bi-egg-fried text-teal me-1"></i> Jenis & Tekstur MPASI
                            </h5>
                        </div>
                        <div class="card-body p-4">
                            {{-- Jenis MPASI --}}
                            <div class="mb-4">
                                <label class="form-label fw-bold">Jenis MPASI <span class="text-danger">*</span></label>
                                @php
                                    $jenisBadgeColors = [
                                        'Bubur Susu'       => '#0d6efd',
                                        'Bubur Saring'     => '#16B3AC',
                                        'Pure Sayuran'     => '#16a34a',
                                        'Pure Buah'        => '#F59E0B',
                                        'Bubur Nasi Tim'   => '#8B5CF6',
                                        'Nasi Tim'         => '#EC1E88',
                                        'Finger Food'      => '#ea580c',
                                        'Makanan Keluarga' => '#6366F1',
                                        'Makanan Selingan' => '#14b8a6',
                                    ];
                                @endphp
                                <div class="row g-2">
                                    @foreach ($jenisMpasi as $jenis)
                                        @php $jc = $jenisBadgeColors[$jenis] ?? '#6c757d'; $jid = Str::slug($jenis,'_'); @endphp
                                        <div class="col-12">
                                            <input type="radio" class="btn-check" name="jenis_mpasi" id="jenis_{{ $jid }}"
                                                   value="{{ $jenis }}" {{ old('jenis_mpasi') == $jenis ? 'checked' : '' }} required>
                                            <label class="btn btn-outline-secondary w-100 text-start py-2 px-3"
                                                   for="jenis_{{ $jid }}"
                                                   style="border-radius:10px; font-size:0.85rem; border:2px solid #dee2e6;">
                                                <span class="d-inline-block rounded-circle me-2"
                                                      style="width:10px; height:10px; background:{{ $jc }};"></span>
                                                {{ $jenis }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                                @error('jenis_mpasi') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>

                            {{-- Tekstur --}}
                            <div class="mb-3">
                                <label class="form-label fw-bold">Tekstur <span class="text-danger">*</span></label>
                                <select name="tekstur" class="form-select @error('tekstur') is-invalid @enderror" required>
                                    <option value="">Pilih Tekstur</option>
                                    @foreach ($teksturList as $t)
                                        <option value="{{ $t }}" {{ old('tekstur') == $t ? 'selected' : '' }}>{{ $t }}</option>
                                    @endforeach
                                </select>
                                @error('tekstur') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Kolom Kanan: Frekuensi & Catatan --}}
                <div class="col-lg-4 mb-4">
                    <div class="card border-0 shadow-sm mb-4" style="border-radius:12px; border-top:5px solid #EC1E88 !important;">
                        <div class="card-header bg-white border-bottom py-3 px-4">
                            <h5 class="m-0 fw-bold text-dark">
                                <i class="bi bi-clock-history text-pink me-1"></i> Frekuensi & Catatan Gizi
                            </h5>
                        </div>
                        <div class="card-body p-4">
                            {{-- Frekuensi --}}
                            <div class="mb-4">
                                <label class="form-label fw-bold">Frekuensi Makan <span class="text-danger">*</span></label>
                                <div class="d-flex flex-column gap-2">
                                    @foreach ($frekuensiList as $fr)
                                        <div>
                                            <input type="radio" class="btn-check" name="frekuensi" id="frek_{{ Str::slug($fr,'_') }}"
                                                   value="{{ $fr }}" {{ old('frekuensi') == $fr ? 'checked' : '' }} required>
                                            <label class="btn btn-outline-success w-100 text-start py-2 px-3"
                                                   for="frek_{{ Str::slug($fr,'_') }}"
                                                   style="border-radius:10px; font-size:0.85rem; border:2px solid #dee2e6;">
                                                <i class="bi bi-clock me-2 text-success"></i>{{ $fr }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                                @error('frekuensi') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>

                            {{-- Catatan Gizi --}}
                            <div class="mb-3">
                                <label class="form-label fw-bold">Catatan Gizi <span class="text-danger">*</span></label>
                                <textarea name="catatan_gizi" class="form-control @error('catatan_gizi') is-invalid @enderror" rows="4"
                                          placeholder="Contoh: Anak sudah menerima bubur sayur bayam + tahu, tidak ada reaksi alergi...">{{ old('catatan_gizi') }}</textarea>
                                @error('catatan_gizi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="text-end">
                        <a href="{{ route('mpasi.index') }}" class="btn btn-light border px-4 me-2"
                           style="border-radius:30px; font-weight:600;">Batal</a>
                        <button type="submit" class="btn text-white px-5 shadow-sm"
                                style="background:linear-gradient(135deg,#16a34a,#15803d); border-radius:30px; font-weight:600;">
                            <i class="bi bi-save me-1"></i> Simpan MPASI
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </section>

    <style>
        .text-teal { color: #16B3AC !important; }
        .text-pink { color: #EC1E88 !important; }
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
