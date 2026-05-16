@extends('layouts.dashboard.template')

@section('content')
    <div class="pagetitle">
        <h1>Profil Suami</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Profil Suami</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card border-0 shadow-sm" style="border-radius: 12px; border-top: 5px solid #EC1E88 !important;">
                    <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                        <a href="{{ route('profil-suami.create') }}" class="btn text-white px-4" style="background-color: #EC1E88; border-radius: 50px;">
                            <i class="bi bi-plus-lg me-1"></i> + TAMBAH PROFIL
                        </a>
                        <h5 class="m-0 fw-bold text-dark">Daftar Profil Suami</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            {{ $dataTable->table(['class' => 'table table-hover w-100', 'id' => 'profilsuami-table']) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @push('scripts')
        {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
        <script>
            $(document).on('click', '.btn-delete', function(e) {
                e.preventDefault();
                let form = $(this).closest('form');
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
                            url: form.attr('action'),
                            type: 'POST',
                            data: form.serialize(),
                            success: function(response) {
                                if (response.status === 'success') {
                                    Swal.fire({
                                        title: 'Terhapus!',
                                        text: response.message,
                                        icon: 'success',
                                        confirmButtonColor: '#EC1E88'
                                    }).then(() => {
                                        $('#profilsuami-table').DataTable().ajax.reload();
                                    });
                                }
                            }
                        });
                    }
                });
            });
        </script>
    @endpush
@endsection
