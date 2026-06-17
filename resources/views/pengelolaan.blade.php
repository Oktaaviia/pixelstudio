@extends('layouts.app')

@section('title', 'Pengelolaan Konten — PixelStudio')

@section('content')
<div class="dashboard-page">

    <div class="dashboard-header">
        <div>
            <h1>Pengelolaan <span class="gold">Konten</span></h1>
            <p class="text-muted">Kelola daftar layanan, portofolio, dan paket secara langsung</p>
        </div>
        <a href="{{ route('admin') }}" class="btn-outline-nav">
            <i class="ti ti-arrow-left"></i> Kembali ke Admin
        </a>
    </div>

    @if(session('success'))
        <div style="background: rgba(40, 167, 69, 0.1); border: 1px solid #28a745; color: #4ade80; padding: 14px 20px; border-radius: 10px; margin-bottom: 24px; display:flex; align-items:center; gap:10px;">
            <i class="ti ti-circle-check" style="font-size:20px;"></i> {{ session('success') }}
        </div>
    @endif

    {{-- ===== TAB NAVIGASI KATEGORI ===== --}}
    <div id="tabNav" style="display: none; gap: 12px; margin-bottom: 28px; flex-wrap: wrap; align-items: center;">
        <button onclick="switchTab('menu')"
            style="display: inline-flex; align-items: center; gap: 8px; padding: 12px 18px; border-radius: 10px; font-size: 14px; font-weight: 600; cursor: pointer; transition: 0.2s; border: 2px dashed var(--border); background: transparent; color: var(--text-secondary); height: 46px;">
            <i class="ti ti-arrow-left"></i> Kembali ke Menu Pilihan
        </button>
        <div style="width: 1px; height: 26px; background: var(--border); margin: 0 8px;"></div>
        <button onclick="switchTab('layanan')" id="tab-layanan"
            style="display: inline-flex; align-items: center; gap: 8px; padding: 12px 22px; border-radius: 10px; font-size: 14px; font-weight: 600; cursor: pointer; transition: 0.2s; border: 2px solid var(--dark-border); background: transparent; color: var(--text-muted); height: 46px;">
            <i class="ti ti-package"></i> Layanan
            <span id="badge-layanan" style="background: rgba(255,255,255,0.08); border-radius: 20px; padding: 2px 8px; font-size: 11px;">{{ $layanan->count() }}</span>
        </button>
        <button onclick="switchTab('portofolio')" id="tab-portofolio"
            style="display: inline-flex; align-items: center; gap: 8px; padding: 12px 22px; border-radius: 10px; font-size: 14px; font-weight: 600; cursor: pointer; transition: 0.2s; border: 2px solid var(--dark-border); background: transparent; color: var(--text-muted); height: 46px;">
            <i class="ti ti-photo"></i> Portofolio
            <span id="badge-portofolio" style="background: rgba(255,255,255,0.08); border-radius: 20px; padding: 2px 8px; font-size: 11px;">{{ $portofolio->count() }}</span>
        </button>
        <button onclick="switchTab('paket')" id="tab-paket"
            style="display: inline-flex; align-items: center; gap: 8px; padding: 12px 22px; border-radius: 10px; font-size: 14px; font-weight: 600; cursor: pointer; transition: 0.2s; border: 2px solid var(--dark-border); background: transparent; color: var(--text-muted); height: 46px;">
            <i class="ti ti-gift"></i> Paket
            <span id="badge-paket" style="background: rgba(255,255,255,0.08); border-radius: 20px; padding: 2px 8px; font-size: 11px;">{{ $paketList->count() }}</span>
        </button>
    </div>

    {{-- ===== MENU PILIHAN KATEGORI AWAL ===== --}}
    <div id="section-menu" style="display: block; margin-bottom: 40px;">
        <p style="color: var(--text-secondary); margin-bottom: 24px; font-size: 15px;">Pilih kategori konten yang ingin Anda kelola:</p>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 24px;">
            
            {{-- Card Layanan --}}
            <div onclick="switchTab('layanan')" class="menu-choice-card" style="background: var(--bg-surface); border: 1px solid var(--border); padding: 35px 25px; border-radius: 16px; text-align: center; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 20px rgba(0,0,0,0.15);">
                <div class="menu-icon-wrapper" style="width: 70px; height: 70px; border-radius: 50%; background: rgba(184, 149, 90, 0.1); border: 1px solid rgba(184, 149, 90, 0.25); display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; color: var(--gold); transition: 0.3s;">
                    <i class="ti ti-package" style="font-size: 32px;"></i>
                </div>
                <h3 style="margin: 0 0 10px 0; font-size: 20px; font-weight: 700; color: #fff;">Manajemen Layanan</h3>
                <p style="color: var(--text-secondary); font-size: 13px; line-height: 1.5; margin: 0 0 20px 0;">Kelola katalog jenis jasa desain grafis, deskripsi, durasi pengerjaan, jumlah revisi, dan harga dasar.</p>
                <span style="background: rgba(184, 149, 90, 0.15); color: var(--gold); padding: 6px 16px; border-radius: 20px; font-size: 13px; font-weight: 600;">
                    {{ $layanan->count() }} Item Terdaftar
                </span>
            </div>

            {{-- Card Portofolio --}}
            <div onclick="switchTab('portofolio')" class="menu-choice-card" style="background: var(--bg-surface); border: 1px solid var(--border); padding: 35px 25px; border-radius: 16px; text-align: center; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 20px rgba(0,0,0,0.15);">
                <div class="menu-icon-wrapper" style="width: 70px; height: 70px; border-radius: 50%; background: rgba(139, 124, 248, 0.1); border: 1px solid rgba(139, 124, 248, 0.25); display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; color: var(--purple); transition: 0.3s;">
                    <i class="ti ti-photo" style="font-size: 32px;"></i>
                </div>
                <h3 style="margin: 0 0 10px 0; font-size: 20px; font-weight: 700; color: #fff;">Portofolio Karya</h3>
                <p style="color: var(--text-secondary); font-size: 13px; line-height: 1.5; margin: 0 0 20px 0;">Kelola galeri hasil desain, nama klien, tahun pengerjaan, deskripsi proyek, serta tautan gambar portofolio.</p>
                <span style="background: rgba(139, 124, 248, 0.15); color: var(--purple); padding: 6px 16px; border-radius: 20px; font-size: 13px; font-weight: 600;">
                    {{ $portofolio->count() }} Karya Terdaftar
                </span>
            </div>

            {{-- Card Paket --}}
            <div onclick="switchTab('paket')" class="menu-choice-card" style="background: var(--bg-surface); border: 1px solid var(--border); padding: 35px 25px; border-radius: 16px; text-align: center; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 20px rgba(0,0,0,0.15);">
                <div class="menu-icon-wrapper" style="width: 70px; height: 70px; border-radius: 50%; background: rgba(40, 167, 69, 0.1); border: 1px solid rgba(40, 167, 69, 0.25); display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; color: #28a745; transition: 0.3s;">
                    <i class="ti ti-gift" style="font-size: 32px;"></i>
                </div>
                <h3 style="margin: 0 0 10px 0; font-size: 20px; font-weight: 700; color: #fff;">Paket & Harga</h3>
                <p style="color: var(--text-secondary); font-size: 13px; line-height: 1.5; margin: 0 0 20px 0;">Kelola paket harga (Starter, Premium, Custom), jumlah konsep, revisi, fitur source file, dan prioritas pengerjaan.</p>
                <span style="background: rgba(40, 167, 69, 0.15); color: #28a745; padding: 6px 16px; border-radius: 20px; font-size: 13px; font-weight: 600;">
                    {{ $paketList->count() }} Paket Aktif
                </span>
            </div>

        </div>
    </div>

    {{-- ================= SECTION: LAYANAN (PACKAGES) ================= --}}
    <div id="section-layanan" class="tab-section" style="display: block;">
        <div class="section-card" style="margin-bottom: 30px;">
            <div class="section-card-header" style="display:flex; justify-content:space-between; align-items:center;">
                <h3><i class="ti ti-package" style="color:var(--gold);"></i> Manajemen Layanan</h3>
                <button onclick="toggleModal('modalTambahLayanan')" class="admin-btn-create">
                    <i class="ti ti-plus"></i> Tambah Layanan
                </button>
            </div>

            <div style="overflow-x:auto;">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Layanan</th>
                            <th>Kategori</th>
                            <th>Harga</th>
                            <th>Durasi</th>
                            <th>Revisi</th>
                            <th style="text-align:right;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($layanan as $item)
                        <tr>
                            <td class="gold">{{ $item->id }}</td>
                            <td><strong>{{ $item->name }}</strong></td>
                            <td><span style="background: rgba(184,149,90,0.15); color:var(--gold); padding:3px 8px; border-radius:20px; font-size:12px;">{{ $item->category }}</span></td>
                            <td class="gold">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                            <td style="color:var(--text-muted);">{{ $item->duration ?? '-' }}</td>
                            <td style="color:var(--text-muted);">{{ $item->revision }}x</td>
                            <td style="text-align:right;">
                                <div class="admin-actions">
                                    <button onclick="editLayanan({{ json_encode($item) }})" class="admin-btn-edit">
                                        <i class="ti ti-edit"></i> Edit
                                    </button>
                                    <form action="{{ route('layanan.destroy', $item->id) }}" method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus layanan ini?');" style="margin:0;">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="admin-btn-delete">
                                            <i class="ti ti-trash"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" style="text-align:center; color:var(--text-muted); padding:32px;">
                                Belum ada layanan. <button onclick="toggleModal('modalTambahLayanan')" style="background:none; border:none; color:var(--gold); cursor:pointer;">Tambah sekarang</button>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- ================= SECTION: PORTOFOLIO ================= --}}
    <div id="section-portofolio" class="tab-section" style="display: none;">
        <div class="section-card">
            <div class="section-card-header" style="display:flex; justify-content:space-between; align-items:center;">
                <h3><i class="ti ti-photo" style="color:var(--gold);"></i> Manajemen Portofolio</h3>
                <button onclick="toggleModal('modalTambahPorto')" class="admin-btn-create">
                    <i class="ti ti-plus"></i> Tambah Portofolio
                </button>
            </div>

            <div style="overflow-x:auto;">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Judul Karya</th>
                            <th>Kategori</th>
                            <th>Klien</th>
                            <th>Tahun</th>
                            <th style="text-align:right;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($portofolio as $porto)
                        <tr>
                            <td class="gold">{{ $porto->id }}</td>
                            <td><strong>{{ $porto->title }}</strong></td>
                            <td><span style="background: rgba(184,149,90,0.15); color:var(--gold); padding:3px 8px; border-radius:20px; font-size:12px;">{{ $porto->category }}</span></td>
                            <td style="color:var(--text-muted);">{{ $porto->klien ?? '-' }}</td>
                            <td style="color:var(--text-muted);">{{ $porto->tahun ?? '-' }}</td>
                            <td style="text-align:right;">
                                <div class="admin-actions">
                                    <button onclick="editPorto({{ json_encode($porto) }})" class="admin-btn-edit">
                                        <i class="ti ti-edit"></i> Edit
                                    </button>
                                    <form action="{{ route('portofolio.destroy', $porto->id) }}" method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus portofolio ini?');" style="margin:0;">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="admin-btn-delete">
                                            <i class="ti ti-trash"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" style="text-align:center; color:var(--text-muted); padding:32px;">
                                Belum ada portofolio. <button onclick="toggleModal('modalTambahPorto')" style="background:none; border:none; color:var(--gold); cursor:pointer;">Tambah sekarang</button>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- ================= SECTION: PAKET ================= --}}
    <div id="section-paket" class="tab-section" style="display: none;">
        <div class="section-card" style="margin-top: 0;">
            <div class="section-card-header" style="display:flex; justify-content:space-between; align-items:center;">
                <h3><i class="ti ti-gift" style="color:var(--gold);"></i> Manajemen Paket Layanan</h3>
                <button onclick="toggleModal('modalTambahPaket')" class="admin-btn-create">
                    <i class="ti ti-plus"></i> Tambah Paket
                </button>
            </div>

            <div style="overflow-x:auto;">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Paket</th>
                            <th>Harga</th>
                            <th>Konsep</th>
                            <th>Revisi</th>
                            <th>Sumber</th>
                            <th>Prioritas</th>
                            <th>Featured</th>
                            <th>Custom</th>
                            <th style="text-align:right;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($paketList as $pkg)
                        <tr>
                            <td class="gold">{{ $pkg->id }}</td>
                            <td><strong>{{ $pkg->nama }}</strong></td>
                            <td style="color:var(--text-muted);">{{ $pkg->price }}</td>
                            <td style="color:var(--text-muted);">{{ $pkg->konsep }}</td>
                            <td style="color:var(--text-muted);">{{ $pkg->revisi }}</td>
                            <td>
                                @if($pkg->fitur_sumber)
                                    <span style="color:#28a745;"><i class="ti ti-check"></i> Ya</span>
                                @else
                                    <span style="color:var(--text-muted);"><i class="ti ti-x"></i> Tidak</span>
                                @endif
                            </td>
                            <td>
                                @if($pkg->prioritas)
                                    <span style="color:#28a745;"><i class="ti ti-check"></i> Ya</span>
                                @else
                                    <span style="color:var(--text-muted);"><i class="ti ti-x"></i> Tidak</span>
                                @endif
                            </td>
                            <td>
                                @if($pkg->featured)
                                    <span class="admin-badge admin-badge-gold">Featured</span>
                                @else
                                    <span style="color:var(--text-muted);">-</span>
                                @endif
                            </td>
                            <td>
                                @if($pkg->custom)
                                    <span class="admin-badge admin-badge-purple">Custom</span>
                                @else
                                    <span style="color:var(--text-muted);">-</span>
                                @endif
                            </td>
                            <td style="text-align:right;">
                                <div class="admin-actions">
                                    <button onclick="editPaket({{ json_encode($pkg) }})" class="admin-btn-edit">
                                        <i class="ti ti-edit"></i> Edit
                                    </button>
                                    <form action="{{ route('paket.destroy', $pkg->id) }}" method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus paket ini?');" style="margin:0;">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="admin-btn-delete">
                                            <i class="ti ti-trash"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10" style="text-align:center; color:var(--text-muted); padding:32px;">
                                Belum ada paket. <button onclick="toggleModal('modalTambahPaket')" style="background:none; border:none; color:var(--gold); cursor:pointer;">Tambah sekarang</button>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

