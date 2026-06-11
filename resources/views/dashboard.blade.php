@extends('layouts.app')

@section('title', 'Dashboard Admin — PixelStudio')

@section('content')
<div class="dashboard-page">

    <div class="dashboard-header">
        <div>
            {{-- Gunakan session karena dashboard customer diredirect ke admin --}}
            <h1>Halo, <span class="gold">{{ session('username', 'Admin') }}</span> 👋</h1>
            <p class="text-muted">Selamat datang kembali di PixelStudio</p>
        </div>
        @if(strtolower(session('role')) === 'admin')
            <a href="{{ route('admin') }}" class="btn-primary-nav">
                <i class="ti ti-layout-dashboard"></i> Panel Admin
            </a>
        @else
            <a href="{{ route('order') }}" class="btn-primary-nav">
                <i class="ti ti-plus"></i> Pesanan Baru
            </a>
        @endif
    </div>

    {{-- Stats --}}
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon purple"><i class="ti ti-shopping-bag"></i></div>
            <div>
                <div class="stat-num">{{ isset($orders) ? $orders->count() : 0 }}</div>
                <div class="stat-label">Total Pesanan</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon gold"><i class="ti ti-loader"></i></div>
            <div>
                <div class="stat-num">{{ isset($orders) ? $orders->where('status', 'Diproses')->count() : 0 }}</div>
                <div class="stat-label">Sedang Diproses</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green"><i class="ti ti-circle-check"></i></div>
            <div>
                <div class="stat-num">{{ isset($orders) ? $orders->where('status', 'Selesai')->count() : 0 }}</div>
                <div class="stat-label">Selesai</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon muted"><i class="ti ti-clock"></i></div>
            <div>
                <div class="stat-num">{{ isset($orders) ? $orders->where('status', 'Menunggu Validasi')->count() : 0 }}</div>
                <div class="stat-label">Menunggu Validasi</div>
            </div>
        </div>
    </div>

    {{-- Tabel Pesanan --}}
    <div class="section-card">
        <div class="section-card-header">
            <h3><i class="ti ti-list"></i> Riwayat Pesanan</h3>
        </div>
        <table class="data-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Layanan</th>
                    <th>Paket</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @if(isset($orders) && $orders->count() > 0)
                @forelse ($orders as $order)
                <tr>
                    <td class="gold">#{{ str_pad($order->id, 3, '0', STR_PAD_LEFT) }}</td>
                    <td>{{ $order->layanan }}</td>
                    <td>{{ $order->paket }}</td>
                    <td style="color:var(--text-muted); font-size:12px;">
                        {{ \Carbon\Carbon::parse($order->created_at)->format('d M Y') }}
                    </td>
                    <td>
                        <span class="badge badge-{{ strtolower(str_replace(' ', '-', $order->status)) }}">
                            {{ $order->status }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align:center; color:var(--text-muted); padding:32px;">
                        Belum ada pesanan — <a href="{{ route('order') }}" style="color:var(--gold);">Buat sekarang</a>
                    </td>
                </tr>
                @endforelse
                @else
                <tr>
                    <td colspan="5" style="text-align:center; color:var(--text-muted); padding:32px;">
                        Belum ada pesanan
                    </td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>

</div>
@endsection
