@extends('layouts.dashboard.template')

@section('content')
    <div class="pagetitle">
        <h1>Edit Wilayah Dinkes</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('wilaya-dinkes.index') }}">Wilayah Dinkes</a></li>
                <li class="breadcrumb-item active">Edit</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px; border-top: 5px solid #EC1E88 !important;">
                    <div class="card-header bg-white border-bottom py-3 px-4">
                        <h5 class="m-0 fw-bold text-dark">Form Edit Wilayah Dinkes</h5>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('wilaya-dinkes.update', $wilayaDinke->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row mb-3">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Kode Dinkes <span class="text-danger">*</span></label>
                                    <input type="text" name="kode_dinkes" class="form-control @error('kode_dinkes') is-invalid @enderror" value="{{ old('kode_dinkes', $wilayaDinke->kode_dinkes) }}" required>
                                    @error('kode_dinkes') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Tipe Dinkes <span class="text-danger">*</span></label>
                                    <select name="tipe_dinkes" class="form-select @error('tipe_dinkes') is-invalid @enderror" required>
                                        <option value="">Pilih Tipe</option>
                                        <option value="Provinsi" {{ old('tipe_dinkes', $wilayaDinke->tipe_dinkes) == 'Provinsi' ? 'selected' : '' }}>Provinsi</option>
                                        <option value="Kabupaten" {{ old('tipe_dinkes', $wilayaDinke->tipe_dinkes) == 'Kabupaten' ? 'selected' : '' }}>Kabupaten</option>
                                        <option value="Kota" {{ old('tipe_dinkes', $wilayaDinke->tipe_dinkes) == 'Kota' ? 'selected' : '' }}>Kota</option>
                                        <option value="Puskesmas" {{ old('tipe_dinkes', $wilayaDinke->tipe_dinkes) == 'Puskesmas' ? 'selected' : '' }}>Puskesmas</option>
                                        <option value="Lainnya" {{ old('tipe_dinkes', $wilayaDinke->tipe_dinkes) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                    </select>
                                    @error('tipe_dinkes') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Nama Dinkes <span class="text-danger">*</span></label>
                                <textarea name="nama_dinkes" class="form-control @error('nama_dinkes') is-invalid @enderror" rows="3" required>{{ old('nama_dinkes', $wilayaDinke->nama_dinkes) }}</textarea>
                                @error('nama_dinkes') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="row mt-4">
                                <div class="col-12 text-end">
                                    <a href="{{ route('wilaya-dinkes.index') }}" class="btn btn-light border px-4 me-2" style="border-radius: 8px;">Batal</a>
                                    <button type="submit" class="btn text-white px-4" style="background-color: #EC1E88; border-radius: 8px;">Perbarui</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
