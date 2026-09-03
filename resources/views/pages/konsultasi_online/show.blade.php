@extends('layouts.dashboard.template')

@section('content')
@php
    $user = auth()->user();
    $chatListQuery = \App\Models\KonsultasiOnline::with(['user.profilIbu', 'fasilitasKesehatan'])->orderBy('updated_at', 'desc');
    
    // Filter consultations based on roles
    $roleNameLower = strtolower($user->role->nama_role ?? '');
    if ($roleNameLower === 'ibu hamil') {
        $chatListQuery->where('user_id', $user->id);
    } elseif (in_array($roleNameLower, ['nakes', 'kader posyandu', 'kader']) && $user->fasilitas_kesehatan_id) {
        $chatListQuery->where('fasilitas_kesehatan_id', $user->fasilitas_kesehatan_id);
    }
    
    $otherConsultations = $chatListQuery->get();
@endphp

<div class="pagetitle d-flex justify-content-between align-items-center">
    <div>
        <h1 class="fw-bold text-dark">Portal Telemedisin</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('konsultasi-online.index') }}">Konsultasi Online</a></li>
                <li class="breadcrumb-item active">WhatsApp Chat</li>
            </ol>
        </nav>
    </div>
    <a href="{{ route('konsultasi-online.index') }}" class="btn btn-outline-secondary rounded-pill px-4 fw-bold text-secondary bg-white border-light-subtle shadow-sm">
        <i class="bi bi-arrow-left me-1"></i> Kembali ke Riwayat
    </a>
</div>

