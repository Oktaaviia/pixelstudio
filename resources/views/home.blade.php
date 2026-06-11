@extends('layouts.app')

@section('title', 'Beranda — PixelStudio')

@section('content')

{{-- HERO --}}
<section class="hero">
    {{-- Baris badge: Studio label + cuaca --}}
    <div class="hero-badge-row">
        <div class="hero-badge">
            <i class="ti ti-sparkles"></i>
            Studio Desain Grafis Profesional
        </div>
        {{-- Cuaca Surabaya (diisi oleh weather.js) --}}
        <div class="hero-weather" id="weather-badge">
            <i class="ti ti-cloud"></i>
            <span id="weather-text">Memuat cuaca...</span>
        </div>
    </div>

    <h1>Desain yang Berbicara<br>untuk <span>Brand-mu</span></h1>
    <p>Poster, banner, feed Instagram, dan lebih banyak lagi — kami wujudkan identitas visual impianmu dengan sentuhan profesional.</p>
    <div class="hero-cta">
        <a href="#paket" class="btn-hero">Lihat Paket</a>
        <a href="{{ route('portofolio') }}" class="btn-hero-ghost">
            <i class="ti ti-player-play"></i> Lihat Portofolio
        </a>
    </div>
</section>

{{-- STATS --}}
<div class="stats-bar">
    <div class="stat-item">
        <div class="stat-num">500+</div>
        <div class="stat-label">Proyek Selesai</div>
    </div>
    <div class="stat-item">
        <div class="stat-num">200+</div>
        <div class="stat-label">Klien Puas</div>
    </div>
    <div class="stat-item">
        <div class="stat-num">4.9★</div>
        <div class="stat-label">Rating Rata-rata</div>
    </div>
    <div class="stat-item">
        <div class="stat-num">3 Hari</div>
        <div class="stat-label">Rata-rata Pengerjaan</div>
    </div>
</div>

