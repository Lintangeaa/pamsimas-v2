<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Pembayaran Tagihan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="mb-4 text-lg font-semibold">Pembayaran untuk Tagihan ID: {{ $tagihan->id }}</h3>
                    <div id="payment-button" class="flex justify-center">
                        <button id="pay-button" class="px-4 py-2 text-white bg-blue-500 rounded-md hover:bg-blue-600">
                            Bayar Sekarang
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('services.midtrans.client_key') }}"></script>
    <script type="text/javascript">
        document.getElementById('pay-button').onclick = function() {
            snap.pay('{{ $snapToken }}', {
                // Optional
                onSuccess: function(result) {
                    alert("Payment successful!");
                    console.log(result);
                    window.location.href = "{{ route('admin.pembayaran.index') }}";
                },
                // Optional
                onPending: function(result) {
                    alert("Waiting for payment!");
                    console.log(result);
                },
                // Optional
                onError: function(result) {
                    alert("Payment failed!");
                    console.log(result);
                }
            });
        };
    </script>
</x-app-layout>
