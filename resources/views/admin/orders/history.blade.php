<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Riwayat Pesanan (Selesai)') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
                            role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4"
                            role="alert">
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @endif

                    <h3 class="text-2xl font-bold mb-6">Daftar Riwayat Pesanan</h3>

                    @if ($orders->isEmpty())
                        <p class="text-center text-gray-500 dark:text-gray-400">Belum ada pesanan yang masuk ke riwayat.
                        </p>
                    @else
                        {{-- PERUBAHAN DI SINI: Gunakan struktur tabel --}}
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            ID Pesanan
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Pelanggan
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Total
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Status
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Estimasi
                                        </th>
                                        {{-- Kolom Aksi dihilangkan sesuai permintaan --}}
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach ($orders as $order)
                                        {{-- Baris tabel dapat diklik untuk detail modal --}}
                                        <tr class="cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200"
                                            onclick="openOrderDetailModal({{ json_encode([
                                                'id' => $order->id,
                                                'customerName' => $order->user->name,
                                                'customerEmail' => $order->user->email,
                                                'customerPhone' => $order->customer_phone,
                                                'totalAmount' => 'Rp' . number_format($order->total_amount, 0, ',', '.'),
                                                'status' => ucfirst($order->status),
                                                'estimatedDeliveryDate' => $order->estimated_delivery_date ? $order->estimated_delivery_date->format('d M Y') : '-',
                                                'shippingAddress' => $order->shipping_address . ', ' . $order->shipping_city . ', ' . $order->shipping_postal_code,
                                                'paymentMethod' => ucfirst(str_replace('_', ' ', $order->payment_method)),
                                                'customerNotes' => $order->customer_notes,
                                                'orderItems' => $order->items->map(function ($item) {
                                                        return [
                                                            'productName' => $item->product->name,
                                                            'quantity' => $item->quantity,
                                                            'subtotal' => 'Rp' . number_format($item->subtotal, 0, ',', '.'),
                                                            'itemNotes' => $item->item_notes,
                                                            'designFile' => $item->design_file ? asset($item->design_file) : null,
                                                        ];
                                                    })->toArray(),
                                                'createdAt' => $order->created_at->format('d M Y, H:i'),
                                            ]) }})">
                                            <td
                                                class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-200">
                                                #{{ $order->id }}
                                            </td>
                                            <td
                                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                                {{ $order->user->name }}
                                            </td>
                                            <td
                                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                                Rp{{ number_format($order->total_amount, 0, ',', '.') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                <span
                                                    class="px-3 py-1 rounded-full text-xs font-semibold {{ $order->status === 'pending'
                                                        ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/50 dark:text-yellow-200'
                                                        : ($order->status === 'processing'
                                                            ? 'bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-200'
                                                            : ($order->status === 'completed'
                                                                ? 'bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-200'
                                                                : 'bg-gray-100 text-gray-800 dark:bg-gray-900/50 dark:text-gray-200')) }}">
                                                    {{ ucfirst($order->status) }}
                                                </span>
                                            </td>
                                            <td
                                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                                {{ $order->estimated_delivery_date ? $order->estimated_delivery_date->format('d M Y') : '-' }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-8">
                            {{ $orders->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL BARU UNTUK DETAIL RIWAYAT PESANAN (ini dipindahkan ke sini) --}}
    <div id="orderHistoryDetailModal"
        class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50 hidden">
        <div
            class="relative bg-white dark:bg-gray-800 rounded-lg p-6 max-w-2xl max-h-[90vh] overflow-y-auto text-gray-900 dark:text-gray-100">
            <button
                class="absolute top-4 right-4 text-gray-700 dark:text-gray-300 text-3xl font-bold hover:text-gray-900 dark:hover:text-white"
                onclick="closeOrderHistoryDetailModal()">&times;</button>
            <h3 class="text-2xl font-bold mb-4">Detail Pesanan #<span id="modalOrderId"></span></h3>

            <div class="mb-4">
                <p class="font-semibold">Status: <span id="modalOrderStatus"
                        class="px-3 py-1 rounded-full text-xs font-semibold"></span></p>
                <p class="font-semibold">Estimasi Pengiriman: <span id="modalOrderEstimatedDelivery"></span></p>
                <p class="text-sm text-gray-600 dark:text-gray-400">Tanggal Pesan: <span
                        id="modalOrderCreatedAt"></span></p>
            </div>

            <hr class="my-4 border-gray-200 dark:border-gray-700">

            <h4 class="text-xl font-bold mb-3">Informasi Pelanggan</h4>
            <p>Nama: <span id="modalOrderCustomerName"></span></p>
            <p>Email: <span id="modalOrderCustomerEmail"></span></p>
            <p>Telepon: <span id="modalOrderCustomerPhone"></span></p>
            <p>Alamat: <span id="modalOrderShippingAddress"></span></p>
            <p>Metode Pembayaran: <span id="modalOrderPaymentMethod"></span></p>
            <p>Catatan Pelanggan: <span id="modalOrderCustomerNotes" class="italic"></span></p>

            <hr class="my-4 border-gray-200 dark:border-gray-700">

            <h4 class="text-xl font-bold mb-3">Item Pesanan (<span id="modalOrderTotalAmount"></span>)</h4>
            <ul id="modalOrderItems" class="list-disc ps-5 space-y-2 text-sm text-gray-600 dark:text-gray-400">
                {{-- Items will be populated by JS --}}
            </ul>

            {{-- Link untuk admin melihat halaman edit order (opsional, jika ingin bisa edit dari modal riwayat) --}}
            <div class="flex justify-end mt-6">
                <a href="#" id="modalEditOrderLink">

            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function openOrderDetailModal(orderData) {
                // Populate basic order info
                document.getElementById('modalOrderId').textContent = orderData.id;
                document.getElementById('modalOrderEstimatedDelivery').textContent = orderData.estimatedDeliveryDate;
                document.getElementById('modalOrderCreatedAt').textContent = orderData.createdAt;
                document.getElementById('modalOrderTotalAmount').textContent = orderData.totalAmount;

                // Update status badge
                const statusSpan = document.getElementById('modalOrderStatus');
                statusSpan.textContent = orderData.status;
                statusSpan.className = 'px-3 py-1 rounded-full text-xs font-semibold'; // Reset classes
                if (orderData.status.toLowerCase() === 'pending') {
                    statusSpan.classList.add('bg-yellow-100', 'text-yellow-800', 'dark:bg-yellow-900/50',
                        'dark:text-yellow-200');
                } else if (orderData.status.toLowerCase() === 'processing') {
                    statusSpan.classList.add('bg-blue-100', 'text-blue-800', 'dark:bg-blue-900/50', 'dark:text-blue-200');
                } else if (orderData.status.toLowerCase() === 'completed') {
                    statusSpan.classList.add('bg-green-100', 'text-green-800', 'dark:bg-green-900/50', 'dark:text-green-200');
                } else {
                    statusSpan.classList.add('bg-gray-100', 'text-gray-800', 'dark:bg-gray-900/50', 'dark:text-gray-200');
                }

                // Populate customer info
                document.getElementById('modalOrderCustomerName').textContent = orderData.customerName;
                document.getElementById('modalOrderCustomerEmail').textContent = orderData.customerEmail;
                document.getElementById('modalOrderCustomerPhone').textContent = orderData.customerPhone;
                document.getElementById('modalOrderShippingAddress').textContent = orderData.shippingAddress;
                document.getElementById('modalOrderPaymentMethod').textContent = orderData.paymentMethod;
                document.getElementById('modalOrderCustomerNotes').textContent = orderData.customerNotes ||
                    '-'; // Handle null notes

                // Populate order items
                const orderItemsList = document.getElementById('modalOrderItems');
                orderItemsList.innerHTML = ''; // Clear previous items
                orderData.orderItems.forEach(item => {
                    const li = document.createElement('li');
                    li.innerHTML = `${item.productName} (x${item.quantity}) - ${item.subtotal}`;
                    if (item.itemNotes) {
                        li.innerHTML += ` <span class="text-gray-500">(${item.itemNotes})</span>`;
                    }
                    if (item.designFile) {
                        li.innerHTML +=
                            ` <a href="${item.designFile}" target="_blank" class="text-blue-500 hover:underline ms-2">Lihat Desain</a>`;
                    }
                    orderItemsList.appendChild(li);
                });

                // Set link ke halaman edit order admin
                document.getElementById('modalEditOrderLink').href =
                    `/admin/orders/${orderData.id}/edit`; // Contoh: /admin/orders/123/edit

                // Show the modal
                document.getElementById('orderHistoryDetailModal').classList.remove('hidden');
            }

            function closeOrderHistoryDetailModal() {
                document.getElementById('orderHistoryDetailModal').classList.add('hidden');
            }

            document.getElementById('orderHistoryDetailModal').addEventListener('click', function(event) {
                if (event.target.id === 'orderHistoryDetailModal') {
                    closeOrderHistoryDetailModal();
                }
            });
        </script>
    @endpush
</x-app-layout>