{{-- PAKET --}}
<section class="section" id="paket">
    <div class="section-header">
        <div class="section-label">Paket Layanan</div>
        <h2>Pilih Paket yang Tepat</h2>
        <p>Semua paket sudah termasuk file sumber dan hasil desain beresolusi tinggi</p>
        @if(session('username') && strtolower(session('role')) === 'admin')
            <button onclick="toggleModal('modalTambahPaket')" class="btn-primary-nav" style="margin-top: 15px;">
                <i class="ti ti-plus"></i> Tambah Paket Baru
            </button>
        @endif
    </div>

    <div class="packages-grid">
        @foreach ($paketList as $pkg)
        <div class="pkg-card {{ $pkg->featured ? 'featured' : '' }} {{ $pkg->custom ? 'custom-pkg' : '' }}">

            @if ($pkg->featured)
                <div class="featured-badge">⭐ Paling Populer</div>
            @endif
            @if ($pkg->custom)
                <div class="featured-badge" style="background: var(--purple); color: #fff;">✦ Fully Custom</div>
            @endif

            <div class="pkg-name">Paket {{ $pkg->nama }}</div>
            <div class="pkg-price">
                {{ $pkg->price }}
                <span>/ proyek</span>
            </div>
            <div class="pkg-desc">{{ $pkg->desc }}</div>

            <ul class="pkg-features">
                <li><span class="check">✦</span> {{ $pkg->konsep }} Konsep desain</li>
                <li><span class="check">✦</span> {{ $pkg->revisi }} Revisi</li>
                <li><span class="check">✦</span> Format JPG & PNG</li>
                <li>
                    @if($pkg->fitur_sumber)
                        <span class="check">✦</span>
                    @else
                        <span class="cross">✗</span>
                    @endif
                    File sumber (.psd)
                </li>
                <li>
                    @if($pkg->prioritas)
                        <span class="check">✦</span>
                    @else
                        <span class="cross">✗</span>
                    @endif
                    Prioritas pengerjaan
                </li>
            </ul>

            {{-- TOMBOL ADAPTIF --}}
            @if(session('username'))
                @if(strtolower(session('role')) === 'admin')
                    <a href="{{ route('admin') }}" class="btn-pkg" style="background: var(--bg-surface); color: var(--text-muted);">
                        Panel Admin
                    </a>
                @else
                    <a href="{{ route('order') }}" class="btn-pkg {{ $pkg->featured ? 'gold' : ($pkg->custom ? 'purple' : '') }}">
                        {{ $pkg->custom ? 'Diskusi Sekarang' : 'Pesan Sekarang' }}
                    </a>
                @endif
            @else
                <a href="{{ route('login') }}" class="btn-pkg {{ $pkg->featured ? 'gold' : ($pkg->custom ? 'purple' : '') }}">
                    {{ $pkg->custom ? 'Diskusi Sekarang' : 'Pesan Sekarang' }}
                </a>
            @endif

            @if(session('username') && strtolower(session('role')) === 'admin')
                <div style="display: flex; gap: 8px; margin-top: 15px; width: 100%;">
                    <button onclick="editPaket({{ json_encode($pkg) }})" class="btn-pkg" style="flex: 1; background: #1a1a1a; color: var(--gold); border: 1px solid var(--border); padding: 8px; font-size: 13px; font-weight: 600; cursor: pointer; border-radius: 8px; text-transform: none; letter-spacing: 0;">
                        <i class="ti ti-edit"></i> Edit
                    </button>
                    <form action="{{ route('paket.destroy', $pkg->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus paket ini?');" style="flex: 1; margin: 0;">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn-pkg" style="width: 100%; background: rgba(220,53,69,0.1); color: #dc3545; border: 1px solid #dc3545; padding: 8px; font-size: 13px; font-weight: 600; cursor: pointer; border-radius: 8px; text-transform: none; letter-spacing: 0;">
                            <i class="ti ti-trash"></i> Hapus
                        </button>
                    </form>
                </div>
            @endif

        </div>
        @endforeach
    </div>

    {{-- Tombol Lihat Detail Paket --}}
    <div style="text-align: center; margin-top: 36px;">
        <a href="{{ route('layanan') }}" class="btn-hero-ghost" style="display: inline-flex; align-items: center; gap: 8px; padding: 13px 32px; font-size: 14px;">
            <i class="ti ti-layout-grid"></i> Lihat Detail Paket & Layanan
        </a>
    </div>
</section>

