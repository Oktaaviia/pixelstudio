<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Routing\Controller as BaseController;

class PageController extends BaseController
{
    // =============================================
    // === HALAMAN PUBLIK / CUSTOMER ===
    // =============================================

    // Halaman Beranda (/)
    public function index()
    {
        $packages = DB::table('packages')->get();
        $paketList = DB::table('paket')->get();
        return view('home', compact('packages', 'paketList'));
    }

    // Halaman Katalog Layanan (/layanan)
    public function layanan()
    {
        $layanan = DB::table('packages')->get();
        return view('layanan', compact('layanan'));
    }

    // AJAX: Pencarian Layanan Real-Time (/layanan/search)
    public function searchLayanan(Request $request)
    {
        $keyword = $request->get('q', '');
        $layanan = DB::table('packages')
            ->where('name', 'like', "%{$keyword}%")
            ->orWhere('category', 'like', "%{$keyword}%")
            ->orWhere('description', 'like', "%{$keyword}%")
            ->get();
        return response()->json($layanan);
    }

    // Detail Satu Paket Layanan (/layanan/{id})
    public function detailLayanan($id)
    {
        $item = DB::table('packages')->where('id', $id)->first();
        if (!$item) {
            return redirect()->route('layanan')->with('error', 'Layanan tidak ditemukan.');
        }
        $paketList = DB::table('paket')->orderBy('id', 'asc')->get();
        return view('layanan-detail', compact('item', 'paketList'));
    }

    // Halaman Portofolio (/portofolio)
    public function portofolio()
    {
        $portofolio = DB::table('portfolios')->orderBy('id', 'desc')->get();
        return view('portofolio', compact('portofolio'));
    }

    // Detail Satu Karya Portofolio (/portofolio/{id})
    public function detailPortofolio($id)
    {
        $item = DB::table('portfolios')->where('id', $id)->first();
        if (!$item) {
            return redirect()->route('portofolio')->with('error', 'Portofolio tidak ditemukan.');
        }
        return view('portofolio-detail', compact('item'));
    }

    // =============================================
    // === AUTENTIKASI ===
    // =============================================

    // Form Login GET (/login)
    public function login()
    {
        if (session()->has('user_id')) {
            // Jika sudah login, redirect ke halaman yang sesuai
            return redirect()->route(strtolower(session('role')) === 'admin' ? 'admin' : 'home');
        }
        return view('login');
    }

    // Proses Login POST (/login)
    public function doLogin(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $user = DB::table('users')->where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->with('error', 'Email atau password salah. Silakan coba lagi.');
        }

        // Simpan data user ke session
        session([
            'user_id'      => $user->id,
            'username'     => $user->username,
            'email'        => $user->email,
            'role'         => $user->role,
            'nama_lengkap' => $user->username,
        ]);

        // Sinkronisasi cookie tema jika ada
        $theme = $request->cookie('pref_theme', 'dark');
        session(['pref_theme' => $theme]);

        // Arahkan ke halaman berdasarkan role
        if (strtolower($user->role) === 'admin') {
            return redirect()->route('admin')->with('success', 'Selamat datang, Admin!');
        }

