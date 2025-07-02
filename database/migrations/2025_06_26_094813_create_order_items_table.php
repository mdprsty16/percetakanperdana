<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade'); // Link ke tabel orders
            $table->foreignId('product_id')->constrained()->onDelete('cascade'); // Link ke produk yang dipesan
            $table->integer('quantity');
            $table->decimal('price_per_unit', 10, 2); // Harga produk saat dipesan
            $table->decimal('subtotal', 12, 2); // (quantity * price_per_unit)
            $table->string('design_file')->nullable(); // Path ke file desain yang diunggah
            $table->text('item_notes')->nullable(); // Catatan spesifik untuk item ini (misal: warna, ukuran custom)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};