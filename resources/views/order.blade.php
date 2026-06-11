@extends('layouts.app')

@section('title', 'Buat Pesanan Baru — PixelStudio')

@section('content')
<div class="container mt-5" style="color: var(--text-main); padding-bottom: 50px; max-width: 800px; margin: 0 auto; padding-left: 20px; padding-right: 20px;">

    <div style="margin-bottom: 30px;">
        <h2 style="margin: 0 0 8px 0; font-size: 28px; font-weight: 700; color: #fff;">Formulir <span style="color: var(--gold);">Pemesanan Desain</span></h2>
        <p style="margin: 0; color: var(--text-muted); font-size: 14px;">Isi detail brief kreatif di bawah ini untuk memulai project desain Anda.</p>
    </div>

    {{-- Alert Error (Validasi Server-side) --}}
    @if($errors->any())
        <div id="error-box" style="background: rgba(220, 53, 69, 0.1); border: 1px solid #dc3545; color: #ff6b6b; padding: 15px; border-radius: 8px; margin-bottom: 25px; font-size: 14px;">
            <strong style="display: block; margin-bottom: 5px;">Penyebab Gagal Kirim:</strong>
            <ul style="margin: 0; padding-left: 20px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Alert Error dari Client-side JavaScript --}}
    <div id="js-error-box" style="display:none; background: rgba(220, 53, 69, 0.1); border: 1px solid #dc3545; color: #ff6b6b; padding: 15px; border-radius: 8px; margin-bottom: 25px; font-size: 14px;">
        <strong><i class="ti ti-alert-circle"></i> Data Tidak Lengkap:</strong>
        <p id="js-error-msg" style="margin: 5px 0 0 0;"></p>
    </div>

    <div style="background: var(--dark-surface); border: 1px solid var(--dark-border); padding: 35px; border-radius: 15px; box-shadow: 0 4px 20px rgba(0,0,0,0.2);">
        <form id="order-form" action="{{ route('order.post') }}" method="POST" enctype="multipart/form-data" style="display: flex; flex-direction: column; gap: 20px;" novalidate>
            @csrf

            {{-- 1. PILIH LAYANAN --}}
            <div style="display: flex; flex-direction: column; gap: 6px;">
                <label style="font-size: 13px; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px;">Jenis Layanan Desain <span style="color:#dc3545;">*</span></label>
                <select name="layanan" id="pilihLayanan" style="background: #1a1a1a; color: #fff; border: 1px solid var(--dark-border); padding: 12px; border-radius: 8px; font-size: 14px; outline: none; width: 100%; cursor: pointer;" required>
                    <option value="" disabled selected>— Pilih Layanan Desain —</option>
                    @foreach($layanan as $l)
                        <option value="{{ $l->name }}" {{ old('layanan') == $l->name ? 'selected' : '' }}>
                            {{ $l->name }} [{{ $l->category }}]
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- 2. PILIH PAKET --}}
            <div style="display: flex; flex-direction: column; gap: 6px;">
                <label style="font-size: 13px; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px;">Pilihan Paket Kebutuhan <span style="color:#dc3545;">*</span></label>
                <select name="paket" id="pilihanPaket" onchange="cekTipePaket()" style="background: #1a1a1a; color: #fff; border: 1px solid var(--dark-border); padding: 12px; border-radius: 8px; font-size: 14px; outline: none; width: 100%; cursor: pointer;" required>
                    <option value="" disabled selected>— Pilih Paket Desain —</option>
                    @foreach($paket as $p)
                        <option value="{{ $p['nama'] }}" data-is-custom="{{ isset($p['custom']) && $p['custom'] ? '1' : '0' }}" {{ old('paket') == $p['nama'] ? 'selected' : '' }}>
                            {{ $p['nama'] }} ({{ $p['price'] }})
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- 3. NAMA BRAND & WHATSAPP (SEJAJAR) --}}
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div style="display: flex; flex-direction: column; gap: 6px;">
                    <label style="font-size: 13px; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px;">Nama Brand / Project <span style="color:#dc3545;">*</span></label>
                    <input type="text" name="brand" id="inputBrand" value="{{ old('brand') }}" placeholder="Contoh: Kopi Anak Muda"
                        style="background: #1a1a1a; color: #fff; border: 1px solid var(--dark-border); padding: 12px; border-radius: 8px; font-size: 14px; outline: none;" required>
                </div>
                <div style="display: flex; flex-direction: column; gap: 6px;">
                    <label style="font-size: 13px; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px;">Nomor WhatsApp Anda <span style="color:#dc3545;">*</span></label>
                    <input type="text" name="whatsapp" id="inputWA" value="{{ old('whatsapp') }}" placeholder="Contoh: 08123456789"
                        style="background: #1a1a1a; color: #fff; border: 1px solid var(--dark-border); padding: 12px; border-radius: 8px; font-size: 14px; outline: none;" required>
                </div>
            </div>

            {{-- 4. UKURAN & DEADLINE (SEJAJAR) --}}
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div style="display: flex; flex-direction: column; gap: 6px;">
                    <label style="font-size: 13px; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px;">Ukuran Desain / Dimensi <span style="color:#dc3545;">*</span></label>
                    <input type="text" name="ukuran" id="inputUkuran" value="{{ old('ukuran') }}" placeholder="Contoh: 1080x1080px / A4"
                        style="background: #1a1a1a; color: #fff; border: 1px solid var(--dark-border); padding: 12px; border-radius: 8px; font-size: 14px; outline: none;" required>
                </div>
                <div style="display: flex; flex-direction: column; gap: 6px;">
                    <label style="font-size: 13px; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px;">Target Deadline Selesai</label>
                    <input type="date" name="deadline" value="{{ old('deadline') }}"
                        style="background: #1a1a1a; color: #fff; border: 1px solid var(--dark-border); padding: 12px; border-radius: 8px; font-size: 14px; outline: none; cursor: pointer;">
                </div>
            </div>

            {{-- 5. DESKRIPSI BRIEF --}}
            <div style="display: flex; flex-direction: column; gap: 6px;">
                <label style="font-size: 13px; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px;">Brief Deskripsi Keinginan Desain <span style="color:#dc3545;">*</span></label>
                <textarea name="deskripsi" id="inputDeskripsi" rows="4" placeholder="Jelaskan konsep, preferensi warna, tulisan yang harus ada di dalam desain secara mendetail..."
                    style="background: #1a1a1a; color: #fff; border: 1px solid var(--dark-border); padding: 12px; border-radius: 8px; font-size: 14px; outline: none; resize: vertical; font-family: inherit;" required>{{ old('deskripsi') }}</textarea>
            </div>

            {{-- 6. CATATAN TAMBAHAN --}}
            <div style="display: flex; flex-direction: column; gap: 6px;">
                <label style="font-size: 13px; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px;">Catatan Tambahan (Opsional)</label>
                <textarea name="catatan" rows="2" placeholder="Link referensi asset pendukung atau catatan instruksi khusus lainnya..."
                    style="background: #1a1a1a; color: #fff; border: 1px solid var(--dark-border); padding: 12px; border-radius: 8px; font-size: 14px; outline: none; resize: vertical; font-family: inherit;">{{ old('catatan') }}</textarea>
            </div>

            <hr style="border: 0; border-top: 1px solid var(--dark-border); margin: 10px 0;">

            {{-- 7. KOTAK UPLOAD BUKTI BAYAR (REGULER/NON-CUSTOM SAJA) --}}
            <div id="sectionPembayaran" style="display: none; background: rgba(255, 255, 255, 0.02); border: 1px solid var(--dark-border); padding: 25px; border-radius: 12px; transition: 0.3s;">
                <h4 style="margin: 0 0 6px 0; color: var(--gold); font-size: 15px; font-weight: 600; display: flex; align-items: center; gap: 6px;">
                    <i class="ti ti-upload"></i> Upload Bukti Pembayaran
                </h4>
                <p style="font-size: 13px; margin: 0 0 15px 0; color: var(--text-muted); line-height: 1.5;">
                    Silakan lakukan transfer ke rekening resmi PixelStudio, lalu upload bukti transfernya di sini:<br>
                    <strong style="color: #fff; font-size: 14px;">Bank BCA — 1234567890 a/n PixelStudio Kreatif Pratama</strong>
                </p>

                <div style="display: flex; flex-direction: column; gap: 6px;">
                    <label style="display: block; font-size: 13px; font-weight: 600;">Upload Lampiran Bukti Transfer (<span style="color: #dc3545;">Wajib untuk paket reguler</span>)</label>
                    <input type="file" name="bukti_bayar" id="inputBukti" accept="image/jpeg,image/png,image/jpg"
                        style="color: var(--text-muted); font-size: 13px; cursor: pointer;">
                    <small style="color: var(--text-muted); font-size: 11px; margin-top: 2px;">Format file didukung: JPG, JPEG, PNG (Maksimal ukuran file: 2MB)</small>
                </div>
            </div>

            {{-- 8. NOTIFIKASI KHUSUS PAKET CUSTOM --}}
            <div id="sectionCustom" style="display: none; background: rgba(184,149,90, 0.08); border: 1px dashed var(--gold); padding: 20px; border-radius: 12px; transition: 0.3s;">
                <p style="margin: 0; font-size: 13px; color: #fff; line-height: 1.6; display: flex; align-items: flex-start; gap: 8px;">
                    <span style="font-size: 16px;">💬</span>
                    <span>
                        <strong>Paket Custom — Diskusi Langsung via WhatsApp:</strong><br>
                        Setelah kamu submit formulir ini, admin kami akan menghubungi kamu melalui WhatsApp untuk mendiskusikan kebutuhan dan menyepakati harga. Tidak perlu bayar dulu sebelum deal harga disepakati.
                    </span>
                </p>
            </div>

            {{-- BUTTON SUBMIT --}}
            <button type="submit" id="btn-submit"
                style="background: var(--gold); color: #000; border: none; padding: 14px; border-radius: 8px; font-size: 15px; font-weight: 700; cursor: pointer; transition: 0.2s; text-transform: uppercase; letter-spacing: 0.5px; width: 100%; margin-top: 10px;">
                <i class="ti ti-send"></i> <span id="btn-submit-text">Proses & Daftarkan Project</span>
            </button>

        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
