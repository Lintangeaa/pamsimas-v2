<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight">
            {{ __('Tagihan Pelanggan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="mb-2 text-lg font-semibold">Tagihan Pelanggan</h3>
                    <div class="flex justify-end mb-2">
                        <x-redirect-button :href="route('admin.tagihan.create')">
                            Tambah
                        </x-redirect-button>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                        No</th>
                                    <th
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                        Nama Pelanggan</th>
                                    <th
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                        No Pelanggan</th>
                                    <th
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                        Periode</th>
                                    <th
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                        Pemakaian</th>
                                    <th
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                        Total</th>
                                    <th
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                        Aksi</th>
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
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $tagihan->pemakaian }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $tagihan->total }}</td>
                                        <td class="flex pt-2 space-x-2">
                                            <form id="form-delete-{{ $tagihan->id }}"
                                                action="{{ route('admin.tagihan.delete', $tagihan->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <x-custom-button class="bg-red-500"
                                                    onclick="deleteTagihan('{{ $tagihan->id }}')" type="button">
                                                    <i class="bi bi-trash" style="font-size: larger;"></i>
                                                </x-custom-button>
                                            </form>
                                            <x-redirect-button class="bg-cyan-500" :href="route('admin.tagihan.edit', $tagihan->id)">
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
        function deleteTagihan(id) {
            if (confirm('Apakah Anda yakin ingin menghapus tagihan ini?')) {
                document.getElementById('form-delete-' + id).submit();
            }
        }
    </script>
</x-app-layout>
