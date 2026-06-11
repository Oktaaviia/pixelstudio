@extends('layouts.app')

@section('title', 'Layanan — PixelStudio')

@section('content')
<div class="layanan-page">

    {{-- Header --}}
    <div class="layanan-hero">
        <div class="section-label">Layanan Kami</div>
        <h1>Semua Jasa <span class="gold">Desain Grafis</span></h1>
        <p>Temukan layanan yang tepat untuk kebutuhan visual brand-mu</p>
        @if(session('username') && strtolower(session('role')) === 'admin')
            <!-- Admin create button is relocated to the filter bar wrapper -->
        @endif

        {{-- Kolom Pencarian AJAX --}}
        <div style="max-width: 480px; margin: 24px auto 0; position: relative;">
            <input type="text" id="search-layanan"
                placeholder="Cari layanan desain..."
                oninput="searchLayanan(this.value)"
                style="width: 100%; padding: 12px 38px 12px 44px; background: var(--dark-surface); border: 1px solid var(--dark-border); color: var(--text-main); border-radius: 10px; font-size: 14px; outline: none; box-sizing: border-box;">
            <i class="ti ti-search" style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: var(--text-muted); font-size: 18px;"></i>
            <i class="ti ti-loader spin" id="search-loader" style="display:none; position: absolute; right: 14px; top: 50%; transform: translateY(-50%); color: var(--gold); font-size: 18px; pointer-events: none;"></i>
        </div>
    </div>

    {{-- Filter Bar --}}
    <div class="layanan-filter-wrap" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px; margin-bottom: 30px;">
        <div class="layanan-filter" style="margin: 0;">
            <button class="filter-chip active" onclick="filterLayanan('semua', this)">
                Semua
            </button>
            <button class="filter-chip" onclick="filterLayanan('Cetak', this)">
                <i class="ti ti-files"></i> Cetak
            </button>
            <button class="filter-chip" onclick="filterLayanan('Social Media', this)">
                <i class="ti ti-brand-instagram"></i> Social Media
            </button>
            <button class="filter-chip" onclick="filterLayanan('Digital', this)">
                <i class="ti ti-device-desktop"></i> Digital
            </button>
            <button class="filter-chip" onclick="filterLayanan('Branding', this)">
                <i class="ti ti-hexagon"></i> Branding
            </button>
            <button class="filter-chip" onclick="filterLayanan('Packaging', this)">
                <i class="ti ti-box"></i> Packaging
            </button>
        </div>
        @if(session('username') && strtolower(session('role')) === 'admin')
            <button onclick="toggleModal('modalTambahLayanan')" class="admin-btn-create" style="flex-shrink: 0;">
                <i class="ti ti-plus"></i> Tambah Layanan Baru
            </button>
        @endif
    </div>

    {{-- Grid Layanan --}}
    <div class="layanan-grid-katalog" id="layanan-grid">
        @foreach ($layanan as $item)
        @php
            // Mapping ikon berdasarkan kategori dari DB
            $iconMap = [
                'Cetak'        => 'ti-files',
                'Social Media' => 'ti-brand-instagram',
                'Digital'      => 'ti-device-desktop',
                'Branding'     => 'ti-hexagon',
                'Packaging'    => 'ti-box',
            ];
            $icon = $iconMap[$item->category] ?? 'ti-palette';
        @endphp
        <div class="layanan-katalog-card"
            data-kategori="{{ $item->category }}"
            data-id="{{ $item->id }}"
            data-nama="{{ $item->name }}">

            <div class="lk-icon">
                <i class="ti {{ $icon }}"></i>
            </div>

            <div class="lk-kategori">{{ $item->category }}</div>
            <div class="lk-nama">{{ $item->name }}</div>
            <div class="lk-desc">{{ $item->description }}</div>

            {{-- Removed lk-meta (duration & revisions) per user request --}}

            <div class="lk-footer">
                @if(session('username') && strtolower(session('role')) === 'admin')
                    <div style="display:flex; gap:8px; width:100%;">
                        <button onclick="editLayanan({{ json_encode($item) }})" class="btn-primary-nav" style="flex:1; background:#1a1a1a; color:var(--gold); border:1px solid var(--border); padding:8px; cursor:pointer; border-radius:8px; font-size:13px; font-weight:600; display:inline-flex; align-items:center; justify-content:center; gap:4px;">
                            <i class="ti ti-edit"></i> Edit
                        </button>
                        <form action="{{ route('layanan.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus layanan ini?');" style="flex:1; margin:0;">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-primary-nav" style="width:100%; background:rgba(220,53,69,0.1); color:#dc3545; border:1px solid #dc3545; padding:8px; cursor:pointer; border-radius:8px; font-size:13px; font-weight:600; display:inline-flex; align-items:center; justify-content:center; gap:4px;">
                                <i class="ti ti-trash"></i> Hapus
                            </button>
                        </form>
                    </div>
                @else
                    <a href="{{ route('layanan.detail', $item->id) }}" class="btn-primary-nav" style="width: 100%; justify-content: center;">
                        <i class="ti ti-info-circle"></i> Lihat Detail
                    </a>
                @endif
            </div>

        </div>
        @endforeach
    </div>

    {{-- Empty State --}}
    <div class="empty-state" id="empty-state" style="display:none;">
        <i class="ti ti-search-off"></i>
        <p>Tidak ada layanan yang sesuai pencarian/filter</p>
        <button class="btn-outline-nav" onclick="resetFilter()">Reset Filter</button>
    </div>

    {{-- Error State --}}
    <div class="empty-state" id="error-state" style="display:none; border-color: rgba(220,53,69,0.3); background: rgba(220,53,69,0.05); color: #ff6b6b;">
        <i class="ti ti-alert-triangle" style="font-size: 48px; color: #dc3545;"></i>
        <p style="margin-top: 10px; font-weight: 500;">Gagal mengambil data layanan dari server. Silakan coba lagi.</p>
        <button class="btn-outline-nav" style="border-color: #dc3545; color: #dc3545;" onclick="resetFilter()">Muat Ulang</button>
    </div>

