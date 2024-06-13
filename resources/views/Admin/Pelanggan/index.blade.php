<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Pelanggan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold mb-2">Daftar Pelanggan</h3>
                    <div class="flex justify-end mb-2">
                        <x-primary-button>Tambah</x-primary-button>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">No</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Username</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Email</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nama</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">No Pelanggan</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Alamat</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200 dark:divide-gray-600">
                                @php $count = 1; @endphp
                                @foreach ($pelanggans as $pelanggan)

                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $count ++ }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $pelanggan->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $pelanggan->email }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $pelanggan->nama_pelanggan }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $pelanggan->no_pelanggan }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $pelanggan->alamat_pelanggan }}</td>
                                    <td>
                                        <x-custom-button class="bg-red-500" onclick="a">
                                            <i class="bi bi-trash" style="font-size: larger;"></i>
                                        </x-custom-button>
                                        <x-custom-button class="bg-cyan-500">
                                            <i class="bi bi-pencil-square" style="font-size: larger;"></i>
                                        </x-custom-button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>