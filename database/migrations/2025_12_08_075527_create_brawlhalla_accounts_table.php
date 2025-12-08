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
        Schema::create('brawlhalla_accounts', function (Blueprint $table) {
            $table->id('account_id');

            $table->string('title');
            $table->text('description');
            $table->decimal('price', 15, 2);
            $table->string('rekber_number')->nullable();
            $table->string('seller_number')->nullable();
            $table->json('image_url')->nullable();

            // Relasi ke User
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('brawlhalla_accounts');
    }
};
