<aside x-data="{ open: false }" class="flex-shrink-0 w-64 bg-white border-r border-gray-100">
    <!-- Sidebar Navigation -->
    <div class="flex flex-col h-full">
        <!-- Logo -->
        <div class="flex items-center justify-center h-16">
            <a href="{{ route('dashboard') }}">
                <div class="text-2xl font-semibold text-blue-800">Pamsimas</div>
            </a>
        </div>

        <div class="justify-center hidden sm:flex sm:items-center ms-3">
            <x-dropdown align="left" width="48">
                <x-slot name="trigger">
                    <button
                        class="inline-flex items-center px-3 py-2 text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out bg-white border border-transparent rounded-md hover:text-gray-700 focus:outline-none">
                        <div>{{ Auth::user()->username }}</div>

                        <div class="ms-1">
                            <svg class="w-4 h-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                    </button>
                </x-slot>

                <x-slot name="content">
                    <x-dropdown-link :href="route('profile.edit')">
                        {{ __('Profile') }}
                    </x-dropdown-link>

                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-dropdown-link :href="route('logout')"
                            onclick="event.preventDefault();
                                                this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-dropdown-link>
                    </form>
                </x-slot>
            </x-dropdown>
        </div>
    </div>

    <!-- Navigation Links -->

    <div class="flex-1 px-5 mt-10 overflow-y-auto">


        @if (Auth::user()->role === 'admin')
            <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="flex">
                <i class="bi bi-house-door" style="font-size: larger;"></i>
                <span>{{ __('Dashboard') }}</span>
            </x-nav-link>

            <x-nav-link :href="route('admin.pelanggan')" :active="request()->routeIs('admin.pelanggan')" class="flex items-center">
                <i class="bi bi-person" style="font-size: larger;"></i> <!-- Icon untuk Data Pelanggan -->
                <span>{{ __('Data Pelanggan') }}</span>
            </x-nav-link>

            <x-nav-link :href="route('admin.tagihan.index')" :active="request()->routeIs('admin.tagihan.index')" class="flex items-center">
                <i class="bi bi-receipt" style="font-size: larger;"></i> <!-- Icon untuk Tagihan Pelanggan -->
                <span>{{ __('Tagihan Pelanggan') }}</span>
            </x-nav-link>

            <x-nav-link :href="route('admin.pembayaran.index')" :active="request()->routeIs('admin.pembayaran.index')" class="flex items-center">
                <i class="bi bi-cash" style="font-size: larger;"></i> <!-- Icon untuk Pembayaran -->
                <span>{{ __('Pembayaran') }}</span>
            </x-nav-link>

            <x-nav-link :href="route('admin.laporan.index')" :active="request()->routeIs('admin.laporan.index')" class="flex items-center">
                <i class="bi bi-file-earmark-text" style="font-size: larger;"></i> <!-- Icon untuk Laporan -->
                <span>{{ __('Laporan') }}</span>
            </x-nav-link>

            <x-nav-link :href="route('admin.tagihan.cari')" :active="request()->routeIs('admin.tagihan.cari')" class="flex items-center">
                <i class="bi bi-search" style="font-size: larger;"></i> <!-- Icon untuk Cari Tagihan -->
                <span>{{ __('Cari Tagihan') }}</span>
            </x-nav-link>
        @endif

        @if (Auth::user()->role === 'pelanggan')
            <x-nav-link :href="route('pelanggan.tagihan.index')" :active="request()->routeIs('pelanggan.tagihan.index')" class="flex items-center">
                <i class="bi bi-receipt" style="font-size: larger;"></i>
                <span>{{ __('Tagihan') }}</span>
            </x-nav-link>

            <x-nav-link :href="route('pelanggan.pembayaran.index')" :active="request()->routeIs('pelanggan.pembayaran.index')" class="flex items-center">
                <i class="bi bi-cash" style="font-size: larger;"></i> <!-- Icon untuk Pembayaran -->
                <span>{{ __('Pembayaran') }}</span>
            </x-nav-link>
        @endif
    </div>


</aside>
