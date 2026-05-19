@extends('layouts.dashboard.template')

@section('content')
<style>
    @media (max-width: 767px) {
        /* Hide Dashboard Elements for Full Screen Chat App Experience */
        #header, #sidebar, #footer, .back-to-top {
            display: none !important;
        }
        #main {
            padding: 0 !important;
            margin: 0 !important;
            height: 100dvh !important;
            overflow: hidden !important;
            display: flex;
            flex-direction: column;
        }
        body, html {
            background-color: #efeae2 !important;
            overflow: hidden !important;
            height: 100dvh !important;
            width: 100%;
            position: fixed;
        }

        .chat-container-card {
            height: 100dvh !important;
            min-height: 100dvh !important;
            border-radius: 0 !important;
            margin: 0 !important;
        }
        .chat-sidebar {
            width: 100% !important;
            min-width: 100% !important;
            height: 100% !important;
            border-right: none !important;
            display: {{ request()->has('chat_id') ? 'none' : 'flex' }} !important;
        }
        .chat-window {
            width: 100% !important;
            height: 100% !important;
            display: {{ request()->has('chat_id') ? 'flex' : 'none' }} !important;
        }
        #chat-messages-container {
            height: calc(100dvh - 140px) !important;
            max-height: calc(100dvh - 140px) !important;
            overflow-y: auto !important;
            -webkit-overflow-scrolling: touch !important;
        }
        .mobile-back-btn {
            display: flex !important;
        }
    }
    @media (min-width: 768px) {
        .mobile-back-btn {
            display: none !important;
        }
    }
</style>

