@extends('layouts.dashboard.template')

@section('content')
    <div class="pagetitle">
        <h1>Tambah KB Pasca Salin</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('kb-pasca-salin.index') }}">KB Pasca Salin</a></li>
                <li class="breadcrumb-item active">Tambah</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card border-0 shadow-sm mb-4" style="border-radius:12px; border-top:5px solid #EC1E88 !important;">
                    <div class="card-header bg-white border-bottom py-3 px-4">
                        <h5 class="m-0 fw-bold text-dark">Form Tambah KB Pasca Salin</h5>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('kb-pasca-salin.store') }}" method="POST">
                            @csrf

                            <div class="row mb-3">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label fw-bold">Pilih Buku KIA (Pasien) <span class="text-danger">*</span></label>
                                    <select name="buku_kia_id" class="form-select select2 @error('buku_kia_id') is-invalid @enderror" data-placeholder="Pilih Pasien / Buku KIA" required>
                                        <option value=""></option>
                                        @foreach ($bukuKias as $bk)
                                            <option value="{{ $bk->id }}" {{ old('buku_kia_id', $selectedBukuKiaId ?? '') == $bk->id ? 'selected' : '' }}>
                                                {{ $bk->profilIbu->nama_lengkap ?? 'Tidak Diketahui' }} (Reg Kohort Ibu: {{ $bk->no_reg_kohort_ibu ?? '-' }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('buku_kia_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Tenaga Kesehatan (Petugas) <span class="text-danger">*</span></label>
                                    <select name="nakes_id" class="form-select select2 @error('nakes_id') is-invalid @enderror" data-placeholder="Pilih Tenaga Kesehatan" required>
                                        <option value=""></option>
                                        @foreach ($nakes as $n)
                                            <option value="{{ $n->id }}" {{ old('nakes_id', Auth::user()->role->nama_role == 'nakes' ? Auth::id() : '') == $n->id ? 'selected' : '' }}>
                                                {{ $n->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('nakes_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Fasilitas Kesehatan <span class="text-danger">*</span></label>
                                    <select name="fasilitas_kesehatan_id" class="form-select select2 @error('fasilitas_kesehatan_id') is-invalid @enderror" data-placeholder="Pilih Fasilitas Kesehatan" required>
                                        <option value=""></option>
                                        @foreach ($faskes as $f)
                                            <option value="{{ $f->id }}" {{ old('fasilitas_kesehatan_id', Auth::user()->fasilitas_kesehatan_id) == $f->id ? 'selected' : '' }}>
                                                {{ $f->nama_faskes }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('fasilitas_kesehatan_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Metode KB <span class="text-danger">*</span></label>
                                    <select name="metode_kb" class="form-select @error('metode_kb') is-invalid @enderror" required>
                                        <option value="">Pilih Metode KB</option>
                                        @foreach (['MAL (Metode Amenore Laktasi)', 'Kondom', 'Pil KB', 'Suntik KB', 'Implan / Susuk', 'IUD / Spiral', 'MOW (Steril Wanita)', 'MOP (Steril Pria)', 'Lainnya'] as $m)
                                            <option value="{{ $m }}" {{ old('metode_kb') == $m ? 'selected' : '' }}>{{ $m }}</option>
                                        @endforeach
                                    </select>
                                    @error('metode_kb') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Tanggal Mulai <span class="text-danger">*</span></label>
                                    <input type="text" name="tanggal_mulai" class="form-control datepicker @error('tanggal_mulai') is-invalid @enderror" value="{{ old('tanggal_mulai', date('Y-m-d')) }}" placeholder="Pilih Tanggal" required>
                                    @error('tanggal_mulai') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label fw-bold">Catatan</label>
                                    <textarea name="catatan" class="form-control @error('catatan') is-invalid @enderror" rows="4" placeholder="Keterangan tambahan atau catatan medis KB...">{{ old('catatan') }}</textarea>
                                    @error('catatan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-12">
                                    <a href="{{ route('kb-pasca-salin.index') }}" class="btn btn-light border px-4 me-2" style="border-radius:8px;">Batal</a>
                                    <button type="submit" class="btn text-white px-4" style="background-color:#EC1E88; border-radius:8px;">Simpan</button>
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

                // Init Select2 if active
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
