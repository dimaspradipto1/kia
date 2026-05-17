@extends('layouts.dashboard.template')

@section('content')
    <div class="pagetitle">
        <h1>Wilayah Dinkes</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Wilayah Dinkes</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px; border-top: 5px solid #EC1E88 !important;">
                    <div class="card-header bg-white border-bottom py-3 px-4">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <div class="d-inline-flex shadow-sm overflow-hidden" style="border: 1px solid #e3e6f0; border-radius: 30px;">
                                    <a href="{{ route('wilaya-dinkes.create') }}" class="btn btn-sm font-weight-bold px-3 py-1 border-0" style="background-color: #EC1E88; color: white; font-size: 11px; height: 32px; display: flex; align-items: center; border-radius: 30px;">
                                        <i class="bi bi-plus-lg me-1"></i> TAMBAH DINKES
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-4 text-end">
                                <h5 class="m-0 fw-bold text-dark" style="font-size: 1.1rem;">Data Wilayah Dinkes</h5>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <div class="table-responsive">
                            {!! $dataTable->table(['class' => 'table table-hover table-striped w-100']) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @push('scripts')
        {!! $dataTable->scripts() !!}
        <script>
            function confirmDelete(id) {
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Data yang dihapus tidak dapat dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#EC1E88',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ url('wilaya-dinkes') }}/" + id,
                            type: 'POST',
                            data: {
                                _method: 'DELETE',
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                if (response.status === 'success') {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Berhasil!',
                                        text: response.message,
                                        confirmButtonColor: '#EC1E88'
                                    }).then(() => {
                                        $('#wilayadinkes-table').DataTable().ajax.reload();
                                    });
                                } else {
                                    Swal.fire('Error!', response.message, 'error');
                                }
                            },
                            error: function(xhr) {
                                Swal.fire('Error!', 'Terjadi kesalahan saat menghapus data.', 'error');
                            }
                        });
                    }
                });
            }
        </script>
    @endpush
@endsection
