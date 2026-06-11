<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('paket', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('konsep');
            $table->string('revisi');
            $table->string('price');
            $table->text('desc')->nullable();
            $table->boolean('fitur_sumber')->default(false);
            $table->boolean('prioritas')->default(false);
            $table->boolean('featured')->default(false);
            $table->boolean('custom')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paket');
    }
};
