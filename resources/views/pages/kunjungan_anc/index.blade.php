@extends('layouts.dashboard.template')

@section('content')
    <div class="pagetitle d-flex justify-content-between align-items-center">
        <div>
            <h1>Kunjungan Antenatal Care (ANC)</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Kunjungan ANC</li>
                </ol>
            </nav>
        </div>
    </div>

    <section class="section animate__animated animate__fadeIn">
        <div class="row">
            {{-- Kapsul Navigasi Kiri --}}
            <div class="col-lg-3 mb-4">
                <div class="card border-0 shadow-sm" style="border-radius:12px; background: linear-gradient(135deg, #FFF0F5 0%, #FFE4E1 100%);">
                    <div class="card-body p-4 d-flex flex-column align-items-center text-center">
                        <div class="d-flex align-items-center justify-content-center mb-3 shadow-xs"
                             style="width:80px; height:80px; border-radius:50%; background:white;">
                            <i class="bi bi-clipboard2-pulse-fill" style="font-size:2.5rem; color:#EC1E88;"></i>
                        </div>
                        <h5 class="fw-bold text-dark mb-1">Pemeriksaan ANC</h5>
                        <p class="text-muted small mb-4">Catat pemeriksaan rutin ibu hamil (Trimester 1, 2, dan 3) secara berkala.</p>
                        
                        <a href="{{ route('kunjungan-anc.create') }}" class="btn w-100 text-white py-2.5 shadow-sm fw-bold"
                           style="background-color:#EC1E88; border-radius:30px; letter-spacing: 0.5px;">
                            <i class="bi bi-plus-circle-fill me-1.5"></i> CATAT KUNJUNGAN
                        </a>
                    </div>
                </div>
            </div>

            {{-- Tabel Data Kanan --}}
            <div class="col-lg-9 mb-4">
                <div class="card border-0 shadow-sm" style="border-radius:12px;">
                    <div class="card-header bg-white border-bottom py-3 px-4 d-flex justify-content-between align-items-center">
                        <h5 class="m-0 fw-bold text-dark">Data Pemeriksaan ANC</h5>
                        <span class="badge bg-light text-pink border border-pink px-3 py-2 fw-semibold" style="border-radius:20px;">
                            Total Kunjungan: {{ \App\Models\KunjunganAnc::count() }}
                        </span>
                    </div>
                    <div class="card-body p-4">
                        <div class="table-responsive">
                            {{ $dataTable->table(['class' => 'table table-hover align-middle table-custom-anc', 'style' => 'width:100%']) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
        .text-pink {
            color: #EC1E88 !important;
        }
        .border-pink {
            border-color: #fce4f1 !important;
        }
        /* Custom Premium Table Styling */
        .table-custom-anc thead th {
            background-color: #FFF0F5 !important;
            color: #EC1E88 !important;
            font-weight: 700 !important;
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 0.5px;
            border-bottom: 3px solid #EC1E88 !important;
            padding: 12px 16px !important;
        }
        .table-custom-anc tbody td {
            padding: 12px 16px !important;
            border-bottom: 1px solid #fce4f1 !important;
        }
        .table-custom-anc tbody tr:hover {
            background-color: #FFF5F7 !important;
        }
        .shadow-xs {
            box-shadow: 0 2px 4px rgba(0,0,0,0.02);
        }
    </style>

    @push('scripts')
        {{ $dataTable->scripts() }}
        <script>
            $(document).on('click', '.btn-delete', function () {
                var id = $(this).data('id');
                Swal.fire({
                    title: 'Hapus Pemeriksaan ANC?',
                    text: "Seluruh data riwayat pemeriksaan antenatal care ini akan terhapus!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#EC1E88',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ url('kunjungan-anc') }}/" + id,
                            type: 'POST',
                            data: {
                                _method: 'DELETE',
                                _token: "{{ csrf_token() }}"
                            },
                            success: function (response) {
                                if (response.status === 'success') {
                                    Swal.fire({
                                        title: 'Terhapus!',
                                        text: response.message,
                                        icon: 'success',
                                        confirmButtonColor: '#EC1E88'
                                    }).then(() => {
                                        window.LaravelDataTables["kunjunganancs-table"].ajax.reload();
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
