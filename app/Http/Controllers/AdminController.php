<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product; // Digunakan untuk berinteraksi dengan data produk
use App\Models\Order; // Digunakan untuk berinteraksi dengan data pesanan
use App\Models\User; // Digunakan jika ingin mengelola data pengguna dari panel admin (opsional)
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // Digunakan untuk mengelola file (misal: menyimpan/menghapus gambar produk)
use Illuminate\Support\Facades\Auth; // Digunakan untuk otentikasi (meskipun tidak langsung di method ini, bisa relevan untuk middleware)
use Illuminate\Support\Facades\DB; // Digunakan untuk operasi database yang lebih kompleks seperti transaksi

class AdminController extends Controller
{
    /**
     * Menampilkan daftar semua produk yang tersedia di sistem admin.
     * Untuk apa: Memberikan gambaran umum produk kepada administrator.
     */
    public function productsIndex()
    {
        $products = Product::all(); // Mengambil semua data produk dari database
        return view('admin.index', compact('products')); // Menampilkan view admin dengan data produk
    }

    /**
     * Menampilkan formulir untuk menambahkan produk baru.
     * Untuk apa: Menyediakan antarmuka bagi admin untuk input data produk baru.
     */
    public function productsCreate()
    {
        return view('admin.tambah'); // Menampilkan view form tambah produk
    }

