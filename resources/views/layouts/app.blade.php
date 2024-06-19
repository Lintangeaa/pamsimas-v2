<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="flex min-h-screen bg-gray-100 ">
        <!-- Sidebar -->
        <div
            class="fixed top-0 bottom-0 left-0 z-50 w-64 overflow-y-auto transition duration-300 ease-in-out bg-blue-800 border-r border-gray-200 sidebar ">
            @include('layouts.sidebar')
        </div>

        <!-- Main Content -->
        <div class="relative flex flex-col flex-1 min-w-0 ml-64 content">
            <!-- Page Heading -->
            @isset($header)
                <header class="fixed w-full bg-white shadow">
                    <div class="px-5">
                        <div class="w-full h-5 mt-5 bg-blue-800"></div>
                    </div>
                    <div class="px-2 py-6 text-black max-w-7xl sm:px-5 lg:px-5">
                        <div class="px-5 py-5 text-2xl bg-gray-200 rounded"> {{ $header }}</div>
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main class="flex-1 mt-36">
                <!-- Button to open/close sidebar -->
                <button onclick="toggleSidebar()"
                    class="fixed z-50 px-4 py-2 text-gray-800 bg-gray-200 rounded-md top-4 left-4 hover:bg-gray-400 ">
                    <i class="text-pink-500 bi bi-list"></i>
                </button>


                {{ $slot }}
            </main>

            <footer class="flex items-center justify-center h-20 text-white bg-blue-800">
                <div class="float-start">
                    <p>2024 Pamsimas - Tirta Sanur Abadi</p>
                </div>
                <div class="">
                    <p>Crafted with <i class="text-pink-500 bi bi-heart"></i> by Nathwa
                    </p>
                </div>

            </footer>
        </div>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.querySelector('.sidebar');
            const content = document.querySelector('.content')
            sidebar.classList.toggle('hidden');
            content.classList.toggle('ml-64')
        }
    </script>
</body>

</html>
