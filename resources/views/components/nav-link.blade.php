@props(['active'])

@php
    $classes =
        $active ?? false
            ? 'flex justify-center space-x-2 items-center h-10 rounded font-semibold bg-blue-800 border-indigo-400 text-sm font-medium leading-5 text-white focus:outline-none focus:border-indigo-700 transition duration-150 ease-in-out'
            : 'flex justify-start px-4 space-x-4 items-center h-10 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500  hover:text-gray-700  hover:border-gray-300 focus:outline-none focus:text-gray-700  focus:border-gray-300  transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
