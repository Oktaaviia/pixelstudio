@extends('layouts.app')

@section('title', 'Profil Saya — PixelStudio')

@section('content')
<div class="container mt-5" style="color: var(--text-main); padding-bottom: 50px; max-width: 1200px; margin: 0 auto; padding-left: 20px; padding-right: 20px;">

    {{-- CARD DETAIL PROFIL --}}
    <div class="profile-card" style="background: var(--dark-surface); border: 1px solid var(--dark-border); padding: 30px; border-radius: 15px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 20px;">
        <div style="display: flex; align-items: center; gap: 20px;">
            <div class="avatar" style="width: 70px; height: 70px; background: var(--gold); color: #000; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 28px; font-weight: bold; flex-shrink: 0;">
                {{ strtoupper(substr(session('username'), 0, 1)) }}
            </div>
            
            <div style="display: flex; flex-direction: column; gap: 4px;">
                <div style="display: flex; align-items: center; gap: 12px; flex-wrap: wrap;">
                    <h2 style="margin: 0; font-size: 24px; font-weight: 600; line-height: 1.2;">
                        Halo, <span style="color: var(--gold);">{{ session('username') }}!</span>
                    </h2>
                    <span class="badge" style="background: #28a745; color: #fff; padding: 4px 10px; border-radius: 6px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; display: inline-block;">
                        {{ session('role') }}
                    </span>
                </div>
                <p style="margin: 0; color: var(--text-muted); font-size: 14px;">{{ session('email') }}</p>
            </div>
        </div>

        <div>
            @if(strtolower(session('role')) !== 'admin')
                <a href="{{ route('order') }}" class="btn-primary" style="background: var(--gold); color: #000; padding: 12px 24px; border-radius: 10px; text-decoration: none; font-weight: 600; display: inline-block;">
                    + Buat Order Baru
                </a>
            @endif
        </div>
    </div>

    {{-- RIWAYAT PESANAN --}}
    @if(strtolower(session('role')) !== 'admin')
        <div class="orders-section" style="background: var(--dark-surface); border: 1px solid var(--dark-border); padding: 30px; border-radius: 15px; margin-top: 30px;">
            <h3 style="margin-top: 0; display: flex; align-items: center; gap: 10px; font-size: 18px; font-weight: 600;">
                <i class="ti ti-clipboard-list" style="color: var(--gold);"></i> Riwayat Pemesanan Desain Anda
            </h3>
            <p style="color: var(--text-muted); font-size: 13px; margin-bottom: 20px;">Daftar project dan status pengerjaan desain kamu.</p>
            
            @if(isset($my_orders) && $my_orders->count() > 0)
                <div style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse; text-align: left; color: var(--text-main);">
                        <thead>
                            <tr style="border-bottom: 2px solid var(--dark-border); color: var(--text-muted); font-size: 13px; text-transform: uppercase;">
                                <th style="padding: 12px 8px;">Layanan</th>
                                <th style="padding: 12px 8px;">Paket</th>
                                <th style="padding: 12px 8px;">Nama Brand</th>
                                <th style="padding: 12px 8px; text-align: center;">Status</th>
                                <th style="padding: 12px 8px; text-align: right;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($my_orders as $order)
                                <tr style="border-bottom: 1px solid var(--dark-border); font-size: 14px;">
                                    <td style="padding: 16px 8px; font-weight: 600;">{{ $order->layanan }}</td>
                                    <td style="padding: 16px 8px;">{{ $order->paket }}</td>
                                    <td style="padding: 16px 8px; color: var(--text-muted);">{{ $order->nama_brand ?? '-' }}</td>
                                    <td style="padding: 16px 8px; text-align: center;">
                                        @if(strtolower($order->status) === 'selesai')
                                            <span style="background: rgba(40, 167, 69, 0.2); color: #28a745; padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; border: 1px solid #28a745;">✓ Selesai</span>
                                        @elseif(strtolower($order->status) === 'menunggu negosiasi')
                                            <span style="background: rgba(255, 193, 7, 0.2); color: #ffc107; padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; border: 1px solid #ffc107;">💬 Negosiasi WA</span>
                                        @else
                                            <span style="background: rgba(184,149,90, 0.2); color: var(--gold); padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; border: 1px solid var(--gold);">⏳ {{ $order->status }}</span>
                                        @endif
                                    </td>
                                    <td style="padding: 16px 8px; text-align: right;">
                                        <button onclick="bukaDetail({{ json_encode($order) }})" style="background: #262626; color: #fff; border: 1px solid var(--dark-border); padding: 6px 12px; border-radius: 6px; cursor: pointer; font-size: 13px; font-weight: 500; display: inline-flex; align-items: center; gap: 6px;">
                                            <i class="ti ti-eye" style="color: var(--gold);"></i> Detail
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div style="text-align: center; padding: 50px 20px; color: var(--text-muted);">
                    <i class="ti ti-package-off" style="font-size: 45px; display: block; margin-bottom: 15px;"></i>
                    <span>Belum ada riwayat pesanan desain.</span>
                </div>
            @endif
        </div>
    @endif
