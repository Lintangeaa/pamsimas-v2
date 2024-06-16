<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight">
            {{ __('Daftar Tagihan dan Pembayaran') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('admin.pembayaran.index') }}" method="GET">
                        <div class="flex items-center mb-4">
                            <label for="no_pelanggan" class="mr-2">Cari berdasarkan No. Pelanggan:</label>
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
                                    <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Total</th>
                                    <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Status Pembayaran
                                    </th>
                                    <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($tagihans as $tagihan)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $loop->iteration }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $tagihan->user->pelanggan->nama_pelanggan }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $tagihan->user->pelanggan->no_pelanggan }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $tagihan->periode }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $tagihan->total }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if ($tagihan->pembayarans->isEmpty())
                                                Belum Dibayar
                                            @else
                                                Sudah Dibayar
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if ($tagihan->pembayarans->isEmpty())
                                                <form action="{{ route('admin.pembayaran.bayar', $tagihan->id) }}"
                                                    method="GET">
                                                    @csrf
                                                    <button type="submit"
                                                        class="px-4 py-1 text-white bg-blue-500 rounded-md hover:bg-blue-600">
                                                        Bayar
                                                    </button>
                                                </form>
                                            @endif
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
</x-app-layout>
