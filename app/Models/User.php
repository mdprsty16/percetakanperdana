<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // Atribut yang dapat diisi secara massal untuk pembuatan atau pembaruan pengguna
    protected $fillable = [
        'name',    // Untuk menyimpan nama lengkap pengguna
        'email',   // Untuk menyimpan alamat email unik pengguna (digunakan untuk login)
        'password',// Untuk menyimpan kata sandi ter-hash pengguna
    ];

    // Atribut yang akan disembunyikan saat model dikonversi ke array atau JSON
    protected $hidden = [
        'password',      // Untuk menyembunyikan hash kata sandi demi keamanan
        'remember_token',// Untuk menyembunyikan token 'ingat saya' demi keamanan
    ];

    // Atribut yang akan di-cast ke tipe data tertentu secara otomatis oleh Eloquent
    protected $casts = [
        'email_verified_at' => 'datetime', // Untuk mengubah timestamp verifikasi email menjadi objek datetime
        'password' => 'hashed',            // Untuk memastikan kata sandi selalu di-hash saat disimpan
        'is_admin' => 'boolean',           // Untuk mengubah nilai menjadi boolean (true/false) yang menunjukkan status admin
    ];

    // Daftar email yang dianggap sebagai admin (digunakan untuk otorisasi statis)
    protected $adminEmails = [
        'admin@example.com', // Ganti dengan email admin yang sebenarnya
        'zani@percetakan.com', // Contoh email admin lainnya
        // Tambahkan email lain di sini
    ];

    // Fungsi untuk memeriksa apakah pengguna saat ini adalah seorang administrator
    public function isAdmin(): bool
    {
        // Menggunakan atribut 'is_admin' dari model untuk menentukan hak akses admin
        return (bool) $this->is_admin;
    }

    // Alternatif: Fungsi untuk memeriksa status admin dengan membaca dari konfigurasi .env
    // Ini direkomendasikan untuk daftar email admin yang lebih panjang atau yang sering berubah.
    // Caranya: Tambahkan di .env: ADMIN_EMAILS="admin@example.com,zani@percetakan.com"
    /*
    public function isAdminByEnv(): bool
    {
        $adminEmails = explode(',', env('ADMIN_EMAILS', ''));
        return in_array($this->email, $adminEmails);
    }
    */

    // Relasi: Menunjukkan bahwa setiap pengguna (User) dapat memiliki banyak pesanan (Order)
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}