<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Pelanggan') }}
        </h2>
    </x-slot>

    <div class="p-12">
        <!-- Tampilkan pesan sukses jika ada -->
        @if (session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
        <script>
            // Tampilkan alert menggunakan window.alert
            window.alert("Data pelanggan berhasil diperbarui.");
        </script>
        @endif

        <!-- Tampilkan pesan error jika ada -->
        @if (session('error'))
        <div class="alert alert-danger" role="alert">
            {{ session('error') }}
        </div>
        <script>
            // Tampilkan alert menggunakan window.alert
            window.alert("Gagal memperbarui data pelanggan. Silakan coba lagi.");
        </script>
        @endif

        <form action="{{ route('admin.pelanggan.update', ['uuid' => $pelanggan->user_id]) }}" method="POST" class="bg-white p-5 rounded border">
            @csrf
            @method('PUT') <!-- Blade directive untuk menambahkan _method field -->
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama</label>
                <input type="text" name="name" id="name" value="{{ $user->name }}" class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" required>
            </div>

            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                <input type="email" name="email" id="email" value="{{ $user->email }}" class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" required>
            </div>

            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Password</label>
                <input type="password" name="password" id="password" class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
            </div>

            <div class="mb-4">
                <label for="nama_pelanggan" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama Pelanggan</label>
                <input type="text" name="nama_pelanggan" id="nama_pelanggan" value="{{ $pelanggan->nama_pelanggan }}" class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" required>
            </div>

            <div class="mb-4">
                <label for="alamat_pelanggan" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Alamat Pelanggan</label>
                <textarea name="alamat_pelanggan" id="alamat_pelanggan" rows="3" class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" required>{{ $pelanggan->alamat_pelanggan }}</textarea>
            </div>

            <div>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Simpan</button>
            </div>
        </form>
    </div>
</x-app-layout>