</div>

{{-- MODAL POP-UP DETAIL UNTUK CUSTOMER --}}
<div id="modalDetail" style="display: none; position: fixed; z-index: 9999; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.7); backdrop-filter: blur(4px); align-items: center; justify-content: center; padding: 20px;">
    <div style="background: var(--dark-surface); border: 1px solid var(--dark-border); width: 100%; max-width: 600px; border-radius: 15px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.5); animation: fadeIn 0.2s ease-out;">
        
        <div style="padding: 20px 25px; border-bottom: 1px solid var(--dark-border); display: flex; justify-content: space-between; align-items: center; background: rgba(184,149,90, 0.05);">
            <h4 style="margin: 0; font-size: 18px; font-weight: 600; color: var(--gold); display: flex; align-items: center; gap: 8px;">
                <i class="ti ti-file-info"></i> Detail Spesifikasi Project Anda
            </h4>
            <span onclick="tutupDetail()" style="color: var(--text-muted); font-size: 24px; cursor: pointer; font-weight: bold;">&times;</span>
        </div>

        <div style="padding: 25px; max-height: 70vh; overflow-y: auto; color: var(--text-main); font-size: 14px; display: flex; flex-direction: column; gap: 16px;">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                <div>
                    <label style="color: var(--text-muted); font-size: 12px; display: block; margin-bottom: 4px;">Jenis Layanan</label>
                    <strong id="detLayanan" style="font-size: 15px;">-</strong>
                </div>
                <div>
                    <label style="color: var(--text-muted); font-size: 12px; display: block; margin-bottom: 4px;">Paket Terpilih</label>
                    <strong id="detPaket" style="font-size: 15px; color: var(--gold);">-</strong>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                <div>
                    <label style="color: var(--text-muted); font-size: 12px; display: block; margin-bottom: 4px;">Nama Brand</label>
                    <span id="detBrand" style="font-weight: 500;">-</span>
                </div>
                <div>
                    <label style="color: var(--text-muted); font-size: 12px; display: block; margin-bottom: 4px;">Ukuran & Target Deadline</label>
                    <span id="detUkuran" style="font-weight: 500;">-</span> (<span id="detDeadline" style="color: #dc3545; font-weight: 500;">-</span>)
                </div>
            </div>

            <hr style="border: 0; border-top: 1px solid var(--dark-border); margin: 5px 0;">

            <div>
                <label style="color: var(--text-muted); font-size: 12px; display: block; margin-bottom: 4px;">Brief Konten Deskripsi</label>
                <div id="detDeskripsi" style="background: rgba(255,255,255,0.03); border: 1px solid var(--dark-border); padding: 12px; border-radius: 8px; line-height: 1.5; white-space: pre-line;">-</div>
            </div>

            <div>
                <label style="color: var(--text-muted); font-size: 12px; display: block; margin-bottom: 4px;">Catatan Tambahan</label>
                <div id="detCatatan" style="background: rgba(255,255,255,0.03); border: 1px solid var(--dark-border); padding: 12px; border-radius: 8px; line-height: 1.5; font-style: italic; color: var(--text-muted); white-space: pre-line;">-</div>
            </div>

            {{-- DETAIL FOTO TRANSFER CLIENT --}}
            <div>
                <label style="color: var(--text-muted); font-size: 12px; display: block; margin-bottom: 4px;">Lampiran Bukti Transfer Pembayaran</label>
                <div id="boxBuktiTransferUser"></div>
            </div>
        </div>

        <div style="padding: 15px 25px; border-top: 1px solid var(--dark-border); text-align: right; background: rgba(0,0,0,0.1);">
            <button onclick="tutupDetail()" style="background: var(--gold); color: #000; border: none; padding: 10px 20px; border-radius: 8px; font-weight: 600; cursor: pointer;">
                Tutup Halaman
            </button>
        </div>
    </div>
