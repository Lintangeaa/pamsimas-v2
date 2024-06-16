<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight ">
            {{ __('Pelanggan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 ">
                    <h3 class="mb-2 text-lg font-semibold">Daftar Pelanggan</h3>
                    <div class="flex justify-end mb-2">
                        <x-redirect-button :href="route('tambah-pelanggan')">
                            Tambah
                        </x-redirect-button>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 ">
                            <thead class="bg-gray-50 ">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase ">
                                        No</th>
                                    <th
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase ">
                                        Username</th>
                                    <th
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase ">
                                        Nama</th>
                                    <th
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase ">
                                        No Pelanggan</th>
                                    <th
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase ">
                                        Alamat</th>
                                    <th
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase ">
                                        Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200 ">
                                @php $count = 1; @endphp
                                @foreach ($pelanggans as $data)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $count++ }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $data->username }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $data->pelanggan->nama_pelanggan }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $data->pelanggan->no_pelanggan }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $data->pelanggan->alamat_pelanggan }}
                                        </td>
                                        <td class="flex pt-2 space-x-2">
                                            <form id="form-delete-{{ $data->id }}"
                                                action="{{ route('admin.pelanggan.delete', $data->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <x-custom-button class="bg-red-500"
                                                    onclick="deletePelanggan('{{ $data->id }}')">
                                                    <i class="bi bi-trash" style="font-size: larger;"></i>
                                                </x-custom-button>
                                            </form>
                                            <x-redirect-button class="bg-cyan-500" :href="route('admin.pelanggan.edit', $data->id)">
                                                <i class="bi bi-pencil-square" style="font-size: larger;"></i>
                                            </x-redirect-button>
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

    <script>
        function deletePelanggan(id) {
            if (confirm('Apakah Anda yakin ingin menghapus pelanggan ini?')) {
                document.getElementById('form-delete-' + id).submit();
            }
        }
    </script>
</x-app-layout>
