@extends('layouts.dashboard.template')

@section('content')
    <div class="pagetitle d-flex justify-content-between align-items-center">
        <div>
            <h1>Bayi Baru Lahir</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Bayi Baru Lahir</li>
                </ol>
            </nav>
        </div>
    </div>

    <section class="section animate__animated animate__fadeIn">
        <div class="row">
            {{-- Banner Info Atas --}}
            <div class="col-lg-12 mb-4">
                <div class="card border-0 shadow-sm" style="border-radius:12px; background: linear-gradient(135deg, #E8F5FF 0%, #D1E9FF 100%);">
                    <div class="card-body p-4">
                        <div class="row align-items-center">
                            <!-- Info Utama -->
                            <div class="col-xl-5 col-lg-6 d-flex align-items-center gap-3 mb-3 mb-lg-0">
                                <div class="d-flex align-items-center justify-content-center shadow-xs flex-shrink-0"
                                     style="width:70px; height:70px; border-radius:50%; background:white;">
                                    <i class="bi bi-emoji-smile-fill" style="font-size:2.2rem; color:#0d6efd;"></i>
                                </div>
                                <div>
                                    <h4 class="fw-bold text-dark mb-1">Bayi Baru Lahir</h4>
                                    <p class="text-muted small mb-0">Catat data pemeriksaan, imunisasi awal, dan kondisi bayi saat lahir.</p>
                                </div>
                            </div>
                            
                            <!-- Metrics Cards -->
                            <div class="col-xl-5 col-lg-6 mb-3 mb-lg-0">
                                <div class="row g-2">
                                    <div class="col-6">
                                        <div class="d-flex align-items-center p-2 rounded h-100" style="background:rgba(13,110,253,.07);">
                                            <i class="bi bi-check-circle-fill text-success me-2 fs-5 d-none d-sm-inline"></i>
                                            <div>
                                                <div class="fw-semibold text-dark" style="font-size: 0.7rem; line-height: 1.1;">Total Tercatat</div>
                                                <div class="fw-bold fs-6 text-primary mt-0.5">{{ \App\Models\BayiBaruLahir::count() }}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="d-flex align-items-center p-2 rounded h-100" style="background:rgba(13,110,253,.07);">
                                            <i class="bi bi-people-fill text-info me-2 fs-5 d-none d-sm-inline"></i>
                                            <div>
                                                <div class="fw-semibold text-dark" style="font-size: 0.7rem; line-height: 1.1;">Kondisi Baik</div>
                                                <div class="fw-bold fs-6 text-success mt-0.5">{{ \App\Models\BayiBaruLahir::where('kondisi_umum','Baik')->count() }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Tombol Aksi -->
                            <div class="col-xl-2 col-lg-12 text-xl-end mt-3 mt-xl-0">
                                <a href="{{ route('bayi-baru-lahir.create') }}" class="btn text-white py-2.5 px-3 shadow-sm fw-bold w-100"
                                   style="background: linear-gradient(135deg, #0d6efd, #0a58ca); border-radius:30px; letter-spacing: 0.5px; font-size: 0.85rem;">
                                    <i class="bi bi-plus-circle-fill me-1"></i> CATAT BAYI
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
                        <h5 class="m-0 fw-bold text-dark">Data Pemeriksaan Bayi Baru Lahir</h5>
                        <span class="badge text-white px-3 py-2 fw-semibold" style="border-radius:20px; background:linear-gradient(135deg,#0d6efd,#0a58ca);">
                            Total: {{ \App\Models\BayiBaruLahir::count() }}
                        </span>
                    </div>
                    <div class="card-body p-4">
                        <div class="table-responsive">
                            {{ $dataTable->table(['class' => 'table table-hover table-bordered align-middle table-custom-bbl', 'style' => 'width:100%']) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
        .table-custom-bbl.table-bordered,
        .table-custom-bbl.table-bordered th,
        .table-custom-bbl.table-bordered td {
            border: 1px solid #dbeafe !important;
        }
        .table-custom-bbl thead th {
            background-color: #EFF6FF !important;
            color: #0d6efd !important;
            font-weight: 700 !important;
            text-transform: uppercase;
            font-size: 0.78rem;
            letter-spacing: 0.5px;
            border-bottom: 3px solid #0d6efd !important;
            padding: 12px 16px !important;
        }
        .table-custom-bbl tbody td {
            padding: 12px 16px !important;
            border-bottom: 1px solid #dbeafe !important;
        }
        .table-custom-bbl tbody tr:hover {
            background-color: #F0F7FF !important;
        }
        .shadow-xs { box-shadow: 0 2px 4px rgba(0,0,0,0.04); }
    </style>

    @push('scripts')
        {{ $dataTable->scripts() }}
        <script>
            $(document).on('click', '.btn-delete', function () {
                var id = $(this).data('id');
                Swal.fire({
                    title: 'Hapus Data Bayi Baru Lahir?',
                    text: "Seluruh data pencatatan bayi ini akan terhapus permanen!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ url('bayi-baru-lahir') }}/" + id,
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
                                        confirmButtonColor: '#0d6efd'
                                    }).then(() => {
                                        window.LaravelDataTables["bayibarulahir-table"].ajax.reload();
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
