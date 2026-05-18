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
            {{-- Kapsul Navigasi Kiri --}}
            <div class="col-lg-3 mb-4">
                <div class="card border-0 shadow-sm" style="border-radius:12px; background: linear-gradient(135deg, #E8F5FF 0%, #D1E9FF 100%);">
                    <div class="card-body p-4 d-flex flex-column align-items-center text-center">
                        <div class="d-flex align-items-center justify-content-center mb-3 shadow-xs"
                             style="width:80px; height:80px; border-radius:50%; background:white;">
                            <i class="bi bi-baby" style="font-size:2.5rem; color:#0d6efd;"></i>
                        </div>
                        <h5 class="fw-bold text-dark mb-1">Bayi Baru Lahir</h5>
                        <p class="text-muted small mb-4">Catat data pemeriksaan, imunisasi awal, dan kondisi bayi saat lahir.</p>

                        <a href="{{ route('bayi-baru-lahir.create') }}" class="btn w-100 text-white py-2 shadow-sm fw-bold"
                           style="background: linear-gradient(135deg, #0d6efd, #0a58ca); border-radius:30px; letter-spacing: 0.5px;">
                            <i class="bi bi-plus-circle-fill me-1"></i> CATAT BAYI BARU LAHIR
                        </a>

                        <hr class="w-100 my-3">

                        <div class="w-100 text-start">
                            <div class="d-flex align-items-center mb-2 p-2 rounded" style="background:rgba(13,110,253,.07);">
                                <i class="bi bi-check-circle-fill text-success me-2"></i>
                                <div>
                                    <div class="fw-semibold small text-dark">Total Tercatat</div>
                                    <div class="fw-bold fs-5 text-primary">{{ \App\Models\BayiBaruLahir::count() }}</div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center p-2 rounded" style="background:rgba(13,110,253,.07);">
                                <i class="bi bi-people-fill text-info me-2"></i>
                                <div>
                                    <div class="fw-semibold small text-dark">Kondisi Baik</div>
                                    <div class="fw-bold fs-5 text-success">{{ \App\Models\BayiBaruLahir::where('kondisi_umum','Baik')->count() }}</div>
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
                        <h5 class="m-0 fw-bold text-dark">Data Pemeriksaan Bayi Baru Lahir</h5>
                        <span class="badge text-white px-3 py-2 fw-semibold" style="border-radius:20px; background:linear-gradient(135deg,#0d6efd,#0a58ca);">
                            Total: {{ \App\Models\BayiBaruLahir::count() }}
                        </span>
                    </div>
                    <div class="card-body p-4">
                        <div class="table-responsive">
                            {{ $dataTable->table(['class' => 'table table-hover align-middle table-custom-bbl', 'style' => 'width:100%']) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
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
