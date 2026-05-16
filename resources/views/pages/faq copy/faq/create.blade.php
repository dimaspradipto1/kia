@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Tambah FAQ</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('faqs.index') }}">FAQ</a></li>
            <li class="breadcrumb-item active">Tambah</li>
        </ol>
    </nav>
</div>

<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px; overflow: hidden; border-top: 5px solid #EC1E88 !important;">
                <div class="card-header bg-white border-bottom py-3 px-4">
                    <h5 class="m-0 fw-bold text-dark" style="font-size: 1.1rem;">Form Tambah FAQ</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('faqs.store') }}" method="POST">
                        @csrf
                        <div class="row mb-3">
                            <label for="pertanyaan" class="col-sm-2 col-form-label fw-bold">Pertanyaan</label>
                            <div class="col-sm-10">
                                <input type="text" name="pertanyaan" class="form-control @error('pertanyaan') is-invalid @enderror" value="{{ old('pertanyaan') }}" required>
                                @error('pertanyaan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="jawaban" class="col-sm-2 col-form-label fw-bold">Jawaban</label>
                            <div class="col-sm-10">
                                <textarea name="jawaban" class="form-control @error('jawaban') is-invalid @enderror" rows="5" required>{{ old('jawaban') }}</textarea>
                                @error('jawaban')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="tips" class="col-sm-2 col-form-label fw-bold">Tips (Opsional)</label>
                            <div class="col-sm-10">
                                <textarea name="tips" class="form-control @error('tips') is-invalid @enderror" rows="3">{{ old('tips') }}</textarea>
                                @error('tips')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>



                        <div class="row mb-3">
                            <label for="is_active" class="col-sm-2 col-form-label fw-bold">Status</label>
                            <div class="col-sm-10">
                                <select name="is_active" class="form-select @error('is_active') is-invalid @enderror" required>
                                    <option value="1" {{ old('is_active') == '1' ? 'selected' : '' }}>Aktif</option>
                                    <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>Non-Aktif</option>
                                </select>
                                @error('is_active')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-10 offset-sm-2">
                                <button type="submit" class="btn text-white px-4" style="background-color: #EC1E88;">Simpan FAQ</button>
                                <a href="{{ route('faqs.index') }}" class="btn btn-secondary px-4">Batal</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