{{-- ======================== MODAL: TAMBAH LAYANAN ======================== --}}
<div id="modalTambahLayanan" class="admin-modal">
    <div class="admin-modal-box">
        <div class="admin-modal-header">
            <h4><i class="ti ti-plus"></i> Tambah Layanan Baru</h4>
            <button type="button" class="admin-modal-close" onclick="toggleModal('modalTambahLayanan')">&times;</button>
        </div>
        <form action="{{ route('layanan.store') }}" method="POST" class="admin-form">
            @csrf
            <div class="admin-form-grid">
                <div class="admin-field">
                    <label>Nama Layanan *</label>
                    <input type="text" name="name" required placeholder="Contoh: Desain Poster">
                </div>
                <div class="admin-field">
                    <label>Kategori *</label>
                    <select name="category" required>
                        <option value="">-- Pilih Kategori --</option>
                        <option>Cetak</option>
                        <option>Social Media</option>
                        <option>Digital</option>
                        <option>Branding</option>
                        <option>Packaging</option>
                    </select>
                </div>
            </div>
            <div class="admin-form-grid">
                <div class="admin-field">
                    <label>Durasi Pengerjaan</label>
                    <input type="text" name="duration" placeholder="Contoh: 2-3 Hari">
                </div>
                <div class="admin-field">
                    <label>Jumlah Revisi</label>
                    <input type="number" name="revision" min="0" placeholder="Contoh: 3">
                </div>
            </div>
            <div class="admin-field">
                <label>Harga Layanan (Rp) *</label>
                <input type="number" name="price" required min="0" placeholder="Contoh: 150000">
            </div>
            <div class="admin-field">
                <label>Deskripsi Layanan</label>
                <textarea name="description" rows="3" placeholder="Deskripsi singkat layanan..."></textarea>
            </div>
            <div class="admin-form-actions">
                <button type="button" class="admin-btn-cancel" onclick="toggleModal('modalTambahLayanan')">
                    Batal
                </button>
                <button type="submit" class="admin-btn-save">
                    <i class="ti ti-plus"></i> Simpan Layanan
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ======================== MODAL: EDIT LAYANAN ======================== --}}
<div id="modalEditLayanan" class="admin-modal">
    <div class="admin-modal-box">
        <div class="admin-modal-header">
            <h4><i class="ti ti-edit"></i> Edit Layanan</h4>
            <button type="button" class="admin-modal-close" onclick="toggleModal('modalEditLayanan')">&times;</button>
        </div>
        <form id="formEditLayanan" method="POST" class="admin-form">
            @csrf
            <div class="admin-form-grid">
                <div class="admin-field">
                    <label>Nama Layanan *</label>
                    <input type="text" name="name" id="editLayananName" required placeholder="Contoh: Desain Poster">
                </div>
                <div class="admin-field">
                    <label>Kategori *</label>
                    <select name="category" id="editLayananCategory" required>
                        <option>Cetak</option>
                        <option>Social Media</option>
                        <option>Digital</option>
                        <option>Branding</option>
                        <option>Packaging</option>
                    </select>
                </div>
            </div>
            <div class="admin-form-grid">
                <div class="admin-field">
                    <label>Durasi Pengerjaan</label>
                    <input type="text" name="duration" id="editLayananDuration" placeholder="Contoh: 2-3 Hari">
                </div>
                <div class="admin-field">
                    <label>Jumlah Revisi</label>
                    <input type="number" name="revision" id="editLayananRevision" min="0" placeholder="Contoh: 3">
                </div>
            </div>
            <div class="admin-field">
                <label>Harga Layanan (Rp) *</label>
                <input type="number" name="price" id="editLayananPrice" required min="0" placeholder="Contoh: 150000">
            </div>
            <div class="admin-field">
                <label>Deskripsi Layanan</label>
                <textarea name="description" id="editLayananDesc" rows="3" placeholder="Deskripsi singkat layanan..."></textarea>
            </div>
            <div class="admin-form-actions">
                <button type="button" class="admin-btn-cancel" onclick="toggleModal('modalEditLayanan')">
                    Batal
                </button>
                <button type="submit" class="admin-btn-save">
                    <i class="ti ti-device-floppy"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ======================== MODAL: TAMBAH PORTOFOLIO ======================== --}}
