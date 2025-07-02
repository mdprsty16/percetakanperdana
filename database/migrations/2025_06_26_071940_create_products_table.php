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
        Schema::create('products', function (Blueprint $table) {
            $table->id(); // Auto-incrementing ID
            $table->string('name'); // Nama Produk
            $table->text('description')->nullable(); // Deskripsi Produk, bisa kosong
            $table->string('image')->nullable(); // Path gambar produk, bisa kosong
            $table->decimal('price', 10, 2); // Harga produk, 10 digit total, 2 di belakang koma
            $table->timestamps(); // created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};