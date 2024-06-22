<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">

        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                <!-- Informasi Pelanggan -->
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="flex items-center p-6">
                        <span class="text-4xl text-gray-400">
                            <i class="bi bi-people"></i>
                        </span>
                        <div class="ml-4">
                            <h3 class="mb-2 text-lg font-semibold">Pelanggan</h3>
                            <p class="text-gray-900">{{ $totalPelanggan }}</p>
                        </div>
                    </div>
                </div>

                <!-- Total Uang Masuk -->
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="flex items-center p-6">
                        <span class="text-4xl text-green-400">
                            <i class="bi bi-cash"></i>
                        </span>
                        <div class="ml-4">
                            <h3 class="mb-2 text-lg font-semibold">Total Uang Masuk</h3>
                            <p class="text-gray-900">Rp {{ $totalUangMasuk }}</p>
                        </div>
                    </div>
                </div>

                <!-- Tagihan Belum Bayar -->
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="flex items-center p-6">
                        <span class="text-4xl text-red-400">
                            <i class="bi bi-file-earmark-text"></i>
                        </span>
                        <div class="ml-4">
                            <h3 class="mb-2 text-lg font-semibold">Tagihan Belum Bayar</h3>
                            <p class="text-gray-900">{{ $tagihanBelumDibayar }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
