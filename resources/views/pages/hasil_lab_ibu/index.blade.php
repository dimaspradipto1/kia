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
            {{-- Kapsul Navigasi Kiri --}}
            <div class="col-lg-3 mb-4">
                <div class="card border-0 shadow-sm" style="border-radius:12px; background: linear-gradient(135deg, #E6F8F8 0%, #D4F2F2 100%);">
                    <div class="card-body p-4 d-flex flex-column align-items-center text-center">
                        <div class="d-flex align-items-center justify-content-center mb-3 shadow-xs"
                             style="width:80px; height:80px; border-radius:50%; background:white;">
                             <i class="bi bi-flask-fill" style="font-size:2.5rem; color:#16B3AC;"></i>
                        </div>
                        <h5 class="fw-bold text-dark mb-1">Hasil Lab Ibu</h5>
                        <p class="text-muted small mb-4">Catat parameter laboratorium lengkap ibu hamil (Hb, Protein Urine, Sifilis, HIV, Hepatitis B, dll.).</p>
                        
                        <a href="{{ route('hasil-lab-ibu.create') }}" class="btn w-100 text-white py-2.5 shadow-sm fw-bold"
                           style="background-color:#16B3AC; border-radius:30px; letter-spacing: 0.5px;">
                            <i class="bi bi-plus-circle-fill me-1.5"></i> CATAT HASIL LAB
                        </a>
                    </div>
                </div>
            </div>

            {{-- Tabel Data Kanan --}}
            <div class="col-lg-9 mb-4">
                <div class="card border-0 shadow-sm" style="border-radius:12px;">
                    <div class="card-header bg-white border-bottom py-3 px-4 d-flex justify-content-between align-items-center">
                        <h5 class="m-0 fw-bold text-dark">Daftar Hasil Lab Ibu</h5>
                        <span class="badge bg-light text-teal border border-teal px-3 py-2 fw-semibold" style="border-radius:20px;">
                            Total Rekam Lab: {{ \App\Models\HasilLabIbu::count() }}
                        </span>
                    </div>
                    <div class="card-body p-4">
                        <div class="table-responsive">
                            {{ $dataTable->table(['class' => 'table table-hover align-middle table-custom-lab', 'style' => 'width:100%']) }}
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
