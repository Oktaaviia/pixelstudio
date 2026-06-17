@extends('layouts.app')
@section('title', 'Portofolio — PixelStudio')
@section('content')
<div class="layanan-page">
    <div class="layanan-hero">
        <div class="section-label">Portofolio</div>
        <h1>Karya <span class="gold">Terbaik Kami</span></h1>
        <p>Koleksi proyek desain yang telah kami kerjakan untuk berbagai klien</p>
        @if(session('username') && strtolower(session('role')) === 'admin')
            <!-- Admin create button is relocated to the filter bar wrapper -->
        @endif

        {{-- Kolom Pencarian Portofolio --}}
        <div style="max-width: 480px; margin: 24px auto 0; position: relative;">
            <input type="text" id="search-porto"
                placeholder="Cari karya desain..."
                oninput="searchPorto(this.value)"
                style="width: 100%; padding: 12px 38px 12px 44px; background: var(--dark-surface); border: 1px solid var(--dark-border); color: var(--text-main); border-radius: 10px; font-size: 14px; outline: none; box-sizing: border-box;">
            <i class="ti ti-search" style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: var(--text-muted); font-size: 18px;"></i>
            <i class="ti ti-loader spin" id="porto-loader" style="display:none; position: absolute; right: 14px; top: 50%; transform: translateY(-50%); color: var(--gold); font-size: 18px; pointer-events: none;"></i>
        </div>
    </div>

    <div class="layanan-filter-wrap" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px; margin-bottom: 30px;">
        <div class="layanan-filter" style="margin: 0;">
            <button class="filter-chip active" onclick="filterKarya('semua', this)">Semua</button>
            <button class="filter-chip" onclick="filterKarya('Branding', this)"><i class="ti ti-hexagon"></i> Branding</button>
            <button class="filter-chip" onclick="filterKarya('Social Media', this)"><i class="ti ti-brand-instagram"></i> Social Media</button>
            <button class="filter-chip" onclick="filterKarya('Cetak', this)"><i class="ti ti-files"></i> Cetak</button>
            <button class="filter-chip" onclick="filterKarya('Digital', this)"><i class="ti ti-device-desktop"></i> Digital</button>
            <button class="filter-chip" onclick="filterKarya('Packaging', this)"><i class="ti ti-box"></i> Packaging</button>
        </div>
        <div style="display: flex; align-items: center; gap: 16px; flex-shrink: 0;">
            <div style="font-size:13px; color:var(--text-muted);" id="jumlah-karya">
                {{ count($portofolio) }} karya
            </div>
            @if(session('username') && strtolower(session('role')) === 'admin')
                <button onclick="toggleModal('modalTambahPorto')" class="admin-btn-create">
                    <i class="ti ti-plus"></i> Tambah Portofolio Baru
                </button>
            @endif
        </div>
    </div>

    <div class="porto-grid" id="porto-grid">
        @forelse ($portofolio as $item)
        @php
            // Warna aksen per kategori (karena DB tidak punya kolom warna)
            $warnaMap = [
                'Branding'     => 'var(--gold)',
                'Social Media' => '#9B59B6',
                'Cetak'        => '#E74C3C',
                'Digital'      => '#3498DB',
                'Packaging'    => '#2ECC71',
            ];
            $warna = $warnaMap[$item->category] ?? 'var(--gold)';
        @endphp
        <div class="porto-card" data-kategori="{{ $item->category }}" data-title="{{ strtolower($item->title) }}" data-klien="{{ strtolower($item->klien ?? '') }}" style="display: flex; flex-direction: column; overflow: hidden; background: var(--dark-surface); border: 1px solid var(--dark-border); border-radius: 12px; transition: 0.3s; cursor: default; position: relative;">
            <a href="{{ route('portofolio.detail', $item->id) }}" style="text-decoration: none; color: inherit; display: block; flex: 1;">
                <div class="porto-img-wrap" style="background: {{ $warna }}22;">
                    @if($item->image)
                        <img src="{{ $item->image }}" alt="{{ $item->title }}" class="porto-img"
                            onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                    @endif
                    <div class="porto-img-fallback"
                        style="{{ $item->image ? 'display:none;' : '' }} background:linear-gradient(135deg, {{ $warna }}33, {{ $warna }}11);">
                        <i class="ti ti-photo" style="font-size:40px; color:{{ $warna }};"></i>
                    </div>
                    <div class="porto-overlay">
                        <div class="porto-overlay-btn"><i class="ti ti-eye"></i> Lihat Detail</div>
                    </div>
                </div>

                <div class="porto-info">
                    <div class="porto-kategori" style="color:{{ $warna }}">{{ $item->category }}</div>
                    <div class="porto-judul">{{ $item->title }}</div>
                    <div class="porto-klien">
                        <i class="ti ti-building"></i> {{ $item->klien ?? 'PixelStudio' }} · {{ $item->tahun ?? date('Y') }}
                    </div>
                </div>
            </a>

            @if(session('username') && strtolower(session('role')) === 'admin')
                <div class="admin-actions" style="padding: 0 15px 15px 15px; margin-top: -5px;">
                    <button onclick="editPorto({{ json_encode($item) }})" class="admin-btn-edit" style="flex:1; justify-content:center;">
                        <i class="ti ti-edit"></i> Edit
                    </button>
                    <form action="{{ route('portofolio.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus portofolio ini?');" style="flex: 1; margin: 0;">
                        @csrf @method('DELETE')
                        <button type="submit" class="admin-btn-delete" style="width: 100%; justify-content:center;">
                            <i class="ti ti-trash"></i> Hapus
                        </button>
                    </form>
                </div>
            @endif
        </div>
        @empty
        <div style="text-align:center; padding:60px 20px; color:var(--text-muted); grid-column: 1 / -1;">
            <i class="ti ti-photo-off" style="font-size:48px; display:block; margin-bottom:16px;"></i>
            <p>Belum ada karya yang ditampilkan. Admin dapat menambahkannya melalui halaman Pengelolaan.</p>
        </div>
        @endforelse
    </div>

    <div class="empty-state" id="empty-porto" style="display:none;">
        <i class="ti ti-photo-off"></i>
        <p>Tidak ada karya di kategori ini</p>
        <button class="btn-outline-nav" onclick="resetPorto()">Lihat Semua</button>
    </div>

