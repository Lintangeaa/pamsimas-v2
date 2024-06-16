<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 ">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 ">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="username" :value="__('Username')" />
            <x-text-input id="username" name="username" type="text" class="block w-full mt-1" :value="old('username', $user->username)"
                required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('username')" />
        </div>


        <div>

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                <div>
                    <p class="mt-2 text-sm text-gray-800 ">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification"
                            class="text-sm text-gray-600 underline rounded-md hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 ">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 text-sm font-medium text-green-600 dark:text-green-400">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        @if ($user->role === 'pelanggan')
            <div>
                <x-input-label for="nama_pelanggan" :value="__('Nama Pelanggan')" />
                <x-text-input id="nama_pelanggan" name="nama_pelanggan" type="text" class="block w-full mt-1"
                    :value="old('nama_pelanggan', $user->pelanggan->nama_pelanggan)" required autocomplete="nama_pelanggan" />
                <x-input-error class="mt-2" :messages="$errors->get('nama_pelanggan')" />
            </div>

            <div>
                <x-input-label for="alamat_pelanggan" :value="__('Alamat Pelanggan')" />
                <x-text-input id="alamat_pelanggan" name="alamat_pelanggan" type="text" class="block w-full mt-1"
                    :value="old('alamat_pelanggan', $user->pelanggan->alamat_pelanggan)" required autocomplete="alamat_pelanggan" />
                <x-input-error class="mt-2" :messages="$errors->get('alamat_pelanggan')" />
            </div>
        @endif

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
