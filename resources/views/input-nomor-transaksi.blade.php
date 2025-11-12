<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Input Nomor Penjualan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-xl  font-bold mb-4">Selamat datang, {{ Auth::user()->pelanggan->Nama_Pelanggan ?? Auth::user()->name }}!</h1>
                    <p>Masukkan nomor transaksi yang tertera di nota Anda.</p>

                    @if(session('success'))
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('input.nomor.transaksi') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="id_transaksi_input" class="block text-sm font-medium text-gray-700">Nomor Penjualan *</label>
                            <input type="text" name="id_transaksi_input" id="id_transaksi_input" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required maxlength="18">
                            @error('id_transaksi_input')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex justify-center">
                            <button type="submit" class="inline-flex items-center px-4 py-2 border  text-sm font-medium rounded-lg shadow-sm text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Konfirmasi
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>