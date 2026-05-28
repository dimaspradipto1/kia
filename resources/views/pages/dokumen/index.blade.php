@extends('layouts.dashboard.template')

@section('content')
    <div class="pagetitle">
        <h1>Manajemen Dokumen</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Dokumen</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card border-0 shadow-sm" style="border-radius:12px; border-top:5px solid #EC1E88 !important;">
                    <div class="card-header bg-white border-bottom py-3 px-4 d-flex justify-content-between align-items-center">
                        <a href="{{ route('dokumen.create') }}" class="btn btn-sm text-white px-3"
                           style="background-color:#EC1E88; border-radius:20px;">
                            <i class="bi bi-plus-circle me-1"></i> TAMBAH DOKUMEN
                        </a>
                        <h5 class="m-0 fw-bold text-dark">Daftar Dokumen</h5>
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
                title: 'Hapus Dokumen?',
                text: 'File dokumen akan dihapus permanen!',
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

        $(document).on('click', '.btn-update-status', function () {
            const id = $(this).data('id');
            const status = $(this).data('status');
            const title = status === 'verified' ? 'Verifikasi Dokumen?' : 'Tolak Dokumen?';
            const text = status === 'verified' ? 'Dokumen akan ditandai sebagai sah.' : 'Dokumen akan ditolak.';
            const color = status === 'verified' ? '#198754' : '#dc3545';

            Swal.fire({
                title: title,
                text: text,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: color,
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Lanjutkan!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/dokumen/${id}/status`,
                        type: 'PATCH',
                        data: {
                            _token: '{{ csrf_token() }}',
                            status: status
                        },
                        success: function (response) {
                            if (response.success) {
                                Swal.fire('Berhasil!', response.message, 'success');
                                window.LaravelDataTables["dokumen-table"].ajax.reload();
                            }
                        },
                        error: function () {
                            Swal.fire('Gagal!', 'Terjadi kesalahan sistem.', 'error');
                        }
                    });
                }
            });
        });
    </script>
@endpush
