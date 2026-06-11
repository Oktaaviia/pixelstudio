@extends('layouts.app')

@section('title', 'Masuk — PixelStudio')

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

        <h2>Masuk ke PixelStudio</h2>
        <p class="login-sub">Kelola pesanan dan pantau progres desainmu</p>

        @if(session('error'))
            <div class="alert-error">
                <i class="ti ti-alert-circle"></i> {{ session('error') }}
            </div>
        @endif

        @if(session('success'))
            <div class="alert-success">
                <i class="ti ti-circle-check"></i> {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('login.post') }}" method="POST">
            @csrf

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email"
                    placeholder="email@contoh.com"
                    value="{{ old('email') }}" required>
            </div>

            <div class="form-group">
                <label>Password</label>
                <div class="input-password">
                    <input type="password" id="password" name="password"
                        placeholder="••••••••" required>
                    <button type="button" class="toggle-pass" onclick="togglePass('password', this)">
                        <i class="ti ti-eye"></i>
                    </button>
                </div>
            </div>

            <button type="submit" class="btn-login-submit">
                Masuk <i class="ti ti-arrow-right"></i>
            </button>
        </form>

        <div class="login-footer-text">
            Belum punya akun? <a href="{{ route('register') }}">Daftar gratis</a>
        </div>

    </div>
</div>
@endsection

@section('scripts')
<script>
function togglePass(id, btn) {
    const input = document.getElementById(id);
    const isPass = input.type === 'password';
    input.type = isPass ? 'text' : 'password';
    btn.innerHTML = isPass
        ? '<i class="ti ti-eye-off"></i>'
        : '<i class="ti ti-eye"></i>';
}
</script>
@endsection