<div id="modalTambahPorto" class="admin-modal">
    <div class="admin-modal-box">
        <div class="admin-modal-header">
            <h4><i class="ti ti-photo"></i> Tambah Portofolio Baru</h4>
            <button type="button" class="admin-modal-close" onclick="toggleModal('modalTambahPorto')">&times;</button>
        </div>
        <form action="{{ route('portofolio.store') }}" method="POST" class="admin-form" enctype="multipart/form-data">
            @csrf
            <div class="admin-form-grid">
                <div class="admin-field">
                    <label>Judul Karya *</label>
                    <input type="text" name="title" required placeholder="Contoh: Rebrand Kopi Anak Muda">
                </div>
                <div class="admin-field">
                    <label>Kategori *</label>
                    <select name="category" required>
                        <option value="">-- Pilih Kategori --</option>
                        <option>Branding</option>
                        <option>Social Media</option>
                        <option>Cetak</option>
                        <option>Digital</option>
                        <option>Packaging</option>
                    </select>
                </div>
            </div>
            <div class="admin-form-grid">
                <div class="admin-field">
                    <label>Nama Klien</label>
                    <input type="text" name="klien" placeholder="Contoh: PT Kopi Nusantara">
                </div>
                <div class="admin-field">
                    <label>Tahun Rilis</label>
                    <input type="text" name="tahun" placeholder="Contoh: 2025" value="{{ date('Y') }}">
                </div>
            </div>
            <div class="admin-field">
                <label>Deskripsi Proyek</label>
                <textarea name="description" rows="3" placeholder="Ceritakan singkat tentang proyek ini..."></textarea>
            </div>
            <div class="admin-field">
                <label>File Gambar * (Maks. 2MB)</label>
                <input type="file" name="image" accept="image/*" required style="background: transparent; border: none; padding: 0; color: var(--text-main);">
            </div>
            <div class="admin-form-actions">
                <button type="button" class="admin-btn-cancel" onclick="toggleModal('modalTambahPorto')">
                    Batal
                </button>
                <button type="submit" class="admin-btn-save">
                    <i class="ti ti-plus"></i> Simpan Portofolio
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ======================== MODAL: EDIT PORTOFOLIO ======================== --}}
<div id="modalEditPorto" class="admin-modal">
    <div class="admin-modal-box">
        <div class="admin-modal-header">
            <h4><i class="ti ti-edit"></i> Edit Portofolio</h4>
            <button type="button" class="admin-modal-close" onclick="toggleModal('modalEditPorto')">&times;</button>
        </div>
        <form id="formEditPorto" method="POST" class="admin-form" enctype="multipart/form-data">
            @csrf
            <div class="admin-form-grid">
                <div class="admin-field">
                    <label>Judul Karya *</label>
                    <input type="text" name="title" id="editPortoTitle" required placeholder="Contoh: Rebrand Kopi Anak Muda">
                </div>
                <div class="admin-field">
                    <label>Kategori *</label>
                    <select name="category" id="editPortoCategory" required>
                        <option>Branding</option>
                        <option>Social Media</option>
                        <option>Cetak</option>
                        <option>Digital</option>
                        <option>Packaging</option>
                    </select>
                </div>
            </div>
            <div class="admin-form-grid">
                <div class="admin-field">
                    <label>Nama Klien</label>
                    <input type="text" name="klien" id="editPortoKlien" placeholder="Contoh: PT Kopi Nusantara">
                </div>
                <div class="admin-field">
                    <label>Tahun Rilis</label>
                    <input type="text" name="tahun" id="editPortoTahun" placeholder="Contoh: 2025">
                </div>
            </div>
            <div class="admin-field">
                <label>Deskripsi Proyek</label>
                <textarea name="description" id="editPortoDesc" rows="3" placeholder="Ceritakan singkat tentang proyek ini..."></textarea>
            </div>
            <div class="admin-field">
                <label>Gambar Portofolio Saat Ini</label>
                <div id="editPortoImagePreview" style="margin-top: 8px;">
                    <img src="" id="editPortoImageTag" style="max-width: 150px; border-radius: 8px; border: 1px solid var(--border); display: none;">
                    <span id="editPortoImageNone" style="color: var(--text-muted); font-size: 13px;">Belum ada gambar</span>
                </div>
            </div>
            <div class="admin-field" style="margin-top: 15px;">
                <label>Ganti Gambar Baru (Opsional, Maks. 2MB)</label>
                <input type="file" name="image" accept="image/*" style="background: transparent; border: none; padding: 0; color: var(--text-main);">
            </div>
            <div class="admin-form-actions">
                <button type="button" class="admin-btn-cancel" onclick="toggleModal('modalEditPorto')">
                    Batal
                </button>
                <button type="submit" class="admin-btn-save">
                    <i class="ti ti-device-floppy"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ======================== MODAL: TAMBAH PAKET ======================== --}}
