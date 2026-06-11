@extends('layouts.app')

@section('title', $item->title . ' — PixelStudio')

@section('content')
<div class="dashboard-page">

    <div class="breadcrumb">
        <a href="{{ route('home') }}">Beranda</a>
        <i class="ti ti-chevron-right"></i>
        <a href="{{ route('portofolio') }}">Portofolio</a>
        <i class="ti ti-chevron-right"></i>
        <span class="gold">{{ $item->title }}</span>
    </div>

    @php
        $warnaMap = [
            'Branding'     => 'var(--gold)',
            'Social Media' => '#9B59B6',
            'Cetak'        => '#E74C3C',
            'Digital'      => '#3498DB',
            'Packaging'    => '#2ECC71',
        ];
        $warna = $warnaMap[$item->category] ?? 'var(--gold)';
    @endphp

    <div class="detail-layout">

        {{-- Kiri --}}
        <div class="detail-main">

            <div class="porto-detail-img-wrap" style="background: {{ $warna }}22;">
                @if($item->image)
                    <img src="{{ $item->image }}" alt="{{ $item->title }}" class="porto-detail-img"
                        onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                @endif
                <div class="porto-img-fallback-lg"
                    style="{{ $item->image ? 'display:none;' : '' }} background:linear-gradient(135deg, {{ $warna }}22, {{ $warna }}08);">
                    <i class="ti ti-photo" style="font-size:64px; color:{{ $warna }};"></i>
                </div>
            </div>

            <div class="section-card" style="margin-top:20px;">
                <div class="section-card-header">
                    <h3><i class="ti ti-file-description"></i> Tentang Proyek</h3>
                </div>
                <div style="padding:24px;">
                    <p style="font-size:14px; color:var(--text-secondary); line-height:1.8;">
                        {{ $item->description ?? 'Deskripsi proyek belum tersedia.' }}
                    </p>
                </div>
            </div>

            {{-- Karya Lainnya dari Kategori Sama --}}
            @php
                $lainnya = \Illuminate\Support\Facades\DB::table('portfolios')
                    ->where('id', '!=', $item->id)
                    ->where('category', $item->category)
                    ->limit(3)
                    ->get();
            @endphp

            @if($lainnya->count() > 0)
            <div style="margin-top:28px;">
                <h3 style="font-size:16px; font-weight:700; margin-bottom:16px;">Karya Lainnya di Kategori Ini</h3>
                <div style="display:grid; grid-template-columns:repeat(3,1fr); gap:16px;">
                    @foreach ($lainnya as $karya)
                    @php
                        $karya_warna = $warnaMap[$karya->category] ?? 'var(--gold)';
                    @endphp
                    <a href="{{ route('portofolio.detail', $karya->id) }}" class="porto-card-mini">
                        <div class="porto-mini-img" style="background:{{ $karya_warna }}22;">
                            @if($karya->image)
                                <img src="{{ $karya->image }}" alt="{{ $karya->title }}"
                                    style="width:100%; height:100%; object-fit:cover;"
                                    onerror="this.style.display='none';">
                            @else
                                <i class="ti ti-photo" style="font-size:28px; color:{{ $karya_warna }};"></i>
                            @endif
                        </div>
                        <div style="padding:10px 12px;">
                            <div style="font-size:11px; color:{{ $karya_warna }}; margin-bottom:3px;">{{ $karya->category }}</div>
                            <div style="font-size:13px; font-weight:600; color:var(--text-main);">{{ $karya->title }}</div>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif

        </div>

        {{-- Sidebar --}}
        <div class="detail-sidebar">
            <div class="section-card sidebar-cta">
                <div style="padding:24px;">

                    <div style="display:inline-flex; align-items:center; gap:6px;
                        background:{{ $warna }}22; border:1px solid {{ $warna }}44;
                        color:{{ $warna }}; font-size:11px; font-weight:600;
                        padding:4px 14px; border-radius:20px; margin-bottom:14px;">
                        {{ $item->category }}
                    </div>

                    <h2 style="font-size:20px; font-weight:800; margin-bottom:6px;">
                        {{ $item->title }}
                    </h2>

                    <div style="margin:16px 0; display:flex; flex-direction:column; gap:10px;">
                        @if($item->klien)
                        <div class="sidebar-info-row">
                            <i class="ti ti-building"></i>
                            <span>{{ $item->klien }}</span>
                        </div>
                        @endif
                        @if($item->tahun)
                        <div class="sidebar-info-row">
                            <i class="ti ti-calendar"></i>
                            <span>Tahun {{ $item->tahun }}</span>
                        </div>
                        @endif
                    </div>

                    <div style="border-top:1px solid var(--dark-border); padding-top:18px; margin-top:4px;">
                        <p style="font-size:12.5px; color:var(--text-muted); line-height:1.7; margin-bottom:16px;">
                            Tertarik dengan hasil karya seperti ini? Pesan layanan desain sekarang!
                        </p>
                        @if(session('username') && strtolower(session('role')) !== 'admin')
                            <a href="{{ route('order') }}" class="btn-hero"
                                style="width:100%; text-align:center; display:block;">
                                Pesan Desain Serupa
                            </a>
                        @elseif(strtolower(session('role') ?? '') === 'admin')
                            <span class="btn-hero"
                                style="width:100%; text-align:center; display:block; background:#333; cursor:not-allowed; opacity:0.5;">
                                Admin Mode
                            </span>
                        @else
                            <a href="{{ route('login') }}" class="btn-hero"
                                style="width:100%; text-align:center; display:block;">
                                Masuk untuk Memesan
                            </a>
                        @endif
                        <a href="{{ route('portofolio') }}" class="btn-outline-nav"
                            style="width:100%; text-align:center; display:block; margin-top:10px;">
                            Lihat Semua Karya
                        </a>
                    </div>

                </div>
            </div>
        </div>

    </div>

</div>
@endsection