        return redirect()->route('home')->with('success', 'Selamat datang kembali, ' . $user->username . '!');
    }

    // Form Register GET (/register)
    public function register()
    {
        if (session()->has('user_id')) {
            return redirect()->route('home');
        }
        return view('register');
    }

    // Proses Register POST (/register)
    public function submitRegister(Request $request)
    {
        $request->validate([
            'name'                  => 'required|string|min:2|max:100',
            'email'                 => 'required|email',
            'password'              => 'required|min:6|confirmed',
        ]);

        // Cek apakah email sudah terdaftar
        $emailExists = DB::table('users')->where('email', $request->email)->exists();
        if ($emailExists) {
            return back()->with('error', 'Email ini sudah terdaftar. Silakan gunakan email lain atau login.')->withInput();
        }

        // Buat username dari nama (lowercase, tanpa spasi)
        $baseUsername = strtolower(str_replace(' ', '', $request->name));
        $username     = $baseUsername;
        $counter      = 1;
        while (DB::table('users')->where('username', $username)->exists()) {
            $username = $baseUsername . $counter;
            $counter++;
        }

        DB::table('users')->insert([
            'username'   => $username,
            'email'      => $request->email,
            'password'   => Hash::make($request->password),
            'role'       => 'customer',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('login')->with('success', 'Akun berhasil dibuat! Silakan masuk menggunakan email Anda.');
    }

    // AJAX: Cek Ketersediaan Email (/api/cek-email)
    public function cekEmail(Request $request)
    {
        $email    = $request->get('email', '');
        $tersedia = !DB::table('users')->where('email', $email)->exists();
        return response()->json(['tersedia' => $tersedia]);
    }

    // Logout (/logout)
    public function logout()
    {
        session()->flush();
        return redirect()->route('login')->with('success', 'Anda telah berhasil keluar.');
    }

    // =============================================
    // === AREA CUSTOMER TERPROTEKSI ===
    // =============================================

    // Halaman Profil & Riwayat Pesanan Customer (/pesanan)
    public function pesanan()
    {
        if (!session()->has('user_id')) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $userId = session('user_id');

        $my_orders = DB::table('orders')
            ->where('user_id', $userId)
            ->orderBy('id', 'desc')
            ->get();

        return view('pesanan', compact('my_orders'));
    }

    // Halaman Profil Lama (redirect ke pesanan agar tidak 404)
    public function profile()
    {
        if (!session()->has('user_id')) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu untuk melihat profil.');
        }
        return redirect()->route('pesanan');
    }

    // Form Pemesanan GET (/order) - Harus login
    public function order()
    {
        if (!session()->has('user_id')) {
            return redirect()->route('login')->with('error', 'Anda harus login terlebih dahulu untuk memesan paket layanan.');
        }

        if (strtolower(session('role')) === 'admin') {
            return redirect()->route('admin')->with('error', 'Admin tidak dapat membuat pesanan.');
        }

        $layanan = DB::table('packages')->select('id', 'name', 'category')->get();

        $paket = DB::table('paket')->select('nama', 'price', 'custom')->get()->map(function($p) {
            return (array) $p;
        })->toArray();

        return view('order', compact('layanan', 'paket'));
    }

    // Proses Simpan Pesanan POST (/order)
    public function submitOrder(Request $request)
    {
        if (!session()->has('user_id')) {
            return redirect()->route('login');
        }

        $request->validate([
            'layanan'   => 'required|string',
            'paket'     => 'required|string',
            'brand'     => 'required|string|max:100',
            'whatsapp'  => 'required|string|max:20',
            'ukuran'    => 'required|string|max:100',
            'deskripsi' => 'required|string|min:10',
        ]);

        // Tentukan tipe order: custom atau reguler
        $tipe = strtolower($request->paket) === 'custom' ? 'custom' : 'reguler';

        // Handle upload bukti bayar (opsional untuk custom)
        $fileBukti = null;
        if ($request->hasFile('bukti_bayar') && $request->file('bukti_bayar')->isValid()) {
            $file      = $request->file('bukti_bayar');
            $namaFile  = time() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());
            $file->move(public_path('uploads/bukti'), $namaFile);
            $fileBukti = $namaFile;
        }

        DB::table('orders')->insert([
            'user_id'    => session('user_id'),
            'layanan'    => $request->layanan,
            'paket'      => $request->paket,
            'nama_brand' => $request->brand,
            'whatsapp'   => $request->whatsapp,
            'ukuran'     => $request->ukuran,
            'deadline'   => $request->deadline ?: null,
            'deskripsi'  => $request->deskripsi,
            'catatan'    => $request->catatan ?? null,
            'bukti_bayar'=> $fileBukti,
            'status'     => 'Menunggu Validasi',
            'tipe'       => $tipe,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('order.sukses')->with([
            'success_order' => true,
            'nama_brand'    => $request->brand,
            'layanan'       => $request->layanan,
            'tipe'          => $tipe,
        ]);
    }

    // Halaman Sukses Order (/order/sukses)
    public function orderSukses()
    {
        if (!session()->has('success_order')) {
            return redirect()->route('home');
        }
        return view('order-sukses');
    }

    // =============================================
    // === AREA ADMIN ===
    // =============================================

    // Middleware cek admin (dipakai di dalam method)
    private function cekAdmin()
    {
        if (!session()->has('user_id') || strtolower(session('role')) !== 'admin') {
            abort(403, 'Akses ditolak. Hanya Administrator yang dapat mengakses halaman ini.');
        }
    }

    // Dashboard Admin (/admin) — Panel utama dengan daftar pesanan
    public function admin(Request $request)
    {
        $this->cekAdmin();

        $semuaPesanan = DB::table('orders')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->select('orders.*', 'users.username as customer', 'users.email as email_customer')
            ->orderBy('orders.id', 'desc')
            ->get();

        $total_pesanan = $semuaPesanan->count();
        $menunggu      = $semuaPesanan->where('status', 'Menunggu Validasi')->count();
        $proses        = $semuaPesanan->where('status', 'Diproses')->count();
        $selesai       = $semuaPesanan->where('status', 'Selesai')->count();
        $ditolak       = $semuaPesanan->where('status', 'Ditolak')->count();

        // Filter berdasarkan status jika ada query string
        $filterStatus = $request->get('filter_status', 'semua');
        $query = DB::table('orders')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->select('orders.*', 'users.username as customer', 'users.email as email_customer')
            ->orderBy('orders.id', 'desc');

        if ($filterStatus !== 'semua') {
            $statusMap = [
                'perlu_acc' => 'Menunggu Validasi',
                'diproses'  => 'Diproses',
                'selesai'   => 'Selesai',
                'ditolak'   => 'Ditolak',
            ];
            if (isset($statusMap[$filterStatus])) {
                $query->where('orders.status', $statusMap[$filterStatus]);
            }
        }

        $pesanan = $query->get();

        return view('admin', compact('pesanan', 'total_pesanan', 'menunggu', 'proses', 'selesai', 'ditolak', 'filterStatus'));
    }

    // Update Status Pesanan (POST /admin/update-status/{id})
    public function updateStatus(Request $request, $id)
    {
        $this->cekAdmin();

        $request->validate([
            'status' => 'required|in:Menunggu Validasi,Diproses,Selesai,Ditolak',
        ]);

        DB::table('orders')->where('id', $id)->update([
            'status'     => $request->status,
            'updated_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Status pesanan #' . $id . ' berhasil diperbarui!');
    }

    // Dashboard Lama (redirect ke admin)
    public function dashboard()
    {
        $this->cekAdmin();
        return redirect()->route('admin');
    }

    // =============================================
    // === AREA PENGELOLAAN KONTEN (CRUD) ===
    // =============================================

    // Halaman Pengelolaan (/pengelolaan)
    public function pengelolaan()
    {
        $this->cekAdmin();

        $layanan    = DB::table('packages')->orderBy('id', 'desc')->get();
        $portofolio = DB::table('portfolios')->orderBy('id', 'desc')->get();
        $paketList  = DB::table('paket')->orderBy('id', 'asc')->get();

        return view('pengelolaan', compact('layanan', 'portofolio', 'paketList'));
    }

    // Halaman admin layanan (alias ke pengelolaan)
    public function adminLayanan()
    {
        return redirect()->route('pengelolaan');
    }

    // === CRUD PACKAGES ===

    public function storeLayanan(Request $request)
    {
        $this->cekAdmin();

        $request->validate([
            'name'        => 'required|string|max:100',
            'category'    => 'required|string|max:100',
            'price'       => 'required|numeric|min:0',
            'revision'    => 'nullable|integer|min:0',
            'duration'    => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'image'       => 'nullable|string|max:255',
        ]);

        DB::table('packages')->insert([
            'name'        => $request->name,
            'category'    => $request->category,
            'price'       => $request->price ?? 0,
            'revision'    => $request->revision ?? 0,
            'duration'    => $request->duration ?? null,
            'description' => $request->description ?? null,
            'image'       => $request->image ?? 'default.jpg',
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);

        return redirect()->back()->with('success', 'Layanan baru sukses ditambahkan!');
    }

    public function updateLayanan(Request $request, $id)
    {
        $this->cekAdmin();

        $request->validate([
            'name'        => 'required|string|max:100',
            'category'    => 'required|string|max:100',
            'price'       => 'required|numeric|min:0',
            'revision'    => 'nullable|integer|min:0',
            'duration'    => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'image'       => 'nullable|string|max:255',
        ]);

        DB::table('packages')->where('id', $id)->update([
            'name'        => $request->name,
            'category'    => $request->category,
            'price'       => $request->price ?? 0,
            'revision'    => $request->revision,
            'duration'    => $request->duration,
            'description' => $request->description,
            'image'       => $request->image,
            'updated_at'  => now(),
        ]);

        return redirect()->back()->with('success', 'Layanan berhasil diubah!');
    }

    public function destroyLayanan($id)
    {
        $this->cekAdmin();
        DB::table('packages')->where('id', $id)->delete();
        return redirect()->back()->with('success', 'Layanan berhasil dihapus!');
    }

    public function storePortofolio(Request $request)
    {
        $this->cekAdmin();

        $request->validate([
            'title'       => 'required|string|max:150',
            'category'    => 'required|string|max:100',
            'klien'       => 'nullable|string|max:100',
            'tahun'       => 'nullable|string|max:10',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120',
        ]);

        $fileImage = null;
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $file     = $request->file('image');
            $namaFile = time() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());
            $file->move(public_path('uploads/portfolio'), $namaFile);
            $fileImage = '/uploads/portfolio/' . $namaFile;
        }

        DB::table('portfolios')->insert([
            'title'       => $request->title,
            'category'    => $request->category,
            'klien'       => $request->klien ?? null,
            'tahun'       => $request->tahun ?? date('Y'),
            'description' => $request->description ?? null,
            'image'       => $fileImage,
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);

        return redirect()->back()->with('success', 'Portofolio baru berhasil ditambah!');
    }

    public function updatePortofolio(Request $request, $id)
    {
        $this->cekAdmin();

        $request->validate([
            'title'       => 'required|string|max:150',
            'category'    => 'required|string|max:100',
            'klien'       => 'nullable|string|max:100',
            'tahun'       => 'nullable|string|max:10',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120',
        ]);

        $porto = DB::table('portfolios')->where('id', $id)->first();
        $fileImage = $porto ? $porto->image : null;

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $file     = $request->file('image');
            $namaFile = time() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());
            $file->move(public_path('uploads/portfolio'), $namaFile);
            $fileImage = '/uploads/portfolio/' . $namaFile;
        }

        DB::table('portfolios')->where('id', $id)->update([
            'title'       => $request->title,
            'category'    => $request->category,
            'klien'       => $request->klien ?? null,
            'tahun'       => $request->tahun ?? date('Y'),
            'description' => $request->description ?? null,
            'image'       => $fileImage,
            'updated_at'  => now(),
        ]);

        return redirect()->back()->with('success', 'Portofolio sukses diperbarui!');
    }

    public function destroyPortofolio($id)
    {
        $this->cekAdmin();
        DB::table('portfolios')->where('id', $id)->delete();
        return redirect()->back()->with('success', 'Portofolio sukses dihapus!');
    }

    // =============================================
    // === THEME SWITCHER ===
    // =============================================

    // Simpan preferensi tema ke cookie (POST /tema)
    public function saveTema(Request $request)
    {
        $tema = $request->get('tema', 'dark');
        $tema = in_array($tema, ['dark', 'light']) ? $tema : 'dark';

        return response()->json(['ok' => true, 'tema' => $tema])
            ->cookie('pref_theme', $tema, 60 * 24 * 365); // Simpan 1 tahun
    }

    // === CRUD PAKET (PRICING PLANS) ===

    public function storePaket(Request $request)
    {
        $this->cekAdmin();

        $request->validate([
            'nama'   => 'required|string|max:100',
            'konsep' => 'required|string|max:100',
            'revisi' => 'required|string|max:100',
            'price'  => 'required|string|max:100',
            'desc'   => 'nullable|string',
        ]);

        DB::table('paket')->insert([
            'nama'         => $request->nama,
            'konsep'       => $request->konsep,
            'revisi'       => $request->revisi,
            'price'        => $request->price,
            'desc'         => $request->desc,
            'fitur_sumber' => $request->has('fitur_sumber'),
            'prioritas'    => $request->has('prioritas'),
            'featured'     => $request->has('featured'),
            'custom'       => $request->has('custom'),
            'created_at'   => now(),
            'updated_at'   => now(),
        ]);

        return redirect()->back()->with('success', 'Paket baru sukses ditambahkan!');
    }

    public function updatePaket(Request $request, $id)
    {
        $this->cekAdmin();

        $request->validate([
            'nama'   => 'required|string|max:100',
            'konsep' => 'required|string|max:100',
            'revisi' => 'required|string|max:100',
            'price'  => 'required|string|max:100',
            'desc'   => 'nullable|string',
        ]);

        DB::table('paket')->where('id', $id)->update([
            'nama'         => $request->nama,
            'konsep'       => $request->konsep,
            'revisi'       => $request->revisi,
            'price'        => $request->price,
            'desc'         => $request->desc,
            'fitur_sumber' => $request->has('fitur_sumber'),
            'prioritas'    => $request->has('prioritas'),
            'featured'     => $request->has('featured'),
            'custom'       => $request->has('custom'),
            'updated_at'   => now(),
        ]);

        return redirect()->back()->with('success', 'Paket berhasil diubah!');
    }

    public function destroyPaket($id)
    {
        $this->cekAdmin();
        DB::table('paket')->where('id', $id)->delete();
        return redirect()->back()->with('success', 'Paket berhasil dihapus!');
    }
}