@props(['class' => 'block w-full px-4 py-2 text-start text-sm leading-5 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800'])

@php
// Tambahkan kondisi untuk menampilkan link hanya untuk pelanggan
if (Auth::check() && Auth::user()->isPelanggan()) {
    $class .= ' ' . 'dropdown-link-pelanggan'; // Tambahkan kelas untuk styling
}
@endphp

<a {{ $attributes->merge(['class' => $class]) }}>
    {{ $slot }}
</a>