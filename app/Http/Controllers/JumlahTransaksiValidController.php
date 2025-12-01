<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; // Kita akan gunakan query builder untuk menghitung

class JumlahTransaksiValidController extends Controller
{
    public function index(Request $request)
    {
        // Pastikan hanya karyawan yang bisa mengakses
        if (!Auth::user()->isKaryawan()) {
            abort(403, 'Akses ditolak. Hanya karyawan yang dapat mengakses fitur ini.');
        }

        $search = $request->input('search');

        // Buat query untuk pelanggan
        // Gabungkan dengan rekaman_transaksi untuk menghitung input_status VALID
        $query = DB::table('pelanggan')
            ->leftJoin('rekaman_transaksi', 'pelanggan.ID_Pelanggan', '=', 'rekaman_transaksi.pelanggan_id')
            ->select(
                'pelanggan.ID_Pelanggan',
                'pelanggan.Nama_Pelanggan',
                'pelanggan.Email_Pelanggan', // Opsional, bisa ditampilkan jika perlu
                DB::raw('COUNT(CASE WHEN rekaman_transaksi.input_status = "VALID" THEN 1 END) as jumlah_transaksi_valid')
            )
            ->groupBy('pelanggan.ID_Pelanggan', 'pelanggan.Nama_Pelanggan', 'pelanggan.Email_Pelanggan'); // Group by untuk menghitung per pelanggan

        // Tambahkan pencarian jika ada
        if ($search) {
            $query->where('pelanggan.Nama_Pelanggan', 'LIKE', "%{$search}%");
        }

        // Ambil pelanggan dengan jumlah transaksi valid dan pagination
        $pelanggans = $query->paginate(10)->appends(['search' => $search]);

        return view('jumlah-transaksi-valid.index', compact('pelanggans', 'search'));
    }
}