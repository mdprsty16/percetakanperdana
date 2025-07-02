<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Models\Product; // Pastikan untuk mengimpor model Product
use App\Http\Controllers\AdminController; // Import AdminController
use App\Http\Controllers\OrderController; // Import OrderController

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route untuk halaman utama (welcome page)
Route::get('/', function () {
    $products = Product::all();
    return view('welcome', compact('products'));
});

// Route untuk Dashboard, dilindungi oleh middleware 'auth' dan 'verified'
Route::get('/dashboard', function () {
    $products = Product::all(); // Mengambil semua produk untuk ditampilkan di dashboard user
    return view('dashboard', compact('products'));
})->middleware(['auth', 'verified'])->name('dashboard');

// Grup Route yang memerlukan otentikasi (auth) untuk fungsionalitas umum
Route::middleware('auth')->group(function () {
    // Route untuk manajemen profil user (dari Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ========================================================
    // ROUTES UNTUK MANAJEMEN PRODUK DAN PESANAN (ADMIN)
    // ========================================================
    Route::prefix('admin')->name('admin.')->middleware('is_admin')->group(function () {
        // ... (routes produk admin: index, create, store, edit, update, destroy) ...
        Route::get('products', [AdminController::class, 'productsIndex'])->name('products.index');
        Route::get('products/create', [AdminController::class, 'productsCreate'])->name('products.create');
        Route::post('products', [AdminController::class, 'productsStore'])->name('products.store');
        Route::get('products/{product}/edit', [AdminController::class, 'productsEdit'])->name('products.edit');
        Route::put('products/{product}', [AdminController::class, 'productsUpdate'])->name('products.update');
        Route::delete('products/{product}', [AdminController::class, 'productsDestroy'])->name('products.destroy');

        // ========================================================
        // ROUTES UNTUK MANAJEMEN PESANAN (ADMIN)
        // ========================================================
        Route::get('orders', [AdminController::class, 'ordersIndex'])->name('orders.index'); // Daftar semua pesanan aktif
        Route::get('orders/{order}/edit', [AdminController::class, 'ordersEdit'])->name('orders.edit'); // Form edit pesanan
        Route::put('orders/{order}', [AdminController::class, 'ordersUpdate'])->name('orders.update'); // Update pesanan
        // Route::delete('orders/{order}', [AdminController::class, 'ordersDestroy'])->name('orders.destroy'); // Opsional: Hapus pesanan

        // >>> INI ADALAH ROUTE UNTUK RIWAYAT PESANAN ADMIN <<<
        Route::get('orders/history', [AdminController::class, 'ordersHistory'])->name('orders.history'); // Daftar riwayat pesanan (status 'completed')
    });

    // ========================================================
    // ROUTES UNTUK PEMESANAN (ORDER) - FORM BUAT PESANAN DAN LIHAT PESANAN SAYA
    // ========================================================
    Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create'); // Menampilkan form pemesanan
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store'); // Memproses dan menyimpan pesanan
    Route::get('/my-orders', [OrderController::class, 'myOrders'])->name('orders.my'); // ROUTE PESANAN SAYA

    // >>> INI ADALAH ROUTE UNTUK RIWAYAT PESANAN PENGGUNA <<<
    Route::get('/orders/completed', [OrderController::class, 'completedOrders'])->name('orders.completed');
});

// Route otentikasi Breeze (login, register, dll.)
require __DIR__.'/auth.php';