<?php

namespace App\Http\Controllers;

use App\Models\Product; // Digunakan untuk mengambil detail produk
use App\Models\Order; // Digunakan untuk membuat dan mengelola pesanan utama
use App\Models\OrderItem; // Digunakan untuk membuat dan mengelola item-item dalam pesanan
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Digunakan untuk mendapatkan ID pengguna yang sedang login
use Illuminate\Support\Facades\DB; // Digunakan untuk menjalankan transaksi database
use Illuminate\Support\Facades\Storage; // Digunakan untuk mengelola penyimpanan file (misal: file desain)

class OrderController extends Controller
{
    /**
     * Menampilkan formulir bagi pengguna untuk membuat pesanan baru berdasarkan produk tertentu.
     * Untuk apa: Memungkinkan pelanggan memilih produk dan mengisi detail pemesanan.
     */
    public function create(Request $request)
    {
        $productId = $request->query('product_id'); // Mengambil ID produk dari query parameter URL

        // Mengarahkan kembali jika tidak ada produk yang dipilih
        if (!$productId) {
            return redirect()->back()->with('error', 'Produk tidak ditemukan untuk dipesan.');
        }

        $product = Product::findOrFail($productId); // Mencari produk berdasarkan ID atau menampilkan error 404

        $user = Auth::user(); // Mendapatkan data pengguna yang sedang login
        // Mengisi nilai default untuk formulir dari data profil pengguna (jika ada)
        $defaultAddress = $user->shipping_address ?? '';
        $defaultCity = $user->shipping_city ?? '';
        $defaultPostalCode = $user->shipping_postal_code ?? '';
        $defaultPhone = $user->phone ?? '';

        // Menampilkan view form pemesanan dengan data produk dan informasi default pengguna
        return view('orders.create', compact('product', 'user', 'defaultAddress', 'defaultCity', 'defaultPostalCode', 'defaultPhone'));
    }