</div>

@if(session('username') && strtolower(session('role')) === 'admin')
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
            @csrf @method('PUT')
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
@endif

@endsection

@section('scripts')
<script>
let activeKategori = 'semua';
let searchTimer;

// Filter berdasarkan kategori tombol
function filterLayanan(kategori, el) {
    activeKategori = kategori;
    document.querySelectorAll('.filter-chip').forEach(b => b.classList.remove('active'));
    el.classList.add('active');
    applyFilter();
}

// Pencarian AJAX real-time
function searchLayanan(keyword) {
    clearTimeout(searchTimer);
    
    const loader = document.getElementById('search-loader');
    const emptyState = document.getElementById('empty-state');
    const errorState = document.getElementById('error-state');
    
    if (errorState) errorState.style.display = 'none';

    if (keyword.trim() === '') {
        if (loader) loader.style.display = 'none';
        document.querySelectorAll('.layanan-katalog-card').forEach(c => c.style.display = '');
        if (emptyState) emptyState.style.display = 'none';
        applyFilter();
        return;
    }

    if (loader) loader.style.display = 'block';

    searchTimer = setTimeout(function() {
        fetch('/layanan/search?q=' + encodeURIComponent(keyword))
            .then(r => {
                if (!r.ok) throw new Error('Network response error');
                return r.json();
            })
            .then(data => {
                if (loader) loader.style.display = 'none';
                
                const ids  = data.map(d => String(d.id));
                let visible = 0;
                
                document.querySelectorAll('.layanan-katalog-card').forEach(card => {
                    const show = ids.includes(card.dataset.id);
                    card.style.display = show ? '' : 'none';
                    if (show) visible++;
                });

                if (emptyState) {
                    emptyState.style.display = visible === 0 ? 'flex' : 'none';
                }
            })
            .catch(err => {
                if (loader) loader.style.display = 'none';
                document.querySelectorAll('.layanan-katalog-card').forEach(c => c.style.display = 'none');
                if (emptyState) emptyState.style.display = 'none';
                if (errorState) errorState.style.display = 'flex';
                console.error(err);
            });
    }, 350);
}

function applyFilter() {
    let visible = 0;
    const errorState = document.getElementById('error-state');
    if (errorState) errorState.style.display = 'none';

    document.querySelectorAll('.layanan-katalog-card').forEach(card => {
        const kat     = card.dataset.kategori;
        const matchKat = activeKategori === 'semua' || kat === activeKategori;
        card.style.display = matchKat ? '' : 'none';
        if (matchKat) visible++;
    });
    document.getElementById('empty-state').style.display = visible === 0 ? 'flex' : 'none';
}

function resetFilter() {
    activeKategori = 'semua';
    document.getElementById('search-layanan').value = '';
    const loader = document.getElementById('search-loader');
    if (loader) loader.style.display = 'none';
    document.querySelectorAll('.filter-chip').forEach(b => b.classList.remove('active'));
    document.querySelector('.filter-chip').classList.add('active');
    document.querySelectorAll('.layanan-katalog-card').forEach(c => c.style.display = '');
    document.getElementById('empty-state').style.display = 'none';
    const errorState = document.getElementById('error-state');
    if (errorState) errorState.style.display = 'none';
}

function toggleModal(id) {
    const modal = document.getElementById(id);
    if (!modal) return;
    const isOpen = modal.style.display === 'flex';
    modal.style.display = isOpen ? 'none' : 'flex';
}

// Tutup modal jika klik di luar area box
document.addEventListener('click', function(e) {
    ['modalTambahLayanan', 'modalEditLayanan'].forEach(function(id) {
        const modal = document.getElementById(id);
        if (modal && e.target === modal) modal.style.display = 'none';
    });
});

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
</script>
@endsection
