@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Edit Role</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item">Data Master</li>
            <li class="breadcrumb-item"><a href="{{ route('roles.index') }}">Role</a></li>
            <li class="breadcrumb-item active">Edit</li>
        </ol>
    </nav>
</div>

<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px; overflow: hidden; border-top: 5px solid #046B26 !important;">
                <div class="card-header bg-white border-bottom py-3 px-4">
                    <h5 class="m-0 fw-bold text-dark" style="font-size: 1.1rem;">Form Edit Role: {{ $role->nama_role }}</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('roles.update', $role->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row mb-3">
                            <label for="nama_role" class="col-sm-2 col-form-label fw-bold">Nama Role</label>
                            <div class="col-sm-10">
                                <input type="text" name="nama_role" class="form-control @error('nama_role') is-invalid @enderror" value="{{ old('nama_role', $role->nama_role) }}" required>
                                @error('nama_role')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="deskripsi" class="col-sm-2 col-form-label fw-bold">Deskripsi</label>
                            <div class="col-sm-10">
                                <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" rows="3">{{ old('deskripsi', $role->deskripsi) }}</textarea>
                                @error('deskripsi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-10 offset-sm-2">
                                <button type="submit" class="btn btn-success px-4" style="background-color: #046B26;">Perbarui Role</button>
                                <a href="{{ route('roles.index') }}" class="btn btn-secondary px-4">Batal</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
