@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1 class="fw-bold text-dark">Pusat Notifikasi</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active">Notifikasi</li>
        </ol>
    </nav>
</div>

<section class="section">
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-bottom py-3 px-4 d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="fw-bold mb-0"><i class="bi bi-bell-fill text-primary me-2"></i>Semua Notifikasi</h5>
                        <small class="text-muted">{{ auth()->user()->unreadNotifications()->count() }} belum dibaca</small>
                    </div>
                    @if(auth()->user()->unreadNotifications()->count() > 0)
                        <form action="{{ route('notifikasi.mark-all-read') }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-sm btn-outline-primary rounded-pill">
                                <i class="bi bi-check2-all me-1"></i> Tandai Semua Dibaca
                            </button>
                        </form>
                    @endif
                </div>

                @php
                $tipeConfig = [
                    'ttd_harian'      => ['color' => '#8b5cf6', 'bg' => '#f5f3ff'],
                    'anc_reminder'    => ['color' => '#2563eb', 'bg' => '#eff6ff'],
                    'imunisasi_reminder' => ['color' => '#059669', 'bg' => '#f0fdf4'],
                    'stunting_alert'  => ['color' => '#dc2626', 'bg' => '#fef2f2'],
                    'pasien_belum_anc'=> ['color' => '#d97706', 'bg' => '#fffbeb'],
                    'rekap_anc'       => ['color' => '#0891b2', 'bg' => '#f0f9ff'],
                    'posyandu_bulanan'=> ['color' => '#16a34a', 'bg' => '#f0fdf4'],
                    'tanda_bahaya'    => ['color' => '#dc2626', 'bg' => '#fef2f2'],
                    'kelas_ibu'       => ['color' => '#be185d', 'bg' => '#fdf2f8'],
                    'rujukan'         => ['color' => '#7c3aed', 'bg' => '#faf5ff'],
                ];
                @endphp

                <div class="card-body p-0">
                    @forelse($notifikasi as $notif)
                        @php
                            $data   = $notif->data;
                            $tipe   = $data['tipe'] ?? 'info';
                            $cfg    = $tipeConfig[$tipe] ?? ['color' => '#64748b', 'bg' => '#f8fafc'];
                            $isRead = $notif->read_at !== null;
                        @endphp
                        <div class="d-flex align-items-start px-4 py-3 border-bottom notif-item {{ $isRead ? 'opacity-75' : '' }}"
                             style="{{ !$isRead ? 'background: #fafbff;' : '' }}" data-id="{{ $notif->id }}">

                            {{-- Icon --}}
                            <div class="me-3 mt-1 flex-shrink-0">
                                <div class="rounded-circle d-flex align-items-center justify-content-center"
                                     style="width:44px; height:44px; background:{{ $cfg['bg'] }}; color:{{ $cfg['color'] }};">
                                    <i class="bi {{ $data['icon'] ?? 'bi-bell' }} fs-5"></i>
                                </div>
                            </div>

                            {{-- Content --}}
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <span class="fw-bold text-dark" style="font-size:0.92rem;">{{ $data['judul'] ?? '-' }}</span>
                                        @if(!$isRead)
                                            <span class="badge rounded-pill ms-2 text-white" style="background:{{ $cfg['color'] }}; font-size:0.65rem;">Baru</span>
                                        @endif
                                    </div>
                                    <div class="d-flex align-items-center gap-2 ms-3 flex-shrink-0">
                                        <small class="text-muted">{{ $notif->created_at->diffForHumans() }}</small>
                                        @if(!$isRead)
                                            <button class="btn btn-sm btn-link p-0 text-primary btn-mark-read"
                                                    data-id="{{ $notif->id }}" title="Tandai dibaca">
                                                <i class="bi bi-check2"></i>
                                            </button>
                                        @endif
                                        <form action="{{ route('notifikasi.destroy', $notif->id) }}" method="POST" class="d-inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-link p-0 text-danger" title="Hapus">
                                                <i class="bi bi-trash3"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                <p class="mb-1 text-muted" style="font-size:0.85rem;">{{ $data['pesan'] ?? '' }}</p>
                                @if(!empty($data['link']))
                                    <a href="{{ $data['link'] }}" class="small fw-semibold" style="color:{{ $cfg['color'] }};">
                                        <i class="bi bi-arrow-right-circle me-1"></i>Lihat Detail
                                    </a>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5 text-muted">
                            <i class="bi bi-bell-slash fs-1 d-block mb-3 opacity-50"></i>
                            <p class="fw-semibold">Tidak ada notifikasi</p>
                            <small>Anda akan menerima notifikasi jadwal ANC, TTD, imunisasi, dan peringatan lainnya di sini.</small>
                        </div>
                    @endforelse
                </div>

                @if($notifikasi->hasPages())
                    <div class="card-footer bg-white border-top py-3 px-4">
                        {{ $notifikasi->links() }}
                    </div>
                @endif
            </div>

            {{-- Legenda Tipe Notifikasi --}}
            <div class="card border-0 shadow-sm rounded-4 mt-4">
                <div class="card-header bg-white border-bottom py-3 px-4">
                    <h6 class="fw-bold mb-0"><i class="bi bi-info-circle me-2 text-info"></i>Jenis Notifikasi</h6>
                </div>
                <div class="card-body py-3 px-4">
                    <div class="row g-2">
                        @php
                        $jenisNotif = [
                            ['icon'=>'bi-capsule','color'=>'#8b5cf6','label'=>'Pengingat TTD/MMS Harian','desc'=>'Dikirim setiap hari ke ibu hamil'],
                            ['icon'=>'bi-hospital','color'=>'#2563eb','label'=>'Pengingat Jadwal ANC','desc'=>'H-1 dan hari-H kunjungan ANC'],
                            ['icon'=>'bi-shield-plus','color'=>'#059669','label'=>'Jadwal Imunisasi Anak','desc'=>'Notifikasi imunisasi mendatang'],
                            ['icon'=>'bi-exclamation-triangle','color'=>'#d97706','label'=>'Pasien Belum ANC','desc'=>'Alert untuk nakes: pasien terlambat ANC'],
                            ['icon'=>'bi-graph-down-arrow','color'=>'#dc2626','label'=>'Alert Stunting','desc'=>'BB/TB tidak sesuai standar WHO'],
                            ['icon'=>'bi-calendar-heart','color'=>'#16a34a','label'=>'Pengingat Posyandu','desc'=>'Pengingat posyandu bulanan'],
                        ];
                        @endphp
                        @foreach($jenisNotif as $j)
                            <div class="col-md-4">
                                <div class="d-flex align-items-center gap-2 p-2 rounded-3" style="background:#f8fafc;">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                                         style="width:34px;height:34px;background:{{ $j['color'] }}20;color:{{ $j['color'] }};">
                                        <i class="bi {{ $j['icon'] }}"></i>
                                    </div>
                                    <div>
                                        <div class="fw-semibold" style="font-size:0.8rem;">{{ $j['label'] }}</div>
                                        <div class="text-muted" style="font-size:0.72rem;">{{ $j['desc'] }}</div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.btn-mark-read').forEach(function (btn) {
        btn.addEventListener('click', function () {
            const id   = this.dataset.id;
            const item = this.closest('.notif-item');

            fetch(`/notifikasi/${id}/read`, {
                method : 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}',
                    'Accept'      : 'application/json',
                    'Content-Type': 'application/json',
                },
            }).then(r => r.json()).then(d => {
                if (d.success) {
                    item.classList.add('opacity-75');
                    item.style.background = '';
                    this.remove();
                    const badge = item.querySelector('.badge');
                    if (badge) badge.remove();
                }
            });
        });
    });
});
</script>
@endpush
@endsection
