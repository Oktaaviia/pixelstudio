# PixelStudio — Sistem Manajemen Jasa Desain Grafis

Aplikasi web manajemen jasa desain grafis berbasis Laravel 11, dirancang sebagai platform pemesanan layanan desain online dengan sistem autentikasi berbasis **Session & Cookie**, fitur komunikasi asinkronus **AJAX/JSON**, dan panel administrasi lengkap.

---

## 📋 Gambaran Sistem

PixelStudio adalah platform B2C (Business-to-Customer) yang menghubungkan klien desain dengan tim PixelStudio. Sistem ini memiliki dua peran utama: **Customer** dan **Admin**.

---

## 🗃️ Arsitektur Sistem

```
pixelstudio/
├── app/Http/Controllers/
│   └── PageController.php       # Single controller untuk semua halaman & API
├── routes/
│   └── web.php                  # Definisi semua route aplikasi
├── database/
│   ├── migrations/              # Struktur tabel database
│   └── seeders/DatabaseSeeder.php  # Data awal (admin, paket, portofolio)
├── resources/views/
│   ├── layouts/app.blade.php    # Template utama (navbar, flash, footer)
│   ├── components/
│   │   ├── navbar.blade.php     # Navbar adaptif (login state + theme toggle)
│   │   └── footer.blade.php     # Footer
│   ├── home.blade.php           # Halaman beranda (hero + paket + tentang)
│   ├── layanan.blade.php        # Katalog layanan + AJAX search real-time
│   ├── layanan-detail.blade.php # Detail satu paket layanan
│   ├── portofolio.blade.php     # Grid portofolio karya
│   ├── portofolio-detail.blade.php # Detail satu karya portofolio
│   ├── login.blade.php          # Form login
│   ├── register.blade.php       # Form registrasi + AJAX cek email
│   ├── order.blade.php          # Form pemesanan desain
│   ├── order-sukses.blade.php   # Konfirmasi sukses pesanan
│   ├── pesanan.blade.php        # Profil & riwayat pesanan customer
│   ├── admin.blade.php          # Panel admin — manajemen antrean pesanan
│   └── pengelolaan.blade.php    # CRUD layanan (packages) & portofolio
└── public/
    ├── css/style.css            # CSS custom dengan Dark/Light Mode
    └── js/weather.js            # Fetch cuaca real-time (wttr.in API)
```

---

## 🚀 Cara Instalasi & Menjalankan

### Prasyarat
- PHP >= 8.2
- Composer
- MySQL / MariaDB
- Node.js (opsional, untuk asset build)

### Langkah Instalasi

```bash
# 1. Clone atau ekstrak project
cd d:/www/ps2/pixelstudio

# 2. Install dependensi PHP
composer install

# 3. Salin file environment
copy .env.example .env   # Windows
# atau
cp .env.example .env     # Linux/Mac

# 4. Generate application key
php artisan key:generate

# 5. Konfigurasi database di .env
#    DB_DATABASE=pixelstudio
#    DB_USERNAME=root
#    DB_PASSWORD=

# 6. Jalankan migrasi database
php artisan migrate

# 7. Seed data awal (admin, paket, portofolio)
php artisan db:seed

# 8. Jalankan server development
php artisan serve --port=8000
```

### Akses Aplikasi
Buka browser: `http://127.0.0.1:8000`

---

## 👤 Akun Default (Setelah Seeding)

| Role     | Email                      | Password  |
|----------|----------------------------|-----------|
| Admin    | admin@pixelstudio.com      | admin123  |
| Customer | user@pixelstudio.com       | user123   |

---

## 🗄️ Struktur Database

### Tabel `users`
| Kolom      | Tipe         | Keterangan               |
|------------|--------------|--------------------------|
| id         | bigint (PK)  | Primary key autoincrement |
| username   | varchar(255) | Unique                   |
| email      | varchar(255) | Unique                   |
| password   | varchar(255) | Hashed (bcrypt)          |
| role       | varchar      | `admin` / `customer`     |
| timestamps | —            | created_at, updated_at   |

### Tabel `packages`
| Kolom       | Tipe          | Keterangan              |
|-------------|---------------|-------------------------|
| id          | bigint (PK)   |                         |
| name        | varchar(255)  | Nama paket layanan      |
| category    | varchar(255)  | Kategori desain         |
| price       | decimal(12,2) | Harga                   |
| revision    | int           | Jumlah revisi           |
| duration    | varchar(255)  | Estimasi durasi         |
| description | text          | Deskripsi layanan       |
| image       | varchar       | Nama file gambar        |
| timestamps  | —             |                         |

### Tabel `portfolios`
| Kolom       | Tipe         | Keterangan              |
|-------------|--------------|-------------------------|
| id          | bigint (PK)  |                         |
| title       | varchar(255) | Judul karya             |
| category    | varchar(255) | Kategori                |
| klien       | varchar(255) | Nama klien              |
| tahun       | varchar(10)  | Tahun pengerjaan        |
| description | text         | Deskripsi karya         |
| image       | varchar      | Nama file gambar        |
| timestamps  | —            |                         |