</div>

<script>
function bukaDetail(order) {
    document.getElementById('detLayanan').innerText = order.layanan;
    document.getElementById('detPaket').innerText = order.paket;
    document.getElementById('detBrand').innerText = order.nama_brand || '-';
    document.getElementById('detUkuran').innerText = order.ukuran || '-';
    
    if(order.deadline) {
        const date = new Date(order.deadline);
        document.getElementById('detDeadline').innerText = date.toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
    } else {
        document.getElementById('detDeadline').innerText = 'Tidak ditentukan';
    }

    document.getElementById('detDeskripsi').innerText = order.deskripsi || '-';
    document.getElementById('detCatatan').innerText = order.catatan || '-';

    // Handler Gambar Bukti Transfer User
    const boxBukti = document.getElementById('boxBuktiTransferUser');
    const paket = (order.paket || '').toLowerCase();
    const status = (order.status || '').toLowerCase();
    const isCustom = paket === 'custom';

    if (isCustom) {
        // Untuk paket Custom: cek status, bukan bukti_bayar
        const sudahDiproses = status === 'diproses' || status === 'selesai';
        if (sudahDiproses) {
            boxBukti.innerHTML = `<span style="color:#28a745; font-weight:600; font-size:13px; display:flex; align-items:center; gap:6px;">✅ Pembayaran berhasil.</span>`;
        } else {
            const waUrl = 'https://wa.me/628123456789?text=' + encodeURIComponent('Halo Admin PixelStudio, saya ingin melakukan pembayaran untuk pesanan custom brand *' + (order.nama_brand || '') + '*. Mohon informasi lebih lanjut. Terima kasih!');
            boxBukti.innerHTML = `<span style="color:#ffc107; font-size:13px; display:flex; flex-direction:column; gap:8px;">
                <span>⚠️ Belum melakukan pembayaran. Silakan hubungi admin via WhatsApp untuk menyelesaikan pembayaran.</span>
                <a href="${waUrl}" target="_blank" style="display:inline-flex; align-items:center; gap:6px; background:#25d366; color:white; text-decoration:none; padding:8px 14px; border-radius:6px; font-weight:600; font-size:12px; width:fit-content;">
                    💬 Hubungi Admin via WA
                </a>
            </span>`;
        }
    } else if (order.bukti_bayar) {
        // Non-Custom dengan bukti bayar
        boxBukti.innerHTML = `<a href="/uploads/bukti/${order.bukti_bayar}" target="_blank">
            <img src="/uploads/bukti/${order.bukti_bayar}" style="max-width:100%; max-height:200px; border-radius:8px; border:1px solid var(--dark-border); margin-top:5px; cursor:zoom-in;">
        </a>`;
    } else {
        // Non-Custom tanpa bukti bayar (seharusnya tidak terjadi, fallback)
        boxBukti.innerHTML = `<span style="color:#888; font-style:italic; font-size:13px;">Tidak ada lampiran tersedia.</span>`;
    }

    document.getElementById('modalDetail').style.display = 'flex';
}

function tutupDetail() {
    document.getElementById('modalDetail').style.display = 'none';
}

window.onclick = function(e) {
    const modal = document.getElementById('modalDetail');
    if (e.target == modal) modal.style.display = 'none';
}
</script>

<style>
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>
@endsection
