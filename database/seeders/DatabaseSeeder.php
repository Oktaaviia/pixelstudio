<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     * Jalankan: php artisan db:seed
     */
    public function run(): void
    {
        // === ADMIN ACCOUNT ===
        // Email: admin@pixelstudio.com | Password: admin123
        DB::table('users')->insertOrIgnore([
            'username'   => 'admin',
            'email'      => 'admin@pixelstudio.com',
            'password'   => Hash::make('admin123'),
            'role'       => 'admin',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // === SAMPLE CUSTOMER ACCOUNT ===
        // Email: user@pixelstudio.com | Password: user123
        DB::table('users')->insertOrIgnore([
            'username'   => 'customer_demo',
            'email'      => 'user@pixelstudio.com',
            'password'   => Hash::make('user123'),
            'role'       => 'customer',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // === SAMPLE PACKAGES ===
        $packages = [
            [
                'name'        => 'Desain Poster & Flyer',
                'category'    => 'Cetak',
                'price'       => 150000,
                'revision'    => 3,
                'duration'    => '2-3 Hari',
                'description' => 'Desain poster dan flyer profesional untuk promosi bisnis, event, atau produk Anda.',
                'image'       => 'default.jpg',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'name'        => 'Feed Instagram & Story',
                'category'    => 'Social Media',
                'price'       => 200000,
                'revision'    => 5,
                'duration'    => '1-2 Hari',
                'description' => 'Konten feed dan story Instagram yang menarik untuk meningkatkan engagement brand Anda.',
                'image'       => 'default.jpg',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'name'        => 'Logo & Brand Identity',
                'category'    => 'Branding',
                'price'       => 500000,
                'revision'    => 10,
                'duration'    => '5-7 Hari',
                'description' => 'Pembuatan logo profesional dan identitas visual lengkap untuk brand Anda.',
                'image'       => 'default.jpg',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'name'        => 'Banner Digital',
                'category'    => 'Digital',
                'price'       => 120000,
                'revision'    => 3,
                'duration'    => '1-2 Hari',
                'description' => 'Desain banner digital untuk website, marketplace, dan platform digital lainnya.',
                'image'       => 'default.jpg',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'name'        => 'Desain Packaging',
                'category'    => 'Packaging',
                'price'       => 350000,
                'revision'    => 5,
                'duration'    => '3-5 Hari',
                'description' => 'Desain kemasan produk yang menarik dan informatif untuk meningkatkan nilai jual.',
                'image'       => 'default.jpg',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
        ];

        foreach ($packages as $pkg) {
            DB::table('packages')->insertOrIgnore($pkg);
        }

        // === SAMPLE PORTFOLIOS ===
        $portfolios = [
            [
                'title'       => 'Rebrand Kopi Anak Muda',
                'category'    => 'Branding',
                'klien'       => 'Kopi Anak Muda',
                'tahun'       => '2025',
                'description' => 'Proyek rebranding lengkap termasuk logo baru, warna brand, dan panduan penggunaan visual.',
                'image'       => '/images/porto_kopi.png',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'title'       => 'Kampanye Social Media Batik Nusantara',
                'category'    => 'Social Media',
                'klien'       => 'Batik Nusantara',
                'tahun'       => '2025',
                'description' => 'Desain konten media sosial untuk kampanye promosi produk batik premium.',
                'image'       => '/images/porto_batik.png',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'title'       => 'Packaging Produk Skincare Lumière',
                'category'    => 'Packaging',
                'klien'       => 'Lumière Skincare',
                'tahun'       => '2024',
                'description' => 'Desain kemasan produk skincare premium dengan nuansa elegan dan modern.',
                'image'       => '/images/porto_skincare.png',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
        ];

        foreach ($portfolios as $porto) {
            DB::table('portfolios')->insertOrIgnore($porto);
        }

        // === SAMPLE PAKET ===
        $paket = [
            [
                'nama'         => 'Starter',
                'konsep'       => '1',
                'revisi'       => '2x',
                'price'        => 'Rp 150.000',
                'desc'         => 'Cocok untuk kebutuhan desain sederhana dan personal.',
                'fitur_sumber' => false,
                'prioritas'    => false,
                'featured'     => false,
                'custom'       => false,
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'nama'         => 'Professional',
                'konsep'       => '3',
                'revisi'       => '5x',
                'price'        => 'Rp 350.000',
                'desc'         => 'Pilihan terbaik untuk bisnis yang sedang berkembang.',
                'fitur_sumber' => true,
                'prioritas'    => false,
                'featured'     => true,
                'custom'       => false,
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'nama'         => 'Premium',
                'konsep'       => 'Unlimited',
                'revisi'       => 'Unlimited',
                'price'        => 'Rp 750.000',
                'desc'         => 'Solusi desain lengkap untuk brand profesional.',
                'fitur_sumber' => true,
                'prioritas'    => true,
                'featured'     => false,
                'custom'       => false,
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'nama'         => 'Custom',
                'konsep'       => 'Sesuai Kebutuhan',
                'revisi'       => 'Negosiasi',
                'price'        => 'Harga Negosiasi',
                'desc'         => 'Kebutuhan unik? Diskusikan langsung bersama tim kami.',
                'fitur_sumber' => true,
                'prioritas'    => true,
                'featured'     => false,
                'custom'       => true,
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
        ];

        foreach ($paket as $p) {
            DB::table('paket')->insertOrIgnore($p);
        }
    }
}