<div id="modalTambahPaket" class="admin-modal">
    <div class="admin-modal-box">
        <div class="admin-modal-header">
            <h4><i class="ti ti-plus"></i> Tambah Paket Baru</h4>
            <button type="button" class="admin-modal-close" onclick="toggleModal('modalTambahPaket')">&times;</button>
        </div>
        <form action="{{ route('paket.store') }}" method="POST" class="admin-form">
            @csrf
            <div class="admin-form-grid">
                <div class="admin-field">
                    <label>Nama Paket *</label>
                    <input type="text" name="nama" required placeholder="Contoh: Starter">
                </div>
                <div class="admin-field">
                    <label>Harga Paket *</label>
                    <input type="text" name="price" required placeholder="Contoh: Rp 150.000 atau Harga Negosiasi">
                </div>
            </div>
            <div class="admin-form-grid">
                <div class="admin-field">
                    <label>Konsep Desain *</label>
                    <input type="text" name="konsep" required placeholder="Contoh: 1 atau Unlimited">
                </div>
                <div class="admin-field">
                    <label>Revisi *</label>
                    <input type="text" name="revisi" required placeholder="Contoh: 2x atau Unlimited">
                </div>
            </div>
            <div class="admin-field">
                <label>Deskripsi Paket</label>
                <textarea name="desc" rows="3" placeholder="Deskripsi singkat tentang target paket..."></textarea>
            </div>
            <div class="admin-checkbox-group">
                <label>
                    <input type="checkbox" name="fitur_sumber" value="1"> File Sumber (.psd)
                </label>
                <label>
                    <input type="checkbox" name="prioritas" value="1"> Prioritas Pengerjaan
                </label>
                <label>
                    <input type="checkbox" name="featured" value="1"> Paling Populer (Featured)
                </label>
                <label>
                    <input type="checkbox" name="custom" value="1"> Fully Custom (Kustom)
                </label>
            </div>
            <div class="admin-form-actions">
                <button type="button" class="admin-btn-cancel" onclick="toggleModal('modalTambahPaket')">
                    Batal
                </button>
                <button type="submit" class="admin-btn-save">
                    <i class="ti ti-plus"></i> Simpan Paket
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ======================== MODAL: EDIT PAKET ======================== --}}
<div id="modalEditPaket" class="admin-modal">
    <div class="admin-modal-box">
        <div class="admin-modal-header">
            <h4><i class="ti ti-edit"></i> Edit Paket</h4>
            <button type="button" class="admin-modal-close" onclick="toggleModal('modalEditPaket')">&times;</button>
        </div>
        <form id="formEditPaket" method="POST" class="admin-form">
            @csrf
            <div class="admin-form-grid">
                <div class="admin-field">
                    <label>Nama Paket *</label>
                    <input type="text" name="nama" id="editPaketNama" required placeholder="Contoh: Starter">
                </div>
                <div class="admin-field">
                    <label>Harga Paket *</label>
                    <input type="text" name="price" id="editPaketPrice" required placeholder="Contoh: Rp 150.000 atau Harga Negosiasi">
                </div>
            </div>
            <div class="admin-form-grid">
                <div class="admin-field">
                    <label>Konsep Desain *</label>
                    <input type="text" name="konsep" id="editPaketKonsep" required placeholder="Contoh: 1 atau Unlimited">
                </div>
                <div class="admin-field">
                    <label>Revisi *</label>
                    <input type="text" name="revisi" id="editPaketRevisi" required placeholder="Contoh: 2x atau Unlimited">
                </div>
            </div>
            <div class="admin-field">
                <label>Deskripsi Paket</label>
                <textarea name="desc" id="editPaketDesc" rows="3" placeholder="Deskripsi singkat tentang target paket..."></textarea>
            </div>
            <div class="admin-checkbox-group">
                <label>
                    <input type="checkbox" name="fitur_sumber" id="editPaketFiturSumber" value="1"> File Sumber (.psd)
                </label>
                <label>
                    <input type="checkbox" name="prioritas" id="editPaketPrioritas" value="1"> Prioritas Pengerjaan
                </label>
                <label>
                    <input type="checkbox" name="featured" id="editPaketFeatured" value="1"> Paling Populer (Featured)
                </label>
                <label>
                    <input type="checkbox" name="custom" id="editPaketCustom" value="1"> Fully Custom (Kustom)
                </label>
            </div>
            <div class="admin-form-actions">
                <button type="button" class="admin-btn-cancel" onclick="toggleModal('modalEditPaket')">
                    Batal
                </button>
                <button type="submit" class="admin-btn-save">
                    <i class="ti ti-device-floppy"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script>
