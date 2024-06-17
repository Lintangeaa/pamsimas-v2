<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight">
            {{ __('Laporan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex mb-5 space-x-2 item-center">
                        <x-redirect-button class="bg-green-500 rounded-md hover:bg-green-600" :href="route('laporan.export.excel')">
                            <i class="bi bi-file-excel"></i> Export Excel
                        </x-redirect-button>

                        <x-redirect-button class="bg-red-500 rounded-md hover:bg-red-600" :href="route('laporan.export.pdf')">
                            <i class="bi bi-file-earmark-pdf"></i>Export PDF
                        </x-redirect-button>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">No</th>
                                    <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Nama Pelanggan
                                    </th>
                                    <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">No Pelanggan</th>
                                    <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Periode</th>
                                    <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Pemakaian</th>
                                    <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Total</th>
                                    <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Status Pembayaran
                                    </th>
                                    <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Waktu Pembayaran
                                    </th>

                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($laporans as $laporan)
                                    <tr>
                                        <td class="px-6 py-4 text-center whitespace-nowrap">{{ $loop->iteration }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $laporan->user->pelanggan->nama_pelanggan }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $laporan->user->pelanggan->no_pelanggan }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $laporan->periode }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $laporan->pemakaian }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            Rp. {{ $laporan->total }}</td>
                                        <td class="px-6 py-4 text-center whitespace-nowrap">
                                            @if ($laporan->pembayarans->isEmpty())
                                                Belum Dibayar
                                            @else
                                                {{ $laporan->pembayarans->first()->status }}
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-center whitespace-nowrap">
                                            {{ $laporan->waktu_pembayaran }}
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
