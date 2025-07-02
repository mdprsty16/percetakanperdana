<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // User yang membuat pesanan
            $table->decimal('total_amount', 12, 2); // Total harga pesanan
            $table->string('status')->default('pending'); // Status pesanan: pending, processing, completed, cancelled, failed
            $table->text('shipping_address'); // Alamat lengkap pengiriman
            $table->string('shipping_city')->nullable();
            $table->string('shipping_postal_code')->nullable();
            $table->string('customer_phone')->nullable(); // Nomor telepon pelanggan
            $table->text('customer_notes')->nullable(); // Catatan dari pelanggan
            $table->string('payment_method')->nullable(); // Metode pembayaran: bank_transfer, cod, etc.
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};