<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('banners', function (Blueprint $table) {
            // Kita pakai banner_id karena di Model sudah diset primaryKey = 'banner_id'
            $table->id('banner_id');

            $table->string('title');
            $table->string('category'); // Jual Beli, Home, Promo
            $table->string('image_url');

            // Relasi ke User (siapa yang upload)
            // nullable() jaga-jaga kalau user admin dihapus, bannernya tetap aman
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('banners');
    }
};