{{-- TENTANG KAMI --}}
<section class="section" id="tentang" style="background: var(--bg-surface); border-top: 1px solid var(--border); border-bottom: 1px solid var(--border);">
    <div class="section-header">
        <div class="section-label">Tentang Kami</div>
        <h2>Siapa PixelStudio?</h2>
        <p>Kami adalah tim desainer grafis profesional yang berdedikasi menghadirkan visual terbaik untuk brand-mu</p>
    </div>
    <div class="about-grid">
        <div class="about-card">
            <div class="about-icon"><i class="ti ti-brush"></i></div>
            <h4>Desain Berkualitas</h4>
            <p>Setiap karya kami dibuat dengan penuh perhatian terhadap detail dan estetika visual yang kuat.</p>
        </div>
        <div class="about-card">
            <div class="about-icon"><i class="ti ti-clock"></i></div>
            <h4>Pengerjaan Cepat</h4>
            <p>Rata-rata pengerjaan 3 hari kerja tanpa mengorbankan kualitas hasil desain.</p>
        </div>
        <div class="about-card">
            <div class="about-icon"><i class="ti ti-headset"></i></div>
            <h4>Revisi Fleksibel</h4>
            <p>Kami memastikan kamu puas dengan hasil akhir melalui sistem revisi yang fleksibel.</p>
        </div>
        <div class="about-card">
            <div class="about-icon"><i class="ti ti-shield-check"></i></div>
            <h4>Terpercaya</h4>
            <p>Lebih dari 200 klien telah mempercayakan kebutuhan desain mereka kepada kami.</p>
        </div>
    </div>

    {{-- KONTAK & MEDIA SOSIAL ADMIN --}}
    <div style="margin-top: 50px; text-align: center;">
        <div class="section-label" style="margin-bottom: 10px;">Hubungi Kami</div>
        <h3 style="margin: 0 0 8px 0; font-size: 22px; font-weight: 700;">Temukan Kami di Media Sosial</h3>
        <p style="color: var(--text-muted); font-size: 14px; margin: 0 0 30px 0;">Ikuti update terbaru atau langsung hubungi admin kami</p>

        <div style="display: flex; justify-content: center; flex-wrap: wrap; gap: 16px;">
            {{-- WhatsApp --}}
            <a href="https://wa.me/6281234567890" target="_blank"
                style="display: inline-flex; align-items: center; gap: 10px; background: rgba(37, 211, 102, 0.08); border: 1px solid rgba(37, 211, 102, 0.3); color: #25D366; padding: 14px 22px; border-radius: 12px; text-decoration: none; font-weight: 600; font-size: 14px; transition: 0.2s;"
                onmouseover="this.style.background='rgba(37,211,102,0.15)'; this.style.borderColor='#25D366';"
                onmouseout="this.style.background='rgba(37,211,102,0.08)'; this.style.borderColor='rgba(37,211,102,0.3)';">
                <i class="ti ti-brand-whatsapp" style="font-size: 22px;"></i>
                <span>
                    <strong style="display: block; font-size: 13px;">WhatsApp Admin</strong>
                    <small style="font-size: 11px; opacity: 0.8;">0812-3456-7890</small>
                </span>
            </a>

            {{-- Instagram --}}
            <a href="https://instagram.com/pixelstudio.id" target="_blank"
                style="display: inline-flex; align-items: center; gap: 10px; background: rgba(225, 48, 108, 0.08); border: 1px solid rgba(225, 48, 108, 0.3); color: #e1306c; padding: 14px 22px; border-radius: 12px; text-decoration: none; font-weight: 600; font-size: 14px; transition: 0.2s;"
                onmouseover="this.style.background='rgba(225,48,108,0.15)'; this.style.borderColor='#e1306c';"
                onmouseout="this.style.background='rgba(225,48,108,0.08)'; this.style.borderColor='rgba(225,48,108,0.3)';">
                <i class="ti ti-brand-instagram" style="font-size: 22px;"></i>
                <span>
                    <strong style="display: block; font-size: 13px;">Instagram</strong>
                    <small style="font-size: 11px; opacity: 0.8;">@pixelstudio.id</small>
                </span>
            </a>

            {{-- TikTok --}}
            <a href="https://tiktok.com/@pixelstudio.id" target="_blank"
                style="display: inline-flex; align-items: center; gap: 10px; background: rgba(255, 255, 255, 0.04); border: 1px solid rgba(255,255,255,0.15); color: #fff; padding: 14px 22px; border-radius: 12px; text-decoration: none; font-weight: 600; font-size: 14px; transition: 0.2s;"
                onmouseover="this.style.background='rgba(255,255,255,0.08)'; this.style.borderColor='rgba(255,255,255,0.4)';"
                onmouseout="this.style.background='rgba(255,255,255,0.04)'; this.style.borderColor='rgba(255,255,255,0.15)';">
                <i class="ti ti-brand-tiktok" style="font-size: 22px;"></i>
                <span>
                    <strong style="display: block; font-size: 13px;">TikTok</strong>
                    <small style="font-size: 11px; opacity: 0.8;">@pixelstudio.id</small>
                </span>
            </a>

            {{-- Email --}}
            <a href="mailto:hello@pixelstudio.id" target="_blank"
                style="display: inline-flex; align-items: center; gap: 10px; background: rgba(184, 149, 90, 0.08); border: 1px solid rgba(184,149,90,0.3); color: var(--gold); padding: 14px 22px; border-radius: 12px; text-decoration: none; font-weight: 600; font-size: 14px; transition: 0.2s;"
                onmouseover="this.style.background='rgba(184,149,90,0.15)'; this.style.borderColor='var(--gold)';"
                onmouseout="this.style.background='rgba(184,149,90,0.08)'; this.style.borderColor='rgba(184,149,90,0.3)';">
                <i class="ti ti-mail" style="font-size: 22px;"></i>
                <span>
                    <strong style="display: block; font-size: 13px;">Email</strong>
                    <small style="font-size: 11px; opacity: 0.8;">hello@pixelstudio.id</small>
                </span>
            </a>
        </div>

        {{-- Jam Operasional --}}
        <p style="margin-top: 24px; font-size: 13px; color: var(--text-muted);">
            <i class="ti ti-clock" style="vertical-align: middle;"></i>
            Jam operasional: <strong style="color: var(--text-main);">Senin – Sabtu, 08.00 – 21.00 WIB</strong>
        </p>
    </div>
