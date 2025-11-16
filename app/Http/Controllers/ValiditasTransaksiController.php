<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\RekamanTransaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; // Kita akan gunakan query builder

class ValiditasTransaksiController extends Controller
{
    public function index()
    {
        // Pastikan hanya karyawan yang bisa mengakses
        if (!Auth::user()->isKaryawan()) {
            abort(403, 'Akses ditolak. Hanya karyawan yang dapat mengakses fitur ini.');
        }

        // Kita perlu menggabungkan data dari transaksi dan rekaman_transaksi
        // untuk mendapatkan pelanggan_id dan nama pelanggan jika redeem_status = 'redeemed'
        // dan input_status = 'VALID'.

        // Gunakan query builder untuk join
        $transaksiData = DB::table('transaksi')
            ->select(
                'transaksi.ID_Transaksi',
                'transaksi.karyawan_id',
                'transaksi.redeem_status',
                'transaksi.TotalHarga',
                'transaksi.MetodePembayaran',
                'transaksi.tanggal',
                'rekaman_transaksi.pelanggan_id', // Ambil pelanggan_id dari rekaman_transaksi
                'pelanggan.Nama_Pelanggan'        // Ambil nama pelanggan dari tabel pelanggan
            )
            ->leftJoin('rekaman_transaksi', function ($join) {
                // Join transaksi dengan rekaman_transaksi berdasarkan ID_Transaksi
                $join->on('transaksi.ID_Transaksi', '=', 'rekaman_transaksi.id_transaksi_input')
                     ->where('rekaman_transaksi.input_status', '=', 'VALID'); // Hanya join jika input status VALID
            })
            ->leftJoin('pelanggan', 'rekaman_transaksi.pelanggan_id', '=', 'pelanggan.ID_Pelanggan') // Join ke pelanggan
            ->orderBy('transaksi.tanggal', 'desc') // Urutkan berdasarkan tanggal transaksi, misalnya
            ->orderBy('transaksi.ID_Transaksi', 'asc') // Urutkan berdasarkan ID Transaksi
            ->get(); // Ambil semua data

        return view('validitas-transaksi.index', compact('transaksiData'));
    }
}