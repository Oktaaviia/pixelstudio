<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('layanan');
            $table->string('paket');
            $table->string('nama_brand');
            $table->string('whatsapp');
            $table->text('deskripsi');
            $table->string('ukuran');
            $table->date('deadline')->nullable();
            $table->text('catatan')->nullable();
            $table->string('status')->default('Menunggu Validasi');
            $table->string('bukti_bayar')->nullable(); // Sudah masuk di sini sekalian
            $table->string('tipe')->default('reguler');
            $table->timestamps();
            
            // Jika kamu pakai foreign key ke tabel users, aktifkan baris bawah ini:
            // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
