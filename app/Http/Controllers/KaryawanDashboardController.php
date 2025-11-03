<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\Request;

class KaryawanDashboardController extends Controller
{
    /**
     * Tampilkan dashboard karyawan (daftar pelanggan).
     */
    public function index(Request $request)
    {
        // Ambil input pencarian dari request
        $search = $request->input('search', '');

        // Query data pelanggan
        $pelanggans = Pelanggan::where('Nama_Pelanggan', 'like', "%{$search}%")
            ->orderBy('ID_Pelanggan', 'asc') // Urutkan berdasarkan ID_Pelanggan
            ->paginate(10); // Paginasi 10 data per halaman

        return view('dashboard.karyawan', compact('pelanggans', 'search')); // Ganti nama view
    }
}