// === VALIDASI SISI KLIEN ===
document.getElementById('order-form').addEventListener('submit', function(e) {
    const layanan   = document.getElementById('pilihLayanan').value;
    const paket     = document.getElementById('pilihanPaket').value;
    const brand     = document.getElementById('inputBrand').value.trim();
    const wa        = document.getElementById('inputWA').value.trim();
    const ukuran    = document.getElementById('inputUkuran').value.trim();
    const deskripsi = document.getElementById('inputDeskripsi').value.trim();

    let errorMsg = '';

    if (!layanan)       errorMsg = 'Pilih jenis layanan desain terlebih dahulu.';
    else if (!paket)    errorMsg = 'Pilih paket yang diinginkan.';
    else if (!brand)    errorMsg = 'Nama brand / project wajib diisi.';
    else if (!wa)       errorMsg = 'Nomor WhatsApp wajib diisi.';
    else if (!ukuran)   errorMsg = 'Ukuran desain wajib diisi.';
    else if (!deskripsi || deskripsi.length < 10) errorMsg = 'Brief deskripsi terlalu singkat. Mohon jelaskan lebih detail (minimal 10 karakter).';

    // Validasi bukti bayar HANYA untuk paket non-custom
    const isCustom = isPaketCustom();
    const inputBukti = document.getElementById('inputBukti');
    if (!isCustom && inputBukti && !inputBukti.files.length && !errorMsg) {
        errorMsg = 'Lampiran bukti transfer wajib diunggah untuk paket reguler.';
    }

    if (errorMsg) {
        e.preventDefault();
        const box = document.getElementById('js-error-box');
        document.getElementById('js-error-msg').textContent = errorMsg;
        box.style.display = 'block';
        box.scrollIntoView({ behavior: 'smooth', block: 'center' });
        return false;
    }

    document.getElementById('js-error-box').style.display = 'none';
});

