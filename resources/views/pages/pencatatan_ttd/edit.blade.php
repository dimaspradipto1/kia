@extends('layouts.dashboard.template')

@section('content')
    <div class="pagetitle">
        <h1>Edit Catatan TTD / MMS</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('pencatatan-ttd.index') }}">Pencatatan TTD</a></li>
                <li class="breadcrumb-item active">Edit</li>
            </ol>
        </nav>
    </div>

    <section class="section animate__animated animate__fadeIn">
        <form action="{{ route('pencatatan-ttd.update', $pencatatanTtd->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm mb-4" style="border-radius:12px; border-top:5px solid #e11d48 !important;">
                        <div class="card-header bg-white border-bottom py-3 px-4">
                            <h5 class="m-0 fw-bold text-dark"><i class="bi bi-pencil-square text-danger me-1"></i> Edit Data Pemberian TTD</h5>
                        </div>
                        <div class="card-body p-4">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Pilih Buku KIA (Pasien) <span class="text-danger">*</span></label>
                                <select name="buku_kia_id" class="form-select select2 @error('buku_kia_id') is-invalid @enderror" data-placeholder="Pilih Pasien / Buku KIA" required>
                                    <option value=""></option>
                                    @foreach ($bukuKias as $bk)
                                        <option value="{{ $bk->id }}" {{ old('buku_kia_id', $pencatatanTtd->buku_kia_id) == $bk->id ? 'selected' : '' }}>
                                            {{ $bk->profilIbu->nama_lengkap ?? 'Tidak Diketahui' }} (Reg Kohort: {{ $bk->no_reg_kohort_ibu ?? '-' }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('buku_kia_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Tanggal Pemberian <span class="text-danger">*</span></label>
                                    <input type="text" name="tanggal" class="form-control datepicker @error('tanggal') is-invalid @enderror" value="{{ old('tanggal', $pencatatanTtd->tanggal) }}" placeholder="Pilih Tanggal" required>
                                    @error('tanggal') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Status Konsumsi <span class="text-danger">*</span></label>
                                    <div class="d-flex gap-4 mt-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="diminum" id="diminum_ya" value="Ya" {{ old('diminum', $pencatatanTtd->diminum) == 'Ya' ? 'checked' : '' }} required>
                                            <label class="form-check-label fw-semibold text-success cursor-pointer" for="diminum_ya">
                                                <i class="bi bi-check-circle-fill me-1"></i> Ya (Diminum)
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="diminum" id="diminum_tidak" value="Tidak" {{ old('diminum', $pencatatanTtd->diminum) == 'Tidak' ? 'checked' : '' }} required>
                                            <label class="form-check-label fw-semibold text-danger cursor-pointer" for="diminum_tidak">
                                                <i class="bi bi-x-circle-fill me-1"></i> Tidak Diminum
                                            </label>
                                        </div>
                                    </div>
                                    @error('diminum') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Catatan / Keterangan</label>
                                <textarea name="catatan" class="form-control @error('catatan') is-invalid @enderror" rows="4" placeholder="Keterangan dosis, reaksi obat, atau catatan penting lainnya...">{{ old('catatan', $pencatatanTtd->catatan) }}</textarea>
                                @error('catatan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="row mt-4">
                                <div class="col-12 text-end">
                                    <a href="{{ route('pencatatan-ttd.index') }}" class="btn btn-light border px-4 me-2" style="border-radius:30px; font-weight: 600;">Batal</a>
                                    <button type="submit" class="btn text-white px-5 shadow-sm" style="background-color:#e11d48; border-radius:30px; font-weight: 600;">
                                        <i class="bi bi-save me-1"></i> Perbarui Catatan
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