</div>

@if(session('username') && strtolower(session('role')) === 'admin')
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
@endif

@endsection

@section('scripts')
<script>
let activeKategoriPorto = 'semua';
let portoSearchTimer;

function filterKarya(kategori, el) {
    activeKategoriPorto = kategori;
    document.querySelectorAll('.filter-chip').forEach(b => b.classList.remove('active'));
    el.classList.add('active');
    applyPortoFilter();
}

function applyPortoFilter() {
    let visible = 0;
    const keyword = (document.getElementById('search-porto')?.value || '').toLowerCase().trim();
    document.querySelectorAll('.porto-card').forEach(card => {
        const matchKat = activeKategoriPorto === 'semua' || card.dataset.kategori === activeKategoriPorto;
        const matchSearch = keyword === '' ||
            (card.dataset.title && card.dataset.title.includes(keyword)) ||
            (card.dataset.kategori && card.dataset.kategori.toLowerCase().includes(keyword)) ||
            (card.dataset.klien && card.dataset.klien.includes(keyword));
        const show = matchKat && matchSearch;
        card.style.display = show ? '' : 'none';
        if (show) visible++;
    });
    document.getElementById('jumlah-karya').textContent = visible + ' karya';
    document.getElementById('empty-porto').style.display = visible === 0 ? 'flex' : 'none';
}

function searchPorto(keyword) {
    clearTimeout(portoSearchTimer);
    const loader = document.getElementById('porto-loader');
    if (loader) loader.style.display = 'block';
    portoSearchTimer = setTimeout(function() {
        if (loader) loader.style.display = 'none';
        applyPortoFilter();
    }, 250);
}

function resetPorto() {
    const input = document.getElementById('search-porto');
    if (input) input.value = '';
    activeKategoriPorto = 'semua';
    document.querySelectorAll('.filter-chip').forEach(b => b.classList.remove('active'));
    document.querySelectorAll('.filter-chip')[0].classList.add('active');
    document.querySelectorAll('.porto-card').forEach(c => c.style.display = '');
    const jumlah = document.getElementById('jumlah-karya');
    if (jumlah) jumlah.textContent = document.querySelectorAll('.porto-card').length + ' karya';
    document.getElementById('empty-porto').style.display = 'none';
}

function toggleModal(id) {
    const modal = document.getElementById(id);
    if (!modal) return;
    const isOpen = modal.style.display === 'flex';
    modal.style.display = isOpen ? 'none' : 'flex';
}

// Tutup modal jika klik di luar area box
document.addEventListener('click', function(e) {
    ['modalTambahPorto', 'modalEditPorto'].forEach(function(id) {
        const modal = document.getElementById(id);
        if (modal && e.target === modal) modal.style.display = 'none';
    });
});

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
</script>
@endsection
