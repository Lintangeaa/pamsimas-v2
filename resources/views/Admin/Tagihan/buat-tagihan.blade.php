<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Tambah Tagihan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border rounded-md">
                    <form action="{{ route('admin.tagihan.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="user_id" :value="__('User')" />
                                <select name="user_id" id="user_id"
                                    class="block w-full px-3 py-2 border rounded-md shadow-sm focus:outline-none focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->pelanggan->nama_pelanggan }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <x-input-label for="periode" :value="__('Periode')" />
                                <x-text-input id="periode" class="block w-full mt-1" type="month" name="periode"
                                    required />
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="pemakaian" :value="__('Pemakaian')" />
                                <x-text-input id="pemakaian" class="block w-full mt-1" type="number" name="pemakaian"
                                    required />
                            </div>
                            <div>
                                <x-input-label for="total" :value="__('Total')" />
                                <x-text-input id="total" class="block w-full mt-1" type="number" name="total"
                                    required />
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

    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            const pemakaian = document.getElementById('pemakaian');
            const total = document.getElementById('total');

            function updateTotal() {
                const pemakaianValue = parseFloat(pemakaian.value) || 0;
                let totalSum = 10000;

                if (pemakaianValue > 1) {
                    totalSum += 20000;
                }
                if (pemakaianValue > 10) {
                    totalSum += (pemakaianValue - 10) * 2500;
                }
                total.value = totalSum + 1000;
            }

            pemakaian.addEventListener('input', updateTotal);
        });

        @if (session('success'))

            Swal.fire({
                title: 'Sukses!',
                text: `{{ session('success') }}`,
                icon: 'success',
                confirmButtonText: 'OK'
            });
        @endif
    </script>

</x-app-layout>
