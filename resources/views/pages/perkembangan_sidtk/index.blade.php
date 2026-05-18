@extends('layouts.dashboard.template')

@section('content')
    <div class="pagetitle d-flex justify-content-between align-items-center">
        <div>
            <h1>Perkembangan SIDTK</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Perkembangan SIDTK</li>
                </ol>
            </nav>
        </div>
    </div>

    <section class="section animate__animated animate__fadeIn">
        <div class="row">
            {{-- Kartu Info Kiri --}}
            <div class="col-lg-3 mb-4">
                <div class="card border-0 shadow-sm" style="border-radius:12px; background: linear-gradient(135deg, #F5F3FF 0%, #EDE9FE 100%);">
                    <div class="card-body p-4 d-flex flex-column align-items-center text-center">
                        <div class="d-flex align-items-center justify-content-center mb-3"
                             style="width:80px; height:80px; border-radius:50%; background:white;">
                            <i class="bi bi-brain" style="font-size:2.5rem; color:#7c3aed;"></i>
                        </div>
                        <h5 class="fw-bold text-dark mb-1">Perkembangan SIDTK</h5>
                        <p class="text-muted small mb-4">Stimulasi, Intervensi, Deteksi Dini Tumbuh Kembang anak usia 0–72 bulan.</p>

                        <a href="{{ route('perkembangan-sidtk.create') }}" class="btn w-100 text-white py-2 shadow-sm fw-bold"
                           style="background: linear-gradient(135deg, #7c3aed, #6d28d9); border-radius:30px; letter-spacing:0.5px;">
                            <i class="bi bi-plus-circle-fill me-1"></i> CATAT SKRINING
                        </a>

                        <hr class="w-100 my-3">

                        <div class="w-100 text-start">
                            @php
                                $total    = \App\Models\PerkembanganSidtk::count();
                                $sesuai   = \App\Models\PerkembanganSidtk::where('hasil', 'Sesuai')->count();
                                $menyimpang = \App\Models\PerkembanganSidtk::where('hasil', 'Penyimpangan')->count();
                            @endphp
                            <div class="d-flex align-items-center mb-2 p-2 rounded" style="background:rgba(124,58,237,.08);">
                                <i class="bi bi-clipboard-data-fill me-2" style="color:#7c3aed;"></i>
                                <div>
                                    <div class="fw-semibold small text-dark">Total Skrining</div>
                                    <div class="fw-bold fs-5" style="color:#7c3aed;">{{ $total }}</div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center mb-2 p-2 rounded" style="background:rgba(124,58,237,.08);">
                                <i class="bi bi-check-circle-fill text-success me-2"></i>
                                <div>
                                    <div class="fw-semibold small text-dark">Sesuai</div>
                                    <div class="fw-bold fs-5 text-success">{{ $sesuai }}</div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center p-2 rounded" style="background:rgba(124,58,237,.08);">
                                <i class="bi bi-exclamation-triangle-fill text-danger me-2"></i>
                                <div>
                                    <div class="fw-semibold small text-dark">Penyimpangan</div>
                                    <div class="fw-bold fs-5 text-danger">{{ $menyimpang }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tabel Data Kanan --}}
            <div class="col-lg-9 mb-4">
                <div class="card border-0 shadow-sm" style="border-radius:12px;">
                    <div class="card-header bg-white border-bottom py-3 px-4 d-flex justify-content-between align-items-center">
                        <h5 class="m-0 fw-bold text-dark">Data Skrining Perkembangan SIDTK</h5>
                        <span class="badge text-white px-3 py-2 fw-semibold"
                              style="border-radius:20px; background:linear-gradient(135deg,#7c3aed,#6d28d9);">
                            Total: {{ \App\Models\PerkembanganSidtk::count() }}
                        </span>
                    </div>
                    <div class="card-body p-4">
                        <div class="table-responsive">
                            {{ $dataTable->table(['class' => 'table table-hover align-middle table-custom-sidtk', 'style' => 'width:100%']) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
        .table-custom-sidtk thead th {
            background-color: #F5F3FF !important;
            color: #7c3aed !important;
            font-weight: 700 !important;
            text-transform: uppercase;
            font-size: 0.78rem;
            letter-spacing: 0.5px;
            border-bottom: 3px solid #7c3aed !important;
            padding: 12px 16px !important;
        }
        .table-custom-sidtk tbody td {
            padding: 12px 16px !important;
            border-bottom: 1px solid #EDE9FE !important;
        }
        .table-custom-sidtk tbody tr:hover {
            background-color: #F5F3FF !important;
        }
    </style>

    @push('scripts')
        {{ $dataTable->scripts() }}
        <script>
            $(document).on('click', '.btn-delete', function () {
                var id = $(this).data('id');
                Swal.fire({
                    title: 'Hapus Data Skrining?',
                    text: "Catatan SIDTK ini akan terhapus permanen!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ url('perkembangan-sidtk') }}/" + id,
                            type: 'POST',
                            data: { _method: 'DELETE', _token: "{{ csrf_token() }}" },
                            success: function (response) {
                                if (response.status === 'success') {
                                    Swal.fire({
                                        title: 'Terhapus!',
                                        text: response.message,
                                        icon: 'success',
                                        confirmButtonColor: '#7c3aed'
                                    }).then(() => {
                                        window.LaravelDataTables["perkembangansidtk-table"].ajax.reload();
                                    });
                                }
                            },
                            error: function () {
                                Swal.fire('Gagal!', 'Terjadi kesalahan saat menghapus data.', 'error');
                            }
                        });
                    }
                });
            });
        </script>
    @endpush
@endsection