</section>

@if(session('username') && strtolower(session('role')) === 'admin')
{{-- ======================== MODAL: TAMBAH PAKET ======================== --}}
<div id="modalTambahPaket" style="display:none; position:fixed; z-index:9999; inset:0; background:rgba(0,0,0,0.7); backdrop-filter:blur(4px); align-items:center; justify-content:center; padding:20px;">
    <div style="background:var(--dark-surface); border:1px solid var(--dark-border); width:100%; max-width:560px; border-radius:15px; overflow:hidden; box-shadow:0 10px 30px rgba(0,0,0,0.5); text-align:left;">
        <div style="padding:20px 25px; border-bottom:1px solid var(--dark-border); display:flex; justify-content:space-between; align-items:center;">
            <h4 style="margin:0; color:var(--gold);"><i class="ti ti-plus"></i> Tambah Paket Baru</h4>
            <span onclick="toggleModal('modalTambahPaket')" style="cursor:pointer; color:var(--text-muted); font-size:22px;">&times;</span>
        </div>
        <form action="{{ route('paket.store') }}" method="POST" style="padding:25px; display:flex; flex-direction:column; gap:15px;">
            @csrf
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:15px;">
                <div>
                    <label style="font-size:12px; color:var(--text-muted); display:block; margin-bottom:5px;">Nama Paket *</label>
                    <input type="text" name="nama" required placeholder="Contoh: Starter"
                        style="width:100%; background:#1a1a1a; color:#fff; border:1px solid var(--dark-border); padding:10px; border-radius:8px; font-size:13px; outline:none; box-sizing:border-box;">
                </div>
                <div>
                    <label style="font-size:12px; color:var(--text-muted); display:block; margin-bottom:5px;">Harga Paket *</label>
                    <input type="text" name="price" required placeholder="Contoh: Rp 150.000 atau Harga Negosiasi"
                        style="width:100%; background:#1a1a1a; color:#fff; border:1px solid var(--dark-border); padding:10px; border-radius:8px; font-size:13px; outline:none; box-sizing:border-box;">
                </div>
            </div>
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:15px;">
                <div>
                    <label style="font-size:12px; color:var(--text-muted); display:block; margin-bottom:5px;">Konsep Desain *</label>
                    <input type="text" name="konsep" required placeholder="Contoh: 1 atau Unlimited"
                        style="width:100%; background:#1a1a1a; color:#fff; border:1px solid var(--dark-border); padding:10px; border-radius:8px; font-size:13px; outline:none; box-sizing:border-box;">
                </div>
                <div>
                    <label style="font-size:12px; color:var(--text-muted); display:block; margin-bottom:5px;">Revisi *</label>
                    <input type="text" name="revisi" required placeholder="Contoh: 2x atau Unlimited"
                        style="width:100%; background:#1a1a1a; color:#fff; border:1px solid var(--dark-border); padding:10px; border-radius:8px; font-size:13px; outline:none; box-sizing:border-box;">
                </div>
            </div>
            <div>
                <label style="font-size:12px; color:var(--text-muted); display:block; margin-bottom:5px;">Deskripsi Paket</label>
                <textarea name="desc" rows="3" placeholder="Deskripsi singkat tentang target paket..."
                    style="width:100%; background:#1a1a1a; color:#fff; border:1px solid var(--dark-border); padding:10px; border-radius:8px; font-size:13px; outline:none; resize:vertical; font-family:inherit; box-sizing:border-box;"></textarea>
            </div>
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px; background:#1a1a1a; padding:15px; border-radius:8px; border:1px solid var(--dark-border);">
                <label style="display:flex; align-items:center; gap:8px; font-size:12px; cursor:pointer; color:var(--text-main);">
                    <input type="checkbox" name="fitur_sumber" value="1"> File Sumber (.psd)
                </label>
                <label style="display:flex; align-items:center; gap:8px; font-size:12px; cursor:pointer; color:var(--text-main);">
                    <input type="checkbox" name="prioritas" value="1"> Prioritas Pengerjaan
                </label>
                <label style="display:flex; align-items:center; gap:8px; font-size:12px; cursor:pointer; color:var(--text-main);">
                    <input type="checkbox" name="featured" value="1"> Paling Populer (Featured)
                </label>
                <label style="display:flex; align-items:center; gap:8px; font-size:12px; cursor:pointer; color:var(--text-main);">
                    <input type="checkbox" name="custom" value="1"> Fully Custom (Kustom)
                </label>
            </div>
            <div style="text-align:right; padding-top:5px;">
                <button type="button" onclick="toggleModal('modalTambahPaket')"
                    style="background:#262626; color:#fff; border:1px solid var(--dark-border); padding:10px 20px; border-radius:8px; cursor:pointer; margin-right:8px;">
                    Batal
                </button>
                <button type="submit"
                    style="background:var(--gold); color:#000; border:none; padding:10px 24px; border-radius:8px; font-weight:700; cursor:pointer;">
                    <i class="ti ti-plus"></i> Simpan Paket
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ======================== MODAL: EDIT PAKET ======================== --}}
<div id="modalEditPaket" style="display:none; position:fixed; z-index:9999; inset:0; background:rgba(0,0,0,0.7); backdrop-filter:blur(4px); align-items:center; justify-content:center; padding:20px;">
    <div style="background:var(--dark-surface); border:1px solid var(--dark-border); width:100%; max-width:560px; border-radius:15px; overflow:hidden; box-shadow:0 10px 30px rgba(0,0,0,0.5); text-align:left;">
        <div style="padding:20px 25px; border-bottom:1px solid var(--dark-border); display:flex; justify-content:space-between; align-items:center;">
            <h4 style="margin:0; color:var(--gold);"><i class="ti ti-edit"></i> Edit Paket</h4>
            <span onclick="toggleModal('modalEditPaket')" style="cursor:pointer; color:var(--text-muted); font-size:22px;">&times;</span>
        </div>
        <form id="formEditPaket" method="POST" style="padding:25px; display:flex; flex-direction:column; gap:15px;">
            @csrf @method('PUT')
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:15px;">
                <div>
                    <label style="font-size:12px; color:var(--text-muted); display:block; margin-bottom:5px;">Nama Paket *</label>
                    <input type="text" name="nama" id="editPaketNama" required
                        style="width:100%; background:#1a1a1a; color:#fff; border:1px solid var(--dark-border); padding:10px; border-radius:8px; font-size:13px; outline:none; box-sizing:border-box;">
                </div>
                <div>
                    <label style="font-size:12px; color:var(--text-muted); display:block; margin-bottom:5px;">Harga Paket *</label>
                    <input type="text" name="price" id="editPaketPrice" required
                        style="width:100%; background:#1a1a1a; color:#fff; border:1px solid var(--dark-border); padding:10px; border-radius:8px; font-size:13px; outline:none; box-sizing:border-box;">
                </div>
            </div>
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:15px;">
                <div>
                    <label style="font-size:12px; color:var(--text-muted); display:block; margin-bottom:5px;">Konsep Desain *</label>
                    <input type="text" name="konsep" id="editPaketKonsep" required
                        style="width:100%; background:#1a1a1a; color:#fff; border:1px solid var(--dark-border); padding:10px; border-radius:8px; font-size:13px; outline:none; box-sizing:border-box;">
                </div>
                <div>
                    <label style="font-size:12px; color:var(--text-muted); display:block; margin-bottom:5px;">Revisi *</label>
                    <input type="text" name="revisi" id="editPaketRevisi" required
                        style="width:100%; background:#1a1a1a; color:#fff; border:1px solid var(--dark-border); padding:10px; border-radius:8px; font-size:13px; outline:none; box-sizing:border-box;">
                </div>
            </div>
            <div>
                <label style="font-size:12px; color:var(--text-muted); display:block; margin-bottom:5px;">Deskripsi Paket</label>
                <textarea name="desc" id="editPaketDesc" rows="3"
                    style="width:100%; background:#1a1a1a; color:#fff; border:1px solid var(--dark-border); padding:10px; border-radius:8px; font-size:13px; outline:none; resize:vertical; font-family:inherit; box-sizing:border-box;"></textarea>
            </div>
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px; background:#1a1a1a; padding:15px; border-radius:8px; border:1px solid var(--dark-border);">
                <label style="display:flex; align-items:center; gap:8px; font-size:12px; cursor:pointer; color:var(--text-main);">
                    <input type="checkbox" name="fitur_sumber" id="editPaketFiturSumber" value="1"> File Sumber (.psd)
                </label>
                <label style="display:flex; align-items:center; gap:8px; font-size:12px; cursor:pointer; color:var(--text-main);">
                    <input type="checkbox" name="prioritas" id="editPaketPrioritas" value="1"> Prioritas Pengerjaan
                </label>
                <label style="display:flex; align-items:center; gap:8px; font-size:12px; cursor:pointer; color:var(--text-main);">
                    <input type="checkbox" name="featured" id="editPaketFeatured" value="1"> Paling Populer (Featured)
                </label>
                <label style="display:flex; align-items:center; gap:8px; font-size:12px; cursor:pointer; color:var(--text-main);">
                    <input type="checkbox" name="custom" id="editPaketCustom" value="1"> Fully Custom (Kustom)
                </label>
            </div>
            <div style="text-align:right; padding-top:5px;">
                <button type="button" onclick="toggleModal('modalEditPaket')"
                    style="background:#262626; color:#fff; border:1px solid var(--dark-border); padding:10px 20px; border-radius:8px; cursor:pointer; margin-right:8px;">
                    Batal
                </button>
                <button type="submit"
                    style="background:var(--gold); color:#000; border:none; padding:10px 24px; border-radius:8px; font-weight:700; cursor:pointer;">
                    <i class="ti ti-device-floppy"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endif

