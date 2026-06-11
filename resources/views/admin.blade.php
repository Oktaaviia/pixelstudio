@extends('layouts.app')

@section('title', 'Dashboard Admin — PixelStudio')

@section('content')
<div class="container mt-5" style="color: var(--text-main); padding-bottom: 50px; max-width: 1200px; margin: 0 auto; padding-left: 20px; padding-right: 20px;">

    {{-- CARD WELCOME ADMIN --}}
    <div class="profile-card" style="background: var(--dark-surface); border: 1px solid var(--dark-border); padding: 30px; border-radius: 15px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 20px; margin-bottom: 30px;">
        <div style="display: flex; align-items: center; gap: 20px;">
            <div class="avatar" style="width: 70px; height: 70px; background: #dc3545; color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 28px; font-weight: bold; flex-shrink: 0;">
                A
            </div>
            <div style="display: flex; flex-direction: column; gap: 4px;">
                <div style="display: flex; align-items: center; gap: 12px; flex-wrap: wrap;">
                    <h2 style="margin: 0; font-size: 24px; font-weight: 600; line-height: 1.2;">
                        Workspace <span style="color: var(--gold);">Administrator</span>
                    </h2>
                    <span class="badge" style="background: #dc3545; color: #fff; padding: 4px 10px; border-radius: 6px; font-size: 11px; font-weight: 700; text-transform: uppercase;">
                        {{ session('role') }}
                    </span>
                </div>
                <p style="margin: 0; color: var(--text-muted); font-size: 14px;">Kelola pesanan masuk dan validasi brief desain customer.</p>
            </div>
        </div>
        <div>
            <a href="{{ route('pengelolaan') }}" class="btn-primary" style="background: var(--gold); color: #000; padding: 12px 24px; border-radius: 10px; text-decoration: none; font-weight: 600; display: inline-block; transition: 0.2s;" onmouseover="this.style.opacity='0.9'" onmouseout="this.style.opacity='1'">
                ⚙️ Pengelolaan Konten
            </a>
        </div>
    </div>

    {{-- STATISTIK RINGKAS --}}
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 15px; margin-bottom: 25px;">
        <div style="background: var(--dark-surface); border: 1px solid var(--dark-border); border-radius: 12px; padding: 18px; text-align: center;">
            <div style="font-size: 28px; font-weight: 700; color: #fff;">{{ $total_pesanan }}</div>
            <div style="font-size: 12px; color: var(--text-muted); margin-top: 4px;">Total Pesanan</div>
        </div>
        <a href="{{ route('admin', ['filter_status' => 'perlu_acc']) }}" style="text-decoration: none;">
            <div style="background: var(--dark-surface); border: 1px solid {{ ($filterStatus ?? 'semua') === 'perlu_acc' ? '#17a2b8' : 'var(--dark-border)' }}; border-radius: 12px; padding: 18px; text-align: center; transition: 0.2s; cursor: pointer;" onmouseover="this.style.borderColor='#17a2b8'" onmouseout="this.style.borderColor='{{ ($filterStatus ?? 'semua') === 'perlu_acc' ? '#17a2b8' : 'var(--dark-border)' }}'">
                <div style="font-size: 28px; font-weight: 700; color: #17a2b8;">{{ $menunggu }}</div>
                <div style="font-size: 12px; color: var(--text-muted); margin-top: 4px;">⏳ Perlu ACC</div>
            </div>
        </a>
        <a href="{{ route('admin', ['filter_status' => 'diproses']) }}" style="text-decoration: none;">
            <div style="background: var(--dark-surface); border: 1px solid {{ ($filterStatus ?? 'semua') === 'diproses' ? 'var(--gold)' : 'var(--dark-border)' }}; border-radius: 12px; padding: 18px; text-align: center; transition: 0.2s; cursor: pointer;" onmouseover="this.style.borderColor='var(--gold)'" onmouseout="this.style.borderColor='{{ ($filterStatus ?? 'semua') === 'diproses' ? 'var(--gold)' : 'var(--dark-border)' }}'">
                <div style="font-size: 28px; font-weight: 700; color: var(--gold);">{{ $proses }}</div>
                <div style="font-size: 12px; color: var(--text-muted); margin-top: 4px;">⚙️ Diproses</div>
            </div>
        </a>
        <a href="{{ route('admin', ['filter_status' => 'selesai']) }}" style="text-decoration: none;">
            <div style="background: var(--dark-surface); border: 1px solid {{ ($filterStatus ?? 'semua') === 'selesai' ? '#28a745' : 'var(--dark-border)' }}; border-radius: 12px; padding: 18px; text-align: center; transition: 0.2s; cursor: pointer;" onmouseover="this.style.borderColor='#28a745'" onmouseout="this.style.borderColor='{{ ($filterStatus ?? 'semua') === 'selesai' ? '#28a745' : 'var(--dark-border)' }}'">
                <div style="font-size: 28px; font-weight: 700; color: #28a745;">{{ $selesai }}</div>
                <div style="font-size: 12px; color: var(--text-muted); margin-top: 4px;">✓ Selesai</div>
            </div>
        </a>
        <a href="{{ route('admin', ['filter_status' => 'ditolak']) }}" style="text-decoration: none;">
            <div style="background: var(--dark-surface); border: 1px solid {{ ($filterStatus ?? 'semua') === 'ditolak' ? '#dc3545' : 'var(--dark-border)' }}; border-radius: 12px; padding: 18px; text-align: center; transition: 0.2s; cursor: pointer;" onmouseover="this.style.borderColor='#dc3545'" onmouseout="this.style.borderColor='{{ ($filterStatus ?? 'semua') === 'ditolak' ? '#dc3545' : 'var(--dark-border)' }}'">
                <div style="font-size: 28px; font-weight: 700; color: #dc3545;">{{ $ditolak }}</div>
                <div style="font-size: 12px; color: var(--text-muted); margin-top: 4px;">✗ Ditolak</div>
            </div>
        </a>
    </div>

    {{-- TABEL DATA PESANAN MASUK --}}
    <div class="orders-section" style="background: var(--dark-surface); border: 1px solid var(--dark-border); padding: 30px; border-radius: 15px;">
        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px; margin-bottom: 20px;">
            <h3 style="margin: 0; display: flex; align-items: center; gap: 10px; font-size: 18px; font-weight: 600;">
                <i class="ti ti-server" style="color: var(--gold);"></i> Daftar Seluruh Antrean Project
                @if(($filterStatus ?? 'semua') !== 'semua')
                    <span style="background: rgba(184,149,90,0.15); color: var(--gold); padding: 3px 10px; border-radius: 20px; font-size: 12px;">
                        Filter Aktif
                    </span>
                @endif
            </h3>
            {{-- Filter Pills --}}
            <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                <a href="{{ route('admin') }}" style="padding: 6px 14px; border-radius: 20px; font-size: 12px; font-weight: 600; text-decoration: none; border: 1px solid var(--dark-border); color: {{ ($filterStatus ?? 'semua') === 'semua' ? '#000' : 'var(--text-muted)' }}; background: {{ ($filterStatus ?? 'semua') === 'semua' ? 'var(--gold)' : 'transparent' }}; transition: 0.2s;">
                    Semua
                </a>
                <a href="{{ route('admin', ['filter_status' => 'perlu_acc']) }}" style="padding: 6px 14px; border-radius: 20px; font-size: 12px; font-weight: 600; text-decoration: none; border: 1px solid {{ ($filterStatus ?? 'semua') === 'perlu_acc' ? '#17a2b8' : 'var(--dark-border)' }}; color: {{ ($filterStatus ?? 'semua') === 'perlu_acc' ? '#17a2b8' : 'var(--text-muted)' }}; background: {{ ($filterStatus ?? 'semua') === 'perlu_acc' ? 'rgba(23,162,184,0.1)' : 'transparent' }};">
                    ⏳ Perlu ACC
                </a>
                <a href="{{ route('admin', ['filter_status' => 'diproses']) }}" style="padding: 6px 14px; border-radius: 20px; font-size: 12px; font-weight: 600; text-decoration: none; border: 1px solid {{ ($filterStatus ?? 'semua') === 'diproses' ? 'var(--gold)' : 'var(--dark-border)' }}; color: {{ ($filterStatus ?? 'semua') === 'diproses' ? 'var(--gold)' : 'var(--text-muted)' }}; background: {{ ($filterStatus ?? 'semua') === 'diproses' ? 'rgba(184,149,90,0.1)' : 'transparent' }};">
                    ⚙️ Diproses
                </a>
                <a href="{{ route('admin', ['filter_status' => 'selesai']) }}" style="padding: 6px 14px; border-radius: 20px; font-size: 12px; font-weight: 600; text-decoration: none; border: 1px solid {{ ($filterStatus ?? 'semua') === 'selesai' ? '#28a745' : 'var(--dark-border)' }}; color: {{ ($filterStatus ?? 'semua') === 'selesai' ? '#28a745' : 'var(--text-muted)' }}; background: {{ ($filterStatus ?? 'semua') === 'selesai' ? 'rgba(40,167,69,0.1)' : 'transparent' }};">
                    ✓ Selesai
                </a>
                <a href="{{ route('admin', ['filter_status' => 'ditolak']) }}" style="padding: 6px 14px; border-radius: 20px; font-size: 12px; font-weight: 600; text-decoration: none; border: 1px solid {{ ($filterStatus ?? 'semua') === 'ditolak' ? '#dc3545' : 'var(--dark-border)' }}; color: {{ ($filterStatus ?? 'semua') === 'ditolak' ? '#dc3545' : 'var(--text-muted)' }}; background: {{ ($filterStatus ?? 'semua') === 'ditolak' ? 'rgba(220,53,69,0.1)' : 'transparent' }};">
                    ✗ Ditolak
                </a>
            </div>
        </div>

        @if(isset($pesanan) && $pesanan->count() > 0)
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; text-align: left; color: var(--text-main);">
                    <thead>
                        <tr style="border-bottom: 2px solid var(--dark-border); color: var(--text-muted); font-size: 13px; text-transform: uppercase;">
                            <th style="padding: 12px 8px;">Pelanggan</th>
                            <th style="padding: 12px 8px;">Layanan & Paket</th>
                            <th style="padding: 12px 8px;">Nama Brand</th>
                            <th style="padding: 12px 8px; text-align: center;">Status</th>
                            <th style="padding: 12px 8px; text-align: right;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pesanan as $order)
                            <tr style="border-bottom: 1px solid var(--dark-border); font-size: 14px;">
                                <td style="padding: 16px 8px;">
                                    <strong style="display:block; color:#fff;">{{ $order->customer ?? 'User' }}</strong>
                                    <small style="color: var(--text-muted);">ID: #{{ $order->id }}</small>
                                </td>
                                <td style="padding: 16px 8px;">
                                    <span style="font-weight: 600;">{{ $order->layanan }}</span>
                                    <span style="display:block; font-size:12px; color:var(--gold);">{{ $order->paket }}</span>
                                </td>
                                <td style="padding: 16px 8px; color: var(--text-muted);">{{ $order->nama_brand ?? '-' }}</td>
                                <td style="padding: 16px 8px; text-align: center;">
                                    @if(strtolower($order->status) === 'selesai')
                                        <span style="background: rgba(40, 167, 69, 0.15); color: #28a745; padding: 4px 10px; border-radius: 6px; font-size: 12px; font-weight: 600; border: 1px solid #28a745;">✓ Selesai</span>
                                    @elseif(strtolower($order->status) === 'menunggu validasi')
                                        <span style="background: rgba(23, 162, 184, 0.15); color: #17a2b8; padding: 4px 10px; border-radius: 6px; font-size: 12px; font-weight: 600; border: 1px solid #17a2b8;">⏳ Perlu ACC</span>
                                    @elseif(strtolower($order->status) === 'menunggu negosiasi')
                                        <span style="background: rgba(255, 193, 7, 0.15); color: #ffc107; padding: 4px 10px; border-radius: 6px; font-size: 12px; font-weight: 600; border: 1px solid #ffc107;">💬 Chat WA Custom</span>
                                    @elseif(strtolower($order->status) === 'ditolak')
                                        <span style="background: rgba(220, 53, 69, 0.15); color: #dc3545; padding: 4px 10px; border-radius: 6px; font-size: 12px; font-weight: 600; border: 1px solid #dc3545;">✗ Ditolak</span>
                                    @else
                                        <span style="background: rgba(184,149,90, 0.15); color: var(--gold); padding: 4px 10px; border-radius: 6px; font-size: 12px; font-weight: 600; border: 1px solid var(--gold);">⚙️ {{ $order->status }}</span>
                                    @endif
                                </td>
                                <td style="padding: 16px 8px; text-align: right;">
                                    <div style="display: flex; gap: 8px; justify-content: flex-end; align-items: center; flex-wrap: wrap;">
                                        {{-- Tombol Detail memanggil modal --}}
                                        <button onclick="bukaDetailAdmin({{ json_encode($order) }})" style="background: #262626; color: #fff; border: 1px solid var(--dark-border); padding: 6px 12px; border-radius: 6px; cursor: pointer; font-size: 13px; font-weight: 500; display: inline-flex; align-items: center; gap: 6px;">
                                            <i class="ti ti-eye" style="color: var(--gold);"></i> Detail
                                        </button>

                                        {{-- Tombol Update Status --}}
                                        @if(strtolower($order->status) !== 'selesai' && strtolower($order->status) !== 'ditolak')
                                            <form action="{{ route('admin.updateStatus', $order->id) }}" method="POST" style="margin:0;">
                                                @csrf
                                                <select name="status" onchange="this.form.submit()" style="background: #1a1a1a; color: #fff; border: 1px solid var(--dark-border); padding: 5px 10px; border-radius: 6px; font-size: 13px; cursor: pointer;">
                                                    <option value="" selected disabled>Ubah Status</option>
                                                    <option value="Diproses">✅ Setujui (Diproses)</option>
                                                    <option value="Selesai">🏁 Selesaikan Project</option>
                                                    <option value="Ditolak">❌ Tolak Pesanan</option>
                                                </select>
                                            </form>
                                        @elseif(strtolower($order->status) === 'ditolak')
                                            {{-- Bisa dikembalikan ke diproses --}}
                                            <form action="{{ route('admin.updateStatus', $order->id) }}" method="POST" style="margin:0;">
                                                @csrf
                                                <select name="status" onchange="this.form.submit()" style="background: #1a1a1a; color: #dc3545; border: 1px solid #dc3545; padding: 5px 10px; border-radius: 6px; font-size: 13px; cursor: pointer;">
                                                    <option value="" selected disabled>Ubah Status</option>
                                                    <option value="Diproses">↩️ Aktifkan Kembali</option>
                                                </select>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div style="text-align: center; padding: 50px 20px; color: var(--text-muted);">
                <i class="ti ti-package-off" style="font-size: 45px; display: block; margin-bottom: 15px;"></i>
                <span>
                    @if(($filterStatus ?? 'semua') !== 'semua')
                        Tidak ada pesanan dengan filter ini.
                        <a href="{{ route('admin') }}" style="color: var(--gold); text-decoration: none;">Lihat semua</a>
                    @else
                        Belum ada antrean project desain dari customer masuk.
                    @endif
                </span>
            </div>
        @endif
    </div>
