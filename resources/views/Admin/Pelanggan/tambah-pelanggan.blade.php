<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Tambah Pelanggan') }}
        </h2>
    </x-slot>
    <div class="p-12">
        <form action="{{ route('admin.tambah.pelanggan') }}" method="POST" class="p-5 bg-white border rounded">
            @csrf
            <div class="mb-4">
                <x-input-label for="username" :value="__('Username')" />
                <x-text-input id="username" name="username" type="text" class="block w-full mt-1" required
                    autocomplete="username" />
            </div>

            <div class="mb-4">
                <x-input-label for="nama_pelanggan" :value="__('Nama Pelanggan')" />
                <x-text-input id="nama_pelanggan" name="nama_pelanggan" type="text" class="block w-full mt-1"
                    required autocomplete="nama_pelanggan" />
            </div>

            <div class="mb-4">
                <x-input-label for="alamat_pelanggan" :value="__('Alamat Pelanggan')" />
                <textarea id="alamat_pelanggan" name="alamat_pelanggan" rows="3"
                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                    required></textarea>
            </div>
            <div>
                <button type="submit"
                    class="px-4 py-2 text-white bg-blue-500 rounded-md hover:bg-blue-600">Simpan</button>
            </div>
        </form>
    </div>
    @if (session('success'))
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
