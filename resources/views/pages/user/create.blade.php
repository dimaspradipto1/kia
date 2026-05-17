@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Tambah User</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item">Data Master</li>
            <li class="breadcrumb-item"><a href="{{ route('users.index') }}">User</a></li>
            <li class="breadcrumb-item active">Tambah</li>
        </ol>
    </nav>
</div>

<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px; overflow: hidden; border-top: 5px solid #EC1E88 !important;">
                <div class="card-header bg-white border-bottom py-3 px-4">
                    <h5 class="m-0 fw-bold text-dark" style="font-size: 1.1rem;">Form Tambah User</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-3">
                            <label for="name" class="col-sm-2 col-form-label fw-bold">Nama Lengkap</label>
                            <div class="col-sm-10">
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-sm-2 col-form-label fw-bold">Email</label>
                            <div class="col-sm-10">
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="roles_id" class="col-sm-2 col-form-label fw-bold">Role</label>
                            <div class="col-sm-10">
                                <select name="roles_id" class="form-select @error('roles_id') is-invalid @enderror" required>
                                    <option value="">Pilih Role</option>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->id }}" data-name="{{ strtolower($role->nama_role) }}" {{ old('roles_id') == $role->id ? 'selected' : '' }}>
                                            {{ ucfirst($role->nama_role) }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('roles_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3 d-none" id="nakes-fields-1">
                            <label for="wilaya_dinkes_id" class="col-sm-2 col-form-label fw-bold">Wilayah Dinkes</label>
                            <div class="col-sm-10">
                                <select name="wilaya_dinkes_id" id="wilaya_dinkes_id" class="form-select @error('wilaya_dinkes_id') is-invalid @enderror">
                                    <option value="">Pilih Wilayah Dinkes</option>
                                    @foreach($wilayaDinkes as $dinkes)
                                        <option value="{{ $dinkes->id }}" {{ old('wilaya_dinkes_id') == $dinkes->id ? 'selected' : '' }}>
                                            {{ $dinkes->nama_dinkes }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('wilaya_dinkes_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3 d-none" id="nakes-fields-2">
                            <label for="fasilitas_kesehatan_id" class="col-sm-2 col-form-label fw-bold">Fasilitas Kesehatan</label>
                            <div class="col-sm-10">
                                <select name="fasilitas_kesehatan_id" id="fasilitas_kesehatan_id" class="form-select @error('fasilitas_kesehatan_id') is-invalid @enderror">
                                    <option value="">Pilih Fasilitas Kesehatan</option>
                                    @foreach($fasilitasKesehatan as $faskes)
                                        <option value="{{ $faskes->id }}" {{ old('fasilitas_kesehatan_id') == $faskes->id ? 'selected' : '' }}>
                                            {{ $faskes->nama_faskes }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('fasilitas_kesehatan_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-sm-2 col-form-label fw-bold">Password</label>
                            <div class="col-sm-10">
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-lock"></i></span>
                                    <input type="password" name="password" id="password" class="form-control border-start-0 border-end-0 @error('password') is-invalid @enderror" required>
                                    <button class="btn btn-outline-secondary border-start-0 toggle-password" type="button" data-target="password">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>
                                @error('password')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password_confirmation" class="col-sm-2 col-form-label fw-bold">Konfirmasi Password</label>
                            <div class="col-sm-10">
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-check2-circle"></i></span>
                                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control border-start-0 border-end-0" required>
                                    <button class="btn btn-outline-secondary border-start-0 toggle-password" type="button" data-target="password_confirmation">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>
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
                            <label for="photo" class="col-sm-2 col-form-label fw-bold">Foto Profil</label>
                            <div class="col-sm-10">
                                <input type="file" name="photo" class="form-control @error('photo') is-invalid @enderror" accept="image/*">
                                @error('photo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-10 offset-sm-2">
                                <button type="submit" class="btn text-white px-4" style="background-color: #EC1E88;">Simpan User</button>
                                <a href="{{ route('users.index') }}" class="btn btn-secondary px-4">Batal</a>
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
    document.querySelectorAll('.toggle-password').forEach(button => {
        button.addEventListener('click', function() {
            const targetId = this.getAttribute('data-target');
            const input = document.getElementById(targetId);
            const icon = this.querySelector('i');
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('bi-eye', 'bi-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.replace('bi-eye-slash', 'bi-eye');
            }
        });
    });

    // Handle role change for nakes fields
    const rolesSelect = document.querySelector('select[name="roles_id"]');
    const nakesField1 = document.getElementById('nakes-fields-1');
    const nakesField2 = document.getElementById('nakes-fields-2');
    const dinkesSelect = document.getElementById('wilaya_dinkes_id');
    const faskesSelect = document.getElementById('fasilitas_kesehatan_id');

    function checkNakesFields() {
        const selectedOption = rolesSelect.options[rolesSelect.selectedIndex];
        if (!selectedOption) return;
        
        const roleName = selectedOption.getAttribute('data-name');
        
        if (roleName === 'nakes' || roleName === 'tenaga kesehatan') {
            nakesField1.classList.remove('d-none');
            nakesField2.classList.remove('d-none');
            dinkesSelect.setAttribute('required', 'required');
            faskesSelect.setAttribute('required', 'required');
        } else {
            nakesField1.classList.add('d-none');
            nakesField2.classList.add('d-none');
            dinkesSelect.removeAttribute('required');
            faskesSelect.removeAttribute('required');
            dinkesSelect.value = '';
            faskesSelect.value = '';
        }
    }

    rolesSelect.addEventListener('change', checkNakesFields);
    
    // Trigger on page load to handle old() values
    checkNakesFields();
</script>
@endpush
@endsection
