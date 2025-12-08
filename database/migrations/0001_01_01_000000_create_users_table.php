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
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // Default Laravel (BigInt). Lebih aman buat relation.

            $table->string('name'); // Nama lengkap (dari Google)
            $table->string('email')->unique();
            $table->string('google_id')->nullable()->unique(); // Kunci Login Google
            $table->string('password')->nullable(); // Nullable
            $table->string('avatar')->nullable(); // Foto profil dari Google

            // Custom Fields Anda
            $table->string('role')->default('member'); // member, worker, admin
            $table->decimal('balance', 15, 2)->default(0);

            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
