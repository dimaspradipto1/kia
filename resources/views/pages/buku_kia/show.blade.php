@extends('layouts.dashboard.template')

@section('content')
    <div class="pagetitle">
        <h1>Detail Buku KIA</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('buku-kia.index') }}">Buku KIA</a></li>
                <li class="breadcrumb-item active">Detail</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            {{-- Card Kiri --}}
            <div class="col-xl-4">
                <div class="card shadow-sm border-0" style="border-radius:12px; border-top:5px solid #EC1E88 !important;">
                    <div class="card-body pt-4 d-flex flex-column align-items-center">
                        <div class="d-flex align-items-center justify-content-center mb-3"
                             style="width:100px;height:100px;border-radius:50%;background:#fce4f1;">
                            <i class="bi bi-journal-medical" style="font-size:3rem;color:#EC1E88;"></i>
                        </div>
                        <h2 class="fw-bold text-center fs-5">{{ $bukuKia->profilIbu->nama_lengkap ?? '-' }}</h2>
                        <p class="text-muted small">QR: <strong>{{ $bukuKia->qr_code }}</strong></p>
                        <span class="badge {{ $bukuKia->status === 'Aktif' ? 'bg-success' : 'bg-secondary' }} fs-6">
                            {{ $bukuKia->status }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- Card Kanan --}}
            <div class="col-xl-8">
                <div class="card shadow-sm border-0" style="border-radius:12px;">
                    <div class="card-body pt-3">
                        <ul class="nav nav-tabs nav-tabs-bordered">
                            <li class="nav-item">
                                <button class="nav-link active fw-bold" data-bs-toggle="tab" data-bs-target="#tab-buku">Buku KIA</button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link fw-bold" data-bs-toggle="tab" data-bs-target="#tab-ibu">Profil Ibu</button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link fw-bold" data-bs-toggle="tab" data-bs-target="#tab-suami">Profil Suami</button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link fw-bold" data-bs-toggle="tab" data-bs-target="#tab-anak">Profil Anak</button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link fw-bold" data-bs-toggle="tab" data-bs-target="#tab-pembiayaan">Pembiayaan</button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link fw-bold" data-bs-toggle="tab" data-bs-target="#tab-dokumen">Dokumen</button>
                            </li>
                        </ul>

                        <div class="tab-content pt-3">

                            {{-- Tab Buku KIA --}}
                            <div class="tab-pane fade show active" id="tab-buku">
                                <h5 class="fw-bold mb-3">Data Buku KIA</h5>
                                <table class="table table-bordered table-hover table-sm align-middle">
                                    <tbody>
                                        <tr><th class="bg-light w-40">Fasilitas Kesehatan</th><td>{{ $bukuKia->fasilitasKesehatan->nama_faskes ?? '-' }}</td></tr>
                                        <tr><th class="bg-light">No. Reg Kohort Ibu</th><td>{{ $bukuKia->no_reg_kohort_ibu }}</td></tr>
                                        <tr><th class="bg-light">No. Reg Kohort Bayi</th><td>{{ $bukuKia->no_reg_kohort_bayi }}</td></tr>
                                        <tr><th class="bg-light">No. Reg Kohort Balita</th><td>{{ $bukuKia->no_reg_kohort_balita }}</td></tr>
                                        <tr><th class="bg-light">Kehamilan Ke-</th><td>{{ $bukuKia->kehamilan_ke }}</td></tr>
                                        <tr><th class="bg-light">Jumlah Anak Hidup</th><td>{{ $bukuKia->jumlah_anak_hidup }}</td></tr>
                                        <tr><th class="bg-light">Riwayat Keguguran</th><td>{{ $bukuKia->riwayat_keguguran }}</td></tr>
                                        <tr><th class="bg-light">Riwayat Penyakit</th><td>{{ $bukuKia->riwayat_penyakit ?? '-' }}</td></tr>
                                        <tr><th class="bg-light">No. Catatan Medik RS</th><td>{{ $bukuKia->no_catatan_medik_rs ?? '-' }}</td></tr>
                                        <tr><th class="bg-light">Diterbitkan Pada</th><td>{{ $bukuKia->diterbitkan_pada }}</td></tr>
                                        <tr><th class="bg-light">Diterbitkan Oleh</th><td>{{ $bukuKia->diterbitkan_oleh }}</td></tr>
                                    </tbody>
                                </table>
                            </div>

                            {{-- Tab Profil Ibu --}}
                            <div class="tab-pane fade" id="tab-ibu">
                                @if($bukuKia->profilIbu)
                                    @php $ibu = $bukuKia->profilIbu; @endphp
                                    <h5 class="fw-bold mb-3">Data Profil Ibu</h5>
                                    <table class="table table-bordered table-hover table-sm align-middle">
                                        <tbody>
                                            <tr><th class="bg-light w-40">NIK</th><td>{{ $ibu->nik }}</td></tr>
                                            <tr><th class="bg-light">Nama Lengkap</th><td>{{ $ibu->nama_lengkap }}</td></tr>
                                            <tr><th class="bg-light">Tempat Lahir</th><td>{{ $ibu->tempat_lahir }}</td></tr>
                                            <tr><th class="bg-light">Tanggal Lahir</th><td>{{ $ibu->tanggal_lahir ? \Carbon\Carbon::parse($ibu->tanggal_lahir)->translatedFormat('d F Y') : '-' }}</td></tr>
                                            <tr><th class="bg-light">Golongan Darah</th><td>{{ $ibu->golongan_darah ?? '-' }}</td></tr>
                                            <tr><th class="bg-light">Pendidikan</th><td>{{ $ibu->pendidikan ?? '-' }}</td></tr>
                                            <tr><th class="bg-light">Pekerjaan</th><td>{{ $ibu->pekerjaan ?? '-' }}</td></tr>
                                            <tr><th class="bg-light">Agama</th><td>{{ $ibu->agama ?? '-' }}</td></tr>
                                            <tr><th class="bg-light">Alamat</th><td>{{ $ibu->alamat ?? '-' }}</td></tr>
                                            <tr><th class="bg-light">No. WhatsApp</th><td>{{ $ibu->nomor_wa ?? '-' }}</td></tr>
                                            <tr><th class="bg-light">No. JKN</th><td>{{ $ibu->nomor_jkn ?? '-' }}</td></tr>
                                            <tr><th class="bg-light">Nama Puskesmas</th><td>{{ $ibu->nama_puskesmas ?? '-' }}</td></tr>
                                        </tbody>
                                    </table>
                                @else
                                    <div class="text-center text-muted py-4">
                                        <i class="bi bi-person-x fs-1"></i>
                                        <p class="mt-2">Data profil ibu belum tersedia.</p>
                                    </div>
                                @endif
                            </div>

                            {{-- Tab Profil Suami --}}
                            <div class="tab-pane fade" id="tab-suami">
                                @if($bukuKia->profilSuami)
                                    @php $suami = $bukuKia->profilSuami; @endphp
                                    <h5 class="fw-bold mb-3">Data Profil Suami</h5>
                                    <table class="table table-bordered table-hover table-sm align-middle">
                                        <tbody>
                                            <tr><th class="bg-light w-40">NIK</th><td>{{ $suami->nik }}</td></tr>
                                            <tr><th class="bg-light">Nama Lengkap</th><td>{{ $suami->nama_lengkap }}</td></tr>
                                            <tr><th class="bg-light">Tempat Lahir</th><td>{{ $suami->tempat_lahir ?? '-' }}</td></tr>
                                            <tr><th class="bg-light">Tanggal Lahir</th><td>{{ $suami->tanggal_lahir ? \Carbon\Carbon::parse($suami->tanggal_lahir)->translatedFormat('d F Y') : '-' }}</td></tr>
                                            <tr><th class="bg-light">Golongan Darah</th><td>{{ $suami->golongan_darah ?? '-' }}</td></tr>
                                            <tr><th class="bg-light">Pendidikan</th><td>{{ $suami->pendidikan ?? '-' }}</td></tr>
                                            <tr><th class="bg-light">Pekerjaan</th><td>{{ $suami->pekerjaan ?? '-' }}</td></tr>
                                            <tr><th class="bg-light">No. WhatsApp</th><td>{{ $suami->nomor_wa ?? '-' }}</td></tr>
                                        </tbody>
                                    </table>
                                @else
                                    <div class="text-center text-muted py-4">
                                        <i class="bi bi-person-x fs-1"></i>
                                        <p class="mt-2">Data profil suami belum tersedia.</p>
                                    </div>
                                @endif
                            </div>

                            {{-- Tab Profil Anak --}}
                            <div class="tab-pane fade" id="tab-anak">
                                <h5 class="fw-bold mb-3">Data Profil Anak</h5>
                                @if($bukuKia->profilAnak->count() > 0)
                                    @foreach($bukuKia->profilAnak as $index => $anak)
                                        <div class="mb-3">
                                            <div class="fw-bold text-white px-3 py-2 mb-0 rounded-top" style="background:#EC1E88;">
                                                Anak ke-{{ $index + 1 }}: {{ $anak->nama_anak }}
                                            </div>
                                            <table class="table table-bordered table-sm align-middle mb-0">
                                                <tbody>
                                                    <tr><th class="bg-light w-40">Tanggal Lahir</th><td>{{ $anak->tanggal_lahir ? \Carbon\Carbon::parse($anak->tanggal_lahir)->translatedFormat('d F Y') : '-' }}</td></tr>
                                                    <tr><th class="bg-light">Jenis Kelamin</th><td>{{ $anak->jenis_kelamin ?? '-' }}</td></tr>
                                                    <tr><th class="bg-light">Berat Lahir</th><td>{{ $anak->berat_lahir ?? '-' }} gram</td></tr>
                                                    <tr><th class="bg-light">Panjang Lahir</th><td>{{ $anak->panjang_lahir ?? '-' }} cm</td></tr>
                                                    <tr><th class="bg-light">Golongan Darah</th><td>{{ $anak->golongan_darah ?? '-' }}</td></tr>
                                                    <tr><th class="bg-light">Tempat Lahir</th><td>{{ $anak->tempat_lahir ?? '-' }}</td></tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="text-center text-muted py-4">
                                        <i class="bi bi-person-x fs-1"></i>
                                        <p class="mt-2">Belum ada data profil anak.</p>
                                    </div>
                                @endif
                            </div>

                            {{-- Tab Pembiayaan --}}
                            <div class="tab-pane fade" id="tab-pembiayaan">
                                <h5 class="fw-bold mb-3">Data Pembiayaan</h5>
                                @if($bukuKia->pembiayaans->count() > 0)
                                    @foreach($bukuKia->pembiayaans as $pem)
                                        <div class="mb-3">
                                            <div class="fw-bold text-white px-3 py-2 mb-0 rounded-top d-flex justify-content-between align-items-center" style="background:#EC1E88;">
                                                <span>{{ $pem->jenis_pembiayaan }}</span>
                                                @if($pem->is_active)
                                                    <span class="badge bg-success border border-white">Aktif</span>
                                                @else
                                                    <span class="badge bg-secondary border border-white">Tidak Aktif</span>
                                                @endif
                                            </div>
                                            <table class="table table-bordered table-sm align-middle mb-0">
                                                <tbody>
                                                    <tr><th class="bg-light w-40">Nama Asuransi / BPJS</th><td>{{ $pem->nama_asuransi ?? '-' }}</td></tr>
                                                    <tr><th class="bg-light">Nomor Polis / Kartu</th><td>{{ $pem->nomor_polis ?? '-' }}</td></tr>
                                                    <tr><th class="bg-light">Tanggal Berlaku</th><td>{{ $pem->tanggal_berlaku ? $pem->tanggal_berlaku->translatedFormat('d F Y') : '-' }}</td></tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="text-center text-muted py-4">
                                        <i class="bi bi-credit-card fs-1"></i>
                                        <p class="mt-2">Belum ada data pembiayaan.</p>
                                    </div>
                                @endif
                            </div>

                            {{-- Tab Dokumen --}}
                            <div class="tab-pane fade" id="tab-dokumen">
                                <h5 class="fw-bold mb-3">Dokumen Pendukung</h5>
                                @if($bukuKia->dokumens->count() > 0)
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-sm align-middle">
                                            <thead class="bg-light text-center">
                                                <tr>
                                                    <th>Jenis Dokumen</th>
                                                    <th>Status</th>
                                                    <th>Berkas</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($bukuKia->dokumens as $dok)
                                                    <tr>
                                                        <td>{{ $dok->jenis_dokumen }}</td>
                                                        <td class="text-center">
                                                            @php
                                                                $badgeClass = [
                                                                    'pending'  => 'bg-warning text-dark',
                                                                    'verified' => 'bg-success',
                                                                    'rejected' => 'bg-danger'
                                                                ];
                                                            @endphp
                                                            <span class="badge {{ $badgeClass[$dok->status_verifikasi] ?? 'bg-secondary' }}" id="status-badge-{{ $dok->id }}">
                                                                {{ ucfirst($dok->status_verifikasi) }}
                                                            </span>
                                                        </td>
                                                        <td class="text-center">
                                                            <a href="{{ asset('storage/' . $dok->file) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                                <i class="bi bi-eye"></i>
                                                            </a>
                                                        </td>
                                                        <td class="text-center">
                                                            <div class="d-flex gap-1 justify-content-center">
                                                                @if((Auth::user()->role->nama_role == 'nakes' || Auth::user()->role->nama_role == 'administrator') && $dok->status_verifikasi == 'pending')
                                                                    <button type="button" class="btn btn-xs btn-success btn-update-status" data-id="{{ $dok->id }}" data-status="verified" title="Verifikasi"><i class="bi bi-check-lg"></i></button>
                                                                    <button type="button" class="btn btn-xs btn-outline-danger btn-update-status" data-id="{{ $dok->id }}" data-status="rejected" title="Tolak"><i class="bi bi-x-lg"></i></button>
                                                                @endif
                                                                <a href="{{ route('dokumen.edit', $dok->id) }}" class="btn btn-xs btn-warning text-white" title="Edit"><i class="bi bi-pencil"></i></a>
                                                                <form action="{{ route('dokumen.destroy', $dok->id) }}" method="POST" class="delete-form d-inline">
                                                                    @csrf @method('DELETE')
                                                                    <button type="button" class="btn btn-xs btn-danger btn-delete" title="Hapus"><i class="bi bi-trash"></i></button>
                                                                </form>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <div class="text-center text-muted py-4">
                                        <i class="bi bi-file-earmark-x fs-1"></i>
                                        <p class="mt-2">Belum ada dokumen yang diunggah.</p>
                                    </div>
                                @endif
                            </div>

                        </div>{{-- end tab-content --}}
                    </div>
                    <div class="card-footer bg-white border-0 p-4 pt-0">
                        <a href="{{ route('buku-kia.edit', $bukuKia->id) }}" class="btn text-white px-4"
                           style="background-color:#EC1E88;border-radius:8px;">Edit Data</a>
                        <a href="{{ route('buku-kia.index') }}" class="btn btn-secondary px-4"
                           style="border-radius:8px;">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
        .w-40 { width: 40%; }
    </style>
    @push('scripts')
        <script>
            // JS untuk Tab Dokumen
            $(document).on('click', '.btn-delete', function () {
                const form = $(this).closest('.delete-form');
                Swal.fire({
                    title: 'Hapus Dokumen?',
                    text: 'File dokumen akan dihapus permanen!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#EC1E88',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) form.submit();
                });
            });

            $(document).on('click', '.btn-update-status', function () {
                const id = $(this).data('id');
                const status = $(this).data('status');
                const btnContainer = $(this).closest('.d-flex');
                
                Swal.fire({
                    title: status === 'verified' ? 'Verifikasi Dokumen?' : 'Tolak Dokumen?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: status === 'verified' ? '#198754' : '#dc3545',
                    confirmButtonText: 'Ya, Lanjutkan!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/dokumen/${id}/status`,
                            type: 'PATCH',
                            data: { _token: '{{ csrf_token() }}', status: status },
                            success: function (response) {
                                if (response.success) {
                                    Swal.fire('Berhasil!', response.message, 'success');
                                    location.reload(); // Reload untuk memperbarui tampilan tab
                                }
                            }
                        });
                    }
                });
            });
        </script>
    @endpush
@endsection
