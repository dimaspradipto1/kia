@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Kelola Layanan</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active">Layanan</li>
        </ol>
    </nav>
</div>

<section class="section">
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm" style="border-radius:12px;overflow:hidden;border-top:5px solid #EC1E88 !important;">
                <div class="card-header bg-white border-bottom py-3 px-4 d-flex justify-content-between align-items-center">
                    <h5 class="m-0 fw-bold" style="color:#EC1E88;font-size:1.05rem;">
                        <i class="bi bi-grid-1x2 me-2"></i>Data Layanan
                    </h5>
                    <a href="{{ route('layanans.create') }}" class="btn btn-sm text-white px-4" style="background:#EC1E88;border-radius:8px;">
                        <i class="bi bi-plus-circle me-1"></i> Tambah Layanan
                    </a>
                </div>
                <div class="card-body p-4">
                    <div class="alert alert-info border-0 mb-4" style="border-radius:10px;background:#E0F2FE;">
                        <i class="bi bi-info-circle me-2"></i>
                        Data layanan yang berstatus <strong>Aktif</strong> akan ditampilkan di halaman <strong>Layanan</strong> pada website publik. Urutan menentukan posisi tampil kartu layanan.
                    </div>
                    {{ $dataTable->table(['class' => 'table table-hover table-bordered align-middle']) }}
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
{{ $dataTable->scripts() }}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.btn-delete').forEach(btn => {
            btn.addEventListener('click', function () {
                const form = this.closest('.delete-form');
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
        });
    });
</script>
@endpush
