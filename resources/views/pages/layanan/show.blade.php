@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Detail Layanan</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('layanans.index') }}">Layanan</a></li>
            <li class="breadcrumb-item active">Detail</li>
        </ol>
    </nav>
</div>

<section class="section">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm" style="border-radius:12px;overflow:hidden;border-top:5px solid #EC1E88 !important;">
                <div class="card-header bg-white border-bottom py-3 px-4 d-flex justify-content-between align-items-center">
                    <h5 class="m-0 fw-bold" style="color:#EC1E88;font-size:1.05rem;">
                        <i class="bi bi-grid-1x2 me-2"></i>Detail Layanan
                    </h5>
                    <div class="d-flex gap-2">
                        <a href="{{ route('layanans.edit', $layanan->id) }}" class="btn btn-warning btn-sm">
                            <i class="bi bi-pencil-square me-1"></i> Edit
                        </a>
                        <a href="{{ route('layanans.index') }}" class="btn btn-secondary btn-sm">
                            <i class="bi bi-arrow-left me-1"></i> Kembali
                        </a>
                    </div>
                </div>
                <div class="card-body p-4">
                    @php
                        $colors = $temaColors[$layanan->tema] ?? $temaColors['pink'];
                    @endphp

                    {{-- Preview Kartu --}}
                    <div class="text-center mb-4">
                        <div class="d-inline-block p-4 rounded-3" style="background:{{ $colors['bg'] }};border:2px solid {{ $colors['border'] }};min-width:200px;">
                            <div style="width:64px;height:64px;border-radius:50%;background:{{ $colors['bg'] }};border:2px solid {{ $colors['border'] }};display:flex;align-items:center;justify-content:center;margin:0 auto 12px;">
                                <i class="fa {{ $layanan->ikon }}" style="font-size:1.8rem;color:{{ $colors['ikon'] }};"></i>
                            </div>
                            <h5 class="fw-bold mb-1">{{ $layanan->judul }}</h5>
                            @if($layanan->deskripsi)
                                <p class="text-muted small mb-0">{{ $layanan->deskripsi }}</p>
                            @endif
                        </div>
                    </div>

                    <table class="table table-borderless">
                        <tr>
                            <th width="180" class="text-muted fw-normal">Judul</th>
                            <td class="fw-bold">{{ $layanan->judul }}</td>
                        </tr>
                        <tr>
                            <th class="text-muted fw-normal">Ikon</th>
                            <td><code>{{ $layanan->ikon }}</code></td>
                        </tr>
                        <tr>
                            <th class="text-muted fw-normal">Tema Warna</th>
                            <td>
                                <span class="badge" style="background:{{ $colors['ikon'] }}">{{ ucfirst($layanan->tema) }}</span>
                            </td>
                        </tr>
                        <tr>
                            <th class="text-muted fw-normal">Urutan Tampil</th>
                            <td>{{ $layanan->urutan }}</td>
                        </tr>
                        <tr>
                            <th class="text-muted fw-normal">Status</th>
                            <td>
                                @if($layanan->is_active)
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-danger">Non-Aktif</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th class="text-muted fw-normal">Deskripsi Singkat</th>
                            <td>{{ $layanan->deskripsi ?: '-' }}</td>
                        </tr>
                        @if($layanan->deskripsi_panjang)
                        <tr>
                            <th class="text-muted fw-normal align-top">Deskripsi Lengkap</th>
                            <td style="white-space:pre-wrap">{{ $layanan->deskripsi_panjang }}</td>
                        </tr>
                        @endif
                        <tr>
                            <th class="text-muted fw-normal">Dibuat</th>
                            <td>{{ $layanan->created_at->format('d M Y, H:i') }}</td>
                        </tr>
                        <tr>
                            <th class="text-muted fw-normal">Terakhir Diperbarui</th>
                            <td>{{ $layanan->updated_at->format('d M Y, H:i') }}</td>
                        </tr>
                    </table>

                    {{-- Hapus --}}
                    <div class="border-top pt-3 mt-2">
                        <form action="{{ route('layanans.destroy', $layanan->id) }}" method="POST" class="d-inline delete-form-detail">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-danger btn-sm btn-delete-detail">
                                <i class="bi bi-trash me-1"></i> Hapus Layanan Ini
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
document.querySelector('.btn-delete-detail')?.addEventListener('click', function () {
    const form = this.closest('.delete-form-detail');
    Swal.fire({
        title: 'Hapus Layanan?',
        text: 'Data layanan ini akan dihapus permanen.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#EC1E88',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal',
    }).then(result => { if (result.isConfirmed) form.submit(); });
});
</script>
@endpush
