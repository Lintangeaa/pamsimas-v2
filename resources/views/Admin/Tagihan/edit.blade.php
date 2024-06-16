<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Edit Tagihan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border rounded-md">
                    <form action="{{ route('admin.tagihan.update', $tagihan->id) }}" method="POST" class="space-y-4">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="user_id" :value="__('User')" />
                                <select name="user_id" id="user_id"
                                    class="block w-full px-3 py-2 border rounded-md shadow-sm focus:outline-none focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}"
                                            {{ $tagihan->user_id == $user->id ? 'selected' : '' }}>
                                            {{ $user->pelanggan->nama_pelanggan }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <x-input-label for="periode" :value="__('Periode')" />
                                <x-text-input id="periode" class="block w-full mt-1" type="text" name="periode"
                                    required value="{{ $tagihan->periode }}" />
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="pemakaian" :value="__('Pemakaian')" />
                                <x-text-input id="pemakaian" class="block w-full mt-1" type="number" name="pemakaian"
                                    required value="{{ $tagihan->pemakaian }}" />
                            </div>
                            <div>
                                <x-input-label for="total" :value="__('Total')" />
                                <x-text-input id="total" class="block w-full mt-1" type="number" name="total"
                                    required value="{{ $tagihan->total }}" />
                            </div>
                        </div>
                        <div class="flex justify-end">
                            <x-primary-button class="bg-blue-500 hover:bg-blue-600">
                                {{ __('Simpan') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
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