<div class="pagetitle d-none d-md-flex justify-content-between align-items-center">
    <div>
        <h1 class="fw-bold text-dark">Layanan Telemedisin</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item">Layanan</li>
                <li class="breadcrumb-item active">Konsultasi Medis</li>
            </ol>
        </nav>
    </div>
    @if(auth()->user()->role->nama_role === 'ibu hamil' || auth()->user()->role->nama_role === 'administrator')
        <a href="{{ route('konsultasi-online.create') }}" class="btn btn-success rounded-pill px-4 fw-bold shadow-sm d-flex align-items-center gap-2"
           style="background: linear-gradient(135deg, #10B981, #059669); border: none;">
            <i class="bi bi-plus-circle-fill fs-5"></i> Tulis Keluhan Baru
        </a>
    @endif
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show border-0 rounded-4 p-3 shadow-sm mb-4" role="alert">
        <div class="d-flex align-items-center">
            <i class="bi bi-check-circle-fill fs-4 me-3 text-success"></i>
            <div>
                <strong class="text-success d-block">Berhasil!</strong>
                <span class="small text-secondary">{{ session('success') }}</span>
            </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<section class="section animate__animated animate__fadeIn">
    <div class="row m-0">
        <div class="col-12 p-0">
            
            <!-- Immersive WhatsApp Chat Container -->
            <div class="card border-0 shadow-sm overflow-hidden chat-container-card" style="border-radius: 20px; display: flex; flex-direction: row; background-color: #ffffff;">
                
                {{-- 1. LEFT PANEL: Conversations Sidebar (32% width) --}}
                <div class="chat-sidebar border-end d-flex flex-column" style="width: 32%; background-color: #ffffff; min-width: 280px;">
                    <!-- Sidebar User Profile Header -->
                    <div class="p-3 d-flex align-items-center justify-content-between" style="background-color: #f0f2f5; height: 65px; border-bottom: 1px solid #e3e3e3;">
                        <div class="d-flex align-items-center">
                            <div class="bg-primary text-white rounded-circle p-2 me-2 d-flex align-items-center justify-content-center fw-bold" style="width: 38px; height: 38px; font-size: 14px;">
                                {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                            </div>
                            <span class="fw-bold text-dark small text-truncate" style="max-width: 130px;">{{ auth()->user()->name }}</span>
                        </div>
                        <span class="badge bg-success-subtle text-success border border-success-subtle fw-semibold rounded-pill px-2" style="font-size: 10px;">
                            <i class="bi bi-circle-fill me-1" style="font-size: 6px;"></i> {{ ucwords(auth()->user()->role->nama_role) }} Online
                        </span>
                    </div>

                    <!-- Search Input -->
                    <div class="p-2 border-bottom" style="background-color: #fcffff;">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0 border-light-subtle rounded-start-pill py-1"><i class="bi bi-search text-muted small"></i></span>
                            <input type="text" class="form-control border-start-0 border-light-subtle rounded-end-pill py-1 small" placeholder="Cari percakapan..." id="chat-search" style="font-size: 13px;">
                        </div>
                    </div>

                    <!-- Conversation Thread List -->
                    <div class="flex-grow-1 overflow-y-auto" id="chat-list-container">
                        @forelse($otherConsultations as $item)
                            <a href="{{ route('konsultasi-online.index', ['chat_id' => $item->id]) }}" 
                               class="d-flex align-items-center p-3 border-bottom text-decoration-none transition-all hover-chat-item {{ ($konsultasiOnline && $item->id === $konsultasiOnline->id) ? 'active-chat-item' : '' }}"
                               style="border-left: 4px solid {{ ($konsultasiOnline && $item->id === $konsultasiOnline->id) ? '#128C7E' : 'transparent' }};">
                                
                                <div class="position-relative me-3">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center text-white" 
                                         style="width: 44px; height: 44px; background: linear-gradient(135deg, #128C7E 0%, #075E54 100%);">
                                        <i class="bi bi-chat-heart-fill"></i>
                                    </div>
                                    @if($item->status === 'pending')
                                        <span class="position-absolute bottom-0 end-0 bg-warning border border-white rounded-circle p-1" title="Menunggu Tanggapan"></span>
                                    @elseif($item->status === 'accepted')
                                        <span class="position-absolute bottom-0 end-0 bg-success border border-white rounded-circle p-1" title="Telah Dijawab"></span>
                                    @endif
                                </div>

                                <div class="flex-grow-1 min-w-0">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <h6 class="fw-bold text-dark text-truncate mb-0" style="font-size: 13px;">
                                            @if(auth()->user()->role->nama_role === 'ibu hamil')
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
                                        <p class="text-muted text-truncate mb-0 small" style="font-size: 12px; max-width: 150px;">
                                            <strong>{{ $item->topik }}</strong>: {{ $item->respons ?? $item->pesan }}
                                        </p>
                                        @if($item->status === 'pending')
                                            <span class="badge bg-warning-subtle text-warning" style="font-size: 9px; border-radius: 10px;">Pending</span>
                                        @elseif($item->status === 'accepted')
                                            <span class="badge bg-success-subtle text-success" style="font-size: 9px; border-radius: 10px;">Dijawab</span>
                                        @else
                                            <span class="badge bg-danger-subtle text-danger" style="font-size: 9px; border-radius: 10px;">Rujuk</span>
                                        @endif
                                    </div>
                                </div>
                            </a>
                        @empty
                            <div class="text-center py-5 text-muted small">Belum ada sesi konsultasi terdaftar.</div>
                        @endforelse
                    </div>
                </div>

                {{-- 2. RIGHT PANEL: Interactive Chat Workspace (68% width) --}}
                @if($konsultasiOnline)
                    <div class="chat-window d-flex flex-column" id="chat-window-wrapper" data-chat-id="{{ $konsultasiOnline->id }}" style="width: 68%; background-color: #efeae2; position: relative; height: 100%; overflow: hidden;">
                        
                        <!-- Chat Header -->
                        <div class="p-2 p-md-3 d-flex align-items-center justify-content-between flex-shrink-0" style="background-color: #f0f2f5; min-height: 65px; border-bottom: 1px solid #e3e3e3; z-index: 10;">
                            <div class="d-flex align-items-center flex-grow-1" style="min-width: 0;">
                                <!-- Mobile Back Button -->
                                <a href="{{ route('konsultasi-online.index') }}" class="mobile-back-btn text-dark text-decoration-none me-2 me-md-3 align-items-center justify-content-center">
                                    <i class="bi bi-arrow-left fs-4"></i>
                                </a>
                                
                                <div class="rounded-circle d-flex align-items-center justify-content-center text-white me-2 me-md-3" 
                                     style="width: 40px; height: 40px; background: linear-gradient(135deg, #25D366 0%, #128C7E 100%); flex-shrink: 0;">
                                    <i class="bi bi-person-circle fs-4"></i>
                                </div>
                                <div class="flex-grow-1 text-truncate pe-2">
                                    <h6 class="fw-bold text-dark mb-0 text-truncate" style="font-size: 14px;">
                                        @if(auth()->user()->role->nama_role === 'ibu hamil')
                                            {{ optional($konsultasiOnline->fasilitasKesehatan)->nama_faskes ?? 'Tenaga Kesehatan' }}
                                        @else
                                            {{ optional($konsultasiOnline->user)->name ?? 'Ibu Hamil (Pasien)' }}
                                        @endif
                                    </h6>
                                    <span class="text-muted text-truncate d-block" style="font-size: 11px;">
                                        <i class="bi bi-journals me-1"></i>Topik: <strong class="text-primary">{{ $konsultasiOnline->topik }}</strong>
                                    </span>
                                </div>
                            </div>

                            <!-- Header Actions -->
                            <div class="d-flex align-items-center gap-1 gap-md-2 flex-shrink-0">
                                <span class="badge text-secondary bg-white border border-light-subtle rounded-pill px-2 px-md-3 py-1 fw-bold small d-none d-md-inline-block">
                                    NIK: {{ optional($konsultasiOnline->user->profilIbu)->nik ?? '-' }}
                                </span>
                                
                                @if(in_array(auth()->user()->role->nama_role, ['administrator', 'nakes']) || (auth()->user()->role->nama_role === 'ibu hamil' && $konsultasiOnline->status === 'pending'))
                                    <button type="button" class="btn btn-outline-danger btn-sm rounded-pill px-2 px-md-3 py-1 btn-delete shadow-xs fw-bold small d-flex align-items-center" data-id="{{ $konsultasiOnline->id }}">
                                        <i class="bi bi-trash"></i> <span class="d-none d-md-inline ms-1">Hapus</span>
                                    </button>
                                @endif
                            </div>
                        </div>

                        <!-- Chat Messages Space -->
                        <div class="flex-grow-1 overflow-y-auto px-4 py-3" id="chat-messages-container" style="min-height: 0; background-image: radial-gradient(circle, #efeae2 20%, transparent 20%), radial-gradient(circle, #efeae2 20%, transparent 20%); background-size: 15px 15px; background-position: 0 0, 7.5px 7.5px; background-color: #efeae2; -webkit-overflow-scrolling: touch;">
                            
                            <!-- Initial System Pill -->
                            <div class="d-flex justify-content-center mb-4">
                                <div class="bg-white rounded-3 shadow-xs px-3 py-2 border text-center text-dark" style="max-width: 80%; font-size: 11px; border-radius: 12px !important;">
                                    <div class="fw-bold text-success mb-1 uppercase"><i class="bi bi-shield-plus me-1"></i>SESI TELEMEDIS AKTIF</div>
                                    <span class="text-muted">Dibuka pada:</span> <strong>{{ $konsultasiOnline->created_at ? $konsultasiOnline->created_at->translatedFormat('d F Y H:i') : '' }}</strong>
                                </div>
                            </div>

                            <!-- Alternate Back-and-Forth Chat Bubbles -->
                            @foreach($konsultasiOnline->messages as $msg)
                                @php
                                    $isMe = $msg->sender_id === auth()->id();
                                @endphp
                                @if($isMe)
                                    <!-- Logged-in User's own sent message (Right / Green) -->
                                    <div class="d-flex justify-content-end mb-3">
                                        <div class="rounded-4 shadow-sm p-3 text-dark position-relative" style="max-width: 75%; background-color: #d9fdd3; border-top-right-radius: 4px !important; border: 1px solid #C1E9BA;">
                                            <div class="fw-bold text-primary small mb-1"><i class="bi bi-person-fill-check me-1"></i>Anda</div>
                                            <div style="font-size: 13.5px; line-height: 1.6; white-space: pre-wrap;">{{ $msg->message }}</div>
                                            <div class="text-end text-muted mt-2 d-flex align-items-center justify-content-end" style="font-size: 9px;">
                                                <span>{{ $msg->created_at ? $msg->created_at->translatedFormat('d F Y H:i') : '' }}</span>
                                                <i class="bi bi-check2-all text-success ms-1" style="font-size: 12px;"></i>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <!-- Incoming partner response (Left / White) -->
                                    <div class="d-flex justify-content-start mb-3">
                                        <div class="bg-white rounded-4 shadow-sm p-3 text-dark position-relative border-light" style="max-width: 75%; border-top-left-radius: 4px !important; border: 1px solid #E2E8F0;">
                                            <div class="fw-bold text-success small mb-1">
                                                <i class="bi bi-shield-fill-check me-1"></i>
                                                {{ $msg->sender->name }} ({{ strtoupper($msg->sender->role->nama_role) }})
                                            </div>
                                            <div style="font-size: 13.5px; line-height: 1.6; white-space: pre-wrap;">{{ $msg->message }}</div>
                                            <div class="text-end text-muted mt-2 d-flex align-items-center justify-content-end" style="font-size: 9px;">
                                                <span>{{ $msg->created_at ? $msg->created_at->translatedFormat('d F Y H:i') : '' }}</span>
                                                <i class="bi bi-check2-all text-primary ms-1" style="font-size: 12px;"></i>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach

                            <!-- Session Status System Indicator -->
                            @if($konsultasiOnline->status === 'pending')
                                <div class="d-flex justify-content-center my-4">
                                    <span class="badge bg-warning-subtle text-warning border border-warning-subtle rounded-pill px-3 py-2 small fw-semibold">
                                        <i class="bi bi-clock-history me-1"></i> Menunggu Tanggapan Medis dari Tenaga Kesehatan...
                                    </span>
                                </div>
                            @elseif($konsultasiOnline->status === 'rejected')
                                <div class="d-flex justify-content-center my-4">
                                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle rounded-pill px-3 py-2 small fw-semibold">
                                        <i class="bi bi-exclamation-octagon-fill me-1"></i> Konsultasi ditutup / Rujuk Segera
                                    </span>
                                </div>
                            @endif

                        </div>

                        <!-- Chat Bottom Input Bar -->
                        <div class="p-3 border-top d-flex align-items-center flex-shrink-0" style="background-color: #f0f2f5; min-height: 75px; z-index: 10;">
                            
                            @if($konsultasiOnline->status !== 'rejected')
                                <!-- Dynamic Reply Form -->
                                <form action="{{ route('konsultasi-online.reply', $konsultasiOnline->id) }}" method="POST" class="w-100 d-flex align-items-center gap-2 m-0" id="reply-form">
                                    @csrf
                                    
                                    <div class="d-flex text-secondary fs-4 px-2" style="cursor: pointer;">
                                        <i class="bi bi-emoji-smile me-3" title="Emoji"></i>
                                        <i class="bi bi-paperclip" title="Lampiran"></i>
                                    </div>

                                    <div class="flex-grow-1 position-relative">
                                        <input type="text" name="message" class="form-control border-0 rounded-pill px-4" placeholder="Ketik pesan Anda di sini untuk membalas..." style="font-size: 13.5px; height: 44px;" required autocomplete="off" id="reply-input">
                                    </div>

                                    <button type="submit" class="btn btn-success rounded-circle p-0 d-flex align-items-center justify-content-center shadow-sm" 
                                            style="width: 44px; height: 44px; background-color: #128C7E; border-color: #128C7E;">
                                        <i class="bi bi-send-fill text-white fs-5" style="margin-left: 3px;"></i>
                                    </button>
                                </form>
                            @else
                                <div class="w-100 text-center py-2 text-muted small bg-white-50 border rounded-pill">
                                    <i class="bi bi-lock-fill me-1"></i> Sesi obrolan ini telah ditutup/dirujuk oleh Tenaga Kesehatan.
                                </div>
                            @endif

                        </div>

                    </div>
                @else
                    {{-- 3. UNIFIED STUNNING WELCOME SCREEN --}}
                    <div class="chat-window d-flex flex-column align-items-center justify-content-center text-center" style="width: 68%; background-color: #f8fafc; min-height: 100%;">
                        <div class="bg-emerald-subtle rounded-circle p-4 mb-3 d-flex align-items-center justify-content-center" 
                             style="width: 120px; height: 120px; background-color: #ECFDF5;">
                            <i class="bi bi-chat-heart-fill text-success" style="font-size: 4rem;"></i>
                        </div>
                        <h4 class="fw-bold text-dark">Portal Telemedisin KIA</h4>
                        <p class="text-muted small px-5" style="max-width: 480px;">
                            Selamat datang di Portal Konsultasi Medis Online. Di sini Anda dapat bertukar pesan secara langsung (*back-and-forth*) dengan Tenaga Kesehatan setempat layaknya WhatsApp Chat aktif.
                        </p>
                        <p class="text-secondary small fw-semibold"><i class="bi bi-info-circle me-1 text-primary"></i>Pilih salah satu daftar percakapan aktif di bilah sebelah kiri untuk mulai berkirim pesan langsung.</p>
                    </div>
                @endif

            </div>

        </div>
    </div>
</section>

<style>
    /* Premium Hover Styles */
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
    
    /* Elegant Custom Scrollbars */
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
    
    .transition-all {
        transition: all 0.25s ease-in-out;
    }
</style>

@push('scripts')
<script>
    // Smooth scrolling auto-scroll to the bottom of the active conversation thread
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

    // AJAX Delete Confirmation Flow
    $(document).on('click', '.btn-delete', function () {
        var id = $(this).data('id');
        Swal.fire({
            title: 'Hapus Sesi Konsultasi?',
            text: "Seluruh riwayat pesan obrolan ini akan dihapus secara permanen dari server!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#EF4444',
            cancelButtonColor: '#6B7280',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ url('konsultasi-online') }}/" + id,
                    type: 'POST',
                    data: { _method: 'DELETE', _token: "{{ csrf_token() }}" },
                    success: function (response) {
                        if (response.success) {
                            Swal.fire({
                                title: 'Berhasil Terhapus!',
                                text: response.message,
                                icon: 'success',
                                confirmButtonColor: '#10B981'
                            }).then(() => {
                                window.location.href = "{{ route('konsultasi-online.index') }}";
                            });
                        } else {
                            Swal.fire('Gagal!', response.message, 'error');
                        }
                    },
                    error: function (xhr) {
                        var msg = xhr.responseJSON ? xhr.responseJSON.message : 'Terjadi kesalahan sistem saat menghapus data.';
                        Swal.fire('Gagal!', msg, 'error');
                    }
                });
            }
        });
    });
</script>
@endpush
@endsection
