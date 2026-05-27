@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Intro Halaman Layanan</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active">Intro Layanan</li>
        </ol>
    </nav>
</div>

<section class="section">
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm" style="border-radius:12px;overflow:hidden;border-top:5px solid #EC1E88 !important;">
                <div class="card-header bg-white border-bottom py-3 px-4 d-flex justify-content-between align-items-center">
                    <h5 class="m-0 fw-bold" style="color:#EC1E88;font-size:1.05rem;">
                        <i class="bi bi-layout-text-window-reverse me-2"></i>Kelola Konten Intro Halaman Layanan
                    </h5>
                    <a href="{{ route('layanan-intro.create') }}" class="btn btn-sm text-white px-4" style="background:#EC1E88;border-radius:8px;">
                        <i class="bi bi-plus-circle me-1"></i> Tambah Baru
                    </a>
                </div>
                <div class="card-body p-4">
                    <div class="alert alert-info border-0 mb-4" style="border-radius:10px;background:#E0F2FE;">
                        <i class="bi bi-info-circle me-2"></i>
                        Hanya <strong>1 data aktif</strong> yang ditampilkan sebagai intro di halaman Layanan publik.
                    </div>

                    @if($intro)
                        {{-- Preview card --}}
                        <div class="card border-0 mb-4" style="border-radius:12px;background:linear-gradient(135deg,#FDF2F8,#EFF6FF);">
                            <div class="card-body p-4">
                                <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">
                                    <div>
                                        @if($intro->defaultImage)
                                            <div class="mb-3">
                                                <img src="{{ $intro->defaultImage->url }}" alt="Hero Image" class="rounded-3 shadow-sm" style="max-width:200px; height:auto;">
                                            </div>
                                        @endif
                                        <span class="badge mb-2" style="background:#EC1E88;font-size:.75rem;">{{ $intro->badge_text }}</span>
                                        <h4 class="fw-bold mb-2">{{ $intro->judul }}</h4>
                                        <p class="text-muted mb-3" style="max-width:600px;">{{ $intro->deskripsi }}</p>
                                        @if(is_array($intro->fitur) && count($intro->fitur))
                                            <ul class="list-unstyled mb-0">
                                                @foreach($intro->fitur as $f)
                                                    <li class="d-flex align-items-start gap-2 mb-2">
                                                        <i class="fa fa-check-circle text-success mt-1"></i>
                                                        <div>
                                                            <strong>{{ $f['judul'] }}</strong>
                                                            <br><small class="text-muted">{{ $f['deskripsi'] }}</small>
                                                        </div>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </div>
                                    <div class="d-flex flex-column gap-2">
                                        <span class="badge {{ $intro->is_active ? 'bg-success' : 'bg-danger' }} py-2 px-3">
                                            {{ $intro->is_active ? 'Aktif' : 'Non-Aktif' }}
                                        </span>
                                        <a href="{{ route('layanan-intro.edit', $intro->id) }}" class="btn btn-warning btn-sm">
                                            <i class="bi bi-pencil-square me-1"></i> Edit
                                        </a>
                                        <form action="{{ route('layanan-intro.destroy', $intro->id) }}" method="POST" class="delete-form-intro">
                                            @csrf @method('DELETE')
                                            <button type="button" class="btn btn-danger btn-sm w-100 btn-del-intro">
                                                <i class="bi bi-trash me-1"></i> Hapus
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-5" style="border:2px dashed #e2e8f0;border-radius:12px;">
                            <i class="bi bi-layout-text-window-reverse" style="font-size:3rem;opacity:.3;"></i>
                            <p class="mt-3 text-muted">Belum ada konten intro. Klik <strong>Tambah Baru</strong> untuk membuat.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
document.querySelector('.btn-del-intro')?.addEventListener('click', function () {
    const form = this.closest('.delete-form-intro');
    Swal.fire({
        title: 'Hapus Konten Intro?', text: 'Data akan dihapus permanen.',
        icon: 'warning', showCancelButton: true,
        confirmButtonColor: '#EC1E88', cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, hapus!', cancelButtonText: 'Batal',
    }).then(r => { if (r.isConfirmed) form.submit(); });
});
</script>
@endpush
