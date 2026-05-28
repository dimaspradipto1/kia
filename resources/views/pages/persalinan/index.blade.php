@extends('layouts.dashboard.template')

@section('content')
    <div class="pagetitle d-flex justify-content-between align-items-center">
        <div>
            <h1>Data Persalinan</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Data Persalinan</li>
                </ol>
            </nav>
        </div>
    </div>

    <section class="section animate__animated animate__fadeIn">
        <div class="row">
            {{-- Banner Info Atas --}}
            <div class="col-lg-12 mb-4">
                <div class="card border-0 shadow-sm" style="border-radius:12px; background: linear-gradient(135deg, #FAF5FF 0%, #F3E8FF 100%);">
                    <div class="card-body p-4">
                        <div class="row align-items-center">
                            <!-- Info Utama -->
                            <div class="col-xl-5 col-lg-6 d-flex align-items-center gap-3 mb-3 mb-lg-0">
                                <div class="d-flex align-items-center justify-content-center shadow-xs flex-shrink-0"
                                     style="width:70px; height:70px; border-radius:50%; background:white;">
                                    <i class="bi bi-heart-fill" style="font-size:2.2rem; color:#7E22CE;"></i>
                                </div>
                                <div>
                                    <h4 class="fw-bold text-dark mb-1">Data Persalinan</h4>
                                    <p class="text-muted small mb-0">Kelola informasi riwayat kelahiran bayi, metode persalinan, apgar score, dan kondisi kesehatan ibu & bayi.</p>
                                </div>
                            </div>
                            
                            <!-- Metrics Cards -->
                            <div class="col-xl-5 col-lg-6 mb-3 mb-lg-0">
                                @php
                                    $query = \App\Models\Persalinan::query();
                                    if (auth()->user()->role->nama_role === 'ibu hamil') {
                                        $query->whereHas('bukuKia.profilIbu', function ($q) {
                                            $q->where('user_id', auth()->id());
                                        });
                                    }
                                    $totalPersalinan = $query->count();
                                    $healthyQuery = clone $query;
                                    $totalHealthy = $healthyQuery->where('kondisi_bayi', 'Sehat')->count();
                                @endphp
                                <div class="row g-2">
                                    <div class="col-6">
                                        <div class="d-flex align-items-center p-2 rounded h-100" style="background:rgba(126,34,206,.07);">
                                            <i class="bi bi-check-circle-fill text-purple me-2 fs-5 d-none d-sm-inline"></i>
                                            <div>
                                                <div class="fw-semibold text-dark" style="font-size: 0.7rem; line-height: 1.1;">Total Persalinan</div>
                                                <div class="fw-bold fs-6 text-purple mt-0.5">{{ $totalPersalinan }}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="d-flex align-items-center p-2 rounded h-100" style="background:rgba(126,34,206,.07);">
                                            <i class="bi bi-emoji-smile-fill text-success me-2 fs-5 d-none d-sm-inline"></i>
                                            <div>
                                                <div class="fw-semibold text-dark" style="font-size: 0.7rem; line-height: 1.1;">Bayi Lahir Sehat</div>
                                                <div class="fw-bold fs-6 text-success mt-0.5">{{ $totalHealthy }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Tombol Aksi -->
                            @if (auth()->user()->role->nama_role !== 'ibu hamil')
                                <div class="col-xl-2 col-lg-12 text-xl-end mt-3 mt-xl-0">
                                    <a href="{{ route('persalinan.create') }}" class="btn text-white py-2.5 px-3 shadow-sm fw-bold w-100"
                                       style="background: linear-gradient(135deg, #7E22CE, #6B21A8); border-radius:30px; letter-spacing: 0.5px; font-size: 0.85rem;">
                                        <i class="bi bi-plus-circle-fill me-1"></i> CATAT PERSALINAN
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
                        <h5 class="m-0 fw-bold text-dark">Data Persalinan Ibu</h5>
                        <span class="badge text-white px-3 py-2 fw-semibold" style="border-radius:20px; background:linear-gradient(135deg,#7E22CE,#6B21A8);">
                            Total: {{ $totalPersalinan }}
                        </span>
                    </div>
                    <div class="card-body p-4">
                        <div class="table-responsive">
                            {{ $dataTable->table(['class' => 'table table-hover table-bordered align-middle table-custom-persalinan', 'style' => 'width:100%']) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
        .text-purple {
            color: #7E22CE !important;
        }
        .table-custom-persalinan.table-bordered,
        .table-custom-persalinan.table-bordered th,
        .table-custom-persalinan.table-bordered td {
            border: 1px solid #f3e8ff !important;
        }
        .table-custom-persalinan thead th {
            background-color: #FAF5FF !important;
            color: #7E22CE !important;
            font-weight: 700 !important;
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 0.5px;
            border-bottom: 3px solid #7E22CE !important;
            padding: 12px 16px !important;
        }
        .table-custom-persalinan tbody td {
            padding: 12px 16px !important;
            border-bottom: 1px solid #f3e8ff !important;
        }
        .table-custom-persalinan tbody tr:hover {
            background-color: #FDFBFF !important;
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
                    title: 'Hapus Data Persalinan?',
                    text: "Data persalinan dan riwayat lahir bayi ini akan dihapus secara permanen!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#7E22CE',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ url('persalinan') }}/" + id,
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
                                        confirmButtonColor: '#7E22CE'
                                    }).then(() => {
                                        window.LaravelDataTables["persalinan-table"].ajax.reload();
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
