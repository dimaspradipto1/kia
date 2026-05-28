@extends('layouts.dashboard.template')

@section('content')
    <div class="pagetitle d-flex justify-content-between align-items-center">
        <div>
            <h1>Hasil Laboratorium Ibu</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Hasil Lab Ibu</li>
                </ol>
            </nav>
        </div>
    </div>

    <section class="section animate__animated animate__fadeIn">
        <div class="row">
            {{-- Banner Info Atas --}}
            <div class="col-lg-12 mb-4">
                <div class="card border-0 shadow-sm" style="border-radius:12px; background: linear-gradient(135deg, #E6F8F8 0%, #D4F2F2 100%);">
                    <div class="card-body p-4">
                        <div class="row align-items-center">
                            <div class="{{ auth()->user()->role->nama_role !== 'ibu hamil' ? 'col-md-8' : 'col-md-12' }} d-flex align-items-center gap-3">
                                <div class="d-flex align-items-center justify-content-center shadow-xs flex-shrink-0"
                                     style="width:70px; height:70px; border-radius:50%; background:white;">
                                    <i class="bi bi-droplet-fill" style="font-size:2.2rem; color:#16B3AC;"></i>
                                </div>
                                <div>
                                    <h4 class="fw-bold text-dark mb-1">Hasil Lab Ibu</h4>
                                    <p class="text-muted small mb-0">Catat parameter laboratorium lengkap ibu hamil (Hb, Protein Urine, Sifilis, HIV, Hepatitis B, dll.).</p>
                                </div>
                            </div>
                            @if (auth()->user()->role->nama_role !== 'ibu hamil')
                                <div class="col-md-4 text-md-end mt-3 mt-md-0">
                                    <a href="{{ route('hasil-lab-ibu.create') }}" class="btn text-white py-2.5 px-4 shadow-sm fw-bold"
                                       style="background-color:#16B3AC; border-radius:30px; letter-spacing: 0.5px;">
                                        <i class="bi bi-plus-circle-fill me-1.5"></i> CATAT HASIL LAB
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
                        <h5 class="m-0 fw-bold text-dark">Daftar Hasil Lab Ibu</h5>
                        @php
                            $totalLab = \App\Models\HasilLabIbu::when(
                                auth()->user()->role->nama_role === 'ibu hamil',
                                fn($q) => $q->whereHas('kunjunganAnc.bukuKia.profilIbu', fn($q2) => $q2->where('user_id', auth()->id()))
                            )->count();
                        @endphp
                        <span class="badge bg-light text-teal border border-teal px-3 py-2 fw-semibold" style="border-radius:20px;">
                            Total Rekam Lab: {{ $totalLab }}
                        </span>
                    </div>
                    <div class="card-body p-4">
                        <div class="table-responsive">
                            {{ $dataTable->table(['class' => 'table table-hover table-bordered align-middle table-custom-lab', 'style' => 'width:100%']) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
        .text-teal {
            color: #16B3AC !important;
        }
        .border-teal {
            border-color: #d4f2f2 !important;
        }
        /* Custom Premium Table Styling */
        .table-custom-lab.table-bordered,
        .table-custom-lab.table-bordered th,
        .table-custom-lab.table-bordered td {
            border: 1px solid #d4f2f2 !important;
        }
        .table-custom-lab thead th {
            background-color: #E6F8F8 !important;
            color: #16B3AC !important;
            font-weight: 700 !important;
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 0.5px;
            border-bottom: 3px solid #16B3AC !important;
            padding: 12px 16px !important;
        }
        .table-custom-lab tbody td {
            padding: 12px 16px !important;
            border-bottom: 1px solid #d4f2f2 !important;
        }
        .table-custom-lab tbody tr:hover {
            background-color: #F0FAFA !important;
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
                    title: 'Hapus Hasil Lab?',
                    text: "Seluruh data riwayat rekam lab ini akan terhapus secara permanen!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#EC1E88',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ url('hasil-lab-ibu') }}/" + id,
                            type: 'POST',
                            data: {
                                _method: 'DELETE',
                                _token: "{{ csrf_token() }}"
                            },
                            success: function (response) {
                                if (response.success) {
                                    Swal.fire({
                                        title: 'Terhapus!',
                                        text: response.message,
                                        icon: 'success',
                                        confirmButtonColor: '#16B3AC'
                                    }).then(() => {
                                        window.LaravelDataTables["hasillabibu-table"].ajax.reload();
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
