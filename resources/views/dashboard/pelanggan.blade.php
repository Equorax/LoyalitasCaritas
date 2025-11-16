<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-orange-600 leading-tight">
            {{ __('Dashboard Pelanggan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-xl font-bold mb-4">Selamat datang di dashboard, {{ Auth::user()->pelanggan->Nama_Pelanggan ?? Auth::user()->name }}!</h1>

                    <!-- Jumlah Transaksi Dalam Siklus Diskon -->
                    <div class="mb-6">
                        <h2 class="text-lg font-semibold mb-2">Jumlah Transaksi Dalam Siklus Diskon</h2>
                        @php
                            // Hitung total transaksi valid seumur hidup pelanggan
                            // Kita tetap hitung dari rekaman_transaksi untuk logika siklus diskon
                            $totalTransaksiValid = Auth::user()->pelanggan->rekamanTransaksi()->where('input_status', 'VALID')->count();
                            
                            // Hitung sisa transaksi dalam siklus 5 (0-4)
                            $sisaSiklus = $totalTransaksiValid % 5;
                            
                            // Tentukan jumlah tampilan berdasarkan sisa
                            // Jika total 0, tampilkan 0
                            // Jika sisa 0 dan total > 0 (artinya kelipatan 5), tampilkan 5
                            // Jika sisa > 0, tampilkan sisa
                            $jumlahTransaksiSiklus = ($totalTransaksiValid > 0 && $sisaSiklus == 0) ? 5 : $sisaSiklus;
                        @endphp
                        <div class="bg-sky-700 text-white text-4xl font-bold rounded-lg p-4 text-center">
                            {{ $jumlahTransaksiSiklus }} <!-- Tampilkan jumlah dalam siklus -->
                        </div>
                    </div>

                    <!-- Pesan Diskon (Opsional) -->
                    @php
                        // $jumlahTransaksiSiklus sudah dihitung di atas
                        
                        // Transaksi berikutnya untuk mendapatkan diskon (0 berarti baru saja mendapat diskon)
                        // Kita hitung berdasarkan modulus: jika siklus 5, berikutnya 0, jika siklus 1, berikutnya 4, dst.

                        $transaksiBerikutnyaDiskon = (5 - $jumlahTransaksiSiklus) % 5;

                        // Jika $jumlahTransaksiSiklus adalah 5, maka (5-5)%5 = 0%5 = 0 -> diskon tersedia
                        // Jika $jumlahTransaksiSiklus adalah 1, maka (5-1)%5 = 4%5 = 4 -> butuh 4 lagi
                        // Jika $jumlahTransaksiSiklus adalah 4, maka (5-4)%5 = 1%5 = 1 -> butuh 1 lagi

                        // Cek apakah pelanggan baru saja menyelesaikan siklus 5 (total sekarang habis dibagi 5 dan bukan nol)
                        $baruSajaDapatDiskon = ($jumlahTransaksiSiklus == 5);
                    @endphp

                    @if($baruSajaDapatDiskon)
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4">
                            <p>Selamat! Anda berhak mendapatkan diskon di transaksi berikutnya</p>
                        </div>
                    @elseif($transaksiBerikutnyaDiskon > 0)
                        <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4">
                            <p>Anda hanya perlu melakukan {{ $transaksiBerikutnyaDiskon }} transaksi lagi untuk mendapatkan diskon!</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>