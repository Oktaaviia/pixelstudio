<!DOCTYPE html>
<html lang="id" data-theme="{{ session('pref_theme', cookie('pref_theme') ?? 'dark') }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- CSRF Token untuk AJAX request --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'PixelStudio — Jasa Desain Grafis')</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body>

    {{-- Navbar --}}
    <x-navbar />

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="flash-msg flash-success">
            <i class="ti ti-circle-check"></i> {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="flash-msg flash-error">
            <i class="ti ti-alert-circle"></i> {{ session('error') }}
        </div>
    @endif

    {{-- Konten Utama --}}
    <main>
        @yield('content')
    </main>

    {{-- Footer --}}
    <x-footer />

    {{-- Script Cuaca (untuk badge di hero) --}}
    <script src="{{ asset('js/weather.js') }}"></script>

    {{-- Theme Switcher — Dark/Light Mode --}}
    <script>
    (function() {
        // Baca tema dari localStorage (lebih cepat dari cookie)
        const storedTheme = localStorage.getItem('pref_theme') || '{{ session("pref_theme", "dark") }}';
        document.documentElement.setAttribute('data-theme', storedTheme);
        // Sinkronisasi ke cookie
        document.cookie = 'pref_theme=' + storedTheme + '; path=/; max-age=' + (60 * 60 * 24 * 365);
    })();

    function toggleTheme() {
        const html     = document.documentElement;
        const current  = html.getAttribute('data-theme') || 'dark';
        const newTheme = current === 'dark' ? 'light' : 'dark';

        // Terapkan ke DOM
        html.setAttribute('data-theme', newTheme);

        // Simpan ke localStorage & cookie
        localStorage.setItem('pref_theme', newTheme);
        document.cookie = 'pref_theme=' + newTheme + '; path=/; max-age=' + (60 * 60 * 24 * 365);

        // Kirim ke server via fetch
        fetch('{{ route("tema.save") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
            body: JSON.stringify({ tema: newTheme }),
        }).catch(() => {});

        updateThemeIcon(newTheme);
    }

    function updateThemeIcon(theme) {
        const btn = document.getElementById('theme-toggle-btn');
        if (!btn) return;
        const icon = btn.querySelector('i');
        if (icon) {
            icon.className = theme === 'dark' ? 'ti ti-sun' : 'ti ti-moon';
        }
        btn.title = theme === 'dark' ? 'Ganti ke Mode Terang' : 'Ganti ke Mode Gelap';
    }

    function toggleMobileMenu() {
        const navLinks = document.querySelector('.nav-links');
        if (!navLinks) return;
        navLinks.classList.toggle('active');
        const icon = document.querySelector('#mobile-menu-btn i');
        if (icon) {
            if (navLinks.classList.contains('active')) {
                icon.className = 'ti ti-x';
            } else {
                icon.className = 'ti ti-menu-2';
            }
        }
    }

    // Saat DOM siap
    document.addEventListener('DOMContentLoaded', function() {
        const currentTheme = localStorage.getItem('pref_theme') || 'dark';
        updateThemeIcon(currentTheme);

        // Auto-dismiss flash messages setelah 4 detik
        document.querySelectorAll('.flash-msg').forEach(function(el) {
            setTimeout(function() {
                el.style.opacity = '0';
                setTimeout(function() { el.remove(); }, 500);
            }, 4000);
        });
    });
    </script>

    @yield('scripts')

</body>
</html>
