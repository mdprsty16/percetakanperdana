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
        Schema::table('orders', function (Blueprint $table) {
            // Menambahkan kolom 'estimated_delivery_date'
            // Bertipe 'date', bisa null, dan diletakkan setelah kolom 'status'
            $table->date('estimated_delivery_date')->nullable()->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Menghapus kolom 'estimated_delivery_date' jika migrasi di-rollback
            $table->dropColumn('estimated_delivery_date');
        });
    }
};