### Tabel `orders`
| Kolom       | Tipe         | Keterangan              |
|-------------|--------------|-------------------------|
| id          | bigint (PK)  |                         |
| user_id     | bigint (FK)  | Referensi ke users      |
| layanan     | varchar      | Jenis layanan dipilih   |
| paket       | varchar      | Paket dipilih           |
| nama_brand  | varchar      | Nama brand/project      |
| whatsapp    | varchar      | Nomor WA customer       |
| deskripsi   | text         | Brief desain            |
| ukuran      | varchar      | Dimensi/ukuran desain   |
| deadline    | date         | Target selesai          |
| catatan     | text         | Catatan tambahan        |
| status      | varchar      | `Menunggu Validasi` / `Diproses` / `Selesai` |
| bukti_bayar | varchar      | File bukti transfer     |
| tipe        | varchar      | `reguler` / `custom`    |
| timestamps  | —            |                         |

---

## 🔄 Alur Sistem

### Alur Customer
```
Beranda → Lihat Katalog Layanan → Cari (AJAX) → Detail Paket
    ↓ (klik Pesan Sekarang)
Redirect ke Login (jika belum login)
    ↓ Login / Register
Form Pemesanan → Submit → Halaman Sukses → WhatsApp Admin
    ↓
Dashboard Pesanan (pantau status)
```

### Alur Admin
```
Login → Panel Admin (daftar semua pesanan)
    ↓ Klik "Ubah Status" (select dropdown → auto-submit)
Status diperbarui (Menunggu Validasi → Diproses → Selesai)
    ↓
Pengelolaan Konten → CRUD Layanan (packages) & Portofolio
```

---

## ⚡ Fitur Teknis Utama

### 1. HTML & CSS — Tampilan Frontend
- Struktur HTML5 semantik (`<nav>`, `<main>`, `<section>`, `<footer>`)
- CSS Custom Properties untuk Dark/Light Mode
- Layout responsif menggunakan CSS Grid & Flexbox
- Animasi mikro: hover card, fade-in modal, slide-in flash message
- Glassmorphism & gradient pada elemen premium

### 2. JavaScript & DOM Manipulation
- Validasi form client-side (order form) dengan `e.preventDefault()`
- Toggle tampilan dinamis (seksi pembayaran muncul/hilang berdasarkan pilihan paket)
- Modal detail pesanan — baca data JSON dari atribut dan tampilkan ke DOM
- Toggle password visibility
- Real-time feedback konfirmasi password (match/tidak match)
- Auto-dismiss flash message setelah 4 detik

### 3. Backend PHP & CRUD Database
- **MVC Pattern** via Laravel: Controller → DB Query → View
- **CRUD Packages**: Create, Read, Update, Delete paket layanan
- **CRUD Portfolios**: Create, Read, Update, Delete karya portofolio
- **Orders**: Create (customer) + Update status (admin)
- **Auth**: Register (hash password bcrypt) + Login (verify hash)
- Validasi server-side menggunakan `$request->validate()`

### 4. Cookies & Session (Autentikasi)
- Login menyimpan data ke **Laravel Session**: `user_id`, `username`, `email`, `role`
- Halaman terproteksi cek `session()->has('user_id')` sebelum render
- Admin-only area cek `session('role') === 'admin'`
- Logout melakukan `session()->flush()` + redirect
- **Cookie** `pref_theme` disimpan selama 1 tahun untuk preferensi tema

### 5. Komunikasi Asinkronus (AJAX/JSON)
- **Pencarian Layanan Real-Time** (`GET /layanan/search?q=...`)
  - JavaScript Fetch API mengirim request saat pengguna mengetik
  - Server merespons JSON array `[{id, name, category, ...}]`
  - JavaScript memperbarui DOM tanpa reload halaman
- **Cek Ketersediaan Email** saat Register (`GET /api/cek-email?email=...`)
  - Debounce 500ms sebelum request dikirim
  - Respons JSON `{tersedia: true/false}` ditampilkan ke user
- **Simpan Preferensi Tema** (`POST /tema`)
  - Fetch POST dengan body JSON `{tema: "dark"|"light"}`
  - Server menyimpan ke cookie, response JSON `{ok: true}`

### 6. Kualitas Kode & Dokumentasi
- Kode terstruktur dalam satu controller (`PageController.php`) dengan method terpisah
- Setiap method diberi komentar tujuan dan endpoint terkait
- Variabel dalam Bahasa Indonesia yang deskriptif
- Blade template terorganisir dalam folder `views/` dan `components/`
- README ini mendokumentasikan seluruh sistem secara komprehensif

---

## 🌗 Dark Mode / Light Mode

Sistem tema menggunakan kombinasi:
1. **CSS Custom Properties** — semua warna didefinisikan dalam `:root` dan `[data-theme="light"]`
2. **`data-theme` attribute** pada tag `<html>` — diperbarui oleh JavaScript
3. **`localStorage`** — penyimpanan primer (cepat, persisten lintas halaman)
4. **Cookie `pref_theme`** — sinkronisasi ke server-side rendering Laravel
5. **Toggle button** di navbar — memanggil `toggleTheme()` dengan ikon matahari/bulan

---

## 📁 Upload File

File bukti transfer pembayaran disimpan di:
```
public/uploads/bukti/
```
Format yang didukung: JPG, JPEG, PNG (maks. 2MB)

---

## 🐛 Debug

Dalam mode `APP_ENV=local`, tersedia endpoint debug:
```
GET /debug-session
```
Mengembalikan data session aktif dalam format JSON.
