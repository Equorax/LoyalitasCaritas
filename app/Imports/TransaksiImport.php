<?php

namespace App\Imports;

use App\Models\Transaksi;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
// Jika format tanggal adalah teks dan Anda ingin mengonversinya
// use Carbon\Carbon;

class TransaksiImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Transaksi([
            'ID_Transaksi'      => $row['nomor_transaksi'], // Sesuaikan nama header CSV
            'karyawan_id'       => $row['id_karyawan'],  // <-- Diubah dari 'ID_Karyawan'. Sesuaikan nama header CSV
            // Jika format tanggal di CSV adalah teks seperti '11/15/2025'
            // Anda mungkin perlu mengonversinya ke format Y-m-d H:i:s
            // 'tanggal' => Carbon::createFromFormat('m/d/Y', $row['tanggal'])->format('Y-m-d H:i:s'),
            // Atau jika formatnya sudah benar:
            'tanggal'           => $row['tanggal'], // Sesuaikan nama header CSV
            'TotalHarga'        => $row['total_harga'],  // Sesuaikan nama header CSV
            'MetodePembayaran'  => $row['metode_pembayaran'], // Sesuaikan nama header CSV
            'redeem_status'     => 'unredeemed',
        ]);
    }
}