<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Grafik Statistik') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-xl font-bold mb-6">Statistik Berdasarkan Bulan</h1>

                    <!-- Grafik Jumlah Transaksi -->
                    <div class="mb-8">
                        <h2 class="text-lg font-semibold mb-2">Jumlah Transaksi per Bulan</h2>
                        <div class="border rounded-lg p-4">
                            <canvas id="transaksiChart" width="400" height="200"></canvas>
                        </div>
                    </div>

                    <!-- Grafik Jumlah Pendaftaran Pelanggan -->
                    <div>
                        <h2 class="text-lg font-semibold mb-2">Jumlah Pendaftaran Pelanggan per Bulan</h2>
                        <div class="border rounded-lg p-4">
                            <canvas id="pelangganChart" width="400" height="200"></canvas>
                        </div>
                    </div>

                    <script>
                        document.addEventListener('DOMContentLoaded', function () {
                            // Ambil data dari Blade (dilewatkan via compact)
                            const labelsTransaksi = @json($labelsTransaksi);
                            const dataTransaksi = @json($dataTransaksi);

                            const labelsPelanggan = @json($labelsPelanggan);
                            const dataPelanggan = @json($dataPelanggan);

                            // Konfigurasi Chart.js untuk Grafik Transaksi
                            const ctxTransaksi = document.getElementById('transaksiChart').getContext('2d');
                            const transaksiChart = new Chart(ctxTransaksi, {
                                type: 'bar', // Gunakan tipe 'bar' untuk bar chart
                                data: {
                                    labels: labelsTransaksi, // Label bulan/tahun
                                    datasets: [{
                                        label: 'Jumlah Transaksi',
                                        data: dataTransaksi, // Data jumlah transaksi
                                        backgroundColor: 'rgba(54, 162, 235, 0.2)', // Warna fill
                                        borderColor: 'rgba(54, 162, 235, 1)', // Warna border
                                        borderWidth: 1
                                    }]
                                },
                                options: {
                                    responsive: true,
                                    plugins: {
                                        title: {
                                            display: true,
                                            text: 'Grafik Jumlah Transaksi per Bulan'
                                        }
                                    },
                                    scales: {
                                        y: {
                                            beginAtZero: true, // Mulai sumbu Y dari 0
                                            ticks: {
                                                // Callback untuk memastikan hanya angka bulat yang ditampilkan
                                                callback: function(value) {
                                                    // Jika value adalah bilangan bulat, kembalikan sebagai string
                                                    if (Number.isInteger(value)) {
                                                        return value.toString();
                                                    }
                                                    // Jika bukan bilangan bulat, kembalikan string kosong (tidak ditampilkan)
                                                    return '';
                                                }
                                            }
                                        }
                                    }
                                }
                            });

                            // Konfigurasi Chart.js untuk Grafik Pelanggan
                            const ctxPelanggan = document.getElementById('pelangganChart').getContext('2d');
                            const pelangganChart = new Chart(ctxPelanggan, {
                                type: 'bar', // Gunakan tipe 'bar' untuk bar chart
                                data: {
                                    labels: labelsPelanggan, // Label bulan/tahun
                                    datasets: [{
                                        label: 'Jumlah Pendaftaran',
                                        data: dataPelanggan, // Data jumlah pendaftaran
                                        backgroundColor: 'rgba(75, 192, 192, 0.2)', // Warna fill
                                        borderColor: 'rgba(75, 192, 192, 1)', // Warna border
                                        borderWidth: 1
                                    }]
                                },
                                options: {
                                    responsive: true,
                                    plugins: {
                                        title: {
                                            display: true,
                                            text: 'Grafik Jumlah Pendaftaran Pelanggan per Bulan'
                                        }
                                    },
                                    scales: {
                                        y: {
                                            beginAtZero: true, // Mulai sumbu Y dari 0
                                            ticks: {
                                                // Callback untuk memastikan hanya angka bulat yang ditampilkan
                                                callback: function(value) {
                                                    // Jika value adalah bilangan bulat, kembalikan sebagai string
                                                    if (Number.isInteger(value)) {
                                                        return value.toString();
                                                    }
                                                    // Jika bukan bilangan bulat, kembalikan string kosong (tidak ditampilkan)
                                                    return '';
                                                }
                                            }
                                        }
                                    }
                                }
                            });
                        });
                    </script>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>