    /**
     * Menyimpan data produk baru yang diinput dari formulir ke database.
     * Untuk apa: Menambahkan record produk baru secara persisten.
     */
    public function productsStore(Request $request)
    {
        // Memvalidasi data input dari request untuk memastikan integritas data
        $request->validate([
            'name' => 'required|string|max:255', // Nama produk harus diisi, berupa string, maks 255 karakter
            'description' => 'nullable|string',  // Deskripsi produk opsional, berupa string
            'price' => 'required|numeric|min:0', // Harga produk harus diisi, berupa angka, minimal 0
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Gambar produk opsional, harus gambar, format tertentu, maks 2MB
        ]);

        $imagePath = null;
        // Memeriksa apakah ada file gambar yang diunggah
        if ($request->hasFile('image')) {
            // Menyimpan file gambar ke direktori 'products' di storage publik
            $imagePath = $request->file('image')->store('products', 'public');
        }

        // Membuat record produk baru di database
        Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'image' => $imagePath ? 'storage/' . $imagePath : null, // Menyimpan path relatif gambar
        ]);

        // Mengarahkan kembali ke halaman daftar produk dengan pesan sukses
        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    /**
     * Menampilkan formulir untuk mengedit produk yang sudah ada.
     * Untuk apa: Menyediakan antarmuka bagi admin untuk memodifikasi data produk.
     */
    public function productsEdit(Product $product) // Menggunakan fitur Model Binding untuk langsung mendapatkan objek Product
    {
        return view('admin.edit', compact('product')); // Menampilkan view form edit dengan data produk yang akan diedit
    }

    /**
     * Memperbarui data produk tertentu di database.
     * Untuk apa: Mengubah informasi produk yang sudah ada.
     */
    public function productsUpdate(Request $request, Product $product) // Menggunakan Model Binding untuk produk yang akan diperbarui
    {
        // Memvalidasi data input yang diterima dari request
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validasi untuk gambar baru (jika ada)
        ]);

        // Logika untuk menghapus gambar lama dan menyimpan gambar baru jika ada perubahan gambar
        if ($request->hasFile('image')) {
            if ($product->image) {
                // Menghapus gambar lama dari storage publik
                $oldImagePath = str_replace('storage/', '', $product->image);
                Storage::disk('public')->delete($oldImagePath);
            }
            // Menyimpan gambar baru ke storage dan memperbarui path di model
            $imagePath = $request->file('image')->store('products', 'public');
            $product->image = 'storage/' . $imagePath;
        }

        // Memperbarui atribut produk dengan data dari request
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->save(); // Menyimpan perubahan ke database

        // Mengarahkan kembali ke daftar produk dengan pesan sukses
        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diperbarui!');
    }

    /**
     * Menghapus produk tertentu dari database.
     * Untuk apa: Mengeliminasi produk yang tidak lagi diinginkan dari sistem.
     */
    public function productsDestroy(Product $product) // Menggunakan Model Binding untuk produk yang akan dihapus
    {
        // Memeriksa dan menghapus gambar terkait dari storage jika ada
        if ($product->image) {
            $imagePath = str_replace('storage/', '', $product->image);
            Storage::disk('public')->delete($imagePath);
        }

        $product->delete(); // Menghapus record produk dari database

        // Mengarahkan kembali ke daftar produk dengan pesan sukses
        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil dihapus!');
    }

    // ========================================================
    // METODE UNTUK MANAJEMEN PESANAN (ADMIN)
    // ========================================================

    /**
     * Menampilkan daftar pesanan yang statusnya sedang diproses atau belum selesai (aktif) untuk admin.
     * Untuk apa: Memudahkan admin dalam memantau pesanan yang memerlukan perhatian.
     */
    public function ordersIndex()
    {
        // Mengambil pesanan yang statusnya BUKAN 'completed'
        $orders = Order::where('status', '!=', 'completed')
                        // Mengambil relasi 'user', 'items', dan 'items.product' secara eager loading untuk mengurangi query database
                        ->with('user', 'items.product')
                        ->latest() // Mengurutkan pesanan dari yang terbaru
                        ->paginate(10); // Melakukan paginasi untuk tampilan yang efisien

        return view('admin.orders.index', compact('orders')); // Menampilkan view daftar pesanan aktif
    }

    /**
     * Menampilkan formulir untuk melihat detail dan mengedit pesanan tertentu oleh admin.
     * Untuk apa: Memberikan admin kemampuan untuk memeriksa detail pesanan dan mengubah statusnya.
     */
    public function ordersEdit(Order $order) // Menggunakan Model Binding untuk pesanan yang akan diedit
    {
        $order->load('user', 'items.product'); // Memuat data relasi yang diperlukan
        return view('admin.orders.edit', compact('order')); // Menampilkan view form edit pesanan
    }

    /**
     * Memperbarui status dan estimasi tanggal pengiriman untuk pesanan tertentu oleh admin.
     * Untuk apa: Mengelola dan memperbarui progres pesanan.
     */
    public function ordersUpdate(Request $request, Order $order)
    {
        // Memvalidasi data input untuk status dan tanggal pengiriman
        $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled,failed', // Status harus salah satu dari pilihan yang ditentukan
            'estimated_delivery_date' => 'nullable|date|after_or_equal:today', // Tanggal pengiriman opsional, harus format tanggal, tidak boleh sebelum hari ini
        ]);

        $order->status = $request->status; // Memperbarui status pesanan
        $order->estimated_delivery_date = $request->estimated_delivery_date; // Memperbarui estimasi tanggal pengiriman
        $order->save(); // Menyimpan perubahan ke database

        // Mengarahkan admin ke halaman yang berbeda jika status pesanan diubah menjadi 'completed'
        if ($order->status === 'completed') {
            return redirect()->route('admin.orders.history')->with('success', 'Pesanan #'.$order->id.' berhasil diselesaikan dan masuk ke riwayat!');
        }

        // Mengarahkan kembali ke daftar pesanan aktif jika status diubah ke selain 'completed'
        return redirect()->route('admin.orders.index')->with('success', 'Pesanan #'.$order->id.' berhasil diperbarui!');
    }

    /**
     * Menampilkan daftar riwayat pesanan (dengan status 'completed') untuk admin.
     * Untuk apa: Melihat catatan pesanan yang sudah selesai atau diarsipkan.
     */
    public function ordersHistory()
    {
        // Mengambil pesanan yang statusnya 'completed'
        $orders = Order::where('status', 'completed')
                        // Memuat relasi 'user', 'items', dan 'items.product'
                        ->with('user', 'items.product')
                        ->latest() // Mengurutkan dari yang terbaru
                        ->paginate(10); // Paginasi untuk tampilan

        return view('admin.orders.history', compact('orders')); // Menampilkan view riwayat pesanan
    }

}