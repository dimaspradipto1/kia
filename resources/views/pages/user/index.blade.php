@extends('layouts.dashboard.template')

@section('content')
    <div class="card border-0 shadow-sm mb-4"
        style="border-radius: 12px; overflow: hidden; border-top: 5px solid #EC1E88 !important;">
        <div class="card-header bg-white border-bottom py-3 px-4">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="d-inline-flex shadow-sm overflow-hidden"
                        style="border: 1px solid #e3e6f0; border-radius: 30px;">
                        <a href="{{ route('users.create') }}"
                            class="btn btn-sm font-weight-bold px-3 py-1 border-0 text-white"
                            style="background-color: #EC1E88; font-size: 11px; height: 32px; display: flex; align-items: center; border-top-left-radius: 30px; border-bottom-left-radius: 30px;">
                            <i class="bi bi-plus-lg me-1"></i> TAMBAH
                        </a>
                        <button type="button"
                            class="btn btn-white btn-sm px-3 py-1 border-0 border-start rounded-0 text-primary"
                            data-bs-toggle="modal" data-bs-target="#importModal"
                            style="font-size: 11px; height: 32px; display: flex; align-items: center; background: white;">
                            <i class="bi bi-file-earmark-excel me-1"></i> IMPOR EXCEL
                        </button>
                        <a href="{{ route('users.export-template') }}"
                            class="btn btn-white btn-sm px-3 py-1 border-0 border-start font-weight-bold"
                            style="font-size: 11px; height: 32px; display: flex; align-items: center; border-top-right-radius: 30px; border-bottom-right-radius: 30px; color: #28a745; background: white;">
                            <i class="bi bi-download me-1"></i> DOWNLOAD FORMAT
                        </a>
                    </div>
                </div>
                <div class="col-md-4 text-end">
                    <h5 class="m-0 fw-bold text-dark" style="font-size: 1.1rem;">Data Pengguna</h5>
                </div>
            </div>
        </div>

        <!-- Import Modal -->
        <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg">
        <div class="modal-header text-white" style="background-color: #EC1E88;">
            <h5 class="modal-title fw-bold" id="importModalLabel">Impor Data Pengguna</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                aria-label="Close"></button>
        </div>
                    <form action="{{ route('users.import') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body p-4">
                            <div class="alert alert-info border-0 shadow-none mb-4 d-flex align-items-center">
                                <i class="bi bi-info-circle-fill me-2 fs-5"></i>
                                <div>Pastikan format file sesuai dengan <strong>Format Import</strong> yang telah
                                    disediakan.</div>
                            </div>
                            <div class="form-group mb-3">
                                <label class="fw-bold mb-2">Pilih Berkas Excel (.xlsx / .csv)</label>
                                <input type="file" name="file" class="form-control" id="importFile" required
                                    accept=".xlsx, .xls, .csv">
                            </div>
                        </div>
                        <div class="modal-footer bg-light border-0">
                            <button type="button" class="btn btn-secondary btn-sm px-4"
                                data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-sm px-4 shadow-sm text-white" style="background-color: #EC1E88;">
                                <i class="bi bi-cloud-arrow-up me-1"></i> Mulai Impor
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="card-body p-4">
            <div class="table-responsive">
                {{ $dataTable->table([
                    'class' => 'table table-striped table-bordered align-middle',
                    'style' => 'width:100%',
                ]) }}
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    @if (app()->environment('production'))
        {!! str_replace('http:', 'https:', $dataTable->scripts()) !!}
    @else
        {!! $dataTable->scripts() !!}
    @endif
    <script>
        $(document).on('click', '.btn-delete', function(e) {
            e.preventDefault();
            const form = $(this).closest('form');
            
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#EC1E88',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    </script>
@endpush
