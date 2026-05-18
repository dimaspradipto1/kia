@extends('layouts.dashboard.template')

@section('content')
    <div class="pagetitle d-flex justify-content-between align-items-center">
        <div>
            <h1>Imunisasi Anak</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Imunisasi Anak</li>
                </ol>
            </nav>
        </div>
    </div>

    <section class="section animate__animated animate__fadeIn">
        <div class="row">
            {{-- Kartu Info Kiri --}}
            <div class="col-lg-3 mb-4">
                <div class="card border-0 shadow-sm" style="border-radius:12px; background: linear-gradient(135deg, #F0FFF4 0%, #DCFCE7 100%);">
                    <div class="card-body p-4 d-flex flex-column align-items-center text-center">
                        <div class="d-flex align-items-center justify-content-center mb-3"
                             style="width:80px; height:80px; border-radius:50%; background:white;">
                            <i class="bi bi-shield-plus-fill" style="font-size:2.5rem; color:#16a34a;"></i>
                        </div>
                        <h5 class="fw-bold text-dark mb-1">Imunisasi Anak</h5>
                        <p class="text-muted small mb-4">Catat pemberian vaksin dan imunisasi sesuai jadwal program nasional.</p>

                        <a href="{{ route('imunisasi-anak.create') }}" class="btn w-100 text-white py-2 shadow-sm fw-bold"
                           style="background: linear-gradient(135deg, #16a34a, #15803d); border-radius:30px; letter-spacing:0.5px;">
                            <i class="bi bi-plus-circle-fill me-1"></i> CATAT IMUNISASI
                        </a>

                        <hr class="w-100 my-3">

                        <div class="w-100 text-start">
                            <div class="d-flex align-items-center mb-2 p-2 rounded" style="background:rgba(22,163,74,.08);">
                                <i class="bi bi-check-circle-fill text-success me-2"></i>
                                <div>
                                    <div class="fw-semibold small text-dark">Total Tercatat</div>
                                    <div class="fw-bold fs-5 text-success">{{ \App\Models\ImunisasiAnak::count() }}</div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center p-2 rounded" style="background:rgba(22,163,74,.08);">
                                <i class="bi bi-calendar-check-fill text-success me-2"></i>
                                <div>
                                    <div class="fw-semibold small text-dark">Bulan Ini</div>
                                    <div class="fw-bold fs-5 text-success">{{ \App\Models\ImunisasiAnak::whereMonth('tanggal_pemberian', now()->month)->whereYear('tanggal_pemberian', now()->year)->count() }}</div>
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
                        <h5 class="m-0 fw-bold text-dark">Data Pemberian Imunisasi Anak</h5>
                        <span class="badge text-white px-3 py-2 fw-semibold"
                              style="border-radius:20px; background:linear-gradient(135deg,#16a34a,#15803d);">
                            Total: {{ \App\Models\ImunisasiAnak::count() }}
                        </span>
                    </div>
                    <div class="card-body p-4">
                        <div class="table-responsive">
                            {{ $dataTable->table(['class' => 'table table-hover align-middle table-custom-imunisasi', 'style' => 'width:100%']) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
        .table-custom-imunisasi thead th {
            background-color: #F0FFF4 !important;
            color: #16a34a !important;
            font-weight: 700 !important;
            text-transform: uppercase;
            font-size: 0.78rem;
            letter-spacing: 0.5px;
            border-bottom: 3px solid #16a34a !important;
            padding: 12px 16px !important;
        }
        .table-custom-imunisasi tbody td {
            padding: 12px 16px !important;
            border-bottom: 1px solid #DCFCE7 !important;
        }
        .table-custom-imunisasi tbody tr:hover {
            background-color: #F0FFF4 !important;
        }
    </style>

    @push('scripts')
        {{ $dataTable->scripts() }}
        <script>
            $(document).on('click', '.btn-delete', function () {
                var id = $(this).data('id');
                Swal.fire({
                    title: 'Hapus Data Imunisasi?',
                    text: "Catatan imunisasi ini akan terhapus permanen!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ url('imunisasi-anak') }}/" + id,
                            type: 'POST',
                            data: { _method: 'DELETE', _token: "{{ csrf_token() }}" },
                            success: function (response) {
                                if (response.status === 'success') {
                                    Swal.fire({
                                        title: 'Terhapus!',
                                        text: response.message,
                                        icon: 'success',
                                        confirmButtonColor: '#16a34a'
                                    }).then(() => {
                                        window.LaravelDataTables["imunisasianak-table"].ajax.reload();
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