// Toggle visibilitas modal
function toggleModal(id) {
    const modal = document.getElementById(id);
    if (!modal) return;
    const isOpen = modal.style.display === 'flex';
    modal.style.display = isOpen ? 'none' : 'flex';
}

// ===== SISTEM TAB KATEGORI =====
function switchTab(tab) {
    const tabs    = ['layanan', 'portofolio', 'paket'];
    const gold    = 'var(--gold)';
    const border  = 'var(--dark-border)';

    const secMenu = document.getElementById('section-menu');
    const tabNav  = document.getElementById('tabNav');

    if (tab === 'menu') {
        if (secMenu) secMenu.style.display = 'block';
        if (tabNav) tabNav.style.display = 'none';
        tabs.forEach(function(t) {
            const sec = document.getElementById('section-' + t);
            if (sec) sec.style.display = 'none';
        });
        localStorage.removeItem('pengelolaanTab');
        return;
    }

    if (secMenu) secMenu.style.display = 'none';
    if (tabNav) tabNav.style.display = 'flex';

    tabs.forEach(function(t) {
        const sec = document.getElementById('section-' + t);
        const btn = document.getElementById('tab-' + t);
        const badge = btn ? btn.querySelector('span') : null;

        if (sec) {
            if (t === tab) {
                sec.style.display = 'block';
                if (btn) {
                    btn.style.background  = gold;
                    btn.style.borderColor = gold;
                    btn.style.color       = '#000';
                }
                if (badge) badge.style.background = 'rgba(0,0,0,0.25)';
            } else {
                sec.style.display = 'none';
                if (btn) {
                    btn.style.background  = 'transparent';
                    btn.style.borderColor = border;
                    btn.style.color       = 'var(--text-muted)';
                }
                if (badge) badge.style.background = 'rgba(255,255,255,0.08)';
            }
        }
    });

    // Simpan tab aktif ke localStorage
    localStorage.setItem('pengelolaanTab', tab);
}

