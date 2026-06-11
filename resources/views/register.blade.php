@extends('layouts.app')

@section('title', 'Daftar — PixelStudio')

@section('topbar-action')
    <a href="{{ route('login') }}" class="btn-outline-sm">Masuk</a>
    <a href="{{ route('register') }}" class="btn-primary-sm">Daftar</a>
@endsection

@section('content')
<div class="login-page">
    <div class="login-card">

        <div class="login-logo">
            <div class="logo-icon-lg">P</div>
        </div>

        <h2>Buat Akun Baru</h2>
        <p class="login-sub">Bergabung dengan PixelStudio dan mulai pesan desainmu</p>

        {{-- Menampilkan Pesan Error Session jika ada --}}
        @if(session('error'))
            <div class="alert-error" style="margin-bottom: 20px; padding: 12px 16px; background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.3); border-radius: 8px; color: #EF4444; font-size: 13px;">
                <i class="ti ti-alert-circle"></i> {{ session('error') }}
            </div>
        @endif

        {{-- Menampilkan Error Validasi Masal (Seperti Email Duplicate / Password Pendek) --}}
        @if ($errors->any())
        <div style="margin-bottom: 20px; padding: 12px 16px; background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.3); border-radius: 8px; color: #EF4444; font-size: 13px;">
            <ul style="margin: 0; padding-left: 16px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        {{-- Menampilkan Pesan Sukses jika ada --}}
        @if (session('success'))
        <div style="margin-bottom: 20px; padding: 12px 16px; background: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.3); border-radius: 8px; color: #10B981; font-size: 13px;">
            {{ session('success') }}
        </div>
        @endif

        <form action="{{ route('register.post') }}" method="POST">
            @csrf

            {{-- Input Nama --}}
            <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" name="name"
                    placeholder="Nama lengkapmu"
                    value="{{ old('name') }}" required>
            </div>

            {{-- Input Email --}}
            <div class="form-group">
                <label>Email</label>
                <div style="position:relative;">
                    <input type="email" id="email-input" name="email"
                        placeholder="email@contoh.com"
                        value="{{ old('email') }}" required
                        oninput="cekEmail(this.value)">
                </div>
                <div id="email-status" style="font-size:12px; margin-top:5px;"></div>
            </div>

            {{-- Input Password --}}
            <div class="form-group">
                <label>Password</label>
                <div class="input-password" style="position: relative; display: flex; align-items: center;">
                    <input type="password" id="password" name="password" style="width: 100%;"
                        placeholder="Minimal 6 karakter" required>
                    <button type="button" class="toggle-pass" style="position: absolute; right: 10px; background: none; border: none; cursor: pointer; color: var(--text-muted);" onclick="togglePass('password', this)">
                        <i class="ti ti-eye"></i>
                    </button>
                </div>
            </div>

            {{-- Input Konfirmasi Password (SUDAH DI-CLEANUP & DIKOREKSI) --}}
            <div class="form-group" style="margin-top: 16px;">
                <label>Konfirmasi Password</label>
                <div class="input-password" style="position: relative; display: flex; align-items: center;">
                    <input type="password" id="konfirmasi" name="password_confirmation" style="width: 100%;"
                        placeholder="Ulangi password" required
                        oninput="cekKonfirmasi()">
                    <button type="button" class="toggle-pass" style="position: absolute; right: 10px; background: none; border: none; cursor: pointer; color: var(--text-muted);" onclick="togglePass('konfirmasi', this)">
                        <i class="ti ti-eye"></i>
                    </button>
                </div>
                <div id="konfirmasi-status" style="font-size:12px; margin-top:5px;"></div>
            </div>

            <button type="submit" class="btn-login-submit" style="margin-top:24px; width: 100%;">
                Buat Akun <i class="ti ti-arrow-right"></i>
            </button>
        </form>

        <div class="login-footer-text" style="margin-top: 20px; text-align: center;">
            Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a>
        </div>

    </div>
</div>
@endsection

@section('scripts')
<script>
// Fungsi tampil/sembunyikan password
function togglePass(id, btn) {
    const input = document.getElementById(id);
    const isPass = input.type === 'password';
    input.type = isPass ? 'text' : 'password';
    btn.innerHTML = isPass
        ? '<i class="ti ti-eye-off"></i>'
        : '<i class="ti ti-eye"></i>';
}

// Cek ketersediaan email real-time via AJAX
let emailTimer;
function cekEmail(val) {
    clearTimeout(emailTimer);
    const status = document.getElementById('email-status');
    if (val.length < 5 || !val.includes('@')) {
        status.textContent = '';
        return;
    }
    status.innerHTML = '<span style="color:var(--text-muted);">Mengecek...</span>';
    emailTimer = setTimeout(() => {
        fetch(`/api/cek-email?email=${encodeURIComponent(val)}`)
            .then(r => r.json())
            .then(data => {
                status.innerHTML = data.tersedia
                    ? '<span style="color:#4ade80;">✓ Email tersedia</span>'
                    : '<span style="color:#f87171;">✗ Email sudah terdaftar</span>';
            });
    }, 500);
}

// Fungsi cek kecocokan konfirmasi password secara Real-Time (Sudah Diperbaiki)
function cekKonfirmasi() {
    const pass   = document.getElementById('password').value;
    const konf   = document.getElementById('konfirmasi').value;
    const status = document.getElementById('konfirmasi-status');
    
    if (!konf) { 
        status.textContent = ''; 
        return; 
    }
    
    if (pass === konf) {
        status.innerHTML = '<span style="color:#4ade80;">✓ Password cocok</span>';
    } else {
        status.innerHTML = '<span style="color:#f87171;">✗ Password tidak cocok</span>';
    }
}
</script>
@endsection
