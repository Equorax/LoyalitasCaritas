<?php

namespace App\Imports;

use App\Models\Transaksi; // Import model Transaksi
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
// Hapus baris ini jika tidak menggunakan format serial date dari Excel
// use PhpOffice\PhpSpreadsheet\Shared\Date;

class TransaksiImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // Asumsikan format tanggal di CSV adalah 'Y-m-d H:i:s' atau format lain yang bisa di-parse oleh Laravel/MySQL
        // Jika formatnya berbeda, Anda mungkin perlu mengonversinya menggunakan Carbon
        // use Carbon\Carbon; 
        // $tanggal = Carbon::parse($row['tanggal'])->format('Y-m-d H:i:s');

        return new Transaksi([
            'ID_Transaksi'      => $row['id_transaksi'], // Sesuaikan nama header CSV
            'ID_Karyawan'       => $row['id_karyawan'],  // Sesuaikan nama header CSV
            // Gunakan nilai string tanggal langsung jika formatnya sudah benar
            'tanggal'           => $row['tanggal'], // Sesuaikan nama header CSV
            // Jika format CSV berbeda, konversi dulu, misal:
            // 'tanggal' => \Carbon\Carbon::parse($row['tanggal'])->format('Y-m-d H:i:s'), // Contoh jika formatnya seperti '15/11/2025 10:00 AM'
            
            'TotalHarga'        => $row['total_harga'],  // Sesuaikan nama header CSV
            'MetodePembayaran'  => $row['metode_pembayaran'], // Sesuaikan nama header CSV
            'redeem_status'     => 'unredeemed', // Tetapkan nilai default
        ]);
    }
}