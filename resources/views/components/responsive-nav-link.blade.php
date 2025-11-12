@props(['active'])

@php
$classes = ($active ?? false)
            // --- Gaya untuk link yang aktif ---
            ? 'block w-full ps-3 pe-4 py-2 border-l-4 border-orange-500 dark:border-orange-600 text-start text-base font-medium text-white bg-orange-500 dark:bg-orange-700 focus:outline-none focus:text-white focus:bg-orange-600 dark:focus:bg-orange-800 focus:border-orange-700 dark:focus:border-orange-300 transition duration-150 ease-in-out'
            // --- Gaya untuk link yang tidak aktif ---
            : 'block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-white bg-sky-700 hover:bg-sky-800 focus:outline-none focus:text-white focus:bg-sky-800 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>