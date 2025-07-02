<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Form Pemesanan Produk') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 text-center">
                        Pesanan untuk: {{ $product->name }}
                    </h3>

                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @endif

                    <form action="{{ route('orders.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        {{-- Informasi Produk --}}
                        <div class="mb-8 p-4 border rounded-lg bg-gray-50 dark:bg-gray-700">
                            <div class="flex items-center space-x-4">
                                <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="w-24 h-24 object-cover rounded-md">
                                <div>
                                    <p class="text-xl font-bold">{{ $product->name }}</p>
                                    <p class="text-blue-600 dark:text-blue-400 font-semibold">Rp{{ number_format($product->price, 0, ',', '.') }}</p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ Str::limit($product->description, 100) }}</p>
                                </div>
                            </div>
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                        </div>

                        {{-- Detail Pesanan --}}
                        <div class="mb-6">
                            <label for="quantity" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Jumlah Pesanan</label>
                            <input type="number" name="quantity" id="quantity" min="1" value="{{ old('quantity', 1) }}" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm">
                            @error('quantity')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div class="mb-6">
                            <label for="item_notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Catatan Produk (Opsional, misal: warna, ukuran, finishing)</label>
                            <textarea name="item_notes" id="item_notes" rows="3"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm">{{ old('item_notes') }}</textarea>
                            @error('item_notes')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div class="mb-6">
                            <label for="design_file" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Unggah File Desain (Opsional, Max 5MB)</label>
                            <input type="file" name="design_file" id="design_file"
                                class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 dark:file:bg-blue-900 dark:file:text-blue-200 dark:hover:file:bg-blue-800">
                            @error('design_file')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                            <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">Format yang diterima: JPG, PNG, PDF, AI, CDR, PSD.</p>
                        </div>

                        <hr class="my-8 border-gray-200 dark:border-gray-700">

                        {{-- Informasi Pengiriman --}}
                        <h4 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Informasi Pengiriman</h4>

                        <div class="mb-6">
                            <label for="shipping_address" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Alamat Lengkap Pengiriman</label>
                            <textarea name="shipping_address" id="shipping_address" rows="4" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm">{{ old('shipping_address', $defaultAddress) }}</textarea>
                            @error('shipping_address')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label for="shipping_city" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Kota</label>
                                <input type="text" name="shipping_city" id="shipping_city" value="{{ old('shipping_city', $defaultCity) }}" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm">
                                @error('shipping_city')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label for="shipping_postal_code" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Kode Pos</label>
                                <input type="text" name="shipping_postal_code" id="shipping_postal_code" value="{{ old('shipping_postal_code', $defaultPostalCode) }}" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm">
                                @error('shipping_postal_code')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                            </div>
                        </div>

                        <div class="mb-6">
                            <label for="customer_phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Nomor Telepon</label>
                            <input type="tel" name="customer_phone" id="customer_phone" value="{{ old('customer_phone', $defaultPhone) }}" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm">
                            @error('customer_phone')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div class="mb-6">
                            <label for="customer_notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Catatan Tambahan untuk Pesanan (Opsional)</label>
                            <textarea name="customer_notes" id="customer_notes" rows="3"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm">{{ old('customer_notes') }}</textarea>
                            @error('customer_notes')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                        <hr class="my-8 border-gray-200 dark:border-gray-700">

                        {{-- Metode Pembayaran --}}
                        <h4 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Metode Pembayaran</h4>
                        <div class="mb-6">
                            <div class="mt-2 space-y-2">
                                <label class="inline-flex items-center">
                                    <input type="radio" name="payment_method" value="bank_transfer" class="form-radio text-blue-600 dark:bg-gray-700 dark:border-gray-600 dark:checked:bg-blue-500 dark:checked:border-blue-500" {{ old('payment_method') == 'bank_transfer' ? 'checked' : '' }} required>
                                    <span class="ms-2 text-gray-700 dark:text-gray-300">Transfer Bank</span>
                                </label>
                                <label class="inline-flex items-center ms-4">
                                    <input type="radio" name="payment_method" value="cod" class="form-radio text-blue-600 dark:bg-gray-700 dark:border-gray-600 dark:checked:bg-blue-500 dark:checked:border-blue-500" {{ old('payment_method') == 'cod' ? 'checked' : '' }} required>
                                    <span class="ms-2 text-gray-700 dark:text-gray-300">Cash On Delivery (COD)</span>
                                </label>
                            </div>
                            @error('payment_method')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                        <hr class="my-8 border-gray-200 dark:border-gray-700">

                        {{-- Ringkasan Pesanan (Dinamis dengan JS) --}}
                        <h4 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Ringkasan Pesanan</h4>
                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-gray-600 dark:text-gray-300">{{ $product->name }} (x<span id="summaryQuantity">1</span>)</span>
                                <span class="font-semibold" id="summarySubtotal">Rp{{ number_format($product->price, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between items-center font-bold text-lg border-t border-gray-200 dark:border-gray-600 pt-2 mt-2">
                                <span>Total:</span>
                                <span id="summaryTotal">Rp{{ number_format($product->price, 0, ',', '.') }}</span>
                            </div>
                        </div>


                        <div class="flex items-center justify-end mt-8">
                            <button type="submit"
                                class="inline-flex items-center px-6 py-3 bg-blue-600 border border-transparent rounded-md font-semibold text-base text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Konfirmasi Pesanan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Fungsi untuk menghitung ulang total saat kuantitas berubah
        document.addEventListener('DOMContentLoaded', function() {
            const quantityInput = document.getElementById('quantity');
            const productPrice = {{ $product->price }}; // Harga produk dari PHP

            function updateOrderSummary() {
                const quantity = parseInt(quantityInput.value);
                const subtotal = quantity * productPrice;

                document.getElementById('summaryQuantity').textContent = quantity;
                document.getElementById('summarySubtotal').textContent = `Rp${subtotal.toLocaleString('id-ID')}`; // Format Rupiah
                document.getElementById('summaryTotal').textContent = `Rp${subtotal.toLocaleString('id-ID')}`; // Untuk saat ini total = subtotal
            }

            quantityInput.addEventListener('input', updateOrderSummary);
            // Panggil sekali saat halaman dimuat untuk memastikan ringkasan benar
            updateOrderSummary();
        });
    </script>
    @endpush
</x-app-layout>