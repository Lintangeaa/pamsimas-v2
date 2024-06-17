<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight">
            {{ __('Cari Tagihan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('admin.tagihan.cari') }}" method="GET">
                        <div class="flex items-center mb-4">
                            <label for="no_pelanggan" class="mr-2">No Pelanggan :</label>
                            <input type="text" name="no_pelanggan" id="no_pelanggan"
                                class="px-2 py-1 border rounded-md">
                            <button type="submit"
                                class="px-4 py-1 ml-2 text-white bg-blue-500 rounded-md hover:bg-blue-600">
                                Cari
                            </button>
                        </div>
                    </form>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">No</th>
                                    <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Nama Pelanggan
                                    </th>
                                    <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">No Pelanggan</th>
                                    <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Periode</th>
                                    <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Pemakaian
                                    </th>
                                    <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Total
                                    </th>
                                    <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($tagihans as $tagihan)
                                    <tr>
                                        <td class="px-6 py-4 text-center whitespace-nowrap">{{ $loop->iteration }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $tagihan->user->pelanggan->nama_pelanggan }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $tagihan->user->pelanggan->no_pelanggan }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $tagihan->periode }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $tagihan->pemakaian }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $tagihan->total }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <button
                                                class="px-4 py-1 text-white bg-blue-500 rounded-md hover:bg-blue-600"
                                                onclick="handleBayar('{{ $tagihan->id }}', '{{ $tagihan->total }}')">
                                                Bayar
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    @if (session('error'))
                        <div class="mt-4 text-red-500">
                            {{ session('error') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('services.midtrans.client_key') }}"></script>
    <script>
        function handleBayar(tagihanId, totalBayar) {
            fetch(`{{ url('/admin/pembayaran') }}/${tagihanId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        tagihan_id: tagihanId
                    })
                })
                .then(response => response.json())
                .then(data => {
                    const orderId = data.code
                    snap.pay(data.snap_token, {
                        onSuccess: function(result) {
                            console.log('Pembayaran berhasil:', result);
                            handlePaymentStatus(orderId, 'success');
                            alert('Pembayaran berhasil!');
                        },
                        onPending: function(result) {
                            console.log('Pembayaran tertunda:', result);
                            alert('Pembayaran tertunda!');
                            handlePaymentStatus(orderId, 'pending');
                        },
                        onError: function(result) {
                            console.error('Pembayaran gagal:', result);
                            alert('Pembayaran gagal!');
                            handlePaymentStatus(orderId, 'failed');
                        }
                    });
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat memproses pembayaran.');
                });
        }

        function handlePaymentStatus(orderId, status) {
            fetch(`{{ route('pembayaran.status') }}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        transaction_status: status,
                        order_id: orderId
                    })
                })
                .then(response => {
                    if (response.ok) {
                        window.location.reload();
                        console.log(response)
                    } else {
                        throw new Error('Gagal memperbarui status pembayaran.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat memperbarui status pembayaran.');
                });
        }
    </script>

</x-app-layout>