    /**
     * Menyimpan data pesanan baru beserta item-itemnya ke database.
     * Untuk apa: Memproses dan menyimpan pesanan yang dibuat oleh pelanggan.
     */
    public function store(Request $request)
    {
        // Memvalidasi semua data input dari formulir pemesanan
        $request->validate([
            'product_id' => 'required|exists:products,id', // ID produk harus ada dan valid
            'quantity' => 'required|integer|min:1',       // Kuantitas harus diisi, bilangan bulat, minimal 1
            'shipping_address' => 'required|string|max:255', // Alamat pengiriman harus diisi
            'shipping_city' => 'required|string|max:255',    // Kota pengiriman harus diisi
            'shipping_postal_code' => 'required|string|max:10',// Kode pos harus diisi
            'customer_phone' => 'required|string|max:20',    // Nomor telepon harus diisi
            'design_file' => 'nullable|file|mimes:jpeg,png,jpg,pdf,ai,cdr,psd|max:5048', // File desain opsional, format tertentu, maks 5MB
            'item_notes' => 'nullable|string|max:500',       // Catatan per item opsional
            'customer_notes' => 'nullable|string|max:500',   // Catatan umum pelanggan opsional
            'payment_method' => 'required|in:bank_transfer,cod', // Metode pembayaran harus dipilih dari opsi yang ada
        ]);

        $product = Product::findOrFail($request->product_id); // Mengambil detail produk yang dipesan
        $quantity = $request->quantity;                          // Kuantitas produk
        $pricePerUnit = $product->price;                         // Harga per unit produk
        $subtotalItem = $quantity * $pricePerUnit;               // Subtotal untuk item ini
        $totalAmount = $subtotalItem;                            // Total keseluruhan pesanan (untuk 1 item saja)

        DB::beginTransaction(); // Memulai transaksi database untuk memastikan atomisitas (semua berhasil/semua gagal)

        try {
            // Membuat record pesanan utama di tabel 'orders'
            $order = Order::create([
                'user_id' => Auth::id(),                     // Mengaitkan dengan ID pengguna yang login
                'total_amount' => $totalAmount,              // Mengisi total harga pesanan
                'status' => 'pending',                       // Mengatur status awal pesanan menjadi 'pending'
                'shipping_address' => $request->shipping_address,
                'shipping_city' => $request->shipping_city,
                'shipping_postal_code' => $request->shipping_postal_code,
                'customer_phone' => $request->customer_phone,
                'customer_notes' => $request->customer_notes,
                'payment_method' => $request->payment_method,
            ]);

            $designFilePath = null;
            // Memeriksa apakah ada file desain yang diunggah
            if ($request->hasFile('design_file')) {
                // Menyimpan file desain ke direktori 'designs' di storage publik
                $designFilePath = $request->file('design_file')->store('designs', 'public');
            }

            // Membuat record item pesanan di tabel 'order_items'
            OrderItem::create([
                'order_id' => $order->id,                         // Mengaitkan item dengan pesanan utama
                'product_id' => $product->id,                     // Mengaitkan item dengan produk yang dipesan
                'quantity' => $quantity,                          // Kuantitas item
                'price_per_unit' => $pricePerUnit,                // Harga per unit saat pesanan dibuat
                'subtotal' => $subtotalItem,                      // Subtotal untuk item ini
                'design_file' => $designFilePath ? 'storage/' . $designFilePath : null, // Menyimpan path file desain
                'item_notes' => $request->item_notes,             // Catatan khusus untuk item ini
            ]);

            DB::commit(); // Menyimpan semua perubahan ke database jika tidak ada error

            // Mengarahkan pelanggan ke dashboard dengan pesan sukses
            return redirect()->route('dashboard')->with('success', 'Pesanan Anda berhasil dibuat! Kami akan segera memprosesnya.');
        } catch (\Exception $e) {
            DB::rollBack(); // Mengembalikan semua perubahan jika terjadi error
            // Menghapus file desain yang mungkin sudah terunggah jika terjadi error
            if ($designFilePath) {
                Storage::disk('public')->delete($designFilePath);
            }
            // Mengarahkan kembali dengan pesan error dan input sebelumnya
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memproses pesanan Anda: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Menampilkan daftar pesanan aktif (belum selesai) yang dimiliki oleh pengguna yang sedang login.
     * Untuk apa: Memberikan pelanggan visibilitas terhadap pesanan mereka yang sedang berjalan.
     */
    public function myOrders()
    {
        // Mengambil pesanan pengguna yang statusnya BUKAN 'completed'
        $orders = Auth::user()->orders()
            ->where('status', '!=', 'completed') // Hanya tampilkan pesanan yang belum selesai
            ->with('items.product')             // Memuat detail item pesanan dan produk terkait
            ->latest()                          // Mengurutkan dari yang terbaru
            ->paginate(10);                     // Melakukan paginasi

        return view('orders.my-orders', compact('orders')); // Menampilkan view daftar pesanan aktif pengguna
    }

    /**
     * Menampilkan daftar riwayat pesanan (yang sudah selesai) yang dimiliki oleh pengguna yang sedang login.
     * Untuk apa: Memberikan pelanggan akses ke catatan pesanan yang sudah berhasil diselesaikan.
     */
    public function completedOrders()
    {
        $user = Auth::user(); // Mendapatkan pengguna yang sedang login
        // Mengambil pesanan pengguna yang statusnya 'completed'
        $orders = Order::where('user_id', $user->id)
            ->where('status', 'completed') // Hanya tampilkan pesanan yang sudah selesai
            ->with('items.product')        // Memuat detail item pesanan dan produk terkait
            ->latest()                     // Mengurutkan dari yang terbaru
            ->paginate(10);                // Melakukan paginasi

        return view('orders.completed', compact('orders')); // Menampilkan view riwayat pesanan pengguna
    }
}