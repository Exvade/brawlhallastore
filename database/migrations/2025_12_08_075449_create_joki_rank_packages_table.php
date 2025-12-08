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
        Schema::create('joki_rank_packages', function (Blueprint $table) {
            // Menggunakan custom ID sesuai request
            $table->id('package_id');

            $table->string('name');
            $table->decimal('price', 15, 2);
            $table->string('icon_url')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('joki_rank_packages');
    }
};
