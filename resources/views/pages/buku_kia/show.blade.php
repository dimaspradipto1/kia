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

    <section class="section animate__animated animate__fadeIn">
        <div class="row">
            {{-- Card Kiri: Maternal Passport Style --}}
            <div class="col-xl-3 col-lg-4 mb-4">
                <div class="card shadow-sm border-0 h-100" style="border-radius:16px; overflow:hidden; background: linear-gradient(135deg, #FFF0F5 0%, #FFE4E1 100%);">
                    <div class="card-body pt-4 d-flex flex-column align-items-center position-relative">
                        <div class="position-absolute top-0 end-0 p-3 opacity-25">
                            <i class="bi bi-heart-fill" style="font-size: 4rem; color:#EC1E88;"></i>
                        </div>
                        <div class="d-flex align-items-center justify-content-center mb-3 shadow-sm"
                             style="width:80px; height:80px; border-radius:50%; background:white; border: 4px solid #FFF;">
                            <i class="bi bi-journal-medical" style="font-size:2.5rem; color:#EC1E88;"></i>
                        </div>
                        <h5 class="fw-bold text-center mb-1 text-dark" style="font-family: 'Outfit', sans-serif;">
                            {{ $bukuKia->profilIbu->nama_lengkap ?? 'Nama Ibu Hamil' }}
                        </h5>
                        <p class="text-muted small mb-3">No. Kohort: <span class="badge bg-white text-dark border shadow-xs px-2">{{ $bukuKia->no_reg_kohort_ibu ?? '-' }}</span></p>
                        
                        <div class="w-100 p-3 bg-white mb-3 shadow-xs" style="border-radius: 14px; border-left: 5px solid #EC1E88;">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted small fw-medium">Kode QR</span>
                                <strong class="small text-dark">{{ $bukuKia->qr_code }}</strong>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span class="text-muted small fw-medium">Status Buku</span>
                                <span class="badge {{ $bukuKia->status === 'Aktif' ? 'bg-success' : 'bg-secondary' }} px-2.5 py-1">
                                    {{ $bukuKia->status }}
                                </span>
                            </div>
                        </div>
                        
                        {{-- Quick Info Card --}}
                        <div class="w-100 p-3 bg-white shadow-xs" style="border-radius: 14px; border-left: 5px solid #16B3AC;">
                            <div class="row text-center align-items-center">
                                <div class="col-6 border-end">
                                    <span class="text-muted small d-block mb-1 fw-medium">Jumlah Anak Hidup</span>
                                    <strong class="fs-4 text-dark">{{ $bukuKia->jumlah_anak_hidup }}</strong>
                                </div>
                                <div class="col-6">
                                    <span class="text-muted small d-block mb-1 fw-medium">Kehamilan Ke-</span>
                                    <strong class="fs-4 text-dark">{{ $bukuKia->kehamilan_ke }}</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Card Kanan: Tabbed Information --}}
            <div class="col-xl-9 col-lg-8 mb-4">
                <div class="card shadow-sm border-0 h-100" style="border-radius:16px; overflow: hidden;">
                    <div class="card-body p-4 pt-3">
                        <ul class="nav nav-tabs nav-tabs-bordered mb-4" id="maternityTabs" role="tablist">
                            <li class="nav-item">
                                <button class="nav-link active fw-bold" data-bs-toggle="tab" data-bs-target="#tab-buku"><i class="bi bi-book me-1"></i> Buku KIA</button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link fw-bold" data-bs-toggle="tab" data-bs-target="#tab-anc"><i class="bi bi-clipboard2-pulse me-1"></i> Kunjungan ANC</button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link fw-bold" data-bs-toggle="tab" data-bs-target="#tab-ibu"><i class="bi bi-person-heart me-1"></i> Ibu</button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link fw-bold" data-bs-toggle="tab" data-bs-target="#tab-suami"><i class="bi bi-person-badge me-1"></i> Suami</button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link fw-bold" data-bs-toggle="tab" data-bs-target="#tab-anak"><i class="bi bi-emoji-smile me-1"></i> Anak</button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link fw-bold" data-bs-toggle="tab" data-bs-target="#tab-pembiayaan"><i class="bi bi-credit-card me-1"></i> Biaya</button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link fw-bold" data-bs-toggle="tab" data-bs-target="#tab-nifas"><i class="bi bi-activity me-1"></i> Pemantauan Nifas</button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link fw-bold" data-bs-toggle="tab" data-bs-target="#tab-kb"><i class="bi bi-heart-pulse me-1"></i> KB Pasca Salin</button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link fw-bold" data-bs-toggle="tab" data-bs-target="#tab-dokumen"><i class="bi bi-file-earmark-pdf me-1"></i> Dokumen</button>
                            </li>
                        </ul>

                        <div class="tab-content">

                            {{-- Tab Buku KIA --}}
                            <div class="tab-pane fade show active" id="tab-buku">
                                <h5 class="fw-bold text-dark mb-3 d-flex align-items-center"><i class="bi bi-bookmark-fill text-pink me-2"></i> Data Buku KIA</h5>
                                <table class="table table-bordered table-hover align-middle table-custom-detail">
                                    <tbody>
                                        <tr><th class="w-40">Fasilitas Kesehatan</th><td>{{ $bukuKia->fasilitasKesehatan->nama_faskes ?? '-' }}</td></tr>
                                        <tr><th>No. Reg Kohort Ibu</th><td>{{ $bukuKia->no_reg_kohort_ibu }}</td></tr>
                                        <tr><th>No. Reg Kohort Bayi</th><td>{{ $bukuKia->no_reg_kohort_bayi }}</td></tr>
                                        <tr><th>No. Reg Kohort Balita</th><td>{{ $bukuKia->no_reg_kohort_balita }}</td></tr>
                                        <tr><th>Kehamilan Ke-</th><td>{{ $bukuKia->kehamilan_ke }}</td></tr>
                                        <tr><th>Jumlah Anak Hidup</th><td>{{ $bukuKia->jumlah_anak_hidup }}</td></tr>
                                        <tr><th>Riwayat Keguguran</th><td>{{ $bukuKia->riwayat_keguguran }}</td></tr>
                                        <tr><th>Riwayat Penyakit</th><td>{{ $bukuKia->riwayat_penyakit ?? '-' }}</td></tr>
                                        <tr><th>No. Catatan Medik RS</th><td>{{ $bukuKia->no_catatan_medik_rs ?? '-' }}</td></tr>
                                        <tr><th>Diterbitkan Pada</th><td>{{ $bukuKia->diterbitkan_pada }}</td></tr>
                                        <tr><th>Diterbitkan Oleh</th><td>{{ $bukuKia->diterbitkan_oleh }}</td></tr>
                                    </tbody>
                                </table>
                            </div>

                            {{-- Tab Kunjungan ANC --}}
                            <div class="tab-pane fade" id="tab-anc">
                                <h5 class="fw-bold text-dark mb-3 d-flex align-items-center"><i class="bi bi-clipboard2-pulse-fill text-pink me-2"></i> Riwayat Kunjungan Antenatal Care (ANC)</h5>
                                @if($bukuKia->kunjunganAncs->count() > 0)
                                    @foreach($bukuKia->kunjunganAncs->sortBy('tanggal_kunjungan') as $anc)
                                        <div class="mb-4 card shadow-none border" style="border-radius: 12px; overflow:hidden;">
                                            <div class="fw-bold text-white px-3 py-2.5 mb-0 d-flex justify-content-between align-items-center" style="background: linear-gradient(90deg, #16B3AC 0%, #0d8d87 100%);">
                                                <span><i class="bi bi-heart-pulse-fill me-1.5"></i> Trimester: <strong>Trimester {{ $anc->trimester }} (Kunjungan Ke-{{ $anc->kunjungan_ke }})</strong></span>
                                                <span class="badge bg-white text-teal shadow-sm">Tanggal ANC: {{ \Carbon\Carbon::parse($anc->tanggal_kunjungan)->translatedFormat('d F Y') }}</span>
                                            </div>
                                            <table class="table table-bordered table-hover align-middle mb-0 table-custom-detail">
                                                <tbody>
                                                    <tr>
                                                        <th class="w-40">Pemeriksa / Faskes</th>
                                                        <td>{{ $anc->nakes->name ?? '-' }} ({{ $anc->fasilitasKesehatan->nama_faskes ?? '-' }})</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Parameter Fisik Ibu</th>
                                                        <td>
                                                            Berat Badan: <strong>{{ $anc->berat_badan }} kg</strong> | 
                                                            LiLA: <strong>{{ $anc->lila_cm }} cm</strong> | 
                                                            Tensi: <strong>{{ $anc->tekanan_darah_sistolik }}/{{ $anc->tekanan_darah_diastolik }} mmHg</strong>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Kondisi Kandungan</th>
                                                        <td>
                                                            Tinggi Fundus (TFU): <strong>{{ $anc->tinggi_fundus_cm ? $anc->tinggi_fundus_cm . ' cm' : 'Belum teraba' }}</strong> | 
                                                            DJJ Janin: <strong>{{ $anc->denyut_jantung_janin ?? '-' }}</strong> | 
                                                            Letak Janin: <strong>{{ $anc->letak_janin ?? '-' }}</strong>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>USG & Status TT</th>
                                                        <td>
                                                            Imunisasi TT: <strong>{{ $anc->status_tt ?? '-' }}</strong> | 
                                                            Pemeriksaan USG: <strong>{{ $anc->usg_dilakukan === 'Ya' ? 'Dilakukan (' . ($anc->hasil_usg ?? 'Normal') . ')' : 'Tidak' }}</strong>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Skrining Jiwa & Catatan</th>
                                                        <td>
                                                            Skrining Mental: <span class="badge bg-light text-dark">{{ $anc->skrining_jiwa ?? 'Sehat / Normal' }}</span><br>
                                                            <div class="mt-2 text-muted small"><strong>Catatan Bidan:</strong> {{ $anc->catatan ?? '-' }}</div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="text-center text-muted py-5">
                                        <div class="d-inline-flex justify-content-center align-items-center mb-3 shadow-xs" style="width: 70px; height: 70px; border-radius: 50%; background: #e0f2f1;">
                                            <i class="bi bi-clipboard2-pulse fs-2 text-teal"></i>
                                        </div>
                                        <p class="mt-2 fw-medium text-dark">Belum ada riwayat kunjungan ANC.</p>
                                        <small class="text-muted">Catatan riwayat pemeriksaan berkala ibu hamil akan muncul di sini.</small>
                                    </div>
                                @endif
                            </div>

                            {{-- Tab Profil Ibu --}}
                            <div class="tab-pane fade" id="tab-ibu">
                                @if($bukuKia->profilIbu)
                                    @php $ibu = $bukuKia->profilIbu; @endphp
                                    <h5 class="fw-bold text-dark mb-3 d-flex align-items-center"><i class="bi bi-person-fill text-pink me-2"></i> Profil Ibu Kandung</h5>
                                    <table class="table table-bordered table-hover align-middle table-custom-detail">
                                        <tbody>
                                            <tr><th class="w-40">NIK</th><td>{{ $ibu->nik }}</td></tr>
                                            <tr><th>Nama Lengkap</th><td>{{ $ibu->nama_lengkap }}</td></tr>
                                            <tr><th>Nama Ibu Kandung</th><td>{{ $ibu->nama_ibu_kandung ?? '-' }}</td></tr>
                                            <tr><th>Tempat Lahir</th><td>{{ $ibu->tempat_lahir }}</td></tr>
                                            <tr><th>Tanggal Lahir</th><td>{{ $ibu->tanggal_lahir ? \Carbon\Carbon::parse($ibu->tanggal_lahir)->translatedFormat('d F Y') : '-' }}</td></tr>
                                            <tr><th>Golongan Darah</th><td><span class="badge bg-danger fs-7 px-2.5">{{ $ibu->golongan_darah ?? '-' }}</span></td></tr>
                                            <tr><th>Pendidikan</th><td>{{ $ibu->pendidikan ?? '-' }}</td></tr>
                                            <tr><th>Pekerjaan</th><td>{{ $ibu->pekerjaan ?? '-' }}</td></tr>
                                            <tr><th>Agama</th><td>{{ $ibu->agama ?? '-' }}</td></tr>
                                            <tr><th>Alamat</th><td>{{ $ibu->alamat ?? '-' }}</td></tr>
                                            <tr><th>No. WhatsApp</th><td><i class="bi bi-whatsapp text-success me-1"></i> {{ $ibu->nomor_wa ?? '-' }}</td></tr>
                                            <tr><th>No. JKN / BPJS</th><td>{{ $ibu->nomor_jkn ?? '-' }}</td></tr>
                                            <tr><th>Puskesmas Domisili</th><td>{{ $ibu->nama_puskesmas ?? '-' }}</td></tr>
                                        </tbody>
                                    </table>
                                @else
                                    <div class="text-center text-muted py-5">
                                        <i class="bi bi-person-x fs-1 text-pink opacity-50"></i>
                                        <p class="mt-2 fw-medium">Data profil ibu belum tersedia.</p>
                                    </div>
                                @endif
                            </div>

                            {{-- Tab Profil Suami --}}
                            <div class="tab-pane fade" id="tab-suami">
                                @if($bukuKia->profilSuami)
                                    @php $suami = $bukuKia->profilSuami; @endphp
                                    <h5 class="fw-bold text-dark mb-3 d-flex align-items-center"><i class="bi bi-person-badge-fill text-pink me-2"></i> Profil Suami (Ayah)</h5>
                                    <table class="table table-bordered table-hover align-middle table-custom-detail">
                                        <tbody>
                                            <tr><th class="w-40">NIK</th><td>{{ $suami->nik }}</td></tr>
                                            <tr><th>Nama Lengkap</th><td>{{ $suami->nama_lengkap }}</td></tr>
                                            <tr><th>Tempat Lahir</th><td>{{ $suami->tempat_lahir ?? '-' }}</td></tr>
                                            <tr><th>Tanggal Lahir</th><td>{{ $suami->tanggal_lahir ? \Carbon\Carbon::parse($suami->tanggal_lahir)->translatedFormat('d F Y') : '-' }}</td></tr>
                                            <tr><th>Golongan Darah</th><td><span class="badge bg-danger fs-7 px-2.5">{{ $suami->golongan_darah ?? '-' }}</span></td></tr>
                                            <tr><th>Pendidikan</th><td>{{ $suami->pendidikan ?? '-' }}</td></tr>
                                            <tr><th>Pekerjaan</th><td>{{ $suami->pekerjaan ?? '-' }}</td></tr>
                                            <tr><th>No. WhatsApp</th><td><i class="bi bi-whatsapp text-success me-1"></i> {{ $suami->nomor_wa ?? '-' }}</td></tr>
                                        </tbody>
                                    </table>
                                @else
                                    <div class="text-center text-muted py-5">
                                        <i class="bi bi-person-x fs-1 text-pink opacity-50"></i>
                                        <p class="mt-2 fw-medium">Data profil suami belum tersedia.</p>
                                    </div>
                                @endif
                            </div>

                            {{-- Tab Profil Anak --}}
                            <div class="tab-pane fade" id="tab-anak">
                                <h5 class="fw-bold text-dark mb-3 d-flex align-items-center"><i class="bi bi-heart-pulse-fill text-pink me-2"></i> Riwayat Persalinan & Anak</h5>
                                @if($bukuKia->profilAnak->count() > 0)
                                    @foreach($bukuKia->profilAnak as $index => $anak)
                                        <div class="mb-4 card shadow-none border" style="border-radius: 12px; overflow:hidden;">
                                            <div class="fw-bold text-white px-3 py-2.5 mb-0 d-flex justify-content-between align-items-center" style="background: linear-gradient(90deg, #EC1E88 0%, #F06292 100%);">
                                                <span><i class="bi bi-balloon me-1.5"></i> Anak ke-{{ $index + 1 }}: {{ $anak->nama_anak }}</span>
                                                <span class="badge bg-white text-pink shadow-sm">{{ $anak->jenis_kelamin }}</span>
                                            </div>
                                            <table class="table table-bordered table-hover align-middle mb-0 table-custom-detail">
                                                <tbody>
                                                    <tr><th class="w-40">Tanggal Lahir</th><td>{{ $anak->tanggal_lahir ? \Carbon\Carbon::parse($anak->tanggal_lahir)->translatedFormat('d F Y') : '-' }}</td></tr>
                                                    <tr><th>Berat Lahir</th><td><strong>{{ $anak->berat_lahir ?? '-' }}</strong> gram</td></tr>
                                                    <tr><th>Panjang Lahir</th><td><strong>{{ $anak->panjang_lahir ?? '-' }}</strong> cm</td></tr>
                                                    <tr><th>Golongan Darah</th><td><span class="badge bg-danger fs-7 px-2.5">{{ $anak->golongan_darah ?? '-' }}</span></td></tr>
                                                    <tr><th>Tempat Lahir</th><td>{{ $anak->tempat_lahir ?? '-' }}</td></tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="text-center text-muted py-5">
                                        <i class="bi bi-clipboard-x fs-1 text-pink opacity-50"></i>
                                        <p class="mt-2 fw-medium">Belum ada data profil anak.</p>
                                    </div>
                                @endif
                            </div>

                            {{-- Tab Pembiayaan --}}
                            <div class="tab-pane fade" id="tab-pembiayaan">
                                <h5 class="fw-bold text-dark mb-3 d-flex align-items-center"><i class="bi bi-wallet2 text-pink me-2"></i> Metode Pembiayaan Kesehatan</h5>
                                @if($bukuKia->pembiayaans->count() > 0)
                                    @foreach($bukuKia->pembiayaans as $pem)
                                        <div class="mb-4 card shadow-none border" style="border-radius: 12px; overflow:hidden;">
                                            <div class="fw-bold text-white px-3 py-2.5 mb-0 d-flex justify-content-between align-items-center" style="background: linear-gradient(90deg, #EC1E88 0%, #F06292 100%);">
                                                <span><i class="bi bi-shield-check me-1.5"></i> {{ $pem->jenis_pembiayaan }}</span>
                                                @if($pem->is_active)
                                                    <span class="badge bg-success border border-white">Aktif</span>
                                                @else
                                                    <span class="badge bg-secondary border border-white">Tidak Aktif</span>
                                                @endif
                                            </div>
                                            <table class="table table-bordered table-hover align-middle mb-0 table-custom-detail">
                                                <tbody>
                                                    <tr><th class="w-40">Nama Asuransi / Instansi</th><td>{{ $pem->nama_asuransi ?? '-' }}</td></tr>
                                                    <tr><th>Nomor Polis / Kartu</th><td>{{ $pem->nomor_polis ?? '-' }}</td></tr>
                                                    <tr><th>Tanggal Berlaku</th><td>{{ $pem->tanggal_berlaku ? $pem->tanggal_berlaku->translatedFormat('d F Y') : '-' }}</td></tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="text-center text-muted py-5">
                                        <i class="bi bi-credit-card-2-front fs-1 text-pink opacity-50"></i>
                                        <p class="mt-2 fw-medium">Belum ada data pembiayaan.</p>
                                    </div>
                                @endif
                            </div>

                            {{-- Tab Pemantauan Nifas --}}
                            <div class="tab-pane fade" id="tab-nifas">
                                <h5 class="fw-bold text-dark mb-3 d-flex align-items-center"><i class="bi bi-activity text-pink me-2"></i> Riwayat Pemantauan Nifas (KF)</h5>
                                @if($bukuKia->pemantauanNifas->count() > 0)
                                    @foreach($bukuKia->pemantauanNifas as $pn)
                                        <div class="mb-4 card shadow-none border" style="border-radius: 12px; overflow:hidden;">
                                            <div class="fw-bold text-white px-3 py-2.5 mb-0 d-flex justify-content-between align-items-center" style="background: linear-gradient(90deg, #EC1E88 0%, #F06292 100%);">
                                                <span><i class="bi bi-heart-pulse-fill me-1.5"></i> Kunjungan: <strong>{{ $pn->hari_ke }}</strong></span>
                                                <span class="badge bg-white text-pink shadow-sm">Tanggal: {{ \Carbon\Carbon::parse($pn->tanggal)->translatedFormat('d F Y') }}</span>
                                            </div>
                                            <table class="table table-bordered table-hover align-middle mb-0 table-custom-detail">
                                                <tbody>
                                                    <tr><th class="w-40">Petugas Medis (Nakes)</th><td>{{ $pn->nakes->name ?? '-' }}</td></tr>
                                                    <tr>
                                                        <th>Kondisi Kesehatan / Gejala</th>
                                                        <td>
                                                            @php
                                                                $keluhan = [];
                                                                if ($pn->demam === 'Ya') $keluhan[] = 'Demam';
                                                                if ($pn->pendarahan === 'Ya') $keluhan[] = 'Pendarahan';
                                                                if ($pn->nyeri_ulu_hati === 'Ya') $keluhan[] = 'Nyeri Ulu Hati';
                                                                if ($pn->pandangan_kabur === 'Ya') $keluhan[] = 'Pandangan Kabur';
                                                                if ($pn->keluar_cairan_berbau === 'Ya') $keluhan[] = 'Cairan Berbau';
                                                                if ($pn->payudara_bengkak === 'Ya') $keluhan[] = 'Payudara Bengkak';
                                                                if ($pn->gangguan_jiwa === 'Ya') $keluhan[] = 'Gangguan Jiwa/Depresi';
                                                                if ($pn->gangguan_bak === 'Ya') $keluhan[] = 'Gangguan BAK';
                                                            @endphp
                                                            @if(count($keluhan) > 0)
                                                                <span class="badge bg-danger mb-1">Ada Keluhan</span>
                                                                <div class="text-danger fw-bold small">{{ implode(', ', $keluhan) }}</div>
                                                            @else
                                                                <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i> Normal / Sehat (Bebas Keluhan)</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr><th>Catatan / Keterangan</th><td>{{ $pn->catatan ?? '-' }}</td></tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="text-center text-muted py-5">
                                        <div class="d-inline-flex justify-content-center align-items-center mb-3 shadow-xs" style="width: 70px; height: 70px; border-radius: 50%; background: #fce4f1;">
                                            <i class="bi bi-activity fs-2" style="color: #EC1E88;"></i>
                                        </div>
                                        <p class="mt-2 fw-medium text-dark">Belum ada riwayat pemantauan nifas.</p>
                                        <small class="text-muted">Catatan pemantauan masa nifas (KF 1, KF 2, KF 3) dari bidan akan muncul di sini.</small>
                                    </div>
                                @endif
                            </div>

                            {{-- Tab KB Pasca Salin --}}
                            <div class="tab-pane fade" id="tab-kb">
                                <h5 class="fw-bold text-dark mb-3 d-flex align-items-center"><i class="bi bi-heart-pulse-fill text-pink me-2"></i> Riwayat KB Pasca Salin</h5>
                                @if($bukuKia->kbPascaSalins->count() > 0)
                                    @foreach($bukuKia->kbPascaSalins as $kb)
                                        <div class="mb-4 card shadow-none border" style="border-radius: 12px; overflow:hidden;">
                                            <div class="fw-bold text-white px-3 py-2.5 mb-0 d-flex justify-content-between align-items-center" style="background: linear-gradient(90deg, #EC1E88 0%, #F06292 100%);">
                                                <span><i class="bi bi-activity me-1.5"></i> Metode KB: <strong>{{ $kb->metode_kb }}</strong></span>
                                                <span class="badge bg-white text-pink shadow-sm">Mulai: {{ \Carbon\Carbon::parse($kb->tanggal_mulai)->translatedFormat('d F Y') }}</span>
                                            </div>
                                            <table class="table table-bordered table-hover align-middle mb-0 table-custom-detail">
                                                <tbody>
                                                    <tr><th class="w-40">Tenaga Kesehatan (Petugas)</th><td>{{ $kb->nakes->name ?? '-' }}</td></tr>
                                                    <tr><th>Fasilitas Kesehatan</th><td>{{ $kb->fasilitasKesehatan->nama_faskes ?? '-' }}</td></tr>
                                                    <tr><th>Catatan / Keterangan Medis</th><td>{{ $kb->catatan ?? '-' }}</td></tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="text-center text-muted py-5">
                                        <div class="d-inline-flex justify-content-center align-items-center mb-3 shadow-xs" style="width: 70px; height: 70px; border-radius: 50%; background: #fce4f1;">
                                            <i class="bi bi-heart-pulse-fill fs-2" style="color: #EC1E88;"></i>
                                        </div>
                                        <p class="mt-2 fw-medium text-dark">Belum ada riwayat KB Pasca Salin.</p>
                                        <small class="text-muted">Riwayat layanan keluarga berencana pasca persalinan akan muncul di sini.</small>
                                    </div>
                                @endif
                            </div>

                            {{-- Tab Dokumen --}}
                            <div class="tab-pane fade" id="tab-dokumen">
                                <h5 class="fw-bold text-dark mb-3 d-flex align-items-center"><i class="bi bi-file-earmark-check-fill text-pink me-2"></i> Berkas & Dokumen Pendukung</h5>
                                @if($bukuKia->dokumens->count() > 0)
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover align-middle table-custom-detail">
                                            <thead class="text-center">
                                                <tr>
                                                    <th>Jenis Dokumen</th>
                                                    <th>Status Verifikasi</th>
                                                    <th>Unduh/Lihat</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($bukuKia->dokumens as $dok)
                                                    <tr>
                                                        <td class="fw-medium text-dark">{{ $dok->jenis_dokumen }}</td>
                                                        <td class="text-center">
                                                            @php
                                                                $badgeClass = [
                                                                    'pending'  => 'bg-warning text-dark',
                                                                    'verified' => 'bg-success',
                                                                    'rejected' => 'bg-danger'
                                                                ];
                                                            @endphp
                                                            <span class="badge {{ $badgeClass[$dok->status_verifikasi] ?? 'bg-secondary' }} px-2.5 py-1.5" id="status-badge-{{ $dok->id }}">
                                                                {{ ucfirst($dok->status_verifikasi) }}
                                                            </span>
                                                        </td>
                                                        <td class="text-center">
                                                            <a href="{{ asset('storage/' . $dok->file) }}" target="_blank" class="btn btn-sm text-pink bg-light border-pink px-3" style="border-radius: 20px;">
                                                                <i class="bi bi-eye-fill me-1"></i> Buka File
                                                            </a>
                                                        </td>
                                                        <td class="text-center">
                                                            <div class="d-flex gap-1 justify-content-center">
                                                                @if((Auth::user()->role->nama_role == 'nakes' || Auth::user()->role->nama_role == 'administrator') && $dok->status_verifikasi == 'pending')
                                                                    <button type="button" class="btn btn-sm btn-success btn-update-status" data-id="{{ $dok->id }}" data-status="verified" title="Verifikasi"><i class="bi bi-check-lg"></i></button>
                                                                    <button type="button" class="btn btn-sm btn-outline-danger btn-update-status" data-id="{{ $dok->id }}" data-status="rejected" title="Tolak"><i class="bi bi-x-lg"></i></button>
                                                                @endif
                                                                <a href="{{ route('dokumen.edit', $dok->id) }}" class="btn btn-sm btn-warning text-white" title="Edit"><i class="bi bi-pencil"></i></a>
                                                                <form action="{{ route('dokumen.destroy', $dok->id) }}" method="POST" class="delete-form d-inline">
                                                                    @csrf @method('DELETE')
                                                                    <button type="button" class="btn btn-sm btn-danger btn-delete" title="Hapus"><i class="bi bi-trash"></i></button>
                                                                </form>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <div class="text-center text-muted py-5">
                                        <i class="bi bi-folder-x fs-1 text-pink opacity-50"></i>
                                        <p class="mt-2 fw-medium">Belum ada dokumen pendukung.</p>
                                    </div>
                                @endif
                            </div>

                        </div>{{-- end tab-content --}}
                    </div>
                    
                    <div class="card-footer bg-light border-0 p-4 d-flex gap-2">
                        <a href="{{ route('buku-kia.edit', $bukuKia->id) }}" class="btn text-white px-4"
                           style="background-color:#EC1E88; border-radius:30px; box-shadow: 0 4px 10px rgba(236, 30, 136, 0.2); font-weight: 600;">
                           <i class="bi bi-pencil-square me-1"></i> Edit Data
                        </a>
                        <a href="{{ route('buku-kia.index') }}" class="btn btn-light border px-4"
                           style="border-radius:30px; font-weight: 600;">
                           <i class="bi bi-arrow-left me-1"></i> Kembali
                        </a>
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
        .btn-outline-primary:hover {
            background-color: #EC1E88 !important;
            border-color: #EC1E88 !important;
        }
        .nav-tabs-bordered .nav-link {
            border-radius: 30px !important;
            padding: 8px 18px !important;
            margin-right: 6px;
            margin-bottom: 6px;
            color: #6c757d;
            border: 1px solid #e3e6f0 !important;
            background-color: #fff;
            transition: all 0.25s ease;
            font-size: 0.9rem;
        }
        .nav-tabs-bordered .nav-link.active {
            background: linear-gradient(135deg, #EC1E88 0%, #F06292 100%) !important;
            color: white !important;
            border-color: #EC1E88 !important;
            box-shadow: 0 4px 10px rgba(236, 30, 136, 0.25);
        }
        .nav-tabs-bordered .nav-link:hover:not(.active) {
            background-color: #fce4f1;
            color: #EC1E88;
            border-color: #fce4f1 !important;
        }
        @media (max-width: 767.98px) {
            .nav-tabs-bordered {
                flex-direction: column;
                border-bottom: none !important;
            }
            .nav-tabs-bordered .nav-item {
                width: 100%;
            }
            .nav-tabs-bordered .nav-link {
                width: 100% !important;
                margin-right: 0 !important;
                margin-bottom: 8px !important;
                text-align: center;
            }
        }
        .w-40 { width: 40%; }
        
        /* Custom Maternal-themed Table styling */
        .table-custom-detail th {
            font-weight: 600;
            color: #5a5a5a;
            background-color: #FFF5F7 !important;
            border-color: #fce4f1 !important;
            padding: 10px 15px;
        }
        .table-custom-detail td {
            color: #2b2b2b;
            border-color: #fce4f1 !important;
            padding: 10px 15px;
        }
        .shadow-xs {
            box-shadow: 0 2px 4px rgba(0,0,0,0.02);
        }
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
                                    Swal.fire({
                                        title: 'Berhasil!',
                                        text: response.message,
                                        icon: 'success',
                                        confirmButtonColor: '#EC1E88'
                                    }).then(() => {
                                        location.reload();
                                    });
                                }
                            }
                        });
                    }
                });
            });
        </script>
    @endpush
@endsection
