@extends('layouts.dashboard.template')

@section('content')
    <div class="pagetitle d-flex justify-content-between align-items-center">
        <div>
            <h1>Pencatatan TTD / MMS</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Pencatatan TTD</li>
                </ol>
            </nav>
        </div>
    </div>

    <section class="section animate__animated animate__fadeIn">
        <div class="row">
            {{-- Banner Info Atas --}}
            <div class="col-lg-12 mb-4">
                <div class="card border-0 shadow-sm" style="border-radius:12px; background: linear-gradient(135deg, #FFF1F2 0%, #FFE4E6 100%);">
                    <div class="card-body p-4">
                        <div class="row align-items-center">
                            <!-- Info Utama -->
                            <div class="col-xl-5 col-lg-6 d-flex align-items-center gap-3 mb-3 mb-lg-0">
                                <div class="d-flex align-items-center justify-content-center shadow-xs flex-shrink-0"
                                     style="width:70px; height:70px; border-radius:50%; background:white;">
                                    <i class="bi bi-droplet-fill" style="font-size:2.2rem; color:#E11D48;"></i>
                                </div>
                                <div>
                                    <h4 class="fw-bold text-dark mb-1">Pencatatan TTD / MMS</h4>
                                    <p class="text-muted small mb-0">Pantau pemberian dan konsumsi Tablet Tambah Darah (TTD) dan suplemen mikronutrien bagi Ibu Hamil.</p>
                                </div>
                            </div>
                            
                            <!-- Metrics Cards -->
                            <div class="col-xl-5 col-lg-6 mb-3 mb-lg-0">
                                @php
                                    $query = \App\Models\PencatatanTtd::query();
                                    if (auth()->user()->role->nama_role === 'ibu hamil') {
                                        $query->whereHas('bukuKia.profilIbu', function ($q) {
                                            $q->where('user_id', auth()->id());
                                        });
                                    }
                                    $totalTtd = $query->count();
                                    $complianceQuery = clone $query;
                                    $totalCompliance = $complianceQuery->whereIn('diminum', ['Ya', '1', 'yes'])->count();
                                @endphp
                                <div class="row g-2">
                                    <div class="col-6">
                                        <div class="d-flex align-items-center p-2 rounded h-100" style="background:rgba(225,29,72,.07);">
                                            <i class="bi bi-check-circle-fill text-danger me-2 fs-5 d-none d-sm-inline"></i>
                                            <div>
                                                <div class="fw-semibold text-dark" style="font-size: 0.7rem; line-height: 1.1;">Total Pemberian</div>
                                                <div class="fw-bold fs-6 text-danger mt-0.5">{{ $totalTtd }}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="d-flex align-items-center p-2 rounded h-100" style="background:rgba(225,29,72,.07);">
                                            <i class="bi bi-heart-fill text-success me-2 fs-5 d-none d-sm-inline"></i>
                                            <div>
                                                <div class="fw-semibold text-dark" style="font-size: 0.7rem; line-height: 1.1;">Patuh Konsumsi (Ya)</div>
                                                <div class="fw-bold fs-6 text-success mt-0.5">{{ $totalCompliance }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Tombol Aksi -->
                            @if (auth()->user()->role->nama_role !== 'ibu hamil')
                                <div class="col-xl-2 col-lg-12 text-xl-end mt-3 mt-xl-0">
                                    <a href="{{ route('pencatatan-ttd.create') }}" class="btn text-white py-2.5 px-3 shadow-sm fw-bold w-100"
                                       style="background: linear-gradient(135deg, #e11d48, #be123c); border-radius:30px; letter-spacing: 0.5px; font-size: 0.85rem;">
                                        <i class="bi bi-plus-circle-fill me-1"></i> CATAT TTD/MMS
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tabel Data Bawah --}}
            <div class="col-lg-12 mb-4">
                <div class="card border-0 shadow-sm" style="border-radius:12px;">
                    <div class="card-header bg-white border-bottom py-3 px-4 d-flex justify-content-between align-items-center">
                        <h5 class="m-0 fw-bold text-dark">Data Pencatatan TTD / MMS</h5>
                        <span class="badge text-white px-3 py-2 fw-semibold" style="border-radius:20px; background:linear-gradient(135deg,#e11d48,#be123c);">
                            Total: {{ $totalTtd }}
                        </span>
                    </div>
                    <div class="card-body p-4">
                        <div class="table-responsive">
                            {{ $dataTable->table(['class' => 'table table-hover table-bordered align-middle table-custom-ttd', 'style' => 'width:100%']) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
        .table-custom-ttd.table-bordered,
        .table-custom-ttd.table-bordered th,
        .table-custom-ttd.table-bordered td {
            border: 1px solid #ffe4e6 !important;
        }
        .table-custom-ttd thead th {
            background-color: #FFF1F2 !important;
            color: #e11d48 !important;
            font-weight: 700 !important;
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 0.5px;
            border-bottom: 3px solid #e11d48 !important;
            padding: 12px 16px !important;
        }
        .table-custom-ttd tbody td {
            padding: 12px 16px !important;
            border-bottom: 1px solid #ffe4e6 !important;
        }
        .table-custom-ttd tbody tr:hover {
            background-color: #FFF5F6 !important;
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
                    title: 'Hapus Catatan TTD?',
                    text: "Data catatan TTD ini akan dihapus secara permanen!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#e11d48',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ url('pencatatan-ttd') }}/" + id,
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
                                        confirmButtonColor: '#e11d48'
                                    }).then(() => {
                                        window.LaravelDataTables["pencatatanttd-table"].ajax.reload();
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
