@extends('layouts.dashboard.template')

@section('content')
    <div class="pagetitle">
        <h1>Unggah Dokumen</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('dokumen.index') }}">Dokumen</a></li>
                <li class="breadcrumb-item active">Unggah</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card border-0 shadow-sm mb-4" style="border-radius:12px; border-top:5px solid #EC1E88 !important;">
                    <div class="card-header bg-white border-bottom py-3 px-4">
                        <h5 class="m-0 fw-bold text-dark">Form Unggah Dokumen</h5>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('dokumen.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <label class="form-label fw-bold">Pilih Buku KIA (Ibu) <span class="text-danger">*</span></label>
                                    <select name="buku_kia_id" class="form-select select2 @error('buku_kia_id') is-invalid @enderror" data-placeholder="Pilih Pemilik Buku KIA" required>
                                        <option value=""></option>
                                        @foreach ($bukuKia as $b)
                                            <option value="{{ $b->id }}" {{ old('buku_kia_id') == $b->id ? 'selected' : '' }}>
                                                {{ $b->profilIbu->nama_lengkap }} (QR: {{ $b->qr_code }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('buku_kia_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div id="repeater-container">
                                <div class="repeater-item border rounded p-3 mb-3 bg-light position-relative">
                                    <div class="row">
                                        <div class="col-md-5 mb-2">
                                            <label class="form-label fw-bold small">Jenis Dokumen <span class="text-danger">*</span></label>
                                            <select name="items[0][jenis]" class="form-select select2-basic" required>
                                                <option value="">Pilih Jenis</option>
                                                @foreach(['KTP Ibu', 'KTP Suami', 'Kartu Keluarga', 'Buku Nikah', 'Kartu BPJS/Asuransi', 'Lainnya'] as $j)
                                                    <option value="{{ $j }}">{{ $j }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <label class="form-label fw-bold small">File <span class="text-danger">*</span></label>
                                            <input type="file" name="items[0][file]" class="form-control" required>
                                            <small class="text-muted" style="font-size: 10px;">PDF, JPG, PNG (Max: 2MB)</small>
                                        </div>
                                        <div class="col-md-1 d-flex align-items-end mb-2">
                                            <button type="button" class="btn btn-danger btn-sm remove-item d-none"><i class="bi bi-trash"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <button type="button" id="add-item" class="btn btn-sm btn-outline-primary mb-4" style="border-radius: 20px;">
                                <i class="bi bi-plus-circle me-1"></i> Tambah Dokumen Lain
                            </button>

                            <div class="row">
                                <div class="col-12">
                                    <hr>
                                    <a href="{{ route('dokumen.index') }}" class="btn btn-light border px-4 me-2" style="border-radius:8px;">Batal</a>
                                    <button type="submit" class="btn text-white px-4" style="background-color:#EC1E88; border-radius:8px;">Simpan Semua Dokumen</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <template id="repeater-template">
        <div class="repeater-item border rounded p-3 mb-3 bg-light position-relative">
            <div class="row">
                <div class="col-md-5 mb-2">
                    <label class="form-label fw-bold small">Jenis Dokumen <span class="text-danger">*</span></label>
                    <select name="items[REPLACE_INDEX][jenis]" class="form-select" required>
                        <option value="">Pilih Jenis</option>
                        @foreach(['KTP Ibu', 'KTP Suami', 'Kartu Keluarga', 'Buku Nikah', 'Kartu BPJS/Asuransi', 'Lainnya'] as $j)
                            <option value="{{ $j }}">{{ $j }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 mb-2">
                    <label class="form-label fw-bold small">File <span class="text-danger">*</span></label>
                    <input type="file" name="items[REPLACE_INDEX][file]" class="form-control" required>
                    <small class="text-muted" style="font-size: 10px;">PDF, JPG, PNG (Max: 2MB)</small>
                </div>
                <div class="col-md-1 d-flex align-items-end mb-2">
                    <button type="button" class="btn btn-danger btn-sm remove-item"><i class="bi bi-trash"></i></button>
                </div>
            </div>
        </div>
    </template>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let index = 1;
            const container = document.getElementById('repeater-container');
            const template = document.getElementById('repeater-template').innerHTML;
            const addButton = document.getElementById('add-item');

            addButton.addEventListener('click', function () {
                const newItem = template.replace(/REPLACE_INDEX/g, index);
                container.insertAdjacentHTML('beforeend', newItem);
                index++;
                updateRemoveButtons();
            });

            container.addEventListener('click', function (e) {
                if (e.target.closest('.remove-item')) {
                    e.target.closest('.repeater-item').remove();
                    updateRemoveButtons();
                }
            });

            function updateRemoveButtons() {
                const items = container.querySelectorAll('.repeater-item');
                items.forEach((item, i) => {
                    const removeBtn = item.querySelector('.remove-item');
                    if (items.length === 1) {
                        removeBtn.classList.add('d-none');
                    } else {
                        removeBtn.classList.remove('d-none');
                    }
                });
            }
        });
    </script>
@endpush
