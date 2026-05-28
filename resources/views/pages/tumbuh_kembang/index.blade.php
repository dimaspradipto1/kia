@extends('layouts.dashboard.template')

@section('content')
    <div class="pagetitle d-flex justify-content-between align-items-center">
        <div>
            <h1>Tumbuh Kembang Anak</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Tumbuh Kembang</li>
                </ol>
            </nav>
        </div>
    </div>

    <section class="section animate__animated animate__fadeIn">
        <div class="row">
            {{-- Banner Info Atas --}}
            <div class="col-lg-12 mb-4">
                <div class="card border-0 shadow-sm" style="border-radius:12px; background: linear-gradient(135deg, #FFF7ED 0%, #FED7AA 100%);">
                    <div class="card-body p-4">
                        <div class="row align-items-center">
                            <!-- Info Utama -->
                            <div class="col-xl-5 col-lg-6 d-flex align-items-center gap-3 mb-3 mb-lg-0">
                                <div class="d-flex align-items-center justify-content-center shadow-xs flex-shrink-0"
                                     style="width:70px; height:70px; border-radius:50%; background:white;">
                                    <i class="bi bi-bar-chart-line-fill" style="font-size:2.2rem; color:#ea580c;"></i>
                                </div>
                                <div>
                                    <h4 class="fw-bold text-dark mb-1">Tumbuh Kembang</h4>
                                    <p class="text-muted small mb-0">Pantau berat badan, tinggi badan, dan status gizi anak secara berkala.</p>
                                </div>
                            </div>
                            
                            <!-- Metrics Cards -->
                            <div class="col-xl-5 col-lg-6 mb-3 mb-lg-0">
                                <div class="row g-2">
                                    <div class="col-4">
                                        <div class="d-flex align-items-center p-2 rounded h-100" style="background:rgba(234,88,12,.08);">
                                            <i class="bi bi-clipboard-data-fill text-warning me-2 fs-5 d-none d-sm-inline"></i>
                                            <div>
                                                <div class="fw-semibold text-dark" style="font-size: 0.7rem; line-height: 1.1;">Total Pengukuran</div>
                                                <div class="fw-bold fs-6 mt-0.5" style="color:#ea580c;">{{ \App\Models\TumbuhKembang::count() }}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="d-flex align-items-center p-2 rounded h-100" style="background:rgba(234,88,12,.08);">
                                            <i class="bi bi-exclamation-triangle-fill text-danger me-2 fs-5 d-none d-sm-inline"></i>
                                            <div>
                                                <div class="fw-semibold text-dark" style="font-size: 0.7rem; line-height: 1.1;">Stunting</div>
                                                <div class="fw-bold fs-6 text-danger mt-0.5">{{ \App\Models\TumbuhKembang::where('status_stunting', 'like', '%Stunting%')->count() }}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="d-flex align-items-center p-2 rounded h-100" style="background:rgba(234,88,12,.08);">
                                            <i class="bi bi-calendar-check-fill text-success me-2 fs-5 d-none d-sm-inline"></i>
                                            <div>
                                                <div class="fw-semibold text-dark" style="font-size: 0.7rem; line-height: 1.1;">Bulan Ini</div>
                                                <div class="fw-bold fs-6 text-success mt-0.5">{{ \App\Models\TumbuhKembang::whereMonth('tanggal_ukur', now()->month)->whereYear('tanggal_ukur', now()->year)->count() }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Tombol Aksi -->
                            <div class="col-xl-2 col-lg-12 text-xl-end mt-3 mt-xl-0">
                                <a href="{{ route('tumbuh-kembang.create') }}" class="btn text-white py-2.5 px-3 shadow-sm fw-bold w-100"
                                   style="background: linear-gradient(135deg, #ea580c, #c2410c); border-radius:30px; letter-spacing:0.5px; font-size: 0.85rem;">
                                    <i class="bi bi-plus-circle-fill me-1"></i> CATAT UKUR
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tabel Data Bawah --}}
            <div class="col-lg-12 mb-4">
                <div class="card border-0 shadow-sm" style="border-radius:12px;">
                    <div class="card-header bg-white border-bottom py-3 px-4 d-flex justify-content-between align-items-center">
                        <h5 class="m-0 fw-bold text-dark">Data Pengukuran Tumbuh Kembang</h5>
                        <span class="badge text-white px-3 py-2 fw-semibold"
                              style="border-radius:20px; background:linear-gradient(135deg,#ea580c,#c2410c);">
                            Total: {{ \App\Models\TumbuhKembang::count() }}
                        </span>
                    </div>
                    <div class="card-body p-4">
                        <div class="table-responsive">
                            {{ $dataTable->table(['class' => 'table table-hover table-bordered align-middle table-custom-tk', 'style' => 'width:100%']) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
        .table-custom-tk.table-bordered,
        .table-custom-tk.table-bordered th,
        .table-custom-tk.table-bordered td {
            border: 1px solid #FED7AA !important;
        }
        .table-custom-tk thead th {
            background-color: #FFF7ED !important;
            color: #ea580c !important;
            font-weight: 700 !important;
            text-transform: uppercase;
            font-size: 0.78rem;
            letter-spacing: 0.5px;
            border-bottom: 3px solid #ea580c !important;
            padding: 12px 16px !important;
        }
        .table-custom-tk tbody td {
            padding: 12px 16px !important;
            border-bottom: 1px solid #FED7AA !important;
        }
        .table-custom-tk tbody tr:hover {
            background-color: #FFF7ED !important;
        }
    </style>

    @push('scripts')
        {{ $dataTable->scripts() }}
        <script>
            $(document).on('click', '.btn-delete', function () {
                var id = $(this).data('id');
                Swal.fire({
                    title: 'Hapus Data Tumbuh Kembang?',
                    text: "Catatan pengukuran ini akan terhapus permanen!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ url('tumbuh-kembang') }}/" + id,
                            type: 'POST',
                            data: { _method: 'DELETE', _token: "{{ csrf_token() }}" },
                            success: function (response) {
                                if (response.status === 'success') {
                                    Swal.fire({
                                        title: 'Terhapus!',
                                        text: response.message,
                                        icon: 'success',
                                        confirmButtonColor: '#ea580c'
                                    }).then(() => {
                                        window.LaravelDataTables["tumbuhkembang-table"].ajax.reload();
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