// Cek apakah paket yang dipilih adalah custom
function isPaketCustom() {
    const selectPaket = document.getElementById('pilihanPaket');
    const selectedOption = selectPaket.options[selectPaket.selectedIndex];
    if (!selectedOption) return false;
    // Cek dari data-is-custom attribute (dari database flag)
    const dataCustom = selectedOption.getAttribute('data-is-custom');
    if (dataCustom === '1') return true;
    // Fallback: cek nama mengandung 'custom'
    return selectPaket.value.toLowerCase().includes('custom');
}

// === LOGIKA DINAMIS PAKET CUSTOM vs REGULER ===
function cekTipePaket() {
    const secBayar   = document.getElementById('sectionPembayaran');
    const secCustom  = document.getElementById('sectionCustom');
    const inputBukti = document.getElementById('inputBukti');
    const btnText    = document.getElementById('btn-submit-text');

    if (isPaketCustom()) {
        secBayar.style.display  = 'none';
        secCustom.style.display = 'block';
        if (inputBukti) inputBukti.removeAttribute('required');
        btnText.textContent = 'Submit & Hubungi via WhatsApp';
    } else {
        secBayar.style.display  = 'block';
        secCustom.style.display = 'none';
        if (inputBukti) inputBukti.setAttribute('required', 'required');
        btnText.textContent = 'Upload & Daftarkan Project';
    }
}

// Trigger saat halaman load (untuk menangani 'old' session)
document.addEventListener('DOMContentLoaded', function() {
    const paketSelect = document.getElementById('pilihanPaket');
    if (paketSelect && paketSelect.value !== '') {
        cekTipePaket();
    }
    if (document.getElementById('error-box')) {
        document.getElementById('js-error-box').style.display = 'none';
    }
});
</script>
@endsection
