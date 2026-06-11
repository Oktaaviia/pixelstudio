<nav class="navbar">
    <a href="{{ route('home') }}" class="logo" style="text-decoration: none;">
        <div class="logo-icon">P</div>
        <div class="logo-text">pixel<span>studio</span></div>
    </a>

    <div class="nav-links">
        <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Beranda</a>
        <a href="{{ route('layanan') }}" class="{{ request()->routeIs('layanan*') ? 'active' : '' }}">Layanan</a>
        <a href="{{ route('portofolio') }}" class="{{ request()->routeIs('portofolio*') ? 'active' : '' }}">Portofolio</a>
        <a href="{{ route('home') }}#paket">Paket</a>
        <a href="{{ route('home') }}#tentang">Tentang Kami</a>
    </div>

    <div class="nav-actions">
        {{-- Tombol Switcher Tema --}}
        <button id="theme-toggle-btn"
            onclick="toggleTheme()"
            title="Ganti Tema"
            style="background: none; border: 1px solid var(--border); border-radius: 8px; padding: 7px 10px; cursor: pointer; color: var(--text-muted); transition: 0.2s; line-height: 1; margin-right: 6px;"
            onmouseover="this.style.borderColor='var(--gold)'; this.style.color='var(--gold)';"
            onmouseout="this.style.borderColor='var(--border)'; this.style.color='var(--text-muted)';">
            <i class="ti ti-moon" style="font-size: 16px; vertical-align: middle;"></i>
        </button>

        @if(session('username'))
            {{-- Link ke halaman profil --}}
            @if(strtolower(session('role')) === 'admin')
                <a href="{{ route('admin') }}" class="nav-user"
                    style="text-decoration: none; display: inline-flex; align-items: center; gap: 6px; color: #dc3545; font-weight: 500; margin-right: 14px; transition: 0.2s; font-size: 13px;"
                    onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">
                    <i class="ti ti-shield-check" style="font-size: 20px;"></i>
                    <span>{{ session('username') }}</span>
                </a>
            @else
                <a href="{{ route('pesanan') }}" class="nav-user"
                    style="text-decoration: none; display: inline-flex; align-items: center; gap: 6px; color: var(--gold); font-weight: 500; margin-right: 14px; transition: 0.2s; font-size: 13px;"
                    onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">
                    <i class="ti ti-user-circle" style="font-size: 22px;"></i>
                    <span>{{ session('username') }}</span>
                </a>
            @endif
            <a href="{{ route('logout') }}" class="btn-outline-nav">Keluar</a>
        @else
            <a href="{{ route('login') }}" class="btn-outline-nav">Masuk</a>
            <a href="{{ route('register') }}" class="btn-primary-nav">Pesan Sekarang</a>
        @endif

        {{-- Hamburger Button Mobile --}}
        <button id="mobile-menu-btn" class="mobile-menu-btn" onclick="toggleMobileMenu()" title="Menu Navigasi" style="display: none; background: none; border: 1px solid var(--border); border-radius: 8px; padding: 7px 10px; cursor: pointer; color: var(--text-muted); transition: 0.2s; line-height: 1; margin-left: 6px;">
            <i class="ti ti-menu-2" style="font-size: 16px; vertical-align: middle;"></i>
        </button>
    </div>
</nav>