// Restore tab aktif saat halaman load
document.addEventListener('DOMContentLoaded', function() {
    const savedTab = localStorage.getItem('pengelolaanTab') || 'menu';
    switchTab(savedTab);
});

// Tutup modal jika klik di luar area box
document.addEventListener('click', function(e) {
    ['modalTambahLayanan', 'modalEditLayanan', 'modalTambahPorto', 'modalEditPorto', 'modalTambahPaket', 'modalEditPaket'].forEach(function(id) {
        const modal = document.getElementById(id);
        if (modal && e.target === modal) modal.style.display = 'none';
    });
});

// Isi form edit layanan dengan data yang dipilih
function editLayanan(item) {
    const baseUrl = '{{ url("pengelolaan/layanan") }}';
    document.getElementById('formEditLayanan').action = baseUrl + '/' + item.id;
    document.getElementById('editLayananName').value     = item.name     || '';
    document.getElementById('editLayananCategory').value = item.category || '';
    document.getElementById('editLayananDuration').value = item.duration || '';
    document.getElementById('editLayananRevision').value = item.revision || 0;
    document.getElementById('editLayananPrice').value    = item.price    || 0;
    document.getElementById('editLayananDesc').value     = item.description || '';
    toggleModal('modalEditLayanan');
}

// Isi form edit portofolio dengan data yang dipilih
function editPorto(item) {
    const baseUrl = '{{ url("pengelolaan/portofolio") }}';
    document.getElementById('formEditPorto').action      = baseUrl + '/' + item.id;
    document.getElementById('editPortoTitle').value      = item.title    || '';
    document.getElementById('editPortoCategory').value   = item.category || '';
    document.getElementById('editPortoKlien').value      = item.klien    || '';
    document.getElementById('editPortoTahun').value      = item.tahun    || '';
    document.getElementById('editPortoDesc').value       = item.description || '';
    
    // Preview gambar saat ini
    const imgTag = document.getElementById('editPortoImageTag');
    const imgNone = document.getElementById('editPortoImageNone');
    if (imgTag && imgNone) {
        if (item.image) {
            imgTag.src = item.image;
            imgTag.style.display = 'block';
            imgNone.style.display = 'none';
        } else {
            imgTag.style.display = 'none';
            imgNone.style.display = 'inline';
        }
    }
    
    toggleModal('modalEditPorto');
}

// Isi form edit paket dengan data yang dipilih
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
