<nav class="navbar">
    <a href="{{ route('home') }}" class="logo" style="text-decoration: none;">
        <div class="logo-icon-svg">
            <svg class="logo-svg" width="28" height="28" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect x="3" y="3" width="5" height="5" rx="1.2" fill="var(--purple)" />
                <rect x="9" y="3" width="5" height="5" rx="1.2" fill="url(#logo-grad)" />
                <rect x="15" y="3" width="5" height="5" rx="1.2" fill="var(--gold)" />
                <rect x="3" y="9" width="5" height="5" rx="1.2" fill="url(#logo-grad)" />
                <rect x="9" y="9" width="5" height="5" rx="1.2" fill="var(--purple-light)" />
                <rect x="3" y="15" width="5" height="5" rx="1.2" fill="var(--purple)" />
                <defs>
                    <linearGradient id="logo-grad" x1="3" y1="3" x2="20" y2="20" gradientUnits="userSpaceOnUse">
                        <stop offset="0%" stop-color="var(--purple)" />
                        <stop offset="100%" stop-color="var(--gold)" />
                    </linearGradient>
                </defs>
            </svg>
        </div>
        <div class="logo-text">pixel<span>studio</span></div>
    </a>

    <div class="nav-links">
        <a href="{{ route('home') }}" id="nav-link-home" class="{{ request()->routeIs('home') ? 'active' : '' }}">Beranda</a>
        <a href="{{ route('layanan') }}" id="nav-link-layanan" class="{{ request()->routeIs('layanan*') ? 'active' : '' }}">Layanan</a>
        <a href="{{ route('portofolio') }}" id="nav-link-portofolio" class="{{ request()->routeIs('portofolio*') ? 'active' : '' }}">Portofolio</a>
        <a href="{{ route('home') }}#paket" id="nav-link-paket">Paket</a>
        <a href="{{ route('home') }}#tentang" id="nav-link-tentang">Tentang Kami</a>
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
