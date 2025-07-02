<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Pesanan Saya') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
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

                    <h3 class="text-2xl font-bold mb-6 text-center md:text-left">Daftar Pesanan Anda</h3>

                    @forelse ($orders as $order)
                        <div class="bg-gray-50 dark:bg-gray-700 p-6 rounded-lg shadow-md mb-6 border border-gray-200 dark:border-gray-700">
                            {{-- Header Pesanan (ID, Tanggal, Total, Status) --}}
                            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-4 pb-4 border-b border-gray-200 dark:border-gray-600">
                                <div class="mb-2 md:mb-0">
                                    <p class="text-lg font-semibold">Order ID: <span class="text-blue-600 dark:text-blue-400">#{{ $order->id }}</span></p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Tanggal Pesan: {{ $order->created_at->format('d M Y, H:i') }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-xl font-bold">Total: Rp{{ number_format($order->total_amount, 0, ',', '.') }}</p>
                                    {{-- Status Badge --}}
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold {{
                                        $order->status === 'pending' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/50 dark:text-yellow-200' :
                                        ($order->status === 'processing' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-200' :
                                        ($order->status === 'completed' ? 'bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-200' :
                                        'bg-gray-100 text-gray-800 dark:bg-gray-900/50 dark:text-gray-200'))
                                    }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </div>
                            </div>

                            {{-- Detail Pengiriman --}}
                            <div class="mb-4">
                                <p class="text-gray-700 dark:text-gray-300 font-semibold mb-2">Alamat Pengiriman:</p>
                                <p class="text-sm text-gray-600 dark:text-gray-400">{{ $order->shipping_address }}, {{ $order->shipping_city }}, {{ $order->shipping_postal_code }}</p>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Telepon: {{ $order->customer_phone }}</p>
                            </div>

                            {{-- Estimasi Pengiriman (Hanya tampil jika ada) --}}
                            @if ($order->estimated_delivery_date)
                            <div class="mb-4">
                                <p class="text-gray-700 dark:text-gray-300 font-semibold mb-2">Estimasi Pengiriman:</p>
                                <p class="text-base text-green-600 dark:text-green-400 font-bold">
                                    {{ $order->estimated_delivery_date->format('d M Y') }}
                                </p>
                            </div>
                            @endif

                            {{-- Item Pesanan --}}
                            <p class="text-gray-700 dark:text-gray-300 font-semibold mb-2">Item Pesanan:</p>
                            <ul class="list-disc ps-5 space-y-2 text-sm text-gray-600 dark:text-gray-400">
                                @foreach ($order->items as $item)
                                    <li>
                                        {{ $item->product->name }} (x{{ $item->quantity }}) - Rp{{ number_format($item->subtotal, 0, ',', '.') }}
                                        @if ($item->item_notes)
                                            <span class="text-gray-500">({{ $item->item_notes }})</span>
                                        @endif
                                        @if ($item->design_file)
                                            <a href="{{ asset($item->design_file) }}" target="_blank" class="text-blue-500 hover:underline ms-2">Lihat Desain</a>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>

                            {{-- Catatan Pelanggan (Jika ada) --}}
                            @if ($order->customer_notes)
                            <p class="mt-4 text-gray-700 dark:text-gray-300 font-semibold">Catatan Pelanggan:</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400 italic">{{ $order->customer_notes }}</p>
                            @endif

                        </div>
                    @empty
                        {{-- Pesan jika tidak ada pesanan --}}
                        <div class="text-center text-gray-500 dark:text-gray-400 py-8">
                            <p class="text-lg mb-4">Anda belum memiliki pesanan. Ayo mulai wujudkan ide cetakan Anda!</p>
                            <a href="{{ route('dashboard') }}" class="inline-block px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">Mulai Pesan Sekarang</a>
                        </div>
                    @endforelse

                    {{-- Paginasi --}}
                    <div class="mt-8">
                        {{ $orders->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>