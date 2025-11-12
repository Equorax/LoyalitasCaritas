<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white bg-blue-600']) }}>
    {{ $slot }}
</button>
