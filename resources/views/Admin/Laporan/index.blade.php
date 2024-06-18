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

                    <!-- Filter Form -->
                    <form method="GET" action="{{ route('admin.laporan.index') }}" class="mb-4">
                        <div class="flex space-x-4">
                            <div>
                                <label for="start_date" class="block text-sm font-medium text-gray-700">Start
                                    Date</label>
                                <input type="month" id="start_date" name="start_date"
                                    class="block w-full py-2 pl-3 pr-3 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                    value="{{ request('start_date') }}">
                            </div>
                            <div>
                                <label for="end_date" class="block text-sm font-medium text-gray-700">End Date</label>
                                <input type="month" id="end_date" name="end_date"
                                    class="block w-full py-2 pl-3 pr-3 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                    value="{{ request('end_date') }}">
                            </div>
                            <div class="flex items-end">
                                <button type="submit"
                                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Filter
                                </button>
                            </div>
                        </div>
                    </form>

                    <div class="flex items-center mb-5 space-x-2">
                        <form method="GET" action="{{ route('laporan.export.excel') }}">
                            <input type="hidden" name="start_date" value="{{ request('start_date') }}">
                            <input type="hidden" name="end_date" value="{{ request('end_date') }}">
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-green-500 rounded-md hover:bg-green-600">
                                <i class="bi bi-file-excel"></i> Export Excel
                            </button>
                        </form>

                        <form method="GET" action="{{ route('laporan.export.pdf') }}">
                            <input type="hidden" name="start_date" value="{{ request('start_date') }}">
                            <input type="hidden" name="end_date" value="{{ request('end_date') }}">
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-red-500 rounded-md hover:bg-red-600">
                                <i class="bi bi-file-earmark-pdf"></i> Export PDF
                            </button>
                        </form>
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
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $laporan->periode }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $laporan->pemakaian }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">Rp. {{ $laporan->total }}</td>
                                        <td class="px-6 py-4 text-center whitespace-nowrap">
                                            @if ($laporan->pembayarans->isEmpty())
                                                Belum Dibayar
                                            @else
                                                {{ $laporan->pembayarans->first()->status }}
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-center whitespace-nowrap">
                                            {{ $laporan->waktu_pembayaran }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    @if (session('error'))
                        <div class="mt-4 text-red-500">{{ session('error') }}</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