</div>

{{-- MODAL POP-UP DETAIL UNTUK ADMIN --}}
<div id="modalDetailAdmin" style="display: none; position: fixed; z-index: 9999; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.7); backdrop-filter: blur(4px); align-items: center; justify-content: center; padding: 20px;">
    <div style="background: var(--dark-surface); border: 1px solid var(--dark-border); width: 100%; max-width: 650px; border-radius: 15px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.5); animation: fadeInAdmin 0.2s ease-out; text-align: left;">
        
        <div style="padding: 20px 25px; border-bottom: 1px solid var(--dark-border); display: flex; justify-content: space-between; align-items: center; background: rgba(184,149,90, 0.05);">
            <h4 style="margin: 0; font-size: 18px; font-weight: 600; color: var(--gold); display: flex; align-items: center; gap: 8px;">
                <i class="ti ti-user-code"></i> Brief & Informasi Kontrak Client
            </h4>
            <span onclick="tutupDetailAdmin()" style="color: var(--text-muted); font-size: 24px; cursor: pointer; font-weight: bold;">&times;</span>
        </div>

        <div style="padding: 25px; max-height: 70vh; overflow-y: auto; color: var(--text-main); font-size: 14px; display: flex; flex-direction: column; gap: 16px;">
            
            <div style="background: rgba(255,255,255,0.02); border: 1px solid var(--dark-border); padding: 15px; border-radius: 10px; display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                <div>
                    <label style="color: var(--gold); font-size: 11px; text-transform: uppercase; display: block; font-weight: 600;">Nama Pemesan</label>
                    <strong id="admCustomer" style="font-size: 14px; color: #fff;">-</strong>
                </div>
                <div>
                    <label style="color: var(--gold); font-size: 11px; text-transform: uppercase; display: block; font-weight: 600;">WhatsApp Client</label>
                    <span id="admWhatsapp" style="font-weight: 500; color: #25D366; font-size: 14px;">-</span>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                <div>
                    <label style="color: var(--text-muted); font-size: 12px; display: block; margin-bottom: 4px;">Jenis Layanan</label>
                    <strong id="admLayanan" style="font-size: 15px;">-</strong>
                </div>
                <div>
                    <label style="color: var(--text-muted); font-size: 12px; display: block; margin-bottom: 4px;">Paket Terpilih</label>
                    <strong id="admPaket" style="font-size: 15px; color: var(--gold);">-</strong>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                <div>
                    <label style="color: var(--text-muted); font-size: 12px; display: block; margin-bottom: 4px;">Nama Brand/Project</label>
                    <span id="admBrand" style="font-weight: 500;">-</span>
                </div>
                <div>
                    <label style="color: var(--text-muted); font-size: 12px; display: block; margin-bottom: 4px;">Ukuran & Target Deadline</label>
                    <span id="admUkuran" style="font-weight: 500;">-</span> (<span id="admDeadline" style="color: #dc3545; font-weight: 500;">-</span>)
                </div>
            </div>

            <hr style="border: 0; border-top: 1px solid var(--dark-border); margin: 5px 0;">

            <div>
                <label style="color: var(--text-muted); font-size: 12px; display: block; margin-bottom: 4px;">Brief Konten Deskripsi</label>
                <div id="admDeskripsi" style="background: rgba(255,255,255,0.03); border: 1px solid var(--dark-border); padding: 12px; border-radius: 8px; line-height: 1.5; white-space: pre-line;">-</div>
            </div>

            <div>
                <label style="color: var(--text-muted); font-size: 12px; display: block; margin-bottom: 4px;">Catatan Tambahan</label>
                <div id="admCatatan" style="background: rgba(255,255,255,0.03); border: 1px solid var(--dark-border); padding: 12px; border-radius: 8px; line-height: 1.5; font-style: italic; color: var(--text-muted); white-space: pre-line;">-</div>
            </div>

            {{-- FOTO BUKTI BAYAR --}}
            <div>
                <label style="color: var(--text-muted); font-size: 12px; display: block; margin-bottom: 4px;">Lampiran Bukti Transfer Pembayaran</label>
                <div id="boxBuktiTransferAdmin"></div>
            </div>
        </div>

        <div style="padding: 15px 25px; border-top: 1px solid var(--dark-border); text-align: right; background: rgba(0,0,0,0.1);">
            <button onclick="tutupDetailAdmin()" style="background: var(--gold); color: #000; border: none; padding: 10px 20px; border-radius: 8px; font-weight: 600; cursor: pointer;">
                Selesai Membaca
            </button>
        </div>
    </div>
