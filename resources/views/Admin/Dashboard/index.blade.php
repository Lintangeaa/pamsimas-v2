<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <form method="GET" action="{{ route('dashboard') }}" class="mb-4">
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
            <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                <div class="col-span-1 md:col-span-3">
                    <div class="bg-white shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <canvas id="pieChart" width="400" height="400"></canvas>
                        </div>
                        <div class="flex justify-center space-x-6">
                            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                                <div class="flex items-center p-6">
                                    <span class="text-4xl text-green-400">
                                        <i class="bi bi-file-earmark-text"></i>
                                    </span>
                                    <div class="ml-4">
                                        <h3 class="mb-2 text-lg font-semibold">Tagihan Di Bayar</h3>
                                        <p class="text-gray-900">{{ $tagihanSudahDibayar }}</p>
                                    </div>
                                </div>
                            </div>
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

            </div>
            <div class="flex justify-center w-full mt-5 space-x-12">
                <div class="w-1/4 overflow-hidden bg-white shadow-sm sm:rounded-lg">
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
                <div class="w-1/4 overflow-hidden bg-white shadow-sm sm:rounded-lg">
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
            </div>
        </div>
    </div>
</x-app-layout>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var ctx = document.getElementById('pieChart').getContext('2d');
        var pieChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Tagihan Sudah Dibayar', 'Tagihan Belum Dibayar'],
                datasets: [{
                    label: 'Status Tagihan',
                    data: [{{ $tagihanSudahDibayar }}, {{ $tagihanBelumDibayar }}],
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.6)', // Warna untuk tagihan sudah dibayar
                        'rgba(255, 99, 132, 0.6)' // Warna untuk tagihan belum dibayar
                    ],
                    borderColor: [
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 99, 132, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                legend: {
                    position: 'top',
                },
                tooltips: {
                    callbacks: {
                        label: function(tooltipItem, data) {
                            var dataset = data.datasets[tooltipItem.datasetIndex];
                            var total = dataset.data.reduce(function(previousValue, currentValue,
                                currentIndex, array) {
                                return previousValue + currentValue;
                            });
                            var currentValue = dataset.data[tooltipItem.index];
                            var percentage = Math.floor(((currentValue / total) * 100) + 0.5);
                            return percentage + "%";
                        }
                    }
                }
            }
        });
    });
</script>
