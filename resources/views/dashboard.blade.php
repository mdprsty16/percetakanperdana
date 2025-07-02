<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="">
        <div class="w-full">
            <div class="overflow-hidden shadow-sm">
                <div class="text-gray-900 dark:text-gray-100">

                    @if (Auth::user()->isAdmin())
                        {{-- TAMPILAN DASHBOARD UNTUK ADMIN (Tidak ada perubahan) --}}
                        <div class="p-6">
                            <p class="text-xl font-semibold mb-6">Selamat datang, Admin {{ Auth::user()->name }}!</p>
                            <p class="mb-8 text-gray-600 dark:text-gray-300">
                                Di sini Anda dapat mengelola semua aspek toko percetakan Anda.
                            </p>

                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                                <a href="{{ route('admin.products.index') }}"
                                    class="block bg-blue-100 dark:bg-blue-900/40 border border-blue-200 dark:border-blue-800 p-6 rounded-lg shadow-md hover:shadow-xl hover:bg-blue-200 dark:hover:bg-blue-900 transition duration-300 transform hover:-translate-y-1">
                                    <h3 class="text-2xl font-bold text-blue-800 dark:text-blue-200 mb-2">
                                        <svg class="inline-block w-6 h-6 mr-2 -mt-1" xmlns="http://www.w3.org/2000/svg"
                                            fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M9 17.25V12m0 0l3-3m0 0l3 3m-3-3v6m-9 0H3a2 2 0 01-2-2V9.5a2 2 0 012-2h3.375c.57-1.182 1.833-1.977 3.28-1.977h2.093c1.446 0 2.71 1.047 3.28 1.977H21.5a2 2 0 012 2V15a2 2 0 01-2 2h-1.5Zm0 0v-4.125m0 0a.75.75 0 100-1.5.75.75 0 000 1.5Zm-4.5 0h.008v.008h-.008V12.75Zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0Z" />
                                        </svg>
                                        Manajemen Produk
                                    </h3>
                                    <p class="text-blue-700 dark:text-blue-300 text-sm">Kelola daftar produk, harga, dan
                                        deskripsi.</p>
                                </a>

                                <a href="#"
                                    class="block bg-green-100 dark:bg-green-900/40 border border-green-200 dark:border-green-800 p-6 rounded-lg shadow-md hover:shadow-xl hover:bg-green-200 dark:hover:bg-green-900 transition duration-300 transform hover:-translate-y-1">
                                    <h3 class="text-2xl font-bold text-green-800 dark:text-green-200 mb-2">
                                        <svg class="inline-block w-6 h-6 mr-2 -mt-1" xmlns="http://www.w3.org/2000/svg"
                                            fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        Manajemen Pesanan
                                    </h3>
                                    <p class="text-green-700 dark:text-green-300 text-sm">Lihat dan proses semua pesanan
                                        pelanggan.</p>
                                </a>

                                <a href="#"
                                    class="block bg-purple-100 dark:bg-purple-900/40 border border-purple-200 dark:border-purple-800 p-6 rounded-lg shadow-md hover:shadow-xl hover:bg-purple-200 dark:hover:bg-purple-900 transition duration-300 transform hover:-translate-y-1">
                                    <h3 class="text-2xl font-bold text-purple-800 dark:text-purple-200 mb-2">
                                        <svg class="inline-block w-6 h-6 mr-2 -mt-1" xmlns="http://www.w3.org/2000/svg"
                                            fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15 19.128a9.38 9.38 0 002.684 1.624-.093.093 0 00-.026-.002c-.09-.001-.253-.02-.375-.02H15m0-16.872a9.38 9.38 0 00-2.684-1.624.093.093 0 00.026.002c-.09.001-.253.02-.375.02H15M9 19.128a9.38 9.38 0 01-2.684 1.624.093.093 0 01.026-.002c-.09-.001-.253-.02.375-.02H9m0-16.872a9.38 9.38 0 012.684-1.624.093.093 0 01-.026.002c-.09.001-.253.02-.375.02H9m0 0V5.25A9.38 9.38 0 003 9.375v5.25c0 1.142.36 2.23.993 3.125M9 0C.893 0 0 7.854 0 12c0 2.87.525 5.617 1.488 8.16C2.693 21.36 4.35 22.822 6.375 23.958 8.442 25.106 10.74 25.75 12.000 25.75c1.26 0 3.558-.644 5.625-1.792 2.025-1.136 3.682-2.673 4.897-4.592C23.475 17.617 24 14.87 24 12c0-4.146-.893-12-12-12z" />
                                        </svg>
                                        Manajemen Pengguna
                                    </h3>
                                    <p class="text-purple-700 dark:text-purple-300 text-sm">Kelola akun pengguna dan
                                        peran
                                        mereka.</p>
                                </a>
                            </div>
                            {{-- Batas TAMPILAN DASHBOARD UNTUK ADMIN --}}
                        @else
                            {{-- ============================================= --}}
                            {{-- TAMPILAN DASHBOARD UNTUK PENGGUNA BIASA --}}
                            {{-- ============================================= --}}
                            <div class="p-6">
                                <div class="text-center mb-10">
                                    <p class="text-lg font-semibold mb-3">Selamat datang, {{ Auth::user()->name }}!</p>
                                    <p class="text-gray-600 dark:text-gray-300 max-w-2xl mx-auto">
                                        Jelajahi berbagai produk cetak berkualitas tinggi kami dan wujudkan ide-ide
                                        Anda.
                                        Lihat status pesanan Anda atau mulai pesanan baru di bawah ini.
                                    </p>
                                </div>

                                <div class="border-b border-gray-200 dark:border-gray-700 pb-8 mb-8"></div>

                                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 text-center">Produk
                                    Kami</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                                    @forelse ($products as $product)
                                        <div
                                            class="border border-gray-200 dark:border-gray-700 rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300">
                                            <img src="{{ asset($product->image) }}" alt="{{ $product->name }}"
                                                class="w-full h-36 object-cover rounded-t-lg product-image">
                                            <div class="p-3">
                                                <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                                                    {{ $product->name }}</h4>
                                                <p class="text-gray-600 dark:text-gray-300 mb-3 text-sm line-clamp-3">
                                                    {{ $product->description }}</p>
                                                <div class="flex items-center justify-between">
                                                    <span
                                                        class="text-base font-bold text-blue-600 dark:text-blue-400">Rp{{ number_format($product->price, 0, ',', '.') }}</span>
                                                    {{-- PERBAIKAN DI SINI: Tombol Lihat Detail --}}
                                                    <button
                                                        onclick="openProductDetailModal({{ json_encode([
                                                            'id' => $product->id, // <<< PASTIKAN ID PRODUK DIKIRIM DI SINI
                                                            'image' => asset($product->image),
                                                            'name' => $product->name,
                                                            'price' => 'Rp' . number_format($product->price, 0, ',', '.'),
                                                            'description' => $product->description,
                                                        ]) }})"
                                                        class="px-3 py-1 bg-blue-600 text-white rounded-md text-sm hover:bg-blue-700 transition">
                                                        Lihat Detail
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="col-span-full text-center text-gray-500 dark:text-gray-400">
                                            Belum ada produk yang tersedia saat ini.
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                            {{-- Batas TAMPILAN DASHBOARD UNTUK PENGGUNA BIASA --}}
                    @endif

                </div>
            </div>
        </div>
    </div>

    {{-- Modal untuk Tampilan Detail Produk (ini sudah benar) --}}
    <div id="productDetailModal"
        class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50 hidden">
        <div
            class="relative bg-white dark:bg-gray-800 rounded-lg p-6 max-w-xl max-h-[90vh] overflow-y-auto text-gray-900 dark:text-gray-100">
            <button
                class="absolute top-4 right-4 text-gray-700 dark:text-gray-300 text-3xl font-bold hover:text-gray-900 dark:hover:text-white"
                onclick="closeProductDetailModal()">&times;</button>
            <img id="modalProductImage" src="" alt="" class="w-full h-64 object-cover rounded-lg mb-4">
            <h4 id="modalProductName" class="text-3xl font-bold mb-2"></h4>
            <p id="modalProductPrice" class="text-xl font-bold text-blue-600 dark:text-blue-400 mb-4"></p>
            <p id="modalProductDescription" class="text-gray-700 dark:text-gray-300 mb-6"></p>
            <div class="flex justify-end">
                <a href="#" id="modalOrderButton"
                    class="px-6 py-3 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">Pesan Sekarang</a>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function openProductDetailModal(productData) { // <<< Sekarang menerima satu objek productData
                document.getElementById('modalProductImage').src = productData.image;
                document.getElementById('modalProductName').textContent = productData.name;
                document.getElementById('modalProductPrice').textContent = productData.price;
                document.getElementById('modalProductDescription').textContent = productData.description;

                // PERBAIKAN DI SINI: Set href tombol Pesan Sekarang di modal
                const orderButton = document.getElementById('modalOrderButton');
                orderButton.href = `{{ route('orders.create') }}?product_id=${productData.id}`; // Menggunakan productData.id

                document.getElementById('productDetailModal').classList.remove('hidden');
            }

            function closeProductDetailModal() {
                document.getElementById('productDetailModal').classList.add('hidden');
            }

            document.getElementById('productDetailModal').addEventListener('click', function(event) {
                if (event.target.id === 'productDetailModal') {
                    closeProductDetailModal();
                }
            });
        </script>
    @endpush
</x-app-layout>
