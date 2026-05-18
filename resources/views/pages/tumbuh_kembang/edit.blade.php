@extends('layouts.dashboard.template')

@section('content')
    <div class="pagetitle">
        <h1>Edit Tumbuh Kembang</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('tumbuh-kembang.index') }}">Tumbuh Kembang</a></li>
                <li class="breadcrumb-item active">Edit</li>
            </ol>
        </nav>
    </div>

    <section class="section animate__animated animate__fadeIn">
        <form action="{{ route('tumbuh-kembang.update', $tumbuhKembang->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                {{-- Kolom Kiri: Identitas --}}
                <div class="col-lg-4 mb-4">
                    <div class="card border-0 shadow-sm h-100" style="border-radius:12px; border-top:5px solid #ea580c !important;">
                        <div class="card-header bg-white border-bottom py-3 px-4">
                            <h5 class="m-0 fw-bold text-dark"><i class="bi bi-pencil-square me-1" style="color:#ea580c;"></i> Edit Identitas & Petugas</h5>
                        </div>
                        <div class="card-body p-4">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Profil Anak <span class="text-danger">*</span></label>
                                <select name="profil_anak_id" class="form-select select2 @error('profil_anak_id') is-invalid @enderror" data-placeholder="Pilih Nama Anak" required>
                                    <option value=""></option>
                                    @foreach ($profilAnaks as $pa)
                                        <option value="{{ $pa->id }}" {{ old('profil_anak_id', $tumbuhKembang->profil_anak_id) == $pa->id ? 'selected' : '' }}>
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
                                <label class="form-label fw-bold">Fasilitas Kesehatan <span class="text-danger">*</span></label>
                                <select name="fasilitas_kesehatan_id" class="form-select select2 @error('fasilitas_kesehatan_id') is-invalid @enderror" data-placeholder="Pilih Faskes" required>
                                    <option value=""></option>
                                    @foreach ($faskes as $f)
                                        <option value="{{ $f->id }}" {{ old('fasilitas_kesehatan_id', $tumbuhKembang->fasilitas_kesehatan_id) == $f->id ? 'selected' : '' }}>
                                            {{ $f->nama_faskes }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('fasilitas_kesehatan_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Tenaga Kesehatan <span class="text-danger">*</span></label>
                                <select name="nakes_id" class="form-select select2 @error('nakes_id') is-invalid @enderror" data-placeholder="Pilih Nakes" required>
                                    <option value=""></option>
                                    @foreach ($nakes as $n)
                                        <option value="{{ $n->id }}" {{ old('nakes_id', $tumbuhKembang->nakes_id) == $n->id ? 'selected' : '' }}>
                                            {{ $n->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('nakes_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Tanggal Pengukuran <span class="text-danger">*</span></label>
                                <input type="text" name="tanggal_ukur" class="form-control datepicker @error('tanggal_ukur') is-invalid @enderror"
                                       value="{{ old('tanggal_ukur', $tumbuhKembang->tanggal_ukur->format('Y-m-d')) }}" required>
                                @error('tanggal_ukur') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Usia Anak (Bulan) <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" name="usia_bulan" class="form-control @error('usia_bulan') is-invalid @enderror"
                                           value="{{ old('usia_bulan', $tumbuhKembang->usia_bulan) }}" min="0" max="60" required>
                                    <span class="input-group-text bg-light text-muted">bulan</span>
                                </div>
                                @error('usia_bulan') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Kolom Tengah: Pengukuran Fisik --}}
                <div class="col-lg-4 mb-4">
                    <div class="card border-0 shadow-sm h-100" style="border-radius:12px; border-top:5px solid #16B3AC !important;">
                        <div class="card-header bg-white border-bottom py-3 px-4">
                            <h5 class="m-0 fw-bold text-dark"><i class="bi bi-rulers text-teal me-1"></i> Pengukuran Fisik</h5>
                        </div>
                        <div class="card-body p-4">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Berat Badan <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" step="0.01" name="berat_badan" class="form-control @error('berat_badan') is-invalid @enderror"
                                           value="{{ old('berat_badan', $tumbuhKembang->berat_badan) }}" required>
                                    <span class="input-group-text bg-light text-muted">kg</span>
                                </div>
                                @error('berat_badan') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Tinggi / Panjang Badan <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" step="0.01" name="tinggi_badan" class="form-control @error('tinggi_badan') is-invalid @enderror"
                                           value="{{ old('tinggi_badan', $tumbuhKembang->tinggi_badan) }}" required>
                                    <span class="input-group-text bg-light text-muted">cm</span>
                                </div>
                                @error('tinggi_badan') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Lingkar Kepala</label>
                                <div class="input-group">
                                    <input type="number" step="0.01" name="lingkar_kepala" class="form-control @error('lingkar_kepala') is-invalid @enderror"
                                           value="{{ old('lingkar_kepala', $tumbuhKembang->lingkar_kepala) }}" placeholder="Opsional">
                                    <span class="input-group-text bg-light text-muted">cm</span>
                                </div>
                                @error('lingkar_kepala') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Lingkar Lengan Atas (LiLA)</label>
                                <div class="input-group">
                                    <input type="number" step="0.01" name="lila_cm" class="form-control @error('lila_cm') is-invalid @enderror"
                                           value="{{ old('lila_cm', $tumbuhKembang->lila_cm) }}" placeholder="Opsional">
                                    <span class="input-group-text bg-light text-muted">cm</span>
                                </div>
                                @error('lila_cm') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Kolom Kanan: Status Gizi --}}
                <div class="col-lg-4 mb-4">
                    <div class="card border-0 shadow-sm mb-4" style="border-radius:12px; border-top:5px solid #EC1E88 !important;">
                        <div class="card-header bg-white border-bottom py-3 px-4">
                            <h5 class="m-0 fw-bold text-dark"><i class="bi bi-activity text-pink me-1"></i> Status Gizi & Stunting</h5>
                        </div>
                        <div class="card-body p-4">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Status Gizi BB/U <span class="text-danger">*</span></label>
                                <select name="status_gizi_bb_u" class="form-select @error('status_gizi_bb_u') is-invalid @enderror" required>
                                    <option value="">Pilih Status</option>
                                    @foreach ($statusGizi as $s)
                                        <option value="{{ $s }}" {{ old('status_gizi_bb_u', $tumbuhKembang->status_gizi_bb_u) == $s ? 'selected' : '' }}>{{ $s }}</option>
                                    @endforeach
                                </select>
                                <small class="text-muted">Berat Badan menurut Umur</small>
                                @error('status_gizi_bb_u') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Status Gizi TB/U <span class="text-danger">*</span></label>
                                <select name="status_gizi_tb_u" class="form-select @error('status_gizi_tb_u') is-invalid @enderror" required>
                                    <option value="">Pilih Status</option>
                                    @foreach ($statusTb as $s)
                                        <option value="{{ $s }}" {{ old('status_gizi_tb_u', $tumbuhKembang->status_gizi_tb_u) == $s ? 'selected' : '' }}>{{ $s }}</option>
                                    @endforeach
                                </select>
                                <small class="text-muted">Tinggi Badan menurut Umur</small>
                                @error('status_gizi_tb_u') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Status Gizi BB/TB <span class="text-danger">*</span></label>
                                <select name="status_gizi_bb_tb" class="form-select @error('status_gizi_bb_tb') is-invalid @enderror" required>
                                    <option value="">Pilih Status</option>
                                    @foreach ($statusGizi as $s)
                                        <option value="{{ $s }}" {{ old('status_gizi_bb_tb', $tumbuhKembang->status_gizi_bb_tb) == $s ? 'selected' : '' }}>{{ $s }}</option>
                                    @endforeach
                                </select>
                                <small class="text-muted">Berat Badan menurut Tinggi Badan</small>
                                @error('status_gizi_bb_tb') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Status Stunting</label>
                                <select name="status_stunting" class="form-select @error('status_stunting') is-invalid @enderror">
                                    <option value="">Pilih (Opsional)</option>
                                    @foreach ($statusStunting as $s)
                                        <option value="{{ $s }}" {{ old('status_stunting', $tumbuhKembang->status_stunting) == $s ? 'selected' : '' }}>{{ $s }}</option>
                                    @endforeach
                                </select>
                                @error('status_stunting') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm mb-4" style="border-radius:12px; border-top:5px solid #6366F1 !important;">
                        <div class="card-body p-4">
                            <label class="form-label fw-bold"><i class="bi bi-journal-text me-1" style="color:#6366F1;"></i> Catatan</label>
                            <textarea name="catatan" class="form-control @error('catatan') is-invalid @enderror" rows="3"
                                      placeholder="Rekomendasi diet, perkembangan motorik, dll. (Opsional)">{{ old('catatan', $tumbuhKembang->catatan) }}</textarea>
                            @error('catatan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="text-end">
                        <a href="{{ route('tumbuh-kembang.index') }}" class="btn btn-light border px-4 me-2" style="border-radius:30px; font-weight:600;">Batal</a>
                        <button type="submit" class="btn text-white px-5 shadow-sm" style="background:linear-gradient(135deg,#ea580c,#c2410c); border-radius:30px; font-weight:600;">
                            <i class="bi bi-save me-1"></i> Perbarui Data
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
                        placeholder: function() { return $(this).data('placeholder'); },
                        allowClear: true
                    });
                }
            });
        </script>
    @endpush
@endsection
