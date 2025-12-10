<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>
<body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] m-0 p-0">

    <!-- Kotak Biru Full Screen -->
    <!-- Menggunakan h-screen untuk tinggi penuh layar, w-full untuk lebar penuh -->
    <div class="w-full h-screen bg-sky-700 text-white   p-6 sm:p-8">

        <!-- Tombol Login & Register -->
        <!-- Ditempatkan di atas, di tengah -->
        <div class="flex flex-row sm:flex-row gap-5 sm:gap-3 mb-4 sm:mb-6 justify-end sm:justify-end">
            <a href="{{ route('login') }}" class="text-xs sm:text-sm px-3 py-1.5 bg-blue-500 hover:bg-blue-700 rounded">Log in</a>
            <a href="{{ route('register') }}" class="text-xs sm:text-sm px-3 py-1.5 bg-orange-500 hover:bg-orange-600 rounded">Register</a>
        </div>

        <!-- Teks "Siloyca" -->
        <div class=" flex flex-col items-center justify-center mt-20">
        <h1 class=" flex text-6xl sm:text-5xl font-bold mb-4 sm:mb-6 items-center justify-center ">Siloyca</h1>

        
            <img src="{{ Vite::asset('resources/images/coffee-cat.png') }}" alt="Coffee Cat" class="lg:w-96 lg:h-96 sm:w-96 sm:h-96">
        </div>
    
        

    </div>

</body>
</html>