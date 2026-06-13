<footer class="footer">
    <div class="footer-inner">
        <div class="footer-brand">
            <div class="logo">
                <div class="logo-icon-svg">
                    <svg class="logo-svg" width="28" height="28" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="3" y="3" width="5" height="5" rx="1.2" fill="var(--purple)" />
                        <rect x="9" y="3" width="5" height="5" rx="1.2" fill="url(#logo-grad-footer)" />
                        <rect x="15" y="3" width="5" height="5" rx="1.2" fill="var(--gold)" />
                        <rect x="3" y="9" width="5" height="5" rx="1.2" fill="url(#logo-grad-footer)" />
                        <rect x="9" y="9" width="5" height="5" rx="1.2" fill="var(--purple-light)" />
                        <rect x="3" y="15" width="5" height="5" rx="1.2" fill="var(--purple)" />
                        <defs>
                            <linearGradient id="logo-grad-footer" x1="3" y1="3" x2="20" y2="20" gradientUnits="userSpaceOnUse">
                                <stop offset="0%" stop-color="var(--purple)" />
                                <stop offset="100%" stop-color="var(--gold)" />
                            </linearGradient>
                        </defs>
                    </svg>
                </div>
                <div class="logo-text">pixel<span>studio</span></div>
            </div>
            <p>Studio desain grafis profesional berbasis di Surabaya. Kami menghadirkan visual yang kuat untuk brand-mu.</p>
        </div>

        <div class="footer-links">
            <div class="footer-col">
                <h4>Layanan</h4>
                <ul>
                    <li><a href="{{ route('layanan') }}?kategori=Cetak">Poster & Flyer</a></li>
                    <li><a href="{{ route('layanan') }}?kategori=Social%20Media">Feed Instagram</a></li>
                    <li><a href="{{ route('layanan') }}?kategori=Digital">Banner Digital</a></li>
                    <li><a href="{{ route('layanan') }}?kategori=Branding">Logo & Branding</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Perusahaan</h4>
                <ul>
                    <li><a href="{{ route('home') }}#tentang">Tentang Kami</a></li>
                    <li><a href="{{ route('portofolio') }}">Portofolio</a></li>
                    <li><a href="{{ route('home') }}#kontak">Kontak</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="footer-bottom">
        © 2026 <span>PixelStudio</span> — Jasa Desain Grafis Profesional · Surabaya, Indonesia
    </div>
</footer>
