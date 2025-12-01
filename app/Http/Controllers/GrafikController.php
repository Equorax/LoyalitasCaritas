<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Kita akan gunakan query builder
use App\Models\Transaksi; // Model untuk tabel transaksi
use App\Models\Pelanggan; // Model untuk tabel pelanggan

class GrafikController extends Controller
{
    public function index()
    {
        // Ambil data jumlah transaksi per bulan
        // Asumsikan kolom 'tanggal' di tabel transaksi adalah DATE atau DATETIME
        $transaksiPerBulan = Transaksi::select(
                DB::raw('YEAR(tanggal) as year'),
                DB::raw('MONTH(tanggal) as month'),
                DB::raw('COUNT(*) as count')
            )
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();

        // Ambil data jumlah pendaftaran pelanggan per bulan
        // Asumsikan kolom 'created_at' di tabel pelanggan mencatat waktu pendaftaran
        $pelangganPerBulan = Pelanggan::select(
                DB::raw('YEAR(created_at) as year'),
                DB::raw('MONTH(created_at) as month'),
                DB::raw('COUNT(*) as count')
            )
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();

        // Format data untuk Chart.js
        $labelsTransaksi = [];
        $dataTransaksi = [];
        foreach ($transaksiPerBulan as $item) {
            $labelsTransaksi[] = $item->year . '-' . str_pad($item->month, 2, '0', STR_PAD_LEFT); // Format: YYYY-MM
            $dataTransaksi[] = $item->count;
        }

        $labelsPelanggan = [];
        $dataPelanggan = [];
        foreach ($pelangganPerBulan as $item) {
            $labelsPelanggan[] = $item->year . '-' . str_pad($item->month, 2, '0', STR_PAD_LEFT); // Format: YYYY-MM
            $dataPelanggan[] = $item->count;
        }

        // Kirim data ke view
        return view('grafik.index', compact('labelsTransaksi', 'dataTransaksi', 'labelsPelanggan', 'dataPelanggan'));
    }
}