</div>

<script>
function bukaDetailAdmin(order) {
    document.getElementById('admCustomer').innerText = order.customer || 'Client';
    document.getElementById('admWhatsapp').innerText = order.whatsapp || '-';
    document.getElementById('admLayanan').innerText = order.layanan;
    document.getElementById('admPaket').innerText = order.paket;
    document.getElementById('admBrand').innerText = order.nama_brand || '-';
    document.getElementById('admUkuran').innerText = order.ukuran || '-';
    
    if(order.deadline) {
        const date = new Date(order.deadline);
        document.getElementById('admDeadline').innerText = date.toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
    } else {
        document.getElementById('admDeadline').innerText = 'Tidak ditentukan';
    }

    document.getElementById('admDeskripsi').innerText = order.deskripsi || '-';
    document.getElementById('admCatatan').innerText = order.catatan || '-';

    // Handler Gambar Bukti Transfer
    const boxBukti = document.getElementById('boxBuktiTransferAdmin');
    if(order.bukti_bayar) {
        boxBukti.innerHTML = `<a href="/uploads/bukti/${order.bukti_bayar}" target="_blank">
            <img src="/uploads/bukti/${order.bukti_bayar}" style="max-width:100%; max-height:220px; border-radius:8px; border:1px solid var(--dark-border); margin-top:5px; cursor:zoom-in;" title="Klik untuk memperbesar">
        </a>`;
    } else {
        boxBukti.innerHTML = `<span style="color:#ffc107; font-style:italic; font-size:13px;">Belum / Tidak mengupload lampiran (Kemungkinan skema paket kustom/negosiasi WA).</span>`;
    }

    document.getElementById('modalDetailAdmin').style.display = 'flex';
}

function tutupDetailAdmin() {
    document.getElementById('modalDetailAdmin').style.display = 'none';
}

window.addEventListener('click', function(e) {
    const modal = document.getElementById('modalDetailAdmin');
    if (e.target == modal) modal.style.display = 'none';
});
</script>

<style>
@keyframes fadeInAdmin {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>
@endsection
