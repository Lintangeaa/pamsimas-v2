<aside x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-r border-gray-100 dark:border-gray-700 w-64 flex-shrink-0">
    <!-- Sidebar Navigation -->
    <div class="h-full flex flex-col">
        <!-- Logo -->
        <div class="flex items-center justify-center h-16">
            <a href="{{ route('dashboard') }}">
                <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
            </a>
        </div>

        <div class="hidden sm:flex sm:items-center ms-3 justify-center">
            <x-dropdown align="left" width="48">
                <x-slot name="trigger">
                    <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                        <div>{{ Auth::user()->name }}</div>

                        <div class="ms-1">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
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

                        <x-dropdown-link :href="route('logout')" onclick="event.preventDefault();
                                                this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-dropdown-link>
                    </form>
                </x-slot>
            </x-dropdown>
        </div>
    </div>
    <!-- Navigation Links -->
    <div class="flex-1 mt-10 overflow-y-auto px-5">
        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="flex items-center ">
            <i class="bi bi-house-door" style="font-size: larger;"></i>
            <span> {{ __('Dashboard') }}</span>
        </x-nav-link>
        <x-nav-link :href="route('admin.pelanggan')" :active="request()->routeIs('admin.pelanggan')" class="flex items-center ">
            <i class="bi bi-receipt" style="font-size: larger;"></i>
            <span> {{ __('Pelanggan') }}</span>
        </x-nav-link>
    </div>

    <!-- Settings Dropdown -->



</aside>