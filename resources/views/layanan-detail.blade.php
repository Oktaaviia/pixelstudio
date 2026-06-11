@extends('layouts.app')

@section('title', $item->name . ' — PixelStudio')

@section('content')
<div class="dashboard-page">

    <div class="breadcrumb">
        <a href="{{ route('home') }}">Beranda</a>
        <i class="ti ti-chevron-right"></i>
        <a href="{{ route('layanan') }}">Layanan</a>
        <i class="ti ti-chevron-right"></i>
        <span class="gold">{{ $item->name }}</span>
    </div>

    <div class="detail-layout">
        <div class="detail-main">
            <div class="section-card">
                <div style="padding: 32px;">
                    <div class="detail-header">
                        <div class="detail-icon-lg">
                            @php
                                $iconMap = [
                                    'Cetak'        => 'ti-files',
                                    'Social Media' => 'ti-brand-instagram',
                                    'Digital'      => 'ti-device-desktop',
                                    'Branding'     => 'ti-hexagon',
                                    'Packaging'    => 'ti-box',
                                ];
                                $icon = $iconMap[$item->category] ?? 'ti-palette';
                            @endphp
                            <i class="ti {{ $icon }}"></i>
                        </div>
                        <div>
                            <div class="detail-kategori">{{ $item->category }}</div>
                            <h1 class="detail-title">{{ $item->name }}</h1>
                            <p class="detail-desc">{{ $item->description }}</p>
                            <p class="detail-desc" style="margin-top: 10px;">
                                Layanan <strong style="color: var(--text-main);">{{ $item->name }}</strong> kami dirancang khusus untuk memenuhi kebutuhan visual brand Anda secara profesional dan menyeluruh. Tim desainer berpengalaman kami akan memastikan setiap elemen visual mengomunikasikan pesan brand dengan tepat — mulai dari konsep awal hingga hasil akhir beresolusi tinggi yang siap digunakan. Pengerjaan dilakukan dengan standar kualitas tinggi dalam waktu <strong style="color: var(--gold);">{{ $item->duration ?? 'yang fleksibel' }}</strong>, sesuai kebutuhan dan deadline Anda.
                            </p>
                        </div>
                    </div>

                    <div class="detail-meta-row">
                        <div class="detail-meta-badge">
                            Pengerjaan: {{ $item->duration ?? 'Fleksibel' }}
                        </div>
                    </div>
                </div>
            </div>

            {{-- Pilihan Paket --}}
            <div class="section-card" style="margin-top:20px;">
                <div class="section-card-header">
                    <h3><i class="ti ti-package"></i> Pilihan Paket</h3>
                </div>
                <div style="padding:28px; text-align: center;">
                    <div style="display: flex; flex-wrap: wrap; justify-content: center; gap: 20px; align-items: center; margin-bottom: 24px; background: rgba(255,255,255,0.02); padding: 16px; border-radius: 12px; border: 1px solid var(--dark-border);">
                        @foreach($paketList as $pkg)
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <span style="font-weight: 600; color: var(--text-main); font-size: 15px;">Paket {{ $pkg->nama }}</span>
                            <span style="color: var(--gold); font-weight: 700; font-size: 15px;">({{ $pkg->price }})</span>
                            @if(!$loop->last)
                                <span style="color: var(--dark-border); margin-left: 12px; font-weight: 300;">|</span>
                            @endif
                        </div>
                        @endforeach
                    </div>
                    <a href="{{ route('home') }}#paket" class="btn-hero-ghost" style="display: inline-flex; align-items: center; gap: 8px; font-size: 13px; padding: 10px 24px;">
                        <i class="ti ti-eye"></i> Lihat Detail Paket & Pemesanan
                    </a>
                </div>
            </div>
        </div>

        {{-- Sidebar --}}
        <div class="detail-sidebar">
            <div class="section-card sidebar-cta">
                <div style="padding:24px;">
                    <div class="sidebar-durasi" style="font-size:14px; font-weight:600; color:var(--text-main); margin-bottom:8px;">{{ $item->name }}</div>
                    <div class="sidebar-durasi" style="margin-top:12px;">
                        Pengerjaan: {{ $item->duration ?? 'Waktu fleksibel' }}
                    </div>
                    @if(session('username') && strtolower(session('role')) !== 'admin')
                        <a href="{{ route('order') }}" class="btn-hero"
                            style="width:100%;text-align:center;display:block;margin-top:20px;">
                            Buat Pesanan Sekarang
                        </a>
                    @elseif(strtolower(session('role') ?? '') === 'admin')
                        <span class="btn-hero"
                            style="width:100%;text-align:center;display:block;margin-top:20px; background:#333; cursor:not-allowed; opacity:0.6;">
                            Admin Mode
                        </span>
                    @else
                        <a href="{{ route('login') }}" class="btn-hero"
                            style="width:100%;text-align:center;display:block;margin-top:20px;">
                            Masuk untuk Memesan
                        </a>
                    @endif
                    <a href="{{ route('portofolio') }}" class="btn-outline-nav"
                        style="width:100%;text-align:center;display:flex;align-items:center;justify-content:center;gap:6px;margin-top:10px;">
                        <i class="ti ti-photo"></i> Lihat Portofolio
                    </a>
                    <a href="{{ route('layanan') }}" class="btn-outline-nav"
                        style="width:100%;text-align:center;display:block;margin-top:10px;">
                        Lihat Layanan Lain
                    </a>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
