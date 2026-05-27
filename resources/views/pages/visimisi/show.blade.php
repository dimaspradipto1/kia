@extends('layouts.dashboard.template')

@section('content')
<div class="pagetitle">
    <h1>Detail Visi & Misi</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('visi-misi.index') }}">Visi & Misi</a></li>
            <li class="breadcrumb-item active">Detail</li>
        </ol>
    </nav>
</div>

<section class="section">
    <div class="row justify-content-center">
        <div class="col-lg-10">

            {{-- Header Card --}}
            <div class="card border-0 shadow-sm mb-4" style="border-radius:12px;overflow:hidden;border-top:5px solid #EC1E88 !important;">
                <div class="card-header bg-white border-bottom py-3 px-4 d-flex justify-content-between align-items-center">
                    <h5 class="m-0 fw-bold text-dark" style="font-size:1.1rem;">Detail Konten Visi & Misi</h5>
                    <div class="d-flex gap-2">
                        @if($visiMisi->is_active)
                            <span class="badge bg-success px-3 py-2">Aktif</span>
                        @else
                            <span class="badge bg-danger px-3 py-2">Non-Aktif</span>
                        @endif
                        <a href="{{ route('visi-misi.index') }}" class="btn btn-secondary btn-sm px-3">
                            <i class="bi bi-arrow-left me-1"></i> Kembali
                        </a>
                    </div>
                </div>
                <div class="card-body p-4">

                    {{-- Visi --}}
                    <div class="mb-4 p-4" style="background:#FFF5F8;border-radius:12px;border-left:4px solid #EC1E88;">
                        <div class="d-flex align-items-center mb-2">
                            <div class="rounded-circle d-flex align-items-center justify-content-center me-3"
                                 style="width:38px;height:38px;background:#EC1E88;color:#fff;flex-shrink:0;">
                                <i class="fa fa-eye"></i>
                            </div>
                            <h6 class="fw-bold mb-0" style="color:#EC1E88;">VISI</h6>
                        </div>
                        <p class="mb-0" style="font-size:1.05rem;line-height:1.8;text-align:justify;">{{ $visiMisi->visi }}</p>
                    </div>

                    {{-- Misi --}}
                    <div class="mb-4 p-4" style="background:#F0F9FF;border-radius:12px;border-left:4px solid #0EA5E9;">
                        <div class="d-flex align-items-center mb-3">
                            <div class="rounded-circle d-flex align-items-center justify-content-center me-3"
                                 style="width:38px;height:38px;background:#0EA5E9;color:#fff;flex-shrink:0;">
                                <i class="fa fa-bullseye"></i>
                            </div>
                            <h6 class="fw-bold mb-0" style="color:#0EA5E9;">MISI <span class="badge ms-2" style="background:#0EA5E9;font-size:.75rem;">{{ count($visiMisi->misi ?? []) }} poin</span></h6>
                        </div>
                        <ol class="mb-0 ps-4">
                            @foreach($visiMisi->misi ?? [] as $poin)
                                <li class="mb-2" style="line-height:1.7;">{{ $poin }}</li>
                            @endforeach
                        </ol>
                    </div>

                    {{-- Nilai Ringkasan --}}
                    <div class="mb-4 p-4" style="background:#F0FDF4;border-radius:12px;border-left:4px solid #22C55E;">
                        <div class="d-flex align-items-center mb-2">
                            <div class="rounded-circle d-flex align-items-center justify-content-center me-3"
                                 style="width:38px;height:38px;background:#22C55E;color:#fff;flex-shrink:0;">
                                <i class="fa fa-heart"></i>
                            </div>
                            <h6 class="fw-bold mb-0" style="color:#22C55E;">NILAI (Ringkasan)</h6>
                        </div>
                        <p class="mb-0" style="line-height:1.8;text-align:justify;">
                            {{ $visiMisi->nilai ?? '—' }}
                        </p>
                    </div>

                    {{-- Nilai Items --}}
                    @if(!empty($visiMisi->nilai_items))
                    <div class="p-4" style="background:#F5F3FF;border-radius:12px;border-left:4px solid #8B5CF6;">
                        <div class="d-flex align-items-center mb-3">
                            <div class="rounded-circle d-flex align-items-center justify-content-center me-3"
                                 style="width:38px;height:38px;background:#8B5CF6;color:#fff;flex-shrink:0;">
                                <i class="bi bi-grid-3x2-gap"></i>
                            </div>
                            <h6 class="fw-bold mb-0" style="color:#8B5CF6;">ITEM NILAI DETAIL <span class="badge ms-2" style="background:#8B5CF6;font-size:.75rem;">{{ count($visiMisi->nilai_items) }} item</span></h6>
                        </div>
                        <div class="row g-3">
                            @foreach($visiMisi->nilai_items as $item)
                                @php $colors = $temaColors[$item['tema'] ?? 'blue'] ?? $temaColors['blue']; @endphp
                                <div class="col-md-6">
                                    <div class="p-3 border" style="border-radius:12px;background:{{ $colors['bg'] }};border-color:{{ $colors['border'] }} !important;">
                                        <h6 class="fw-bold mb-1">
                                            <i class="fa {{ $item['ikon'] ?? 'fa-star' }} me-2" style="color:{{ $colors['ikon'] }};"></i>
                                            {{ $item['judul'] }}
                                        </h6>
                                        <p class="small text-muted mb-0" style="line-height:1.6;">{{ $item['deskripsi'] }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @else
                    <p class="text-muted mb-0"><i class="bi bi-dash-circle me-1"></i>Belum ada item nilai detail.</p>
                    @endif
                </div>
                <div class="card-footer bg-white border-top p-4 text-end">
                    <a href="{{ route('visi-misi.edit', $visiMisi->id) }}" class="btn text-white px-5 py-2 fw-bold shadow-sm"
                       style="background:#EC1E88;border-radius:10px;">
                        <i class="bi bi-pencil-square me-2"></i> Edit
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>
@endsection
