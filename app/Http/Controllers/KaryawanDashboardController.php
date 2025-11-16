<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KaryawanDashboardController extends Controller
{
    public function index(Request $request)
    {
        // Pastikan hanya karyawan yang bisa mengakses
        if (!Auth::user()->isKaryawan()) {
            abort(403, 'Akses ditolak.');
        }

        $search = $request->input('search');

        // Buat query untuk pelanggan
        $query = Pelanggan::with('user'); // Load relasi user jika diperlukan untuk tampilan

        // Tambahkan pencarian jika ada
        if ($search) {
            $query->where('Nama_Pelanggan', 'like', "%{$search}%");
        }

        // Ambil pelanggan dengan pagination
        $pelanggans = $query->paginate(10)->appends(['search' => $search]);

        // Hitung siklus transaksi valid untuk setiap pelanggan yang diambil
        foreach ($pelanggans as $pelanggan) {
            // Hitung jumlah transaksi valid dari rekaman_transaksi untuk pelanggan ini
            $totalTransaksiValid = $pelanggan->rekamanTransaksi()
                ->where('input_status', 'VALID')
                ->count();

            // Hitung sisa transaksi dalam siklus 5 (0-4)
            $sisaSiklus = $totalTransaksiValid % 5;

            // Tentukan jumlah tampilan berdasarkan sisa
            // Jika total 0, tampilkan 0
            // Jika sisa 0 dan total > 0 (artinya kelipatan 5), tampilkan 5
            // Jika sisa > 0, tampilkan sisa
            $jumlahTransaksiSiklus = ($totalTransaksiValid > 0 && $sisaSiklus == 0) ? 5 : $sisaSiklus;

            // Tambahkan informasi ini ke objek pelanggan agar bisa diakses di view
            $pelanggan->jumlah_transaksi_siklus = $jumlahTransaksiSiklus;

            // (Opsional) Anda juga bisa menambahkan info tambahan seperti sisa untuk diskon berikutnya
            // $pelanggan->sisa_transaksi_diskon = (5 - $jumlahTransaksiSiklus) % 5;
        }

        return view('dashboard.karyawan', compact('pelanggans', 'search'));
    }
}