<section class="section animate__animated animate__fadeIn">
    <div class="row">
        <div class="col-12">
            
            <!-- Main Immersive Chat Box Container -->
            <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 20px; height: 680px; display: flex; flex-direction: row;">
                
                {{-- 1. LEFT PANEL: Conversations Sidebar (30% width) --}}
                <div class="chat-sidebar border-end d-flex flex-column" style="width: 32%; background-color: #ffffff;">
                    <!-- Sidebar Header -->
                    <div class="p-3 border-bottom d-flex align-items-center justify-content-between" style="background-color: #f0f2f5; height: 60px;">
                        <div class="d-flex align-items-center">
                            <div class="bg-primary text-white rounded-circle p-2 me-2 d-flex align-items-center justify-content-center" style="width: 38px; height: 38px; font-weight: bold;">
                                {{ strtoupper(substr($user->name, 0, 2)) }}
                            </div>
                            <span class="fw-bold text-dark small">{{ $user->name }}</span>
                        </div>
                        <span class="badge bg-success-subtle text-success border border-success-subtle fw-semibold rounded-pill px-2" style="font-size: 10px;">
                            <i class="bi bi-circle-fill me-1" style="font-size: 6px;"></i> Aktif
                        </span>
                    </div>

                    <!-- Sidebar Search -->
                    <div class="p-2 border-bottom" style="background-color: #fcffff;">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0 border-light-subtle rounded-start-pill py-1"><i class="bi bi-search text-muted small"></i></span>
                            <input type="text" class="form-control border-start-0 border-light-subtle rounded-end-pill py-1 small" placeholder="Cari percakapan..." id="chat-search" style="font-size: 13px;">
                        </div>
                    </div>

                    <!-- Conversations List -->
                    <div class="flex-grow-1 overflow-y-auto" style="background-color: #ffffff;" id="chat-list-container">
                        @forelse($otherConsultations as $item)
                            <a href="{{ route('konsultasi-online.show', $item->id) }}" 
                               class="d-flex align-items-center p-3 border-bottom text-decoration-none transition-all hover-chat-item {{ $item->id === $konsultasiOnline->id ? 'active-chat-item' : '' }}"
                               style="border-left: 4px solid {{ $item->id === $konsultasiOnline->id ? '#128C7E' : 'transparent' }};">
                                
                                <!-- Icon / Avatar -->
                                <div class="position-relative me-3">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center text-white" 
                                         style="width: 44px; height: 44px; background: linear-gradient(135deg, #128C7E 0%, #075E54 100%);">
                                        <i class="bi bi-chat-heart-fill"></i>
                                    </div>
                                    @if($item->status === 'pending')
                                        <span class="position-absolute bottom-0 end-0 bg-warning border border-white rounded-circle p-1" title="Menunggu Tanggapan"></span>
                                    @elseif($item->status === 'accepted')
                                        <span class="position-absolute bottom-0 end-0 bg-success border border-white rounded-circle p-1" title="Sudah Dijawab"></span>
                                    @endif
                                </div>

                                <!-- Text Preview -->
                                <div class="flex-grow-1 min-w-0">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <h6 class="fw-bold text-dark text-truncate mb-0" style="font-size: 13px;">
                                            @if($user->role->nama_role === 'ibu hamil')
                                                {{ optional($item->fasilitasKesehatan)->nama_faskes ?? 'Klinik Kesehatan' }}
                                            @else
                                                {{ optional($item->user)->name ?? 'Ibu Hamil' }}
                                            @endif
                                        </h6>
                                        <span class="text-muted" style="font-size: 10px;">
                                            {{ $item->updated_at ? $item->updated_at->format('H:i') : '' }}
                                        </span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <p class="text-muted text-truncate mb-0 small" style="font-size: 12px; max-width: 140px;">
                                            <strong>{{ $item->topik }}</strong>: {{ $item->respons ?? $item->pesan }}
                                        </p>
                                        @if($item->status === 'pending')
                                            <span class="badge bg-warning-subtle text-warning" style="font-size: 9px; border-radius: 10px;">Pending</span>
                                        @elseif($item->status === 'accepted')
                                            <span class="badge bg-success-subtle text-success" style="font-size: 9px; border-radius: 10px;">Dijawab</span>
                                        @else
                                            <span class="badge bg-danger-subtle text-danger" style="font-size: 9px; border-radius: 10px;">Ditolak</span>
                                        @endif
                                    </div>
                                </div>
                            </a>
                        @empty
                            <div class="text-center py-5 text-muted small">Tidak ada percakapan ditemukan.</div>
                        @endforelse
                    </div>
                </div>

                {{-- 2. RIGHT PANEL: WhatsApp Immersive Chat Area (68% width) --}}
                <div class="chat-window d-flex flex-column" style="width: 68%; background-color: #efeae2; position: relative;">
                    
                    <!-- Immersive Header -->
                    <div class="p-3 border-bottom d-flex align-items-center justify-content-between" style="background-color: #f0f2f5; height: 60px; z-index: 10;">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle d-flex align-items-center justify-content-center text-white me-3" 
                                 style="width: 40px; height: 40px; background: linear-gradient(135deg, #25D366 0%, #128C7E 100%);">
                                <i class="bi bi-file-earmark-medical fs-5"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold text-dark mb-0" style="font-size: 14px;">
                                    {{ optional($konsultasiOnline->user)->name ?? 'Ibu Hamil' }}
                                </h6>
                                <span class="text-muted" style="font-size: 11px;">
                                    <i class="bi bi-hospital me-1"></i>{{ optional($konsultasiOnline->fasilitasKesehatan)->nama_faskes ?? 'Klinik Utama' }}
                                </span>
                            </div>
                        </div>

                        <!-- Action Context Menu -->
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge text-secondary bg-white border border-light-subtle rounded-pill px-3 py-1fw-bold small shadow-xs">
                                NIK: {{ optional($konsultasiOnline->user->profilIbu)->nik ?? '-' }}
                            </span>
                            @if(in_array(strtolower($user->role->nama_role ?? ''), ['nakes', 'administrator', 'kader posyandu', 'kader']) && $konsultasiOnline->status !== 'pending')
                                <a href="{{ route('konsultasi-online.edit', $konsultasiOnline->id) }}" class="btn btn-sm btn-outline-warning rounded-pill bg-white px-3 shadow-xs small" title="Ubah Tanggapan Medis">
                                    <i class="bi bi-pencil-square me-1"></i> Ubah Tanggapan
                                </a>
                            @endif
                        </div>
                    </div>

                    <!-- Scrollable Chat Wallpaper Area -->
                    <div class="flex-grow-1 overflow-y-auto px-4 py-3 chat-content-area" id="chat-messages-container" style="background-image: radial-gradient(circle, #efeae2 20%, transparent 20%), radial-gradient(circle, #efeae2 20%, transparent 20%); background-size: 15px 15px; background-position: 0 0, 7.5px 7.5px; background-color: #efeae2;">
                        
                        <!-- System Notification: Topic Started -->
                        <div class="d-flex justify-content-center mb-4">
                            <div class="bg-white rounded-3 shadow-xs px-3 py-2 border text-center text-dark" style="max-width: 80%; font-size: 12px; border-radius: 12px !important;">
                                <div class="fw-bold text-success mb-1 uppercase"><i class="bi bi-shield-plus me-1"></i>SESI TELEMEDIS DIMULAI</div>
                                <span class="text-muted">Keluhan Utama:</span> <strong class="text-primary">{{ $konsultasiOnline->topik }}</strong>
                            </div>
                        </div>

                        <!-- 1. Patient Bubble (Left Aligned / Received) -->
                        <div class="d-flex justify-content-start mb-4">
                            <div class="bg-white rounded-4 shadow-sm p-3 text-dark position-relative border-light" style="max-width: 75%; border-top-left-radius: 4px !important; border: 1px solid #E2E8F0;">
                                <div class="fw-bold text-success small mb-1"><i class="bi bi-person-fill me-1"></i>Pasien (Ibu Hamil)</div>
                                <div style="font-size: 13.5px; line-height: 1.6; white-space: pre-wrap;">{{ $konsultasiOnline->pesan }}</div>
                                <div class="text-end text-muted mt-2 d-flex align-items-center justify-content-end" style="font-size: 9px;">
                                    <span>{{ $konsultasiOnline->created_at ? $konsultasiOnline->created_at->translatedFormat('d F Y H:i') : '' }}</span>
                                    <i class="bi bi-check2-all text-primary ms-1" style="font-size: 12px;"></i>
                                </div>
                            </div>
                        </div>

                        <!-- 2. Midwife / Nakes Reply Bubble (Right Aligned / Sent) -->
                        @if($konsultasiOnline->status === 'accepted')
                            <div class="d-flex justify-content-end mb-4">
                                <div class="rounded-4 shadow-sm p-3 text-dark position-relative" style="max-width: 75%; background-color: #d9fdd3; border-top-right-radius: 4px !important; border: 1px solid #C1E9BA;">
                                    <div class="fw-bold text-primary small mb-1"><i class="bi bi-shield-fill-check me-1"></i>{{ $konsultasiOnline->direspons_oleh ?? 'Tenaga Kesehatan' }}</div>
                                    <div style="font-size: 13.5px; line-height: 1.6; white-space: pre-wrap;">{{ $konsultasiOnline->respons }}</div>
                                    <div class="text-end text-muted mt-2 d-flex align-items-center justify-content-end" style="font-size: 9px;">
                                        <span>{{ $konsultasiOnline->direspons_pada ? \Carbon\Carbon::parse($konsultasiOnline->direspons_pada)->translatedFormat('d F Y H:i') : '' }}</span>
                                        <i class="bi bi-check2-all text-success ms-1" style="font-size: 12px;"></i>
                                    </div>
                                </div>
                            </div>
                        @elseif($konsultasiOnline->status === 'rejected')
                            <!-- Rejected notification bubble -->
                            <div class="d-flex justify-content-center mb-4">
                                <div class="bg-danger-subtle border border-danger-subtle rounded-3 px-3 py-2 text-center text-danger" style="max-width: 80%; font-size: 12px; border-radius: 12px !important;">
                                    <div class="fw-bold"><i class="bi bi-exclamation-octagon-fill me-1"></i>KONSULTASI DIRUJUK / DITOLAK</div>
                                    <p class="mb-0 mt-1 small text-dark" style="white-space: pre-wrap;">{{ $konsultasiOnline->respons ?? 'Keluhan ditolak atau ditutup. Ibu disarankan segera mengunjungi Faskes secara langsung.' }}</p>
                                </div>
                            </div>
                        @else
                            <!-- Pending Glow / Waiting Pill -->
                            <div class="d-flex justify-content-center my-5">
                                <div class="bg-warning-subtle border border-warning-subtle text-warning rounded-4 px-4 py-3 text-center shadow-xs" style="max-width: 75%; border-radius: 16px !important;">
                                    <div class="d-flex align-items-center justify-content-center mb-2">
                                        <div class="spinner-grow spinner-grow-sm text-warning me-2" role="status"></div>
                                        <h6 class="fw-bold mb-0" style="font-size: 13px;">Menunggu Tanggapan Medis...</h6>
                                    </div>
                                    <p class="text-muted small mb-0" style="font-size: 11.5px; line-height: 1.5;">
                                        Pesan keluhan ibu hamil sudah terkirim ke antrean klinik. Tenaga Kesehatan faskes terkait akan segera meninjau keluhan Anda di lembar kerja ini.
                                    </p>
                                </div>
                            </div>
                        @endif

                    </div>

                    <!-- Immersive WhatsApp-Style Footer Input -->
                    <div class="p-3 border-top d-flex align-items-center" style="background-color: #f0f2f5; height: 75px; z-index: 10;">
                        
                        <!-- 1. IF CURRENT USER IS NAKES/KADER AND STATUS IS PENDING: ACTIVE TEXT INPUT FORM -->
                        @if(in_array(strtolower($user->role->nama_role ?? ''), ['nakes', 'administrator', 'kader posyandu', 'kader']) && $konsultasiOnline->status === 'pending')
                            <form action="{{ route('konsultasi-online.update', $konsultasiOnline->id) }}" method="POST" class="w-100 d-flex align-items-center gap-2 m-0">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="accepted">
                                
                                <div class="d-flex text-secondary fs-4 px-2" style="cursor: pointer;">
                                    <i class="bi bi-emoji-smile me-3" title="Emoji"></i>
                                    <i class="bi bi-paperclip" title="Lampiran"></i>
                                </div>

                                <div class="flex-grow-1 position-relative">
                                    <textarea name="respons" class="form-control border-0 rounded-pill px-4 @error('respons') is-invalid @enderror" rows="1" placeholder="Ketik saran dan jawaban medis untuk ibu hamil..." style="font-size: 13px; padding-top: 10px; padding-bottom: 10px; resize: none; max-height: 44px;"></textarea>
                                    @error('respons')
                                        <div class="invalid-tooltip" style="top: -45px;">{{ $message }}</div>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-success rounded-circle p-0 d-flex align-items-center justify-content-center shadow-sm" 
                                        style="width: 44px; height: 44px; background-color: #128C7E; border-color: #128C7E;">
                                    <i class="bi bi-send-fill text-white fs-5" style="margin-left: 3px;"></i>
                                </button>
                            </form>

                        <!-- 2. IF CURRENT USER IS PATIENT AND STATUS IS PENDING: INACTIVE BAR WITH EDIT OPTIONS -->
                        @elseif($user->role->nama_role === 'ibu hamil' && $konsultasiOnline->status === 'pending')
                            <div class="w-100 d-flex align-items-center justify-content-between px-3 bg-white rounded-pill py-2 shadow-xs border">
                                <span class="text-muted small"><i class="bi bi-clock-history me-1 text-warning"></i>Pertanyaan Anda sedang menunggu respons medis Tenaga Kesehatan Puskesmas/Klinik...</span>
                                <a href="{{ route('konsultasi-online.edit', $konsultasiOnline->id) }}" class="btn btn-warning btn-sm text-white rounded-pill px-3 fw-bold small">
                                    <i class="bi bi-pencil-square me-1"></i> Ubah Pesan
                                </a>
                            </div>

                        <!-- 3. IF SESSION IS ALREADY ANSWERED OR CLOSED -->
                        @else
                            <div class="w-100 text-center py-2 text-muted small bg-white-50 border rounded-pill">
                                <i class="bi bi-lock-fill me-1 text-secondary"></i> Sesi konsultasi tanya jawab asinkronus ini telah ditinjau dan selesai dijawab.
                            </div>
                        @endif

                    </div>

                </div>

            </div>

        </div>
    </div>
