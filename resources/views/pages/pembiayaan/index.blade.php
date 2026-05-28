@extends('layouts.dashboard.template')

@section('content')
    <div class="pagetitle">
        <h1>Pembiayaan</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Pembiayaan</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card border-0 shadow-sm" style="border-radius:12px; border-top:5px solid #EC1E88 !important;">
                    <div class="card-header bg-white border-bottom py-3 px-4 d-flex justify-content-between align-items-center">
                        <a href="{{ route('pembiayaan.create') }}" class="btn btn-sm text-white px-3"
                           style="background-color:#EC1E88; border-radius:20px;">
                            <i class="bi bi-plus-circle me-1"></i> TAMBAH PEMBIAYAAN
                        </a>
                        <h5 class="m-0 fw-bold text-dark">Daftar Pembiayaan</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            {{ $dataTable->table(['class' => 'table table-hover table-bordered align-middle w-100']) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
    <script>
        $(document).on('click', '.btn-delete', function () {
            const form = $(this).closest('.delete-form');
            Swal.fire({
                title: 'Hapus Data?',
                text: 'Data pembiayaan akan dihapus permanen!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#EC1E88',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) form.submit();
            });
        });
    </script>
@endpush
