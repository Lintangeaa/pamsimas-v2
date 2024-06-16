<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
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

        <form action="{{ route('admin.pelanggan.update', ['uuid' => $pelanggan->user_id]) }}" method="POST"
            class="p-5 bg-white border rounded">
            @csrf
            @method('PUT') <!-- Blade directive untuk menambahkan _method field -->

            <div class="mb-4">
                <x-input-label for="username" :value="__('Username')" />
                <x-text-input id="username" name="username" type="text" :value="$user->username"
                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                    required />
            </div>

            <div class="mb-4">
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input id="password" name="password" type="password"
                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" />
            </div>

            <div class="mb-4">
                <x-input-label for="nama_pelanggan" :value="__('Nama Pelanggan')" />
                <x-text-input id="nama_pelanggan" name="nama_pelanggan" type="text" :value="$pelanggan->nama_pelanggan"
                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                    required />
            </div>

            <div class="mb-4">
                <x-input-label for="alamat_pelanggan" :value="__('Alamat Pelanggan')" />
                <textarea id="alamat_pelanggan" name="alamat_pelanggan" rows="3"
                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                    required>{{ $pelanggan->alamat_pelanggan }}</textarea>
            </div>

            <div>
                <button type="submit"
                    class="px-4 py-2 font-bold text-white bg-blue-500 rounded hover:bg-blue-700 focus:outline-none focus:shadow-outline">Simpan</button>
            </div>
        </form>
    </div>
</x-app-layout>