</section>

<style>
    /* Premium Hover Styles matching WhatsApp Web list items */
    .hover-chat-item {
        background-color: #ffffff;
        transition: background-color 0.2s ease;
    }
    .hover-chat-item:hover {
        background-color: #f0f2f5 !important;
    }
    .active-chat-item {
        background-color: #ebebeb !important;
    }
    
    /* Scrollbars styles */
    #chat-list-container::-webkit-scrollbar,
    #chat-messages-container::-webkit-scrollbar {
        width: 6px;
    }
    #chat-list-container::-webkit-scrollbar-track,
    #chat-messages-container::-webkit-scrollbar-track {
        background: transparent;
    }
    #chat-list-container::-webkit-scrollbar-thumb,
    #chat-messages-container::-webkit-scrollbar-thumb {
        background-color: rgba(0, 0, 0, 0.15);
        border-radius: 10px;
    }
    
    /* Transition adjustments */
    .transition-all {
        transition: all 0.25s ease-in-out;
    }
</style>

@push('scripts')
<script>
    // Smooth scrolling auto-scroll to the bottom of the WhatsApp thread on load
    $(document).ready(function() {
        var container = document.getElementById('chat-messages-container');
        if (container) {
            container.scrollTop = container.scrollHeight;
        }
    });

    // Real-time live dynamic search filtering for sidebar chats
    $('#chat-search').on('keyup', function() {
        var query = $(this).val().toLowerCase();
        $('#chat-list-container a').each(function() {
            var title = $(this).find('h6').text().toLowerCase();
            var body = $(this).find('p').text().toLowerCase();
            if (title.indexOf(query) !== -1 || body.indexOf(query) !== -1) {
                $(this).removeClass('d-none').addClass('d-flex');
            } else {
                $(this).removeClass('d-flex').addClass('d-none');
            }
        });
    });
</script>
@endpush
@endsection
