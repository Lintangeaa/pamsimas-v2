<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tambah Pelanggan') }}
        </h2>
    </x-slot>
    <div class="p-12">
        <form action="{{ route('admin.tambah.pelanggan') }}" method="POST" class="bg-white p-5 rounded border">
            @csrf
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama</label>
                <input type="text" name="name" id="name" class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" required>
            </div>
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                <input type="email" name="email" id="email" class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" required>
            </div>
            <div class="mb-4">
                <label for="nama_pelanggan" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama Pelanggan</label>
                <input type="text" name="nama_pelanggan" id="nama_pelanggan" class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" required>
            </div>

            <div class="mb-4">
                <label for="alamat_pelanggan" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Alamat Pelanggan</label>
                <textarea name="alamat_pelanggan" id="alamat_pelanggan" rows="3" class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" required></textarea>
            </div>
            <div>
                <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600">Simpan</button>
            </div>
        </form>
    </div>
    @if(session('success'))
    <script>
        Swal.fire({
            title: 'Sukses!',
            text: `{{ session('success') }}`,
            icon: 'success',
            confirmButtonText: 'OK'
        });
    </script>
    @endif

</x-app-layout>