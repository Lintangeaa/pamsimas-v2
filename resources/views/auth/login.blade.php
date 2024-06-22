<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="h-full p-10">
        @csrf

        <div class="flex flex-col items-center">
            <h1 class="text-6xl font-medium">Welcome</h1>
            <h1 class="mt-5 text-xl font-extrabold text-blue-800">Pamsimas Sanur Tirta Abadi</h1>
        </div>

        <div class="px-10 mt-5">
            <!-- Role -->
            <div class="mt-4">
                <x-input-label for="role" :value="__('Role')" />
                <select id="role" name="role" class="block w-full mt-1" required autofocus
                    onchange="toggleRoleFields()">
                    <option value="admin">Admin</option>
                    <option value="pelanggan">Pelanggan</option>
                </select>
                <x-input-error :messages="$errors->get('role')" class="mt-2" />
            </div>

            <!-- Username or No Pelanggan -->
            <div class="mt-4">
                <x-input-label for="username_or_no_pelanggan" :value="__('Username or No Pelanggan')" />
                <x-text-input id="username_or_no_pelanggan" class="block w-full mt-1" type="text"
                    name="username_or_no_pelanggan" :value="old('username_or_no_pelanggan')" required autofocus />
                <x-input-error :messages="$errors->get('username_or_no_pelanggan')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input id="password" class="block w-full mt-1" type="password" name="password" required
                    autocomplete="current-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Remember Me -->
            <div class="block mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox"
                        class="text-indigo-600 border-gray-300 rounded shadow-sm focus:ring-indigo-500" name="remember">
                    <span class="text-sm text-gray-600 ms-2">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-primary-button class="ms-3">
                    {{ __('Log in') }}
                </x-primary-button>
            </div>
        </div>
    </form>

    <script>
        function toggleRoleFields() {
            var role = document.getElementById('role').value;
            var inputLabel = document.querySelector('label[for="username_or_no_pelanggan"]');
            if (role === 'admin') {
                inputLabel.innerText = 'Username';
            } else {
                inputLabel.innerText = 'No Pelanggan';
            }
        }

        // Initialize the form with the correct fields displayed
        document.addEventListener('DOMContentLoaded', function() {
            toggleRoleFields();
        });
    </script>
</x-guest-layout>
