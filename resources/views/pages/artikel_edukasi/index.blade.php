@extends('layouts.dashboard.template')

@section('content')
    <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px; overflow: hidden; border-top: 5px solid #EC1E88 !important;">
        <div class="card-header bg-white border-bottom py-3 px-4">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="d-inline-flex shadow-sm overflow-hidden" style="border: 1px solid #e3e6f0; border-radius: 30px;">
                        <a href="{{ route('artikel-edukasi.create') }}" class="btn btn-success btn-sm font-weight-bold px-3 py-1 border-0"
                            style="background-color: #EC1E88; color: white; font-size: 11px; height: 32px; display: flex; align-items: center; border-top-left-radius: 30px; border-bottom-left-radius: 30px;">
                            <i class="bi bi-plus-lg me-1"></i> TULIS ARTIKEL
                        </a>
                    </div>
                    <a href="{{ route('homepage.artikel') }}" target="_blank" class="btn btn-sm btn-outline-secondary ms-2" style="border-radius:20px;font-size:11px;">
                        <i class="bi bi-box-arrow-up-right me-1"></i> Lihat di Publik
                    </a>
                </div>
                <div class="col-md-4 text-end">
                    <h5 class="m-0 fw-bold text-dark" style="font-size: 1.1rem;">
                        <i class="bi bi-newspaper me-1" style="color:#EC1E88;"></i> Manajemen Artikel Edukasi
                    </h5>
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
                title: 'Hapus Artikel?',
                text: "Artikel yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#EC1E88',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) form.submit();
            });
        });
    </script>
@endpush
