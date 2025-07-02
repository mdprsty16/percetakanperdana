<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    // Atribut yang dapat diisi secara massal saat membuat atau memperbarui record
    protected $fillable = [
        'user_id',                 // Untuk mengaitkan pesanan dengan pengguna yang membuat
        'total_amount',            // Untuk menyimpan total nilai keseluruhan pesanan
        'status',                  // Untuk melacak status terkini dari pesanan (misal: 'pending', 'completed')
        'estimated_delivery_date', // Untuk menyimpan perkiraan tanggal pesanan akan tiba/selesai
        'shipping_address',        // Untuk menyimpan alamat lengkap pengiriman pesanan
        'shipping_city',           // Untuk menyimpan kota tujuan pengiriman
        'shipping_postal_code',    // Untuk menyimpan kode pos area pengiriman
        'customer_phone',          // Untuk kontak pelanggan terkait pesanan
        'customer_notes',          // Untuk menyimpan catatan atau instruksi khusus dari pelanggan
        'payment_method',          // Untuk mencatat metode pembayaran yang dipilih pelanggan
    ];

    // Atribut yang akan di-cast ke tipe data tertentu secara otomatis oleh Eloquent
    protected $casts = [
        'estimated_delivery_date' => 'date', // Untuk memastikan tanggal pengiriman diperlakukan sebagai objek tanggal
    ];

    // Relasi: Menunjukkan bahwa setiap pesanan (Order) dimiliki oleh satu pengguna (User)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi: Menunjukkan bahwa setiap pesanan (Order) dapat memiliki banyak item pesanan (OrderItem)
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}