<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Kelola Pesanan #') . $order->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

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

                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Detail Pesanan</h3>

                    {{-- Informasi Pelanggan --}}
                    <div class="mb-6 p-4 border rounded-lg bg-gray-50 dark:bg-gray-700">
                        <p class="text-lg font-bold mb-2">Pelanggan: {{ $order->user->name }} ({{ $order->user->email }})</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Telepon: {{ $order->customer_phone }}</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Alamat: {{ $order->shipping_address }}, {{ $order->shipping_city }}, {{ $order->shipping_postal_code }}</p>
                    </div>

                    {{-- Item Pesanan --}}
                    <h4 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Item Pesanan</h4>
                    @foreach ($order->items as $item)
                        <div class="mb-4 p-4 border rounded-lg bg-gray-50 dark:bg-gray-700 flex items-center space-x-4">
                            @if ($item->product->image)
                                <img src="{{ asset($item->product->image) }}" alt="{{ $item->product->name }}" class="w-16 h-16 object-cover rounded-md">
                            @endif
                            <div>
                                <p class="text-lg font-semibold">{{ $item->product->name }} (x{{ $item->quantity }})</p>
                                <p class="text-blue-600 dark:text-blue-400 font-semibold">Rp{{ number_format($item->subtotal, 0, ',', '.') }}</p>
                                @if ($item->item_notes)
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Catatan Item: {{ $item->item_notes }}</p>
                                @endif
                                @if ($item->design_file)
                                    <a href="{{ asset($item->design_file) }}" target="_blank" class="text-blue-500 hover:underline text-sm">Lihat File Desain</a>
                                @endif
                            </div>
                        </div>
                    @endforeach

                    <hr class="my-8 border-gray-200 dark:border-gray-700">

                    {{-- Ringkasan dan Status Pesanan --}}
                    <h4 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Ringkasan & Kelola Status</h4>
                    <p class="text-lg font-bold mb-4">Total Pesanan: Rp{{ number_format($order->total_amount, 0, ',', '.') }}</p>
                    <p class="mb-4 text-gray-700 dark:text-gray-300">Metode Pembayaran: <span class="font-semibold">{{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</span></p>
                    @if ($order->customer_notes)
                        <p class="mb-4 text-gray-700 dark:text-gray-300">Catatan Pelanggan: <span class="italic">{{ $order->customer_notes }}</span></p>
                    @endif


                    <form action="{{ route('admin.orders.update', $order) }}" method="POST" class="mt-6">
                        @csrf
                        @method('PUT') {{-- Menggunakan PUT untuk update --}}

                        {{-- KOLOM STATUS PESANAN (DROPDOWN) --}}
                        <div class="mb-4">
                            <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Status Pesanan</label>
                            <select name="status" id="status" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm">
                                <option value="pending" {{ old('status', $order->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="processing" {{ old('status', $order->status) == 'processing' ? 'selected' : '' }}>Processing</option>
                                <option value="completed" {{ old('status', $order->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="cancelled" {{ old('status', $order->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                <option value="failed" {{ old('status', $order->status) == 'failed' ? 'selected' : '' }}>Failed</option>
                            </select>
                            @error('status')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                        {{-- KOLOM ESTIMASI PENGIRIMAN (INPUT DATE) --}}
                        <div class="mb-6">
                            <label for="estimated_delivery_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Estimasi Tanggal Pengiriman (Opsional)</label>
                            <input type="date" name="estimated_delivery_date" id="estimated_delivery_date"
                                value="{{ old('estimated_delivery_date', $order->estimated_delivery_date ? $order->estimated_delivery_date->format('Y-m-d') : '') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm">
                            @error('estimated_delivery_date')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                        {{-- Kolom Catatan Admin (jika Anda menambahkan kolom 'admin_notes' di tabel orders) --}}
                        {{-- Contoh:
                        <div class="mb-6">
                            <label for="admin_notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Catatan Internal Admin (Opsional)</label>
                            <textarea name="admin_notes" id="admin_notes" rows="3"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm">{{ old('admin_notes', $order->admin_notes) }}</textarea>
                            @error('admin_notes')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div> --}}

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('admin.orders.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:bg-gray-300 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 me-2">
                                Batal
                            </a>
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Perbarui Pesanan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>