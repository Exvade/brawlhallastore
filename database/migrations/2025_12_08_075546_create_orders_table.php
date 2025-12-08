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
        Schema::create('orders', function (Blueprint $table) {
            $table->id('order_id'); // Custom Primary Key

            // Relasi ke User Pembeli
            $table->foreignId('user_id')->constrained('users');

            // Package ID (Bisa dari Rank atau Battlepass)
            // Kita pakai unsignedBigInteger biasa karena tidak bisa constrain ke 2 tabel berbeda sekaligus
            $table->unsignedBigInteger('package_id');

            $table->string('service_type'); // 'rank', 'battlepass', 'account'
            $table->decimal('amount', 15, 2);
            $table->string('payment_status')->default('pending');

            // Worker (Nullable, diisi saat "Take Order")
            $table->foreignId('worker_id')->nullable()->constrained('users');

            // Data akun user yang mau dijoki
            $table->text('account_credentials')->nullable();
            $table->string('contact')->nullable();
            $table->string('midtrans_order_id')->nullable();

            $table->string('work_status')->default('pending'); // pending, on_progress, done
            $table->boolean('queued_notified')->default(false);

            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
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