@endsection

@section('scripts')
<script>
function toggleModal(id) {
    const modal = document.getElementById(id);
    if (!modal) return;
    const isOpen = modal.style.display === 'flex';
    modal.style.display = isOpen ? 'none' : 'flex';
}

// Tutup modal jika klik di luar area box
document.addEventListener('click', function(e) {
    ['modalTambahPaket', 'modalEditPaket'].forEach(function(id) {
        const modal = document.getElementById(id);
        if (modal && e.target === modal) modal.style.display = 'none';
    });
});

function editPaket(item) {
    const baseUrl = '{{ url("pengelolaan/paket") }}';
    document.getElementById('formEditPaket').action = baseUrl + '/' + item.id;
    document.getElementById('editPaketNama').value = item.nama || '';
    document.getElementById('editPaketPrice').value = item.price || '';
    document.getElementById('editPaketKonsep').value = item.konsep || '';
    document.getElementById('editPaketRevisi').value = item.revisi || '';
    document.getElementById('editPaketDesc').value = item.desc || '';
    document.getElementById('editPaketFiturSumber').checked = !!item.fitur_sumber;
    document.getElementById('editPaketPrioritas').checked = !!item.prioritas;
    document.getElementById('editPaketFeatured').checked = !!item.featured;
    document.getElementById('editPaketCustom').checked = !!item.custom;
    toggleModal('modalEditPaket');
}
</script>
@endsection
